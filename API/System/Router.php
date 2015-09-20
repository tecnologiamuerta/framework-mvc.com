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
    
    public static function RouteTo($controller, $action){
        echo "\\$controller\\$action";
    }
    
    public static function GetRoute($controller, $action){
        return "\\$controller\\$action";
    }
    
    private function Dispatch(){
        $controller = $this->Routes["controller"];
        $data = "\\Controllers\\".$controller;
        $className = str_replace("\\",DS,$data).".php";
        $notFound = !$this->FileExists($className, "");
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
            if($controller === "ErrorsController"){
                echo "No mames no hay nada";
                return;
            }
            $this->Routes = array(
                "controller" => "ErrorsController",
                "action" => "Error404Action",
                "parameters" => array("Error" => $controller, "Action" => $this->Routes["action"])
            );
            $this->Routes["model"] = rtrim($this->Routes["controller"], "s");
            $this->Dispatch();
            return;
        }
        if(method_exists($data, $this->Routes["action"])){
            $ViewData = call_user_func_array(array($dispatch, $this->Routes["action"]), $this->Routes["parameters"]);
            //echo $ViewData->HasRedirect() ? "Si" : "No";
            if($ViewData->HasRedirect()){
                $ViewData->TryToRedirect();
            }else{
                if($ViewData->Layout == null){
                    $MainLayout = APPLICATION.$ViewData->ViewPath;
                }else{
                    $MainLayout = APPLICATION."Views"."/"."Shared"."/".$ViewData->Layout.".php";
                }
                ob_start(array($this, "Response"));
                require_once($MainLayout);
                ob_end_flush();
            }
        }else{
            echo "Not found";
        }
    }
    
    public function Response($str){
        return str_replace("@var", "Prueba exitosa", $str);
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
    
    public function GetRoutes(){
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