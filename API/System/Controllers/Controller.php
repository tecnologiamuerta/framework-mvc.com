<?php
namespace System\Controllers;

class Controller implements IController{
    protected $Model;
    protected $Action;
    protected $Controller;
    
    public $DefaultAction;
    
    public function __construct($model, $controller, $action){
        $modelClass = "\\Models\\$model";
        $this->Action = $action;
        $this->Controller = $controller;
        
        $notFound = stream_resolve_include_path(str_replace("\\",DS,$modelClass).".php") === false;
        if(!$notFound){
            $this->Model = new $modelClass();
        }
        $this->DefaultAction = "IndexAction";
    }
}