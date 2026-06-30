<?php

class LobbyController
{
    private $renderer;
    private $request;
    private $partidaModel;

    private $usuarioSession;
    private $preguntaModel;
    private $categoriaModel;

    public function __construct($partidaModel, $preguntaModel, $categoriaModel, $renderer, $request, $usuarioSession)
    {
        $this->partidaModel = $partidaModel;
        $this->preguntaModel = $preguntaModel;
        $this->categoriaModel = $categoriaModel;
        $this->renderer = $renderer;
        $this->request = $request;
        $this->usuarioSession = $usuarioSession;
    }

    public function ver()
    {
        $rol = $this->usuarioSession['rol'];
        $idUsuario = $this->usuarioSession['id'];

        $historial = $this->partidaModel->obtenerHistorialPorUsuario($_SESSION['id_usuario']);

        $datos = [
            'username' => $this->usuarioSession['username'],
            'rol' => $rol,
            'nombre' => $_SESSION['nombre_completo'],
            'puntaje_total' => $_SESSION['puntaje_total'],
            'bienvenida_neutro'    => $_SESSION['sexo'] === 'Prefiero no cargarlo',
            'bienvenido'    => $_SESSION['sexo'] === 'Femenino',
            'bienvenida'    => $_SESSION['sexo'] === 'Femenino',
            'es_editor' => $_SESSION['rol'] === 'editor',
            'historial' => $historial,
            'sugerida' => isset($_GET['sugerida']),
];

        $this->renderer->render('lobby', $datos);
    }

    public function cerrarSesion()
    {
        session_destroy();
        Redirect::to('/login/ver');
    }

    public function sugerirVer()
    {
        $categorias = $this->categoriaModel->obtenerTodas();

        $this->renderer->render('sugerirPregunta', [
            'categorias'   => $categorias,
            'campos_crear' => [
                ['indice' => 0, 'indice_display' => 'A'],
                ['indice' => 1, 'indice_display' => 'B'],
                ['indice' => 2, 'indice_display' => 'C'],
                ['indice' => 3, 'indice_display' => 'D'],
            ],
        ]);
    }

    public function sugerirGuardar()
    {
        $enunciado   = $this->request->post('enunciado');
        $categoriaId = $this->request->post('categoria_id');
        $correcta    = (int) $this->request->post('respuesta_correcta');
        $textos      = $this->request->post('respuesta_texto');
        $creadorId   = $this->usuarioSession['id'];

        $respuestas = [];
        foreach ($textos as $indice => $texto) {
            $respuestas[] = [
                'texto'       => $texto,
                'es_correcta' => ($indice == $correcta) ? 1 : 0,
            ];
        }

        $this->preguntaModel->sugerir($enunciado, $categoriaId, $creadorId, $respuestas);

        Redirect::to('/lobby/ver?sugerida=1');
    }

}
?>