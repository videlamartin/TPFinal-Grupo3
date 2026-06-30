<?php
class EditorController
{
    private $preguntaModel;
    private $renderer;
    private $request;
    private $usuarioSesion;

    private $reporteModel;



    public function __construct($preguntaModel, $renderer, $request, $usuarioSesion, $reporteModel)
    {
        $this->preguntaModel  = $preguntaModel;
        $this->renderer       = $renderer;
        $this->request        = $request;
        $this->usuarioSesion  = $usuarioSesion;
        $this->reporteModel   = $reporteModel;
    }

    public function ver()
    {
        $this->verificarAccesoEditor();

        $busqueda  = $_GET['busqueda'] ?? null;
        $preguntas = $this->preguntaModel->obtenerTodas($busqueda);

        $this->renderer->render('editor', [
            'preguntas' => $preguntas,
            'busqueda'  => $busqueda ?? '',
        ]);
    }

    public function crear()
    {
        $this->verificarAccesoEditor();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $enunciado   = trim($_POST['enunciado']);
            $categoriaId = (int) $_POST['categoria_id'];

            $textos   = $_POST['respuesta_texto'];
            $correcta = (int) $_POST['respuesta_correcta'];

            $respuestas = [];
            foreach ($textos as $i => $texto) {
                $respuestas[] = [
                    'texto'      => trim($texto),
                    'es_correcta' => ($i === $correcta) ? 1 : 0,
                ];
            }

            $this->preguntaModel->crear(
                $enunciado,
                $categoriaId,
                $this->usuarioSesion['id'],
                $respuestas
            );

            Redirect::to('/editor/ver');
            return;
        }
        $categorias = $this->preguntaModel->obtenerCategorias();
        $this->renderer->render('editorFormulario', [
            'categorias'   => $categorias,
            'es_modificar' => false,
            'campos_crear' => [
                ['indice' => 0, 'indice_display' => 'A'],
                ['indice' => 1, 'indice_display' => 'B'],
                ['indice' => 2, 'indice_display' => 'C'],
                ['indice' => 3, 'indice_display' => 'D'],
            ],
        ]);
    }

    public function modificar()
    {
        $this->verificarAccesoEditor();

        $id       = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
        $pregunta = $this->preguntaModel->obtenerPorId($id);

        if (!$pregunta) {
            Redirect::to('/editor/ver');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $enunciado   = trim($_POST['enunciado']);
            $categoriaId = (int) $_POST['categoria_id'];
            $textos      = $_POST['respuesta_texto'];
            $ids         = $_POST['respuesta_id'];
            $correcta    = (int) $_POST['respuesta_correcta'];

            $respuestas = [];
            foreach ($textos as $i => $texto) {
                $respuestas[] = [
                    'id'          => (int) $ids[$i],
                    'texto'       => trim($texto),
                    'es_correcta' => ($i === $correcta) ? 1 : 0,
                ];
            }

            $this->preguntaModel->modificar($id, $enunciado, $categoriaId, $respuestas);
            Redirect::to('/editor/ver');
            return;
        }

        $categorias = $this->preguntaModel->obtenerCategorias();
        $respuestas = $this->preguntaModel->obtenerRespuestas($id);

        foreach ($respuestas as $i => &$r) {
            $r['indice']         = $i;
            $r['indice_display'] = ['A','B','C','D'][$i];
        }
        unset($r);

        foreach ($categorias as &$cat) {
            $cat['seleccionada'] = ($cat['id'] === $pregunta['categoria_id']);
        }
        unset($cat);

        $this->renderer->render('editorFormulario', [
            'categorias'   => $categorias,
            'pregunta'     => $pregunta,
            'respuestas'   => $respuestas,
            'es_modificar' => true,
            'id'           => $id,
            'enunciado'    => $pregunta['enunciado'],
        ]);
    }

    public function eliminar()
    {
        $this->verificarAccesoEditor();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('/editor/ver');
            return;
        }

        $id = (int) $_POST['id'];

        $this->preguntaModel->eliminar($id);

        // Si la pregunta venía de reportes,
        // elimino también sus reportes
        if (isset($_POST['desde_reportes'])) {
            $this->reporteModel->eliminarPorPregunta($id);
            Redirect::to('/editor/reportadas');
            return;
        }

        Redirect::to('/editor/ver');
    }

    private function verificarAccesoEditor()
    {
        if ($this->usuarioSesion['rol'] !== 'editor') {
            Redirect::to('/lobby/ver');
        }
    }

    public function reportadas()
    {
        $this->verificarAccesoEditor();

        $reportes = $this->reporteModel->obtenerReportes();

        $this->renderer->render('editorReportadas', [
            'reportes' => $reportes
        ]);
    }

    public function mantenerReporte()
    {
        $this->verificarAccesoEditor();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('/editor/reportadas');
            return;
        }

        $reporteId = (int)$_POST['reporte_id'];

        // elimina todos los reportes de esa pregunta
        $this->reporteModel->mantenerReporte($reporteId);

        Redirect::to('/editor/reportadas');
    }
    public function sugeridas()
    {
        $this->verificarAccesoEditor();

        $preguntas = $this->preguntaModel->obtenerSugeridas();

        $this->renderer->render('editorSugeridas', [
            'preguntas' => $preguntas,
        ]);
    }

    public function resolverSugerida()
    {
        $this->verificarAccesoEditor();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('/editor/sugeridas');
            return;
        }

        $id     = (int) $_POST['id'];
        $accion = $_POST['accion']; // 'APROBADA' o 'RECHAZADA'

        if (in_array($accion, ['APROBADA', 'RECHAZADA'])) {
            $this->preguntaModel->cambiarEstado($id, $accion);
        }

        Redirect::to('/editor/sugeridas');
    }
}
