		</div>
		<div class="col col-md-3 col-sm-12 col-12">
			<p align="center" class="Estilo7"><strong>COMUNICADOS </strong></p>
         	 <div class="AutoScroll comunicados" id="lista_comunicados">
	            <?php 
	            if ( isset($comunicados)) 
	            	if($comunicados!=null)
                    {   
                        foreach ($comunicados -> result() as $fila) 
                        {   
                            echo '<div><h3>'.$fila->titulo.'</h3><p>'.$fila->descripcion.'</p></div>';  
                        }
                    }
                           
                ?>
	          </div>	
		</div>
	</div>
</main>   
   


</body>

</html>
 <script type="text/javascript">
 	var baseurl="<?=base_url();?>";
      $(".comunicados").scroller();
 	
 </script>
