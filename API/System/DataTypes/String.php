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
    
    public function __toString(){
        return $this->data;
    }
}