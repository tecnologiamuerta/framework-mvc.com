<?php
namespace System\Views;

use \System\Application;
use \WEB\Libraries;
use \WEB\Session;
use \System\Router;
use \System\Information\Page;

class View{
    public $Parameters;
    public $Model;
    public $ViewPath;
    public $Title;
    public $Layout;
    public $Post;
    public $Controller;
    public $Session;
    public $ControllerName;
    public $ActionName;
    public $PageInformation;
    
    private $CustomJS;
    private $CustomCSS;
    private $lib;
    private $Data;
    private $EsRedirect;
    private $RedirectTo;
    
    public function __construct($model, $params){
        $argumentos = func_get_args();
        switch(count($argumentos)){
            case 1:
                break;
            case 2:
                $this->Parameters = $params;
                $this->Model = $model;
                break;
        }
        $this->Layout = Application::$Configuration->defaults->layout["name"];
        $this->lib = Libraries::Load();
        $this->AfianzarParametrosPost();
        $this->CustomJS = array();
        $this->CustomCSS = array();
        $this->Session = Session::Init();
        $this->PageInformation = Page::Fill();
    }
    
    public function RenderLibrary($alias){
        $this->lib->Render($alias);
    }
    
    public function RenderScript($js){
        $this->lib->RenderScript($js);
    }
    
    public function RenderStyle($css){
        $this->lib->RenderStyle($css);
    }
    
    public function AddScript($js){
        $this->CustomJS[] = $js;
    }
    
    public function AddStyle($css){
        $this->CustomCSS[] = $css;
    }
    
    public function RenderCustomScript(){
        foreach($this->CustomJS as $js){
            $this->RenderScript($js);
        }
    }
    
    public function RenderCustomStyle(){
        foreach($this->CustomCSS as $css){
            $this->RenderStyle($css);
        }
    }
    
    public function __set($name, $value){
        $this->Data[$name] = $value;
    }
    
    public function __get($name){
        return isset($this->Data[$name]) ? $this->Data[$name] : "";
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
    
    public function SetRedirect($controller, $action){
        $this->EsRedirect = true;
        $this->RedirectTo = Router::GetRoute($controller, $action);
    }
    
    public function TryToRedirect(){
        header("Location: $this->RedirectTo");
    }
    
    public function HasRedirect(){
        return $this->EsRedirect;
    }
    
    public function ViewTo($action){
        $this->ActionName = $action;
        $this->ViewPath = "Views/".$this->ControllerName."/".$action.".php";
    }
    
    private function AfianzarParametrosPost(){
        if($this->IsPost()){
            foreach($_POST as $var => $value){
                $this->Data[$var] = $value;
            }
        }
    }
}