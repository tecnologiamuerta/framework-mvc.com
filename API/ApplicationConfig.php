<?php
    require_once("RegisterNamespace.php");
    
    $namespace = new RegisterPHP();
    $namespace->Add("\Views");
    
    $GLOBALS["namespaces"] = $namespace;
    
    require_once("classloader.php");
?>