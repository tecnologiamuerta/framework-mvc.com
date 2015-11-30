<?php
namespace Controllers;
use \System\Controllers\Controller;
use \System\Views\View;

class LoginController extends Controller{
    public function IndexAction(){
        $this->View->Parameters = func_get_args();
        return $this->View;
    }
}