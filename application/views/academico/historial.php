<div class="cart cart-primary table-responsive" >
	<div class="cart-heading">
			<h3 class="text-center"><strong>HISTORIAL ACADÉMICO</strong></h3>	        		
	</div>

	<form id="formulario" class="form-inline" novalidate>
		<div class="col col-md-12 form-inline">
			<div class="input-group col-md-6 offset-md-3 ">
				<select class="form-control" id="carrera">
    			<?php
					if($carreras!=null)
					{	foreach ($carreras -> result() as $fila) 
                		echo '<option value="'.$fila->cod_pensum.'" >'.$fila->nombre_carrera.' ('.$fila->cod_pensum.')</option>';             				
         			}
             	?>	                       			
				</select>
				<div class="input-group-append">
					<button class="btn btn-success" type="button" id="btn_buscar">Ver Historial</button> 
				</div>
			</div>			    															
		</div>						
	</form>
	<div id="historial_de_notas" class="table-responsive bg-white" style="margin-top: 5px;">
							
	</div>
	<div class="col-xs-12 col-sm-12 table-responsive">
		<table widht="320" class="table table-sm" id="estadisticas" style="display: none;;" >
		<tbody >								  
		  <tr >
		    <td class="out-line" width="100"><strong>Convalidaciones:</strong></td>
		    <td class="out-line" id="h_a_convalidaciones" width="10"></td>
		    <td class="out-line" width="30"></td>
		    <td class="out-line" width="100"><strong>Segundas instancias:</strong></td>
		    <td class="out-line" id="h_a_segundas" width="10"></td>
		    <td class="out-line" width="30"></td>
		    <td class="out-line" width="155"><strong>Materias de Arrastre:</strong></td>
		    <td class="out-line" id="h_a_arrastres" width="10"></td>
		  </tr >
		  <tr >
		    <td class="out-line" ><strong>Materias Aprobadas:</strong></td>
		    <td class="out-line" id="h_a_aprobadas" ></td>
		    <td class="out-line"></td>
		    <td class="out-line" nowrap="nowrap"><strong>Promedio materias aprobadas:</strong></td>
		    <td class="out-line" id="h_a_prom_aprob" ></td>
		    <td class="out-line"></td>
		    <td class="out-line" ><strong>Calificación más alta:</strong></td>
		    <td class="out-line" id="h_a_notaalta" ></td>
		  </tr >
		  <tr >
		    <td class="out-line" ><strong>Materias Reprobadas:</strong></td>
		    <td class="out-line" id="h_a_reprobadas" ></td>
		    <td class="out-line"></td>
		    <td class="out-line" nowrap="nowrap"><strong>Promedio materias reprobadas:</strong></td>
		    <td class="out-line" id="h_a_prom_reprob" ></td>
		    <td class="out-line"></td>
		    <td class="out-line" ><strong>Calificación más baja:</strong></td>
		    <td class="out-line" id="h_a_notabaja" ></td>
		  </tr >
		  <tr >
		    <td class="out-line" ><strong>Materias Cursadas:</strong></td>
		    <td class="out-line" id="h_a_cursadas" ></td>
		    <td class="out-line"></td>
		    <td class="out-line" nowrap="nowrap"><strong>Promedio materias cursadas:</strong></td>
		    <td class="out-line" id="h_a_prom_cursadas" ></td>
		    <td class="out-line"></td>
		    <td class="out-line" ><strong>Calificación con 0:</strong></td>
		    <td class="out-line" id="h_a_cero" ></td>
		  </tr >								  
		</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
$('#carrera').change(function(){
	$("#estadisticas").hide();		
	$("#historial_de_notas").html('');	
});
$('#btn_buscar').click(function(e){
	e.preventDefault();
	$("#estadisticas").hide();		
	$("#historial_de_notas").html('');		

	$.post(baseurl+"academico/historial/buscar_historial_academico",
	{	
		cod_pensum:$("#carrera").val(),
	}, 
	function(data){
	var lista=JSON.parse(data);		
		$("#historial_de_notas").html(lista.tabla);		
		$("#h_a_convalidaciones").html(lista.cant_conv);		
		$("#h_a_segundas").html(lista.cant_inst);		
		$("#h_a_arrastres").html(lista.cant_arras);		
		$("#h_a_aprobadas").html(lista.cant_aprobados);		
		$("#h_a_prom_aprob").html(lista.prom_apro);		
		$("#h_a_notaalta").html(lista.alta);		
		$("#h_a_reprobadas").html(lista.cant_reprobados);		
		$("#h_a_prom_reprob").html(lista.prom_repro);		
		$("#h_a_notabaja").html(lista.baja);		
		$("#h_a_cursadas").html(parseInt(lista.cant_aprobados)+parseInt(lista.cant_reprobados));		
		$("#h_a_prom_cursadas").html(lista.prom_general);		
		$("#h_a_cero").html(lista.cant_ceros);		
		$("#estadisticas").show();		
		$("#modalHistorialAcademico").modal('show');	
	

	});

});
</script>