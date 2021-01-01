function actualizar(){
	var archivo = ($("#archivo"))[0].files[0];
	var codsuc = 0
	var todos = 1;
	var tipo = $("#tipo").val();
	if($("#todos").prop('checked')){
		todos = 1;
	}
	if(todos == 0){
		if(codsuc == 0){
			alertify.error("Seleccione una sucursal");
			return;
		}
	}
	if($("#archivo").val() == ''){
		alertify.error("Seleccione el archivo a importar");
		return;
	}
	document.getElementById('bloquea').style.display='block';
	var data = new FormData();
	data.append("archivo", archivo);
	data.append("codsuc", codsuc);
	data.append("todos", todos);
	data.append("tipo", tipo);
	$.ajax({
        url: url + "eliminardescuentos/eliminar",
        type: "post",
        data: data,
        processData: false,
        contentType: false,
        dataType:'json',
        error: function (e) {
            alertify.error("Ocurrio un error inesperado");
            document.getElementById('bloquea').style.display='none';
        },
        success: function(result){
        	if(result.resp != 0){
        		alertify.success("Descuentos Eliminados");
        		var input = $("#archivo");
        		input = input.val('').clone(true);
        		$("#mensaje").html("Se eliminaron "+result.resp+" registros");
        	}else{
        		alertify.error("Ocurrio un error al eliminar los descuentos");
        	}
            document.getElementById('bloquea').style.display='none';
        }
    });
}