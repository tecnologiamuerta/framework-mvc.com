<?php
namespace System\Configuration;

class ConfigurationManager{
    public $xml;
    public $defaults;
    public $paths;
    public function __construct(){
        $this->xml = new \SimpleXMLElement(file_get_contents(ROOT."ApplicationConfig.xml"));
        $this->defaults = $this->xml->system->defaults;
        $this->paths = $this->xml->system->paths;
    }
}