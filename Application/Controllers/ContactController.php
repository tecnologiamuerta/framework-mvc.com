<?php
namespace controllers;

use \System\Controllers\Controller;
use \System\Views\View;
use \System\Application;
use \WEB\AdminSession;

class ContactController extends Controller
{
    public function IndexAction(){
        $this->View->Parameters = func_get_args();
        return $this->View;
    }
}
?>