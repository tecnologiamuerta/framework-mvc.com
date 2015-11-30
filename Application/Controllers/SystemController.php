<?php
namespace controllers;

use \System\Controllers\Controller;
use \System\Views\View;
use \System\Security\Encryption\Cipher;
use \System\Application;
use \WEB\AdminSession;

class SystemController extends Controller{
    
    public function IndexAction(){
        $this->View->Parameters = func_get_args();
        $this->View->AddScript("AjaxUtils.js");
        $this->View->AddStyle("System.css");
        if(!$this->SessionAdmin->IsAdminActive()){
            $this->View->SetRedirect("System", "Login");
        }
        return $this->View;
    }
    
    public function EncryptedAction(){
        $this->View->Parameters = func_get_args();
        if($this->View->IsPost()){
            $cipher = new Cipher(Application::$Configuration->GetKey());
            $out = $cipher->encrypt($this->View->txtEncriptar);
            $this->View->txtResultado = $out;
            $this->View->a = $cipher->decrypt($out);
        }
        $this->View->Layout = null;
        return $this->View;
    }
    
    public function LoginAction(){
        $this->View->Parameters = func_get_args();
        if($this->View->IsPost()){
            $this->SessionAdmin->Login($this->View->txtPassword);
            if($this->SessionAdmin->IsAdminActive()){
                $this->View->SetRedirect("System", "Index");
            }else{
                $this->View->Error = true;
            }
        }
        return $this->View;
    }
    
    public function LogoutAction(){
        if($this->SessionAdmin->IsAdminActive()){
            $this->SessionAdmin->EndAdminSession();
        }
        $this->View->SetRedirect("System", "Index");
        return $this->View;
    }
}