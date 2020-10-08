<?php


namespace app\core;


abstract class Controller
{
    public array $route;

    public function __construct($route)
    {
        $this->route = $route;
    }
}