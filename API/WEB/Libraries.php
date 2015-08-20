<?php
namespace WEB;

use \System\Application;

class Libraries{
    private static $instance;
    private $config;
    private $availableLibraries = array();
    
    public static function Load(){
        if(!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    private function __construct(){
        $this->config = Application::$Configuration->libraries;
        foreach($this->config->library as $lib){
            $alias = trim($lib["alias"]);
            $this->availableLibraries[$alias] = array(
                "Root" => "librerias/".$lib["name"]."/",
                "files" => array()
            );
            foreach($lib->children() as $file){
                $path = trim($file["path"]);
                if($path === "/"){
                    $fileName = $file["name"];
                }else{
                    $fileName = $path."/".$file["name"];
                }
                $this->availableLibraries[$alias]["files"][] = $fileName;  
            }
        }
    }
    
    public function Render($alias){
        $library = $this->availableLibraries[$alias];
        foreach($library["files"] as $file){
            $fileName = DS.$library["Root"].$file;
            $ext = pathinfo(ROOT."public".DS.$fileName)["extension"];
            if($ext === "js"){
                echo "<script type='text/javascript' src='".$fileName."'></script>";
            }else if($ext === "css"){
                echo "<link rel='stylesheet' type='text/css' href='".$fileName."' />";
            }
        }
    }
    
    public function RenderScript($js){
        $fileName = "/js/".$js;
        echo "<script type='text/javascript' src='".$fileName."'></script>";
    }
}