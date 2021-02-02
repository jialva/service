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
                        <div class="col-md-1">
                            <label for="creditCard">Año</label>
                            <input class="form-control" id="anio" name="anio" value="<?=date('Y')?>">
                        </div>
                        <div class="col-md-1">
                            <label for="creditCard">Mes</label>
                            <input class="form-control" id="mes" name="mes" value="<?=intval(date('m'))?>">
                        </div>
                        <div class="col-md-3">
                            <label for="creditCard">Sucursales</label>
                            <select class="form-control" id="codsuc" name="codsuc" onchange="periodo()">
                                <?=$date['sucursales']?>
                            </select>
                            <input type="checkbox" id="todos" name="todos" checked> Todas las sucursales
                        </div>
                        <div class="col-md-4">
                            <label for="creditCard">Archivo</label>
                            <form enctype="multipart/form-data" id="formulario" onsubmit="return false;">
                                <input type="file" class="form-control" id="archivo" name="archivo" accept=".csv">
                                <label>El archivo debe ser en formato .csv</label>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <div class="demo-btn-group" style="margin-top: 30px;">
                                <a href="javascript:void(0)" class="btn btn-info" onclick="actualizar()">Actualizar</a>
                            </div>
                        </div>
                    </div>
                    <div class="row gutter">
                        <div class="col-md-12">
                            <label id="totalcli"></label>
                        </div>
                        <div class="col-md-12">
                            <label id="totalcon"></label>
                        </div>
                        <div class="col-md-12">
                            <label id="totallec"></label>
                        </div>
                    </div>
                </div>                                
            </div>
        </div>
    </div>
</div>