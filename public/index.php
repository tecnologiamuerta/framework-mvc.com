<?php
use \System\Application;
use \System\Data\Model;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)).DS);
define("API", ROOT."API".DS);
define("APPLICATION", ROOT."Application".DS);

set_include_path(get_include_path().PATH_SEPARATOR.API.PATH_SEPARATOR.APPLICATION);
spl_autoload_extensions(".php");
spl_autoload_register(
    function($class){
        $class = str_replace("\\", DS, $class);
        spl_autoload($class);
        /*$data = spl_autoload($class);
        return $data;*/
    }
);

Application::Run();