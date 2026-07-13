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

        // Evolución ACUMULADA: total de usuarios hasta el corte de cada período
        // (suma corrida de los nuevos usuarios de cada período).
        $acumulado = 0;
        $usuariosAcumulados = [];
        foreach ($usuariosEvolucion as $u) {
            $acumulado += $u['total'];
            $usuariosAcumulados[] = ['periodo' => $u['periodo'], 'total' => $acumulado];
        }

        $graficoUsuarios = json_encode($usuariosEvolucion);
        $graficoPartidas = $this->partidaModel->obtenerGraficoPartidas($periodo);
        $graficoPreguntas = $this->preguntaModel->obtenerGraficoPreguntas($periodo);
        $usuariosPorPais = $this->usuarioModel->obtenerUsuariosPorPais($periodo);
        $usuariosPorSexo = $this->usuarioModel->obtenerUsuariosPorSexo($periodo);
        $usuariosPorEdad = $this->usuarioModel->obtenerUsuariosPorEdad($periodo);
        $porcentajeCorrectas = $this->partidaModel->obtenerPorcentajeCorrectasGeneral($periodo);
        $preguntasPorRol = $this->preguntaModel->obtenerPreguntasCreadasPorRol($periodo);


        $this->renderer->render('admin', [
            'grafico_usuarios' => $graficoUsuarios,
            'usuarios_acumulados' => json_encode($usuariosAcumulados),
            'grafico_partidas' => json_encode($graficoPartidas),
            'grafico_preguntas' => json_encode($graficoPreguntas),
            'usuarios_por_pais' => json_encode($usuariosPorPais),
            'usuarios_por_sexo' => json_encode($usuariosPorSexo),
            'usuarios_por_edad' => json_encode($usuariosPorEdad),
            'porcentaje_correctas' => json_encode($porcentajeCorrectas),
            'preguntas_por_rol' => json_encode($preguntasPorRol),
            'periodo' => $periodo
        ]);
    }
}