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
                        <div class="col-md-12">
                            <label for="creditCard"><b>Periodo: <?=$date['periodo']?></b></label>
                            <input type="hidden" class="form-control" id="anio" name="anio" value="<?=date('Y')?>">
                            <input type="hidden" class="form-control" id="mes" name="mes" value="<?=intval(date('m'))?>">
                        </div>
                        <div class="col-md-12">
                            <table class="display compact" width="100%">
                                <thead>
                                    <tr style="border-bottom: 1px solid #000000;">
                                        <th>Ciclo</th>
                                        <th>Generaci&oacute;n</th>
                                        <th>Le&iacute;dos</th>
                                        <th>Promedios</th>
                                        <th>Digitados</th>
                                        <th>Total</th>
                                        <th>Criticar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?=$date['ciclos']?>
                                </tbody>
                            </table>
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

<style>
    .fila:hover {
        background: #C0C0C0;
    }
</style>