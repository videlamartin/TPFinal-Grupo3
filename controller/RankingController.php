<?php
class RankingController
{
    private $usuarioModel;
    private $renderer;
    private $request;

    public function __construct($usuarioModel, $renderer, $request)
    {
        $this->usuarioModel = $usuarioModel;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function ver()
    {
        if (!isset($_SESSION['id_usuario'])) {
            Redirect::to('/login/ver');
        }

        $ranking = $this->usuarioModel->obtenerRanking();

        $this->renderer->render('ranking', [
            'ranking' => $ranking
        ]);
    }
}