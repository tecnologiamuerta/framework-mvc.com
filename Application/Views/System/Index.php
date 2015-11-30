<?php use \System\Router; ?>
<div class="row">
    <div id="leftbar" class="col-xs-4 col-sm-4 col-md-2 col-lg-2 navbar">
        <ul class="nav nav-stacked nav-pills">
            <li>
                <a data-type="ajax" data-target="#target" href="<?php Router::RouteTo("System", "Encrypted"); ?>">Encrypted</a>
            </li>
            <li>
                <a href="<?php Router::RouteTo("System", "Logout");?>">Cerrar sesión</a>
            </li>
        </ul>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-10 col-lg-10">
        <div id="target"></div>
    </div>
</div>