<?php
namespace System\Controllers;

interface IController{
    public function __construct($model, $controller, $action);
    public function __destruct();
    public function SetVariable($name, $value);
}