$(function(){
    //CargarCaptcha();
})
function CargarCaptcha() {
     $.ajax({
    url: 'configuracion/captcha',
    type: 'post',
    dataType: 'text',
    data:{"capt":"visto"}
   })
   .done(function(data) {
    var visto=$.parseJSON(data);
    var canva=document.getElementById("capatcha");
    var dibujar=canva.getContext("2d");
    canva.width = canva.width;
    dibujar.fillStyle="red";
    dibujar.font='20pt "NeoPrint M319"';
    dibujar.fillText(visto.retornar,6,39);
   })
   .fail(function() {
   })
   .always(function() {
   });
   
}
function fecha() {
    var d = new Date();
    var mm = (d.getMonth()+1);
    if(mm<10){
        mm = '0'+mm;
    }
    var dd = d.getDate();
    if(dd<10){
        dd = '0'+dd;
    }
    var fech = d.getFullYear() + "-" + mm + "-" + dd;

    return fech;
};