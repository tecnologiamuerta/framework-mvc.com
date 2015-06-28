<?php
    class RegisterPHP{
        private $RegisteredNamespace = [];
        
        public function Add($name){
            $this->RegisteredNamespace[] = $name;
        }
        
        public function GetNamespace(){
            return $this->RegisteredNamespace;
        }
    }
?>