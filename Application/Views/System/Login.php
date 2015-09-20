<?php use \System\Router; ?>
<form id="formLogin" method="post" role="form" class="form-horizontal container" action="<?php Router::RouteTo("System", "Login"); ?>">
    <fieldset>
        <legend class="form-group">System login</legend>
        <div class="form-group">
            <label for="txtPassword"><span class="glyphicon glyphicon-lock"></span> Password</label>
            <input name="txtPassword" id="txtPassword" type="password" class="form-control" placeholder="password" value="<?php echo $ViewData->txtPassword;?>" />
        </div>
        <div class="form-group">
            <input type="submit" value="Login" class="btn btn-default" />
        </div>
        <?php
            if($ViewData->Error == true){
        ?>
        <p class="alert alert-danger" style="padding: 20px;">
            <span class="glyphicon glyphicon-alert"></span>
            Contraseña incorrecta
        </p>
        <?php
            }
        ?>
    </fieldset>
</form>