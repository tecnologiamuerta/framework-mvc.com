<?php
namespace Controllers;

use \System\Controllers\Controller;
use \System\Views\View;
use \System\Security\Encryption\Cipher;
use \System\Application;

class EncryptedController extends Controller{
    private $View;
    
    public function __construct($model, $controller, $action){
        parent::__construct($model, $controller, $action);
    }
    
    public function IndexAction(){
        $args = func_get_args();
        $this->View = new View(null, $args);
        $this->View->Title = "Servicio de criptografia";
        if($this->View->IsPost()){
            $cipher = new Cipher(Application::$Configuration->GetKey());
            $out = $cipher->encrypt($this->View->txtEncriptar);
            $this->View->txtResultado = $out;
            $this->View->a = $cipher->decrypt($out);
        }
        return $this->View;
    }
}