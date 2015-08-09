<?php
namespace Controllers;

use \System\Controllers\Controller;
use \System\Views\View;

class ErrorsController extends Controller{
    
    public function __construct($model, $controller, $action){
        parent::__construct($model, $controller, $action);
        $this->DefaultAction = "Error404Action";
    }
    
    /*public function IndexAction(){
        $view = new View(null, func_get_args());
        $view->Title = "Error en la aplicación";
        return $view;
    }*/
    
    public function Error404Action(){
        $view = new View(null, func_get_args());
        $view->Title = "Error en la aplicación";
        return $view;
    }
}