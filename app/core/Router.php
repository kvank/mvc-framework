<?php


namespace app\core;


class Router
{
    protected array $routes = [];
    protected array $params = [];

    public function __construct()
    {
        $routes = require 'app/config/routes.php';
        foreach ($routes as $key => $value) {
            $this->add($key, $value);
        }
    }

    // Добавление маршрута
    public function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    // Проверка маршрута
    public function match()
    {
        $url = trim(str_replace(APP_ROOT_DIR, '', $_SERVER['REQUEST_URI']), '/');
        //$url = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    echo 'Не удалось вызвать действие: ' . $action;
                }
            } else {
                echo 'Не удалось загрузить контроллер: ' . $path;
            }
        } else {
            echo 'Маршрут не найден';
        }
    }
}