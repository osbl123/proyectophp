<div class="cart cart-primary table-responsive" >
	<div class="cart-heading">
			<h3 class="text-center"><strong>CRONOGRAMA DE EVALUACIONES</strong></h3>	        		
	</div>

	<form novalidate>
		<div class="col-sm-8 offset-sm-2">
				
			<div class="form-group row">
			    <label for="carrera" class="col-sm-2 col-md-2 col-form-label">Pensum</label>
			    <div class="col-sm-10 col-md-10">
			      	<select class="form-control" id="carrera">
					<?php
						if($carreras!=null)
						{	foreach ($carreras -> result() as $fila) 
			        		echo '<option value="'.$fila->cod_pensum.'" >'.$fila->nombre_carrera.' ('.$fila->cod_pensum.')</option>';             				
			 			}
			     	?>	                       			
					</select>
			    </div>
		  	</div>
		  	<div class="form-group row">
		    	<label for="gestion" class="col-sm-2 col-md-2 col-form-label">Gestión</label>
			    <div class="col-sm-10 col-md-10">
			      	<select class="form-control" id="gestion">
	                                                        
	                </select>
			    </div>
		  	</div>
		  	<div class="form-group row">
		    	<label for="evaluacion" class="col-sm-2 col-md-2 col-form-label">Evaluación</label>
			    <div class="col-sm-10 col-md-10">
			      	<select class="form-control" id="evaluacion">
	                    <option value="1er parcial" >1er. Parcial</option>            				
	                    <option value="Rezagados 1er parcial" >1er. Parcial Rezagados</option>            				
	                    <option value="2do parcial" >2do. Parcial</option>            				
	                    <option value="Rezagados 2do parcial" >2do. Parcial Rezagados</option>            				
	                    <option value="3er parcial" >3er. Parcial</option>            				
	                    <option value="Rezagados 3er parcial" >3er. Parcial Rezagados</option>            				
	                    <option value="2da Instancia" >Prueba de Recuperación</option>                                   
	                </select>
			    </div>
		  	</div>
		</div>						
	</form>	
	<div id="lista_cronograma" class="table-responsive bg-white" style="margin-top: 5px;">
							
	</div>	
</div>
<script>
function get_gestion() {
	$.post(baseurl+"academico/horario_clases/get_gestion",
	{	
		cod_pensum:$("#carrera").val(),
		cod_ceta:$("#cod_ceta").html(),
	}, 
	function(data){
		$("#gestion").html(data);
		if(data.length>0)
			cargar_cronograma();
	});
}	
function cargar_cronograma()
{

	$("#lista_cronograma").html('<div class="text-center"><label class="text-info"><i id="load_spinner" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> </label></div');
	if($("#combo_gestiones").val()!=0)
	{
		$.post(baseurl+"academico/evaluacion/get_evaluacion",
			{	
				cod_pensum:$("#carrera").val(),
				gestion:$("#gestion").val(),
				cod_ceta:$("#cod_ceta").html(),
				parametro:$("#evaluacion").val(),
			}, 
			function(data){
				$("#lista_cronograma").html(data);
			});
	}	
}

$('#gestion').change(function () {
	cargar_cronograma();
})
$('#carrera').change(function () {
	cargar_cronograma();
})
$('#evaluacion').change(function () {
	cargar_cronograma();
})
</script>
