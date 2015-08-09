<?php
namespace System\Views;

use \System\Application;
use \WEB\Libraries;

class View{
    public $Parameters;
    public $Model;
    public $ViewPath;
    public $Title;
    public $Layout;
    public $Post;
    public $Controller;
    
    private $lib;
    private $Data;
    
    public function __construct($model, $params){
        $this->Parameters = $params;
        $this->Model = $model;
        $this->Layout = Application::$Configuration->defaults->layout["name"];
        $this->lib = Libraries::Load();
        $this->AfianzarParametrosPost();
    }
    
    public function RenderLibrary($alias){
        $this->lib->Render($alias);
    }
    
    public function __set($name, $value){
        $this->Data[$name] = $value;
    }
    
    public function __get($name){
        return $this->Data[$name];
    }
    
    public function __isset($name){
        return isset($this->Data[$name]);
    }
    
    public function __unset($name){
        unset($this->Data[$name]);
    }
    
    public function IsPost(){
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }
    
    private function AfianzarParametrosPost(){
        if($this->IsPost()){
            foreach($_POST as $var => $value){
                $this->Data[$var] = $value;
            }
        }
    }
}