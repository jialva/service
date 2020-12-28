$(function(){
  $("#usuario").focus();
})

function ingresar(){
  var usuario = $("#usuario").val();
  var password = $("#password").val();
  if(usuario==''){
    alertify.error('Ingrese su usario para continuar');
    $("#usuario").focus();
    return;
  }
  if(password==''){
    alertify.error('Ingrese su password para continuar');
    $("#password").focus();
    return;
  }
  $.ajax({
    url:url+'validar_usuario/validar',
    type:'post',
    data:{usuario:usuario,password:password},
    dataType:'json',
    beforeSend:function(){
      //bloquear("#btningresar",'Cargando...');
    },
    success:function(data){
      if(data.res==1){
        alertify.success(data.mensaje);
        var url = "inicio";               
        window.setTimeout($(location).attr('href',url), 5000 );
      }else{
        if(data.res==2){
         alertify.error(data.mensaje);
          $("#password").val('');
          $("#password").focus();
          //desbloquear("#btningresar",'INICIAR');
        }else{
          if(data.res==3){
            alertify.error(data.mensaje);
            $("#usuario").focus();
            //desbloquear("#btningresar",'INICIAR');
          }
        }
      }
    }
  })
}

function bloquear(boton,mensaje){
    $(boton).attr('disabled',true);
    $(boton).html(mensaje);
  }

function desbloquear(boton,mensaje){
    $(boton).attr('disabled',false);
    $(boton).html(mensaje);
  }