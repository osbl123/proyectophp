<div class="cart cart-primary table-responsive" >
	<div class="cart-heading">
			<h3 class="text-center"><strong>HORARIO DE CLASES</strong></h3>	        		
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
		</div>						
	</form>	
	<div id="horario_clases" class="table-responsive bg-white" style="margin-top: 5px;">
							
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
			get_horario();
	});
}	
function get_horario() {
	$("#horario_clases").html('<center class="text-primary"><i class="fa fa-spinner fa-spin fa-3x"  ></i></center>');
	$.post(baseurl+"academico/horario_clases/get_horario",
		{	
			cod_pensum:$("#carrera").val(),
			gestion:$("#gestion").val(),
			cod_ceta:$("#cod_ceta").html(),
		}, 
		function(data){
			if(data.length>0)
				$("#horario_clases").html(data);
			else
				$("#horario_clases").html('<div class="alert alert-danger" role="alert"><center>No existen datos para mostrar para la Gestión y Pensum seleccionados. Comuníquese con el Administrador</center></div>');
		});
}
$('#gestion').change(function () {
	get_horario();
})
$('#carrera').change(function () {
	get_gestion();
})
</script>
