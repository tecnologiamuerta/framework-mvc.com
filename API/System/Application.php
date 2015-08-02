<?php
namespace System;

use \System\Router;
use \System\Configuration\ConfigurationManager;

class Application{
    private $Root;
    private static $instance;
    
    public static $Url;
    public static $Route;
    public static $Configuration; 
    
    public static function Run(){
        if(!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    private function __construct(){
        $this->Root = dirname(dirname(__FILE__));
        self::$Url = isset($_GET["url"]) ? $_GET["url"] : "";
        if(self::$Url === "map"){
            NamespaceMapGenerator::Generate(ROOT);
        }else{
            self::$Configuration = new ConfigurationManager();
            self::$Route = new Router(self::$Url, array(
                "controller" => self::$Configuration->defaults->route["controller"],
                "action" => self::$Configuration->defaults->route["action"],
                "parameters" => array()
            ));
        }
    }
    
    public function __get($name){
        switch($name){
            case "Root":
                return $this->Root;
            break;
            case "Url":
                return $this->Url;
            break;
            default:
                return null;
        }
    }
    
    public function __set($name, $value){
        switch($name){
            case "Root":
                $this->Root = $value;
            break;
        }
    }
}