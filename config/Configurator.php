<?php
class Configurator
{

    private $config;

    public function __construct()
    {
        $this->config = parse_ini_file("config/config.ini");
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
            $this->getRenderer(),
            new Request()
        );
    }

    public function getPerfilController()
    {
        return new PerfilController(
            $this->getUsuarioModel(),
            $this->getPartidaModel(),
            $this->getRenderer(),
            new Request()
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
    public function getPartidaController()
    {
        return new PartidaController(
            $this->getPartidaModel(),
            $this->getPreguntaModel(),
            $this->getUsuarioModel(),
            $this->getCategoriaModel(),
            $this->getRenderer(),
            new Request()
        );
    }
    public function getRankingController()
    {
        return new RankingController(
            $this->getUsuarioModel(),
            $this->getRenderer(),
            new Request()
        );
    }
}
