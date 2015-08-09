<?php
namespace System\Configuration;

class ConfigurationManager{
    public $xml;
    public $defaults;
    public $paths;
    public $libraries;
    public $connections;
    public $environment;
    public $routes;
    public function __construct(){
        $this->xml = new \SimpleXMLElement(file_get_contents(ROOT."ApplicationConfig.xml"));
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
}