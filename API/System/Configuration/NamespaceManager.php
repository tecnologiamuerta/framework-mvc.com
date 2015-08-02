<?php
namespace System\Configuration;

class NamespaceManager{
    const CONTAINER_NAME = "NamespaceDefinition.xml";
    private $XmlDocument;
    public function __construct(){
        $path = ROOT.self::CONTAINER_NAME;
        $this->XmlDocument = simplexml_load_file($path);
        var_dump($this->XmlDocument);
    }
}