<?php
namespace System\Controllers;

use \System\Views\View;
use \System\DataTypes\String;
use \WEB\AdminSession;

class Controller implements IController{
    protected $Model;
    protected $Action;
    protected $Controller;
    protected $View;
    protected $SessionAdmin;
    
    public $DefaultAction;
    
    public function __construct($model, $controller, $action){
        $controller = new String($controller);
        $action = new String($action);
        $modelClass = "\\Models\\$model";
        $this->Action = $action;
        $this->Controller = $controller;
        
        $notFound = stream_resolve_include_path(str_replace("\\",DS,$modelClass).".php") === false;
        if(!$notFound){
            $this->Model = new $modelClass();
        }else{
            $this->Model = null;
        }
        $this->DefaultAction = "IndexAction";
        $this->View = new View($this->Model, null);
        $this->View->ControllerName = $controller->Replace("Controller", "");
        $this->View->ActionName = $action->Replace("Action", "");
        $this->View->ViewPath = "Views/".$this->View->ControllerName."/".$this->View->ActionName.".php";
        $this->SessionAdmin = AdminSession::Init();
    }
}