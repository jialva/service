function actualizar(){
	var archivo = ($("#archivo"))[0].files[0];
	var codsuc = $("#codsuc").val();
	var anio = $("#anio").val();
	var mes = $("#mes").val();
	var todos = 0;
	if(anio == '' || anio == 0){
		alertify.error("El año es incorrecto");
		return;
	}
	if(mes == '' || mes == 0){
		alertify.error("El mes es incorrecto");
		return;
	}
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
	data.append("anio", anio);
	data.append("mes", mes);
	data.append("todos", todos);
	$.ajax({
        url: url + "lecturas/actualizarlecturas",
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
        		alertify.success("Registros actualizados con exito");
        		var input = $("#archivo");
        		input = input.val('').clone(true);
        		$("#totalcli").html("Se actualizaron "+result.cli+" de un total de "+result.total+" registros de clientes");
        		$("#totalcon").html("Se actualizaron "+result.con+" de un total de "+result.total+" registros de conexiones");
        		$("#totallec").html("Se actualizaron "+result.lec+" de un total de "+result.total+" registros de lecturas");
        	}else{
        		$("#totalcli").html("Ocurrio un error al actualizar las lecturas");
        		alertify.error("Ocurrio un error al actualizar los registros");
        	}
            document.getElementById('bloquea').style.display='none';
        }
    });
}