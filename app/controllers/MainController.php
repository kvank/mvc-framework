<?php


namespace app\controllers;


use app\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        echo 'Главная страница';
    }

    public function contactAction()
    {
        echo 'Страница контактов';
    }
}