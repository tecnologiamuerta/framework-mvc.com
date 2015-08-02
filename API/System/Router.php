<?php
namespace System;
class Router{
    private $Url;
    private $Routes;
    private $DefaultRoute; 
    private $Parameters;
    
    public function __construct($url, $defaultRoute){
        $this->Url = $url;
        $this->SetDefault($defaultRoute);
        $this->PrepareRoutes();
        $this->NormalizeRoute();
        $this->Dispatch();
    }
    
    public function PrepareRoutes(){
        $ruta = strlen($this->Url);
        if($ruta === 0){
            if(count($this->DefaultRoute) === 0){
                throw new \Exception("No se ha definido la ruta por default");
            }else{
                $this->Routes = $this->DefaultRoute;
            }
        }else{
            $rutas = explode("/", $this->Url);
            if(count($rutas) === 1){
                $controller = $rutas[0];
                $action = "Index";
                $queryString = array();
            }
            else if(count($rutas) === 2){
                $controller = $rutas[0];
                array_shift($rutas);
                $action = $rutas[0];
                $queryString = array();
            }
            else{
                $controller = $rutas[0];
                array_shift($rutas);
                $action = $rutas[0];
                array_shift($rutas);
                $queryString = $rutas;
            }
            $this->Routes = array(
                "controller" => $controller,
                "action" => $action,
                "parameters" => $queryString
            );
        }
    }
    
    public function Test(){
        foreach($this->Routes as $data => $value){
            if(is_array($value)){
                echo $data." = ".implode(", ", $value)."<br />";
            }else{
                echo $data." = ".$value."<br />";
            }
        }
    }
    
    private function Dispatch(){
        $controller = $this->Routes["controller"];
        $data = "\\Controllers\\".$controller;
        $dispatch = new $data($this->Routes["model"], $this->Routes["controller"], $this->Routes["action"]);
        if((int)method_exists($data, $this->Routes["action"])){
            $ViewData = call_user_func_array(array($dispatch, $this->Routes["action"]), $this->Routes["parameters"]);
            $ViewData->ViewPath = "Views\\".str_replace("Controller", "", $controller)."\\".str_replace("Action", "", $this->Routes["action"]).".php";
            if($ViewData->Layout == null){
                $MainLayout = APPLICATION."Views".DS.str_replace("Controller", "", $controller).DS.str_replace("Action", "", $this->Routes["action"]).".php";
            }else{
                $MainLayout = APPLICATION."Views".DS."Shared".DS.$ViewData->Layout.".php";
            }
            require_once($MainLayout);
        }else{
            throw new \Exception("El controlador ".$controller." con el action ".$this->Routes["action"]." no se encuentra definido");
        }
    }
    
    private function NormalizeRoute(){
        $this->Routes["model"] = rtrim($this->Routes["controller"], "s");
        $this->Routes["controller"] = ucwords($this->Routes["controller"])."Controller";
        if(strlen($this->Routes["action"]) === 0){
            $this->Routes["action"] = "Index";
        }
        $this->Routes["action"] = ucwords($this->Routes["action"])."Action";
    }
    
    private function SetDefault($defaultRoute){
        $this->DefaultRoute = $defaultRoute;
    }
    
    public function GetRoute(){
        return $this->Routes;
    }
}