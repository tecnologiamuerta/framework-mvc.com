<div class="container">
    <div class="jumbotron text-center">
        <h1><?php echo $ViewData->PageInformation->Name; ?></h1>
        <h2><?php echo $ViewData->PageInformation->Slogan?></h2>
    </div>
    <form method="post" id="formContact" name="formContact" class="form-horizontal col-xs-8 col-xs-offset-2">
        <fieldset>
            <legend class="text-center">Tu opinión es importante, haznos la saber</legend>
            <div class="form-group">
                <label class="control-label col-xs-2" for="txtAsunto">Asunto</label>
                <div class="col-xs-10">
                    <input type="text" name="txtAsunto" id="txtAsunto" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2" for="txtNombre">nombre</label>
                <div class="col-xs-10">
                    <input type="text" name="txtnombre" id="txtnombre" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2" for="txtEmail">Email</label>
                <div class="col-xs-10">
                    <input type="text" name="txtEmail" id="txtEmail" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2" for="txtComentario">comentario</label>
                <div class="col-xs-10">
                    <textarea class="form-control" name="txtComentario" id="txtComentario" cols="10" rows="10"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2 sr-only" for="btnEnviar">Acción</label>
                <div class="col-xs-10">
                    <button type="submit"><span>Enviar</span></button>
                </div>
            </div>
        </fieldset>
    </form>
</div>