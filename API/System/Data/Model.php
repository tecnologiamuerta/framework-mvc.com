<?php
namespace System\Data;

use \System\Application;
use \System\Security\Encryption\Cipher;

class Model implements IDBContext{
    private $DBLink;
    private $Connections;
    private $useAlias;
    private $IsEncrypted;
    private $UseConnectionString;
    
    public $ConnectionString;
    public $ArrayParameters;
    public $Result;
    public $Rows;
    
    public function __construct(){
        $this->Connections = Application::$Configuration->connections;
        $this->useAlias = Application::$Configuration->defaults->connection["alias"];
        $this->ConnectionString = $this->CreateOrGetConnectionString();
        $this->prepareDBParameters();
    }
    
    private function CreateOrGetConnectionString(){
        $xpath = 'connection[@alias="'.$this->useAlias.'"]';
        $connection = $this->Connections->xpath($xpath)[0];
        $this->IsEncrypted = $connection["encrypted"] == "true";
        $this->UseConnectionString = $connection["useConnectionString"] == "true";
        
        $connectionString = $connection["connectionString"];
        if($this->IsEncrypted){
            $cipher = new Cipher(Application::$Configuration->GetKey());
            if($this->UseConnectionString){
                $connectionString = $cipher->decrypt($connectionString);
            }else{
                $server = $cipher->decrypt($connection->server["value"]);
                $database = $cipher->decrypt($connection->database["value"]);
                $user = $cipher->decrypt($connection->user["value"]);
                $password = $cipher->decrypt($connection->password["value"]);
                $port = $cipher->decrypt($connection->port["value"]);
                $connectionString = "Server=$server;Port=$port;Database=$database;Uid=$user;Pwd=$password;";
            }
        }else{
            if(!$this->UseConnectionString){
                $server = $connection->server["value"];
                $database = $connection->database["value"];
                $user = $connection->user["value"];
                $password = $connection->password["value"];
                $port = $connection->port["value"];
                $connectionString = "Server=$server;Port=$port;Database=$database;Uid=$user;Pwd=$password;";
            }
        }
        $connectionString = rtrim($connectionString, ";");
        return $connectionString;
    }
    
    private function prepareDBParameters(){
        $partes = explode(";", $this->ConnectionString);
        $array = array();
        foreach($partes as $param){
            $parameters = explode("=", $param);
            $array["$parameters[0]"] = $parameters[1];
        }
        $this->ArrayParameters = $array;
    }
    
    public function Connect(){
        $this->DBLink = mysqli_connect(
            $this->ArrayParameters["Server"], 
            $this->ArrayParameters["Uid"], 
            $this->ArrayParameters["Pwd"],
            $this->ArrayParameters["Database"], 
            $this->ArrayParameters["Port"]
        );
    }
    
    public function Disconnect(){
        return mysqli_close($this->DBLink);
    }
    
    public function GetError(){
        return mysqli_error($this->DBLink);
    }
    
    public function GetErrorNo(){
        return mysqli_errno($this->DBLink);
    }
    
    public function GetNumRows(){
        return mysqli_num_rows($this->Result);
    }
    
    public function FreeResult(){
        mysqli_free_result($this->Result);
    }
    
    public function IsConnected(){
        return !mysqli_connect_errno();
    }
    
    public function Query($sql){
        $this->Result = mysqli_query($this->DBLink, $sql);
        $this->FetchAll();
        return $this->Result;
    }
    
    private function FetchAll(){
        $array = array();
        if(!($this->Result == false)){
            while($row = mysqli_fetch_assoc($this->Result)){
                foreach($row as $cell => $value){
                    if(!isset($array[$cell])){
                        $array[$cell] = array();
                    }
                    $array[$cell][] = $value;
                }
            }
        }
        $this->Rows = $array;
    }
    
    public function Next(){
    }
}