<?php
    if(Count($ViewData->Parameters) === 0){
        $ViewData->Parameters[0] = "Nothing";
    }
?>
<h1>Error 404</h1>
<?php
    if(isset($ViewData->Parameters[1])){
?>
<p>El action <strong><?php echo str_replace("Action", "", $ViewData->Parameters[1]);?></strong> no existe para el controlador 
<strong><?php echo str_replace("Controller", "", $ViewData->Parameters[0]); ?></strong>
</p>
<?php
    }else{
?>
<p>El controlador <strong><?php echo str_replace("Controller", "", $ViewData->Parameters[0]); ?></strong> no fue encontrado</p>
<?php
    }
?>