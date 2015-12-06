<?php
namespace System\Information;

use \System\Application;

class Page{
    public $Name;
    public $Slogan;
    public $Version;
    
    private static $instance;
    
    public static function Fill(){
        if(!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    private function __construct(){
        $this->Name = Application::$Configuration->pageInfo->name;
        $this->Slogan = Application::$Configuration->pageInfo->slogan;
        $this->Version = Application::$Configuration->pageInfo["version"];
    }
}
?>