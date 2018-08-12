<div class="cart cart-primary table-responsive" >
	<div class="cart-heading">
			<h3 class="text-center"><strong>MATERIAL DE APOYO</strong></h3>	        		
	</div>

	<div class="cart-body">
		<div class="table-responsive">
			<table widht="100%" class="table table-sm " >
			<tbody id="resumen_info_estudiantes">	
			<?=$datos;?>									
			</tbody>
			</table>
		</div>						
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
