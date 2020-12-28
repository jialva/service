<div class="dashboard-wrapper">
    <div class="row gutter">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="page-title">
                <h3><?=$date['titulopagina']?></h3>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <div class="row gutter">
                        <div class="col-md-8">
                            <div style="overflow-y: scroll;height: 450px;">
                                <table class="table table-striped no-margin">
                                    <thead>
                                        <tr><th>C&oacute;digo</th><th>Descripci&oacute;n</th></tr>
                                    </thead>
                                    <tbody>
                                        <?=$date['tipoentidades']?>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                        <div class="col-md-4 demo-btn-group center-text">
                            <label for="creditCard">Archivo</label>
                            <form enctype="multipart/form-data" id="formulario" onsubmit="return false;">
                                <input type="file" class="form-control" id="archivo" name="archivo" accept=".csv">
                                <label>El archivo debe ser en formato .csv</label>
                            </form>
                            <a href="javascript:void(0)" class="btn btn-info" onclick="actualizar()">Actualizar</a>
                        </div>
                    </div>
                </div>                                
            </div>
        </div>
    </div>
</div>