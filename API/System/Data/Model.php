<?php
namespace System\Data;

use \System\Application;

class Model implements IDBContext{
    private $DBLink;
    private $Connections;
    private $useAlias;
    private $IsEncrypted;
    private $UseConnectionString;
    
    public function __construct(){
        $this->Connections = Application::$Configuration->connections;
        $this->useAlias = Application::$Configuration->defaults->connection["alias"];
        $this->CreateOrGetConnectionString();
    }
    
    private function CreateOrGetConnectionString(){
        $xpath = 'connection[@alias="'.$this->useAlias.'"]';
        $connection = $this->Connections->xpath($xpath)[0];
        $this->IsEncrypted = $connection["encrypted"] === "true";
        $this->UseConnectionString = $connection["useConnectionString"] === "true";
    }
    
    public function Connect(){
        
    }
    
    public function Disconnect(){
        
    }
    
    public function GetError(){
        
    }
    
    public function GetNumRows(){
        
    }
    
    public function FreeResult(){
        
    }
}