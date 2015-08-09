<?php
    if(Count($ViewData->Parameters) === 0){
        $ViewData->Parameters[0] = "Nothing";
    }
?>
<h1>Error 404</h1>
<p>El controlador <strong><?php echo str_replace("Controller", "", $ViewData->Parameters[0]); ?></strong> no fue encontrado</p>