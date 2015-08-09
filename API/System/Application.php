<?php
namespace System;

use \System\Router;
use \System\Configuration\ConfigurationManager;
use \WEB\Libraries;

class Application{
    private $Root;
    private static $instance;
    private static $IsDeveloper;
    private static $LogPath;
    
    public static $Url;
    public static $Route;
    public static $Configuration;
    public static $Libraries;
    public static $Model;
    
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
            self::$Model = new \System\Data\Model();
            self::$IsDeveloper = self::$Configuration->environment["type"] === "developer";
            
            $this->SetReportingEnvironment();
            $this->RemoveMagicQuotes();
            $this->UnregisterGlobals();
        }
    }
    
    private function StripSlashesDeep($value){
        $value = is_array($value)? array_map("stripSlashesDeep", $value) : stripslashes($value);
        return $value;
    }
    
    private function RemoveMagicQuotes(){
        if(get_magic_quotes_gpc()){
            $_GET = $this->StripSlashesDeep($_GET);
            $_POST = $this->StripSlashesDeep($_POST);
            $_COOKIE = $this->StripSlashesDeep($_COOKIE);
        }
    }
    
    private function UnregisterGlobals(){
        if(ini_get("register_globals")){
            $array = array("_SESSION", "_POST", "_GET", "_COOKIE", "_REQUEST", "_SERVER", "_ENV", "_FILES");
            foreach($array as $value){
                foreach($GLOBALS[$value] as $key => $var){
                    if($var === $GLOBALS[$key]){
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
    
    private function SetReportingEnvironment(){
        if(self::$IsDeveloper){
            error_reporting(E_ALL);
            ini_set("display_errors", "On");
        }else{
            self::$LogPath = ROOT.self::$Configuration->defaults->log["path"].DS."application.log";
            error_reporting(E_ALL);
            ini_set("display", "Off");
            ini_set("log_errors", "On");
            ini_set("error_log", self::$LogPath);
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