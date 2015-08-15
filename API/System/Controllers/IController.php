<?php
namespace System\Controllers;

interface IController{
    public function __construct($model, $controller, $action);
}