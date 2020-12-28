$(function(){
	$("#btnactualizar").hide();
})
function periodo(){
	var codciclo = $("#codciclo").val();
	if(codciclo!=0){
		$.post( url + "fechas/periodo",{codciclo:codciclo},function(data){
			$("#periodo").val(data.periodo);
			$("#anio").val(data.anio);
			$("#mes").val(data.mes);
			$("#nrofacturacion").val(data.nrofacturacion);
			$("#fechalecturaanterior").val('')
			$("#fechalecturaactual").val('')
			$("#fechaemision").val('')
			$("#fechavencimiento").val('')
			$("#fechacorte").val('')
			$("#btnactualizar").hide();
		},'json');
	}else{
		$("#periodo").val('');
		$("#anio").val('');
		$("#mes").val('');
		$("#nrofacturacion").val('');
		$("#btnactualizar").hide();
	}	
}

function mostrar(){
	var nrofacturacion = $("#nrofacturacion").val();
	var codciclo = $("#codciclo").val();
	var tipofacturacion = $("#tipofacturacion").val();
	var anio = $("#anio").val();
	var mes = $("#mes").val();
	if(codciclo == 0){
		alertify.error("Seleccione el ciclo de facturación");
		return;
	}
	if(tipofacturacion == ''){
		alertify.error("Seleccione el tipo de facturación");
		return;
	}

	$.post( url + "fechas/datosfecha",{codciclo:codciclo,anio:anio,mes:mes,tipofacturacion:tipofacturacion},function(data){
		if(data.resp == 1){
			$("#fechalecturaanterior").val(data.fechaanterior)
			$("#fechalecturaactual").val(data.fechaactual)
			$("#fechaemision").val(data.fechaemision)
			$("#fechavencimiento").val(data.fechavencimiento)
			$("#fechacorte").val(data.fechacorte)
			$("#btnactualizar").show();
		}else{
			alertify.error('No se encontraron datos con los criterios seleccionados');
			$("#fechalecturaanterior").val('')
			$("#fechalecturaactual").val('')
			$("#fechaemision").val('')
			$("#fechavencimiento").val('')
			$("#fechacorte").val('')
			$("#btnactualizar").hide();
		}
	},'json');
	
}

function actualizar(){
	var codciclo = $("#codciclo").val();
	var tipofacturacion = $("#tipofacturacion").val();
	var anio = $("#anio").val();
	var mes = $("#mes").val();
	var fechaanterior = $("#fechalecturaanterior").val();
	var fechaultima = $("#fechalecturaactual").val();
	var fechaemision = $("#fechaemision").val();
	var fechavencimiento = $("#fechavencimiento").val();
	var fechacorte = $("#fechacorte").val();
	if(codciclo==0){
		alertify.error('Seleccione el ciclo de facturación');
		return;		
	}
	if(tipofacturacion == ''){
		alertify.error("Seleccione el tipo de facturación");
		return;
	}
	document.getElementById('bloquea').style.display='block';
	$.ajax({
		url: url + 'fechas/actualizarfechas',
		type:'post',
		data:{codciclo:codciclo,anio:anio,mes:mes,tipofacturacion:tipofacturacion,fechaanterior:fechaanterior,fechaultima:fechaultima,fechaemision:fechaemision,fechavencimiento:fechavencimiento,fechacorte:fechacorte},
		dataType:'json',
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