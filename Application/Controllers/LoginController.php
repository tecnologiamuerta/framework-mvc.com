<?php
namespace Controllers;
use \System\Controllers\Controller;
use \System\Views\View;

class LoginController extends Controller{
    public function IndexAction(){
        $args = func_get_args();
        $view = new View(null, $args);
        $view->Title = "Login of System";
        return $view;
    }
}