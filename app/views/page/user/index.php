<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style="float: right;">
            <li>
                <button class="btn btn-primary btn-xs" onclick="abrirmodal()"><i class="fa fa-plus-circle"></i> AGREGAR</button>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="col-md-4" style="float: right;">
                        <input style="" class="form-control" id="buscador" name="buscador" placeholder="Buscar...">
                </div>
                <div class="col-md-12">
                    <div class="table-responsive ltabla">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGuardar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title modalGuardar"></h4>
            </div>    
            <form class="form-usuario" onsubmit="return false;">        
                <div class="modal-body">
                    <fieldset>                        
                        <div class="form-group col-lg-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <span class="mensaje"></span>
                            </div>
                        </div>                        
                        <div class="form-group col-lg-12">                            
                            <div class="col-lg-6">
                                <label class="control-label">
                                    Nombre <span class="symbol required"></span>
                                </label>
                                <span class="input-icon">
                                    <input type="text" class="form-control" name="nombre" id="nombre">
                                    <i class="fa fa-user"></i>
                                    <input type="hidden" id="idusuario" name="idusuario">
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label">
                                    Apellido <span class="symbol required"></span>
                                </label>
                                <span class="input-icon">
                                    <input type="text" class="form-control" name="apellido" id="apellido">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="col-lg-6">
                                <label class="control-label">
                                    Usuario <span class="symbol required"></span>
                                </label>
                                <span class="input-icon">
                                    <input type="text" class="form-control" name="usuario" id="usuario">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label class="control-label">
                                    Password <span class="symbol required"></span>
                                </label>
                                <span class="input-icon">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="col-lg-12">
                                <label class="control-label">
                                    Rol <span class="symbol required"></span>
                                </label>
                                <span class="input-icon">
                                    <select id="idrol" name="idrol" class="form-control"> <?=$date['select']?></select>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" type="" id="btnguardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEliminar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title modalEliminar"></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger m-b-0">
                    <p><b>Confirmación:</b> Está tratando de eliminar un registro, desea continuar?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn width-100 btn-default" data-dismiss="modal">Cancelar</button>
                <button class="btn width-100 btn-danger" id="btneliminar" onclick="confirma_eliminar()">Continuar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRestablecer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title modalRestablecer"></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning m-b-0">
                    <p><b>Confirmación:</b> Está tratando de restablecer un registro, desea continuar?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn width-100 btn-default" data-dismiss="modal">Cancelar</button>
                <button class="btn width-100 btn-warning" id="btnrestablecer" onclick="confirma_restablecer()">Continuar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBorrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title modalBorrar"></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger m-b-0">
                    <p><b>Alto:</b> Está opción eliminará por completo el registro y no se podrá restablecer, desea continuar?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn width-100 btn-default" data-dismiss="modal">Cancelar</button>
                <button class="btn width-100 btn-danger" id="btneliminar" onclick="confirma_borrar()">Continuar</button>
            </div>
        </div>
    </div>
</div>