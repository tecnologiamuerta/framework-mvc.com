<?php
namespace Controllers;

use \System\Controllers\Controller;
use \System\Views\View;

class ErrorsController extends Controller{
    
    public function __construct($model, $controller, $action){
        parent::__construct($model, $controller, $action);
        $this->DefaultAction = "Error404Action";
    }
    
    public function Error404Action(){
        $this->View->Parameters = func_get_args();
        $this->View->Title = "Error en la aplicación";
        
        $controller = $this->View->Parameters[0];
        $action = "";
        if(isset($this->View->Parameters[1])){
            $action = $this->View->Parameters[1];
        }
        
        $this->View->controller = $controller;
        $this->View->action = $action;
        
        return $this->View;
    }
}