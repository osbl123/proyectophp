

 var array_comments_open = new Array();
 var objComentInicial = {
     "id_padre":0,
     "cantidad":0,
     "mostrar":true
 };
 array_comments_open.push(objComentInicial);

$(document).ready(function(){
    
    //función para insertar un nuevo comentario a la bd
    $("#formularioComentar").submit(function(e){
        e.preventDefault();

        $('#comentario').prop('disabled', true);
        $('#spinner').show();

        if( $("#comentario").val().length <= 5){
            $("#comentario").focus().after(alert('Escriba como mínimo 6 carácteres para el comentario'));
            return false;
        }else{
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"), 
                data: {
                    comentario:$("#comentario").val()
                    //$('#h_v').val();
                    ,id_post:$("input[name=id_post]").val()
                },
                success:function(data){ 
                    console.log(" el data es: "+data+" eso");

                    $('#comentario').prop('disabled', false);
                    $('#spinner').hide();

                    $('#comentario').val('');    
                    $('#comentario').focus();
                    //$("#comentario").attr("value", "").focus(); 

                    $("#msg_comentario").delay(500).show(0);
                    $("#msg_comentario").delay(4000).hide(0);
                }
            }); 
            return false;
        }
    });  
    
    //esta funcion es la que permite guardar las respuestas a los comentarios
    $('#formularioResponder').on('submit', function(e){
        e.preventDefault();

        var tipo = $('#tipo_operacion').val();
        var dato = $('#id_operacion').val();

        if( $("#respuesta-text").val().length <= 5){
            $("#respuesta-text").focus().after(alert('Escriba como mínimo 5 carácteres para el comentario'));
            return false;
        }else{
            
            //si se agregar un respuesta es tipo 1
            if(tipo == '1') {
                $.ajax({
                    url: baseurl+'blog/nueva_respuesta', //this is the submit URL
                    type: 'POST', 
                    data: {
                        id_respuesta:dato,
                        id_post_respuesta:$('#id_post_respuesta').val(),
                        'respuesta-text':$('#respuesta-text').val()
                    },
                    success: function(data){
                        console.log('resultado agregar respuesta: '+data);
                        $("#exampleModal").modal('hide');
                    }
                });
                
            } else if(tipo == '2') { //si se agrega denuncia es tipo 2
                $.ajax({
                    url: baseurl+'blog/registrar_denuncia', //this is the submit URL
                    type: 'POST', 
                    data: {
                        id_comentario:dato,
                        'respuesta-text':$('#respuesta-text').val()
                    },
                    success: function(data){
                        console.log('resultado agregar denuncia '+data);
                        $("#exampleModal").modal('hide');
                    }
                });                
            }
        }
        //solo actualiza los comentario si se agrega una respuesta
        if(tipo == '1') {
            actualizarComentarios();
        }
    });

    //Es un div donde se muestra que el comentario se processo correctamente
   $("#msg_comentario").hide();
   //Muestra el icono cargando
   $('#spinner').hide();

   
    // $("#comentario-opciones").hide();

    // $("#comentario").focusin(function() {
    //     $("#comentario-opciones").show();
    // });
    // $("#comentario").focusout(function() {
    //     $("#comentario-opciones").hide(); 
    // });

    actualizarComentarios();    

    setInterval(function() { 
        actualizarComentarios();       
    }, 5000);        
});

//Establece el valor del id respuesta para luego procesarlo
function setIdRespuesta(valor) {
    $('#id_operacion').val(valor);
    $('#tipo_operacion').val('1');

    $('#lbl_titulo_modal').html('Escribe tu respuesta');
    $('#lbl_modal').html('Respuesta:');
}
//Establece el id de comentario que se va a denunciar
function setIdComentarioDen(idComentario) {
    console.log('debo setear la denuncia para el comentario :'+idComentario);
    $('#id_operacion').val(idComentario);
    $('#tipo_operacion').val('2');
    //$("#contenido_mensages").attr("class","alert alert-warning text-center");
    $('#lbl_titulo_modal').html('Describe la razón de tu denuncia');
    $('#lbl_modal').html('Descripción:');
}


function actualizarComentarios() { 
    $.post( baseurl +"blog/actualizar_comentarios", 
    { 
        id_post: $("input[name=id_post]").val(),
        //com:[{id_padre:0,cantidad:1},{id_padre:1,cantidad:2}]
        com:array_comments_open
    }, 
    function(data,status){
        //alert(data);
        var json  = JSON.parse(data);
        for(var i= 0;i<json.length;i++) {
            id_padre = json[i].id_padre;
            var comentarios = json[i].nuevos_comentarios;
            var respuestas_a = json[i].respuestas;
            if(comentarios.length > 0) {
                array_comments_open.forEach( function(element, index) {
                    if(element.id_padre == id_padre) {
                        element.cantidad  += comentarios.length;
                    }
                });

                for(var j = 0;j < comentarios.length;j++) {
                    var coment = comentarios[j];
                    $('#list_coment_'+id_padre).prepend(addLi(coment.id_comentario,coment.id_post,coment.nombre,coment.cod_ceta,coment.contenido,coment.fecha,coment.res));
                }

            }
            if(respuestas_a.length > 0) {
                for(var k = 0;k< respuestas_a.length;k++) {
                    var id_coment = respuestas_a[k].id_comentario;
                    var respuestas = respuestas_a[k].respuestas;
                    if($('#contenedor_respuesta_'+id_coment+' > button').length > 1) {
                        $('#cant_respuesta_'+id_coment).html(respuestas)
                    } else {
                        $('#contenedor_respuesta_'+id_coment).append( getButtonShowCantRespuestas(id_coment,respuestas));
                    }
                }
            }
        }
    });
}

//Funcion que carga las respuestas a un comentario don el id idComentario
function cargarRespueta(idComentarioPadre) {
    

    var coments_load = array_comments_open.filter(function(coment){ 
	    if(coment.id_padre == idComentarioPadre) {
	        return  coment;
	    }
	});

	var contiene = coments_load.length > 0 ;

    if(contiene) {
    	array_comments_open.forEach( function(element, index) {
    		if(element.id_padre == idComentarioPadre) {
    			var showInverted = !(element.mostrar === true);
    			element.mostrar  = showInverted;
    	 		if(showInverted) {
                    $('#list_coment_'+idComentarioPadre).show();
                    var texto = $('#msg_respuesta_'+idComentarioPadre).html();
                    $('#msg_respuesta_'+idComentarioPadre).html(texto.replace('Ver', 'Ocultar'));
                    $('#icon_res_'+idComentarioPadre).removeClass('fa-chevron-down');
                    $('#icon_res_'+idComentarioPadre).addClass('fa-chevron-up');
    	 		} else {
                    $('#list_coment_'+idComentarioPadre).hide();
                    var texto = $('#msg_respuesta_'+idComentarioPadre).html();
                    $('#msg_respuesta_'+idComentarioPadre).html(texto.replace('Ocultar', 'Ver'));
                    $('#icon_res_'+idComentarioPadre).removeClass('fa-chevron-up');
                    $('#icon_res_'+idComentarioPadre).addClass('fa-chevron-down');
    	 		}
    		}
    	});
    } else {
    	var objComent = {
            "id_padre":idComentarioPadre,
            "cantidad":0,
            "mostrar": true
        };
        array_comments_open.push(objComent);
        actualizarComentarios();
        var texto = $('#msg_respuesta_'+idComentarioPadre).html();
        $('#msg_respuesta_'+idComentarioPadre).html(texto.replace('Ver', 'Ocultar'));
        $('#icon_res_'+idComentarioPadre).removeClass('fa-chevron-down');
        $('#icon_res_'+idComentarioPadre).addClass('fa-chevron-up');

    }
    console.log(array_comments_open);
}

function addLi(id_comentario,id_post,nombre,cod_ceta,contenido,fecha,res) {
var li = `<li class="">
        <div class="d-flex mt-3">
            <div class="mr-3">
                <span >
                    <img class="imagen" src="`+baseurl+`plantillas/gallery/`+cod_ceta+`.jpg" alt="imagen estudiante" />
                </span>
            </div>
            <div class="w-100">
                <div>
                    <span><strong>`+nombre+`</strong></span>
                    <span class="text-muted ml-1">Fecha: `+fecha+`</span>
                </div>
                <div name="respuestaComentario" class="mt-1">`+contenido+`</div>
                <div class="mt-1">
                    <div id="contenedor_respuesta_`+id_comentario+`">
                        <button type="button" id="btn_responder" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" onclick="setIdRespuesta(`+id_comentario+`)">Responder</button>`;
var respuestas = parseInt(res);
if(respuestas > 0) {
    li += getButtonShowCantRespuestas(id_comentario,respuestas);
}
li+=`               </div>
                    <div id="mostrar_respuesta`+id_comentario+`" >
                        <ul class="list-unstyled msg_list" id="list_coment_`+id_comentario+`" >
                        </ul>
                    </div>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button id="btn_denuncia" type="button" class="btn" style="width:40px;height:40px;border:0;border-radius: 50%;outline: none;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" style="color:red;" href="#" data-toggle="modal" data-target="#exampleModal" onClick="setIdComentarioDen('`+id_comentario+`')"><i class="fa fa-ban"></i> &nbsp;Denunciar</a>
                </div>
            </div>
        </div>
    </li>`;

    return li;
}

function getButtonShowCantRespuestas(idComentario,cantRespuestas) {
    return  `<button type="button" class="btn btn-link" onclick="cargarRespueta(`+idComentario+`)">
    <span id="msg_respuesta_`+idComentario+`">Ver la(s) <strong id="cant_respuesta_`+idComentario+`">`+cantRespuestas+`</strong> respuesta(s)</span>
    <i id="icon_res_`+idComentario+`" class="fa fa-chevron-down" ></i>
</button>`;
}

