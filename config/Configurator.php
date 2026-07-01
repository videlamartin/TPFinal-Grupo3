<?php
class Configurator
{

    private $config;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->config = parse_ini_file("config/config.ini");
    }

    public function isValidSession()
    {
        return isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario']);
    }
    public function getUsuarioSesion()
    {
        return [
            'id' => $_SESSION['id_usuario'] ?? null,
            'rol' => $_SESSION['rol'] ?? null,
            'username' => $_SESSION['username'] ?? null
        ];
    }

    public function getLoginController()
    {
        return new LoginController(
            $this->getUsuarioModel(),
            $this->getRenderer(),
            new Request()
        );
    }

    public function getUsuarioModel()
    {
        return new UsuarioModel(
            $this->getDatabase()
        );
    }

    public function getLobbyController()
    {
        return new LobbyController(
            $this->getPartidaModel(),
            $this->getPreguntaModel(),
            $this->getCategoriaModel(),
            $this->getRenderer(),
            new Request(),
            $this->getUsuarioSesion()
        );
    }

    public function getPerfilController()
    {
        return new PerfilController(
            $this->getUsuarioModel(),
            $this->getPartidaModel(),
            $this->getRenderer(),
            new Request(),
            $this->getUsuarioSesion()
        );
    }

    public function getVikingoController()
    {
        return new VikingoController($this->getVikingoModel(), $this->getRenderer(), new Request());
    }

    private function getDatabase()
    {
        return new MyDatabase(
            $this->config['hostname'],
            $this->config['username'],
            $this->config['password'],
            $this->config['database']
        );
    }

    private function getRenderer()
    {
        return new MustacheRenderer(__DIR__ . '/../view');
    }

    private function getVikingoModel()
    {
        return new VikingoModel($this->getDatabase());
    }

    public function getRouter()
    {
        return new Router($this, 'login', 'ver');
    }

    public function getOrDefault($controllerName, $defaultControllerName)
    {
        $getter = 'get' . ucfirst($controllerName) . 'Controller';
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }
        $defaultGetter = 'get' . ucfirst($defaultControllerName) . 'Controller';
        return $this->{$defaultGetter}();
    }

    public function getRegistroController()
    {
        return new RegistroController(
            $this->getUsuarioModel(),
            $this->getRenderer(),
            new Request(),
            $this->config['mail_username'],
            $this->config['mail_password']
        );
    }

    public function getPartidaModel()
    {
        return new PartidaModel(
            $this->getDatabase()
        );
    }
    public function getPreguntaModel()
    {
        return new PreguntaModel(
            $this->getDatabase()
        );
    }
    public function getCategoriaModel()
    {
        return new CategoriaModel(
            $this->getDatabase()
        );
    }
    public function getReporteModel()
    {
        return new ReporteModel(
            $this->getDatabase()
        );
    }
    public function getUsuarioPreguntaModel()
    {
        return new UsuarioPreguntaModel($this->getDatabase());
    }
    public function getPartidaController()
    {
        return new PartidaController(
            $this->getPartidaModel(),
            $this->getPreguntaModel(),
            $this->getUsuarioModel(),
            $this->getCategoriaModel(),
            $this->getRenderer(),
            new Request(),
            $this->getUsuarioSesion(),
            $this->getReporteModel(),
            $this->getUsuarioPreguntaModel()
        );
    }
    public function getRankingController()
    {
        return new RankingController(
            $this->getUsuarioModel(),
            $this->getRenderer(),
            new Request(),
            $this->getUsuarioSesion()
        );
    }
    public function getEditorController()
    {
        return new EditorController(
            $this->getPreguntaModel(),
            $this->getRenderer(),
            new Request(),
            $this->getUsuarioSesion(),
            $this->getReporteModel()
        );
    }

    public function getAdminController()
    {
        return new AdminController(
            $this->getUsuarioModel(),
            $this->getPartidaModel(),
            $this->getRenderer(),
            new Request(),
            $this->getUsuarioSesion()
        );
    }


}
