<?php
namespace System\Controllers;

class Controller implements IController{
    protected $Model;
    protected $Action;
    protected $Controller;
    
    public function __construct($model, $controller, $action){
        $this->Action = $action;
        $this->Controller = $controller;
        $this->Model = $model;
    }
    
    public function SetVariable($name, $value){
    }
    
    public function __destruct(){
        
    }
}