<?php
namespace System;

use \System\DataTypes\String;

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
    
    private function Dispatch(){
        $controller = $this->Routes["controller"];
        $data = "\\Controllers\\".$controller;
        $className = str_replace("\\",DS,$data).".php";
        //$notFound = stream_resolve_include_path($className);
        $notFound = !$this->FileExists($className, "");
        //echo $className.($notFound ? " No encontrado" : " Jujujuj")."<br />";
        if($notFound){
            if($controller === "ErrorsController"){
                echo "No mames no hay nada";
                return;
            }
            $this->Routes = array(
                "controller" => "ErrorsController",
                "action" => "Error404Action",
                "parameters" => array("Error" => $controller)
            );
            $this->Routes["model"] = rtrim($this->Routes["controller"], "s");
            $this->Dispatch();
            return;
        }
        
        $dispatch = new $data($this->Routes["model"], $this->Routes["controller"], $this->Routes["action"]);
        if(!method_exists($data, $this->Routes["action"])){
            $this->Routes["action"] = $dispatch->DefaultAction;
        }
        if(method_exists($data, $this->Routes["action"])){
            $ViewData = call_user_func_array(array($dispatch, $this->Routes["action"]), $this->Routes["parameters"]);
            $ViewData->ViewPath = "Views\\".str_replace("Controller", "", $controller)."\\".str_replace("Action", "", $this->Routes["action"]).".php";
            $ViewData->Controller = str_replace("Controller", "", $controller);
            if($ViewData->Layout == null){
                $MainLayout = APPLICATION."Views".DS.str_replace("Controller", "", $controller).DS.str_replace("Action", "", $this->Routes["action"]).".php";
            }else{
                $MainLayout = APPLICATION."Views".DS."Shared".DS.$ViewData->Layout.".php";
            }
            require_once($MainLayout);
        }else{
            echo "Not found";
            //throw new \Exception("El controlador ".$controller." con el action ".$this->Routes["action"]." no se encuentra definido");
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
    
    private function FileExists($path, $ext){
        $rutas = explode(PATH_SEPARATOR, get_include_path());
        foreach($rutas as $ruta){
            $cadena = new String($ruta);
            $cadena2 = new String($path);
            if(!$cadena->EndWith(DS)){
                if(!$cadena2->StartWith(DS)){
                    $ruta = $ruta.DS;
                }
            }else{
                if($cadena2->StartWith(DS)){
                    $ruta = $cadena->RemoveEnd(DS);
                }
            }
            $ruta = $ruta.$path.$ext;
            if(file_exists($ruta)){
                return true;
            }
        }
        return false;
    }
}