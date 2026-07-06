<?php

class AdminController
{
    private $usuarioModel;
    private $renderer;
    private $request;
    private $usuarioSesion;
    private $partidaModel;

    private $preguntaModel;


    public function __construct($usuarioModel, $partidaModel, $preguntaModel,$renderer, $request, $usuarioSesion)
    {
        $this->usuarioModel = $usuarioModel;
        $this->partidaModel = $partidaModel;
        $this->preguntaModel = $preguntaModel;
        $this->renderer = $renderer;
        $this->request = $request;
        $this->usuarioSesion = $usuarioSesion;
    }


    public function ver()
    {
        $periodo = $_GET['periodo'] ?? 'dia';

        $usuariosEvolucion = $this->usuarioModel->obtenerEvolucionUsuarios($periodo);

        foreach ($usuariosEvolucion as &$u) {
            $u['total'] = (int) $u['total'];
        }
        unset($u);

        $graficoUsuarios = json_encode($usuariosEvolucion);
        $graficoPartidas = $this->partidaModel->obtenerGraficoPartidas($periodo);
        $graficoPreguntas = $this->preguntaModel->obtenerGraficoPreguntas($periodo);
        $usuariosPorPais = $this->usuarioModel->obtenerUsuariosPorPais();
        $usuariosPorSexo = $this->usuarioModel->obtenerUsuariosPorSexo();


        $this->renderer->render('admin', [
            'grafico_usuarios' => $graficoUsuarios,
            'grafico_partidas' => json_encode($graficoPartidas),
            'grafico_preguntas' => json_encode($graficoPreguntas),
            'usuarios_por_pais' => json_encode($usuariosPorPais),
            'usuarios_por_sexo' => json_encode($usuariosPorSexo),
            'periodo' => $periodo
        ]);
    }
}