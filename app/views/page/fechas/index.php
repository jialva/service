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
                    <select class="form-control" id="codciclo" name="codciclo" onchange="periodo()">
                        <?=$date['ciclos']?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="creditCard">Periodo</label>
                    <input class="form-control" id="periodo" name="periodo" readonly="readonly">
                    <input type="hidden" id="anio" name="anio">
                    <input type="hidden" id="mes" name="mes">
                    <input type="hidden" id="nrofacturacion" name="nrofacturacion">
                </div>
                <div class="form-group">
                    <label for="creditCard">Tipo Facturaci&oacute;n</label>
                    <select class="form-control" id="tipofacturacion" name="tipofacturacion" onchange="periodo()">
                        <option value="">--Seleccione--</option>
                        <option value="0">Medidos</option>
                        <option value="1">Promediados</option>
                        <option value="2">Asignados</option>
                    </select>
                </div>
                <div class="demo-btn-group center-text">
                    <a href="javascript:void(0)" class="btn btn-info" onclick="mostrar()">Mostrar</a>
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
                            <label class="control-label">Fecha Lec. Anterior</label>
                            <input type="date" class="form-control" id="fechalecturaanterior" name="fechalecturaanterior">
                        </div>
                        <div class="col-md-6 selectContainer">
                            <label class="control-label">Fecha Lec. Actual</label>
                            <input type="date" class="form-control" id="fechalecturaactual" name="fechalecturaactual">
                        </div>
                    </div>
                    <div class="row gutter">
                        <div class="col-md-4">
                            <label class="control-label">Fecha Emisi&oacute;n</label>
                            <input type="date" class="form-control" id="fechaemision" name="fechaemision">
                        </div>
                        <div class="col-md-4 selectContainer">
                            <label class="control-label">Fecha Vencimiento</label>
                            <input type="date" class="form-control" id="fechavencimiento" name="fechavencimiento">
                        </div>
                        <div class="col-md-4 selectContainer">
                            <label class="control-label">Fecha Corte</label>
                            <input type="date" class="form-control" id="fechacorte" name="fechacorte">
                        </div>
                    </div>
                </div>
                <div class="demo-btn-group center-text">
                    <a href="javascript:void(0)" id="btnactualizar" class="btn btn-info" onclick="actualizar()">Actualizar</a>
                </div>                
            </div>
        </div>
    </div>
</div>