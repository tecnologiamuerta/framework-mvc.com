<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title><?php echo ($ViewData->Title); ?></title>
        <?php
            $ViewData->RenderLibrary("jquery");
            $ViewData->RenderLibrary("jquery-ui");
            $ViewData->RenderLibrary("bootstrap");
            $ViewData->RenderScript("Default.js");
        ?>
    </head>
    <body style="padding-top: 55px;">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden-xs" href="<?php echo $ViewData->Controller; ?>" ><?php echo $ViewData->Title; ?></a>
                    <a class="navbar-brand visible-xs collapsed collapse" data-toggle="collapse" data-target="#navbar" href="#" ><?php echo $ViewData->Title; ?></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="/">Inicio</a></li>
                        <li><a href="about">Explicación</a></li>
                        <li><a href="contact">Contacto</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container"><?php require_once(str_replace("\\", DS, $ViewData->ViewPath)); ?></div>
        <footer class="nav navbar-fixed-bottom">
            <nav class="nav navbar-inverse">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand collapse visible-xs-inline collapsed" data-toggle="collapse" data-target="#navbar_footer" href="#">Información de la página</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_footer">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div id="navbar_footer" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="licencia">Licencia</a></li>
                            <li><a href="politicas">Politica de privacidad</a></li>
                            <li><a href="terminos">Terminos del servicio</a></li>
                            <li><a href="contrato">Contrato del usuario</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </footer>
    </body>
</html>