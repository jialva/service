function actualizar(){
	var archivo = ($("#archivo"))[0].files[0];
	var codsuc = $("#codsuc").val();
	var todos = 0;
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
	$.ajax({
        url: url + "rutasecuencia/actualizarrutasecuencia",
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
        		alertify.success("Rutas actualizadas con exito");
        		var input = $("#archivo");
        		input = input.val('').clone(true);
        		$("#mensaje").html("Se actualizaron "+result.resp+" de un total de "+result.total+" registros");
        	}else{
        		alertify.error("Ocurrio un error al actualizar las rutas");
        	}
            document.getElementById('bloquea').style.display='none';
        }
    });
}