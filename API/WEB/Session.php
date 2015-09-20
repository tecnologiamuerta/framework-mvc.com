<?php
namespace WEB;

use \System\Application;
use \System\DataTypes\String;

class Session{
    private static $session;
    
    public static function Init(){
        if(self::$session == null){
            self::$session = new self();
        }
        return self::$session;
    }
    
    private function __construct(){
        if(session_status() == PHP_SESSION_NONE)
            session_start();
    }
    
    public function Get($name){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return String::EmptyString;
    }
    
    public function Set($name, $value){
        $_SESSION[$name] = $value;
    }
    
    public function Exists($name){
        return isset($_SESSION[$name]);
    }
    
    public function GetExpiration(){
        return session_cache_expire();
    }
    
    public function SetExpiration($newExpiration){
        session_cache_expire($newExpiration);
    }
    
    public function Destroy(){
        session_destroy();
    }
    
    public function __destruct(){
        //session_destroy();
    }
    
    public function GetSessionID(){
        return session_id();
    }
}