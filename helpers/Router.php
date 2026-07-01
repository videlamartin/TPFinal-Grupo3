<?php

class Router
{
    private $config;
    private $defaultController;
    private $defaultMethod;

    private $rutasPublicas = [
        'login'    => ['ver', 'login', 'validarCuenta', 'logout'],
        'registro' => ['ver', 'registrar', 'validar'],
    ];

    private $rutasRestringidas = [
        'editor' => ['editor'],
        'admin' => ['administrador']
    ];
    public function __construct($config, $defaultController, $defaultMethod)
    {
        $this->config            = $config;
        $this->defaultController = $defaultController;
        $this->defaultMethod     = $defaultMethod;
    }

    public function dispatch($controller, $method)
    {
        if (!$this->esRutaPublica($controller, $method) && !$this->config->isValidSession()) {
            Redirect::to('/login/ver');
            return;
        }

        if (!$this->tieneAcceso($controller)) {
            Redirect::to('/lobby/ver');
            return;
        }

        $controller = $this->getController($controller);
        $method     = $this->getMethod($controller, $method);
        $controller->{$method}();
    }

    private function tieneAcceso($controller)
    {
        if (!isset($this->rutasRestringidas[$controller])) {
            return true;
        }
        $rol = $this->config->getUsuarioSesion()['rol'] ?? null;
        return in_array($rol, $this->rutasRestringidas[$controller]);
    }
    private function esRutaPublica($controller, $method)
    {
        return isset($this->rutasPublicas[$controller])
            && in_array($method, $this->rutasPublicas[$controller]);
    }

    private function getController($controller)
    {
        return $this->config->getOrDefault($controller, $this->defaultController);
    }

    private function getMethod($controller, $method)
    {
        return method_exists($controller, $method) ? $method : $this->defaultMethod;
    }
}
