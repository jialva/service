<div class="dashboard-wrapper">
    <div class="row gutter">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="page-title">
                <h3><?=$date['titulopagina']?></h3>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label for="creditCard">Ciclo</label>
                    <select class="form-control" id="codciclo" name="codciclo">
                        <?=$date['ciclos']?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="creditCard">Nro de Inscripción</label>
                    <input class="form-control" id="nroinscripcion" name="nroinscripcion">
                </div>
                <div class="demo-btn-group center-text">
                    <a href="javascript:void(0)" class="btn btn-info" onclick="actualizar()">Actualizar</a>
                </div>                
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <div class="row gutter">
                        <div class="col-md-6">
                            <label for="creditCard">Archivo</label>
                            <form enctype="multipart/form-data" id="formulario" onsubmit="return false;">
                                <input type="file" class="form-control" id="archivo" name="archivo" accept=".csv" onchange="limpiar()">
                                <label>El archivo debe ser en formato .csv</label>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="demo-btn-group center-text">
                                <a href="javascript:void(0)" id="btnactualizar" class="btn btn-info" onclick="actualizar()" style="margin-top: 30px;">Actualizar</a>
                            </div>   
                        </div>
                    </div>
                </div>                             
            </div>
        </div>
    </div>
</div>