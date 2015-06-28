<?php
    function Loader($className){
        $fileName = '';
        $namespace = '';
        
        $includePath = dirname(__FILE__).DIRECTORY_SEPARATOR."MVC";
        
        if(false !== ($lastNsPost = strripos($className, '\\'))){
            $namespace = substr($className, 0, $lastNsPost);
            $className = substr($className, $lastNsPost + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
        }
        
        $fileName .= str_replace("_", DIRECTORY_SEPARATOR, $className).".php";
        $fileFullName = $includePath.DIRECTORY_SEPARATOR.$fileName;
        
        if(file_exists($fileFullName)){
            require_once($fileFullName);
        }else{
            foreach($GLOBALS["namespace"]->GetNamespace() as $ns){
                $fileName = str_replace("\\", "", $ns).DIRECTORY_SEPARATOR;
                if(false !== ($lastNsPost = strripos($className, '\\'))){
                    $namespace = substr($className, 0, $lastNsPost);
                    $className = substr($className, $lastNsPost + 1);
                    $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
                }
                $fileName .= str_replace("_", DIRECTORY_SEPARATOR, $className).".php";
                $fileFullName = $includePath.DIRECTORY_SEPARATOR.$fileName;
                
                if(file_exists($fileFullName)){
                    require_once($fileFullName);
                }
            }
        }
    }
    
    spl_autoload_register("Loader", false);
?>