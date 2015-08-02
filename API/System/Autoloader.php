<?php
namespace System;

use \System\Configuration\NamespaceManager;

class Autoloader{
    const CLASS_EXTENSION = ".cphp";
    const INTERFACE_EXTENSION = ".iphp";
    
    private $system_path = array();
    private $NsManager;
    
    public function __construct(){
        $this->system_path = array(
            "API" => API,
            "APPLICATION" => APPLICATION,
        );
        spl_autoload_register(array($this, "SearchClass2"));
        $this->NsManager = new NamespaceManager();
    }
    
    private function SearchClass2($class_name){
        $path = str_replace("\\", DS, $class_name).".php";
        $fullPath = $this->system_path["API"].$path;
        if(file_exists($fullPath)){
            require_once($fullPath);
        }else{
            echo "Not found<br />";
        }
    }
    
    private function SearchClass($class_name){
        if($this->IsController($class_name)){
            $pathApplication = $this->system_path["APPLICATION"];
            $namespace = preg_replace('/Controller$/', '', $class_name, -1);
            $totalClass = $namespace.DS."Controllers".DS.$class_name;
            $class_name = $totalClass;
            echo "Is Controller: ".$class_name."<br />";
        }
        $ok = false;
        foreach($this->system_path as $alias_path){
            $file_name = $alias_path.$class_name.".php";
            if(file_exists($file_name)){
                $ok = true;
                include_once($file_name);
            }
        }
        if(!$ok){
            foreach($this->system_path as $alias_path){
                $pattern = $alias_path."*".DS.$class_name.".php";
                $list = glob($pattern, GLOB_MARK | GLOB_NOESCAPE);
                if(count($list) > 0){
                    foreach($list as $file){
                        include_once($file);
                        $ok = true;
                    }
                }
            }
        }
        if(!$ok){
            foreach($this->system_path as $alias_path){
                $data = $this->FindInDir($alias_path, $class_name.".php");
                if(count($data) > 0){
                    foreach($data as $path){
                        require_once($path);
                    }
                    return true;
                }
            }
            echo "No se pudo crear la clase ".$class_name;
        }
        return $ok;
    }
    
    private function FindInDir($dir, $fileName){
        $list = glob($dir."*".DS.$fileName);
        if(count($list) > 0){
            return $list;
        }else{
            $directorios = scandir($dir, SCANDIR_SORT_NONE);
            $directorios = array_diff($directorios, array("..", "."));
            foreach($directorios as $dirname){
                if(is_dir($dir.$dirname)){
                    return $this->FindInDir($dir.$dirname.DS, $fileName);
                }
            }
        }
    }
    
    private function IsController($className){
        if(strpos("\\", $className)) return false;
        return preg_match("/$[a-zA-Z0-9_]+Controller/",$className);
    }
}