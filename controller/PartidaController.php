<?php
class PartidaController
{
    const DURACION_RULETA_SEGUNDOS = 4;
    private $partidaModel;
    private $preguntaModel;
    private $usuarioModel;
    private $renderer;
    private $request;
    private $categoriaModel;

    private $usuarioSesion;

    public function __construct($partidaModel, $preguntaModel, $usuarioModel,$categoriaModel, $renderer, $request, $usuarioSesion)
    {
        $this->partidaModel = $partidaModel;
        $this->preguntaModel = $preguntaModel;
        $this->usuarioModel = $usuarioModel;
        $this->categoriaModel = $categoriaModel;
        $this->renderer = $renderer;
        $this->request = $request;
        $this->usuarioSesion = $usuarioSesion;

    }

    public function iniciar()
    {
        if (isset($_SESSION['partida'])) {
            Redirect::to('/partida/pregunta');
        }
        $usuario = $this->usuarioModel->buscarPorId($this->usuarioSesion['id']);
        $nivelUsuario = $this->usuarioModel->calcularNivelUsuario($usuario);
        $partidaId = $this->partidaModel->crearPartida($this->usuarioSesion['id']);
        $categoria = $this->categoriaModel->obtenerCategoriaRandom();
        $_SESSION['partida'] = [
            'partida_id'         => $partidaId,
            'pregunta_actual_id' => null,
            'tiempo_inicio'      => null,
            'tiempo_limite'      => 30,
            'nivel_usuario'      => $nivelUsuario,
            'preguntas_vistas'   => []
        ];
        Redirect::to('/partida/pregunta');
    }

    public function pregunta()
    {
        if (!$this->usuarioSesion['id']) Redirect::to('/login/ver');
        if (!isset($_SESSION['partida']))    Redirect::to('/lobby/ver');

        $pregunta = $this->obtenerOSortearPregunta();

        if (!$pregunta) {
            $this->finalizarPartida('sin_preguntas');
            return;
        }

        $tiempoFin = $_SESSION['partida']['tiempo_inicio'] + $_SESSION['partida']['tiempo_limite'];

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
            'tiempo_fin'      => $tiempoFin * 1000, // milisegundos para JS
            'puntaje_actual'  => $this->partidaModel->obtenerPorId($_SESSION['partida']['partida_id'])['puntaje']
        ]);
    }

    public function responder()
    {
        if (!$this->usuarioSesion['id'] || !isset($_SESSION['partida'])) {
            Redirect::to('/login/ver');
        }

        if ($this->tiempoVencido()) {
            $this->finalizarPartida('tiempo');
            return;
        }

        $respuestaId = (int) $_POST['respuesta_id'];
        $respuesta = $this->preguntaModel->verificarRespuesta($respuestaId);


        if (!$respuesta) {
            $this->finalizarPartida('tiempo');
            return;
        }

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

        $categoria = $this->categoriaModel->obtenerCategoriaRandom();
        $_SESSION['partida']['categoria_actual'] = $categoria['nombre'];
        $_SESSION['partida']['categoria_color']  = $categoria['color'];
        $_SESSION['partida']['categoria_id']     = $categoria['id'];

        $pregunta = $this->preguntaModel->obtenerPreguntaParaUsuario(
            $_SESSION['partida']['nivel_usuario'],
            $_SESSION['partida']['preguntas_vistas'],
            $_SESSION['partida']['categoria_id']
        );

        if (!$pregunta) return null;

        $_SESSION['partida']['pregunta_actual_id'] = $pregunta['id'];
        $_SESSION['partida']['tiempo_inicio'] = time() + self::DURACION_RULETA_SEGUNDOS;;
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
            $this->usuarioSesion['id'],
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