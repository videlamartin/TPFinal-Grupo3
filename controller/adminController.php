<?php

class AdminController
{
    private $usuarioModel;
    private $renderer;
    private $request;
    private $usuarioSesion;
    private $partidaModel;

    public function __construct($usuarioModel, $partidaModel,$renderer, $request, $usuarioSesion)
    {
        $this->usuarioModel = $usuarioModel;
        $this->partidaModel = $partidaModel;
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



        $this->renderer->render('admin', [
            'grafico_usuarios' => $graficoUsuarios,
            'grafico_partidas' => json_encode($graficoPartidas),
            'periodo' => $periodo
        ]);
    }
}