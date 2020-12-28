function actualizar(){
	var archivo = ($("#archivo"))[0].files[0];

	if($("#archivo").val() == ''){
		alertify.error("Seleccione el archivo a importar");
		return;
	}
	document.getElementById('bloquea').style.display='block';
	var data = new FormData();
	data.append("archivo", archivo);
	$.ajax({
        url: url + "grupoimpresion/actualizarentidades",
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
        		alertify.success("Grupos actualizadas con exito");
        		var input = $("#archivo");
        		input = input.val('').clone(true);
        	}else{
        		alertify.error("Ocurrio un error al actualizar los grupos");
        	}
            document.getElementById('bloquea').style.display='none';
        }
    });
}