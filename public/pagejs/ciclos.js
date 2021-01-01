function limpiar(){
	var archivo = $("#archivo").val();
	$("#nroinscripcion").val('')
	if(archivo == ''){
		$("#nroinscripcion").prop('readonly',false);
	}else{
		$("#nroinscripcion").prop('readonly',true);
	}	
}

function actualizar(){
	var archivo = ($("#archivo"))[0].files[0];
	var codciclo = $("#codciclo").val();
	var nroinscripcion = $("#nroinscripcion").val();
	var opcion = 0;
	if(codciclo==0){
		alertify.error('Seleccione el ciclo de facturación');
		return;		
	}
	document.getElementById('bloquea').style.display='block';
	var data = new FormData();
	if(nroinscripcion == ''){
		var opcion = 1;
		data.append("archivo", archivo);
	}
	data.append("codciclo", codciclo);
	data.append("nroinscripcion", nroinscripcion);
	data.append("opcion", opcion);
	$.ajax({
		url: url + 'ciclos/actualizaratipico',
		type:'post',
		data: data,
        processData: false,
        contentType: false,
        dataType:'json',
        error: function (e) {
            alertify.error("Ocurrio un error inesperado");
            document.getElementById('bloquea').style.display='none';
        },
		success:function(result){
			if(result.ok==1){
				alertify.success(result.mensaje);
			}else{
				alertify.error(result.mensaje);
			}
			document.getElementById('bloquea').style.display='none';
		}
	})
}