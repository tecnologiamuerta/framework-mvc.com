<?php
namespace System\Configuration;

use \System\DataTypes\String;
use \System\Security\Encryption\Cipher;

class ConfigurationManager{
    public $xml;
    public $defaults;
    public $paths;
    public $libraries;
    public $connections;
    public $environment;
    public $routes;
    public $fileName;
    public function __construct(){
        $this->fileName = ROOT."ApplicationConfig.xml";
        $this->xml = new \SimpleXMLElement(file_get_contents($this->fileName));
        $this->defaults = $this->xml->system->defaults;
        $this->paths = $this->xml->system->paths;
        $this->libraries = $this->xml->libraries;
        $this->connections = $this->xml->system->connections;
        $this->environment = $this->xml->system->environment;
        $this->routes = $this->xml->system->routes;
    }
    
    public function GetDefaultAction($controller){
        $route = $this->xml->system->routes["route[@controller=".$controller."]"];
        return $route;
    }
    
    public function GetKey(){
        $key = $this->xml["key"];
        if($key == null || $key == ""){
            $key = $this->GenerateKey($key);
            $this->SetKey($key);
            $this->Save();
        }
        return $key;
    }
    
    public function IsAdminPassword($password){
        $admin = $this->xml->system->admin;
        $adminPassword = new String($admin["password"]);
        
        $cipher = new Cipher($this->GetKey());
        $capturePassword = $cipher->encrypt($password);
        if($adminPassword->Equals($capturePassword)){
            return true;
        }else{
            return false;
        }
    }
    
    public function SetKey($key){
        $this->xml->addAttribute("key", $key);
    }
    
    public function Save(){
        $this->xml->asXML($this->fileName);
    }
    
    private function GenerateKey(){
        $date = date("d/m/Y H:i:s", time());
        $requestTime = $_SERVER["REQUEST_TIME"];
        $remoteAddr = $_SERVER["REMOTE_ADDR"];
        return sha1($date.$requestTime.$remoteAddr.time());
    }
}