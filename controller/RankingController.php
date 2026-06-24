<?php
class RankingController
{
    private $usuarioModel;
    private $renderer;
    private $request;

    private $usuarioSesion;

    public function __construct($usuarioModel, $renderer, $request, $usuarioSesion)
    {
        $this->usuarioModel = $usuarioModel;
        $this->renderer = $renderer;
        $this->request = $request;
        $this->usuarioSesion = $usuarioSesion;
    }

    public function ver()
    {
        $ranking = $this->usuarioModel->obtenerRanking();

        $this->renderer->render('ranking', [
            'ranking' => $ranking
        ]);
    }
}