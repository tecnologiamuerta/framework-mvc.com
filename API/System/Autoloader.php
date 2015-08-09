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
        spl_autoload_register(array($this, "SearchClass"));
        $this->NsManager = new NamespaceManager();
    }
    
    private function SearchClass($class_name){
        $path = str_replace("\\", DS, $class_name).".php";
        $fullPath = $this->system_path["API"].$path;
        if(file_exists($fullPath)){
            require_once($fullPath);
        }else{
            echo "Not found<br />";
        }
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