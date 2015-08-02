<?php
namespace System\Views;

use \System\Application;

class View{
    public $Parameters;
    public $Model;
    public $ViewPath;
    public $Title;
    public $Layout;
    
    public function __construct($model, $params){
        $this->Parameters = $params;
        $this->Model = $model;
        $this->Layout = Application::$Configuration->defaults->layout["name"];
    }
}