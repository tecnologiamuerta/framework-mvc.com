<?php
namespace Controllers;

use \System\Controllers\Controller;
use \System\Views\View;
use \System\DataTypes\String;
use \System\Collections\Collectionable;

class HomeController extends Controller{
    public function IndexAction(){
        $this->View->Parameters = func_get_args();
        $this->View->Title = "Tecnología Muerta";
        $this->View->Layout = "SharedView";
        $this->View->Data = new Collectionable();
        return $this->View;
    }
}