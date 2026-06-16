<?php
class PartidaController
{
    private $partidaModel;
    private $preguntaModel;
    private $usuarioModel;
    private $renderer;
    private $request;
    private $categoriaModel;

    public function __construct($partidaModel, $preguntaModel, $usuarioModel,$categoriaModel, $renderer, $request)
    {
        $this->partidaModel = $partidaModel;
        $this->preguntaModel = $preguntaModel;
        $this->usuarioModel = $usuarioModel;
        $this->categoriaModel = $categoriaModel;
        $this->renderer = $renderer;
        $this->request = $request;

    }

    public function iniciar()
    {



        if (!isset($_SESSION['id_usuario'])) {
            Redirect::to('/login/ver');
        }

        if (isset($_SESSION['partida'])) {
            Redirect::to('/partida/pregunta');
        }

        $usuario = $this->usuarioModel->buscarPorId($_SESSION['id_usuario']);
        $nivelUsuario = $this->usuarioModel->calcularNivelUsuario($usuario);
        $partidaId = $this->partidaModel->crearPartida($_SESSION['id_usuario']);
        $categoria = $this->categoriaModel->obtenerCategoriaRandom();

        $_SESSION['partida'] = [
            'partida_id'         => $partidaId,
            'pregunta_actual_id' => null,
            'tiempo_inicio'      => null,
            'tiempo_limite'      => 30,
            'nivel_usuario'      => $nivelUsuario,
            'preguntas_vistas'   => [],
            'categoria_actual'   => $categoria['nombre'],
            'categoria_color'    => $categoria['color'],
            'categoria_id'       => $categoria['id']
        ];

        Redirect::to('/partida/pregunta');
    }

    public function pregunta()
    {
        if (!isset($_SESSION['id_usuario'])) Redirect::to('/login/ver');
        if (!isset($_SESSION['partida']))    Redirect::to('/lobby/ver');

        $pregunta = $this->obtenerOSortearPregunta();

        if (!$pregunta) {
            $this->finalizarPartida('sin_preguntas');
            return;
        }

        $this->renderer->render('juego', [
            'pregunta'        => $pregunta['enunciado'],
            'pregunta_id'     => $pregunta['id'],
            'categoria'       => $pregunta['categoria_nombre'],
            'categoria_color' => $pregunta['categoria_color'],
            'categoria_actual'=> $_SESSION['partida']['categoria_actual'],
            'categoria_color_actual' => $_SESSION['partida']['categoria_color'],
            'respuestas'      => $this->preguntaModel->obtenerRespuestas($pregunta['id']),
            'tiempo_restante' => $this->calcularTiempoRestante(),
            'tiempo_limite'   => $_SESSION['partida']['tiempo_limite'],
            'puntaje_actual'  => $this->partidaModel->obtenerPorId($_SESSION['partida']['partida_id'])['puntaje']
        ]);
    }

    public function responder()
    {
        if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['partida'])) {
            Redirect::to('/login/ver');
        }

        if ($this->tiempoVencido()) {
            $this->finalizarPartida('tiempo');
            return;
        }

        $respuestaId = (int) $_POST['respuesta_id'];
        $respuesta = $this->preguntaModel->verificarRespuesta($respuestaId);

        if ($respuesta['es_correcta']) {
            $this->procesarAcierto();
            Redirect::to('/partida/pregunta');
        } else {
            $correcta = $this->preguntaModel->obtenerRespuestaCorrecta(
                $_SESSION['partida']['pregunta_actual_id']
            );
            $this->finalizarPartida('incorrecta', $correcta['texto']);
        }
    }

    // metodos privados: para no caer en muchos if en los metodos publicos

    private function obtenerOSortearPregunta()
    {
        if ($_SESSION['partida']['pregunta_actual_id'] !== null) {
            return $this->preguntaModel->obtenerPorId(
                $_SESSION['partida']['pregunta_actual_id']
            );
        }

        $pregunta = $this->preguntaModel->obtenerPreguntaParaUsuario(
            $_SESSION['partida']['nivel_usuario'],
            $_SESSION['partida']['preguntas_vistas']
        );

        if (!$pregunta) return null;

        $_SESSION['partida']['pregunta_actual_id'] = $pregunta['id'];
        $_SESSION['partida']['tiempo_inicio'] = time();
        $this->preguntaModel->registrarMostrada($pregunta['id']);

        return $pregunta;
    }

    private function tiempoVencido()
    {
        $transcurrido = time() - $_SESSION['partida']['tiempo_inicio'];
        return $transcurrido > $_SESSION['partida']['tiempo_limite'];
    }

    private function calcularTiempoRestante()
    {
        $transcurrido = time() - $_SESSION['partida']['tiempo_inicio'];
        return max(0, $_SESSION['partida']['tiempo_limite'] - $transcurrido);
    }

    private function procesarAcierto()
    {
        $preguntaId = $_SESSION['partida']['pregunta_actual_id'];
        $partidaId  = $_SESSION['partida']['partida_id'];

        $this->partidaModel->sumarPunto($partidaId);
        $this->preguntaModel->registrarCorrecta($preguntaId);

        $_SESSION['partida']['preguntas_vistas'][] = $preguntaId;
        $_SESSION['partida']['pregunta_actual_id'] = null;
        $_SESSION['partida']['tiempo_inicio']      = null;
    }

    private function finalizarPartida($motivo, $respuestaCorrecta = null)
    {
        $partida = $this->partidaModel->obtenerPorId($_SESSION['partida']['partida_id']);
        $this->partidaModel->finalizar($partida['id']);

        // Sumar puntaje y estadisticas al perfil del usuario.
        // Las correctas son las preguntas que se fueron acumulando en
        // 'preguntas_vistas'. Si perdio por responder mal, esa ultima
        // pregunta tambien cuenta como respondida (pero no como correcta).
        $respuestasCorrectas  = count($_SESSION['partida']['preguntas_vistas']);
        $preguntasRespondidas = $respuestasCorrectas + ($motivo === 'incorrecta' ? 1 : 0);

        $this->usuarioModel->sumarPuntaje(
            $_SESSION['id_usuario'],
            $partida['puntaje'],
            $preguntasRespondidas,
            $respuestasCorrectas
        );

        // Mantener actualizado el puntaje que se muestra en el lobby/sesion
        $_SESSION['puntaje_total'] += $partida['puntaje'];

        $datos = [
            'puntaje'            => $partida['puntaje'],
            'motivo_fin'         => $motivo,
            'respuesta_correcta' => $respuestaCorrecta
        ];

        unset($_SESSION['partida']);
        $this->renderer->render('resultado', $datos);
    }
}