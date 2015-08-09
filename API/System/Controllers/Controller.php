<?php
namespace System\Controllers;

class Controller implements IController{
    protected $Model;
    protected $Action;
    protected $Controller;
    
    public $DefaultAction;
    
    public function __construct($model, $controller, $action){
        $this->Action = $action;
        $this->Controller = $controller;
        $this->Model = $model;
        $this->DefaultAction = "IndexAction";
    }
    
    public function SetVariable($name, $value){
    }
    
    public function __destruct(){
        
    }
}