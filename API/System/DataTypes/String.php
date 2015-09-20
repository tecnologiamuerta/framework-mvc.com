<?php
namespace System\DataTypes;
class String{
    const EmptyString = "";
    private $data = "";
    public function __construct($defaultData){
        $this->data = $defaultData;
    }
    
    public function Contains($data){
        return (strpos($this->data, $data) !== FALSE);
    }
    
    public function IsNullOrEmpty(){
        return !($this->data !== null && $this->data !== self::EmptyString);
    }
    
    public function EndWith($str){
        if(substr($this->data, strlen($this->data) - strlen($str)) === $str){
            return true;
        }
        return false;
    }
    
    public function StartWith($str){
        if(substr($this->data, 0, strlen($str)) === $str){
            return true;
        }
        return false;
    }
    
    public function RemoveEnd($str){
        if($this->EndWith($str)){
            return substr($this->data, 0, strlen($this->data) - strlen($str));
        }else return $this->data;
    }
    
    public function RemoveStart($str){
        if($this->StartWith($str)){
            return substr($this->data, strlen($str));
        }else return $this->data;
    }
    
    public function Equals($data){
        return strcmp($this->data, $data) === 0;
    }
    
    public function Replace($strSearch, $strReplace){
        return str_replace($strSearch, $strReplace, $this->data);
    }
    
    public function __toString(){
        return $this->data;
    }
}