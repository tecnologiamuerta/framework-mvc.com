<?php use \System\Router; ?>
<form id="formEncrypted" method="post" role="form" data-type="ajax" action="<?php Router::RouteTo("System", "Encrypted"); ?>">
    <div class="form-group">
        <label for="txtEncriptar">Texto a encriptar</label>
        <textarea class="form-control" name="txtEncriptar" id="txtEncriptar" cols="50" rows="5"><?php
            echo $ViewData->txtEncriptar;
        ?></textarea>
    </div>
    <div class="form-group">
        <label for="txtResultado">Resultado</label>
        <textarea class="form-control" name="txtResultado" id="txtResultado" cols="50" rows="5" readonly="true"><?php
            echo $ViewData->txtResultado;
        ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Enviar" class="btn btn-default" />
    </div>
</form>