<?php
use \System\Application;
use \System\Data\Model;

error_reporting(E_ALL);
ini_set("display_errors", "On");

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)).DS);
define("API", ROOT."API".DS);
define("APPLICATION", ROOT."Application".DS);

set_include_path(API.PATH_SEPARATOR.APPLICATION);
spl_autoload_extensions(".php");
spl_autoload_register(
    function($class){
        $class = str_replace("\\", DS, $class).".php";
        require_once($class);
    }
);
Application::Run();