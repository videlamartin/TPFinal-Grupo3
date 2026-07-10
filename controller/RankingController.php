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
        $miId    = $this->usuarioSesion['id'] ?? null;

        $podio = [];
        $resto = [];
        $medallas = ['🥇', '🥈', '🥉'];

        foreach ($ranking as $i => $fila) {
            $fila['es_yo']   = ($miId !== null && $fila['id'] == $miId);
            $fila['inicial'] = mb_strtoupper(mb_substr($fila['username'], 0, 1));

            if ($i < 3) {
                $fila['medalla'] = $medallas[$i];
                $fila['clase']   = 'p' . ($i + 1);
                $podio[] = $fila;
            } else {
                $resto[] = $fila;
            }
        }

        $this->renderer->render('ranking', [
            'ranking'    => $ranking,
            'podio'      => $podio,
            'resto'      => $resto,
            'hay_resto'  => !empty($resto),
        ]);
    }
}