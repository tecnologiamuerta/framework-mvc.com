<?php
namespace Controllers;

use \System\Controllers\Controller;
use \System\Views\View;
use \System\DataTypes\String;
use \System\Collections\Collectionable;

class HomeController extends Controller{
    public function IndexAction(){
        $args = func_get_args();
        $view = new View(null, $args);
        $view->Title = "Programadores de Tecnología Muerta";
        $view->Layout = "SharedView";
        $view->Data = new Collectionable();
        //$view->Data["op"] = "Prueba";
        //$view->Data[] = "Prueba2";
        return $view;
    }
}