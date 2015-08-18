<?php
use \System\Application;
use \System\Data\Model;

error_reporting(E_ALL);
ini_set("display_errors", "On");

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)).DS);
define("API", ROOT."API".DS);
define("APPLICATION", ROOT."Application".DS);

set_include_path(get_include_path().PATH_SEPARATOR.API.PATH_SEPARATOR.APPLICATION);
spl_autoload_extensions(".php");
spl_autoload_register(
    function($class){
        $class = str_replace("\\", DS, $class).".php";
		$rutas = explode(PATH_SEPARATOR ,get_include_path());
		foreach($rutas as $ruta){
                        //echo $ruta.$class."<br />";
			if(file_exists($ruta.$class)){
				require_once($ruta.$class);
				return;
			}
		}
        //spl_autoload($class);
    }
);
Application::Run();