<?php
namespace System;

class NamespaceMapGenerator{
    const FILE_NAME = "NamespaceDefinition.xml";
    
    private static $instance;
    private $RootSystem;
    
    public static function Generate($root_path){
        if(!self::$instance instanceof self){
            self::$instance = new self($root_path);
        }
        return self::$instance;
    }
    
    private function __construct($root_path){
        $this->RootSystem = $root_path;
        $xml = new \SimpleXMLElement("<api></api>");
        $xml->addAttribute("vendor", "Tecnologia Muerta");
        $xml->addAttribute("path", $this->RootSystem);
        
        $this->CreateXMLNode($this->RootSystem, $xml);
        $xml->asXML($root_path.self::FILE_NAME);
    }
    
    private function CreateXMLNode($dir, $xmlParent){
        $root = $this->GetFilesOfDir($dir);
        $elementName = "";
        foreach($root["file"] as $file){
            $tokens = $this->GetTokens(file_get_contents($file));
            if(count($tokens) > 0){
                foreach($tokens as $data){
                    $elementName = "unknow";
                    if($data[0] == T_INTERFACE) $elementName = "interface";
                    if($data[0] == T_CLASS) $elementName = "class";
                    if($elementName !== "unknow"){
                        $node = $xmlParent->addChild($elementName);
                        $path = pathinfo($file);
                        $node->addAttribute("name", $data[1]);
                        $node->addAttribute("file", basename($file));
                    }
                }
            }
        }
        foreach($root["directory"] as $dirName){
            $next = $xmlParent->addChild("namespace");
            $next->addAttribute("name", basename($dirName));
            $this->CreateXMLNode($dirName, $next);
        }
    }
    
    private function GetFilesOfDir($dir){
        $resultado = array("directory" => array(), "file" => array(), "error" => array());
        $directory = array_diff(scandir($dir, SCANDIR_SORT_NONE), array(".", ".."));
        $directorios = array();
        $archivos = array();
        foreach($directory as $dir_name){
            $data = $dir.$dir_name;
            if(is_dir($data)){
                array_push($resultado["directory"], $data.DS);
            }else if(is_file($data)){
                array_push($resultado["file"], $data);
            }else{
                array_push($resultado["error"], $data);
            }
        }
        return $resultado;
    }
    
    private function GetTokens($file_content){
        $tokens = token_get_all($file_content);
        $count = count($tokens);
        $data = array();
        for($i = 2; $i < $count; $i++){
            if(($tokens[$i - 2][0] == T_CLASS || $tokens[$i - 2][0] == T_INTERFACE) && 
                $tokens[$i - 1][0] == T_WHITESPACE && 
                $tokens[$i][0] == T_STRING){
                $data[] = array($tokens[$i - 2][0] ,$tokens[$i][1]);
            }
        }
        return $data;
    }
}