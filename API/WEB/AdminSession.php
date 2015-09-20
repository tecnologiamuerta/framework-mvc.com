<?php

namespace WEB;

use \System\Application;
use \WEB\Session;

class AdminSession extends Session{
    private static $instance;
    
    public static function Init(){
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct(){
    }
    
    public function Login($password){
        if(Application::$Configuration->IsAdminPassword($password)){
            $this->InitAdminSession();
        }else{
            $this->EndAdminSession();
        }
    }
    
    public function SessionOK(){
        return $this->IsAdminActive();
    }
    
    public function GetInstance(){
        return self::$instance;
    }
    
    public function InitAdminSession(){
        $this->Set("AdminActive", true);
    }
    
    public function EndAdminSession(){
        $this->Set("AdminActive", false);
    }
    
    public function IsAdminActive(){
        return $this->Get("AdminActive");
    }
}