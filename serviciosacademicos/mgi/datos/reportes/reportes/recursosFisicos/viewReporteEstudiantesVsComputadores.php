
<?php

session_start();
                if(isset($_POST['semestre'])){
                    require_once("../../../templates/template.php");
                    $db = getBD();
                    $utils = new Utils_datos();
                
                }

         $periodo=$_POST['semestre'];
  
        if(($periodo)) {
        
         
         $records =$utils-> getDataFormEquipoEstu($db,$periodo);
         $num = count($records);
        
         

  ?>

<div id="tableDiv">

     <table align="center" class="previewReport" width="100%" >
                    <thead>             			
			<tr id="dataColumns">
                            <th class="column borderR" ><span>Periodo</span></th>
                            <th class="column borderR"><span>Total Equipos</span></th>                           
                            <th class="column borderR"><span>Total Estudiantes</span></th>                            
                            <th class="column borderR"><span>Indice</span></th>
			</tr>				
                   </thead>
                    <tbody>  
                        <?php
                        
                         for ($i = 0; $i < $num; $i++) { ?>
                                <tr class="dataColumns">
                                    <td class="column center"><?php echo $periodo ; ?></td>
                                    <td class="column center"><?php echo $records[$i]["Total_PC"]; ?></td>
                                    <td class="column center"><?php echo $records[$i]["Total_Estu"]; ?></td>
                                    <td class="column center"><?php  ($num_t=($records[$i]["Total_Estu"]/$records[$i]["Total_PC"])*100); echo number_format($num_t,2,".",","); ?></td>
                             
                               </tr>
                                <?php } exit;?>  
                               
                    </tbody>
                </table> 
</div>
  <?php } //if periodo?>
      
                <form name="periodo1" id="periodo1" method="post" action="">
                        <span class="mandatory">* Son campos obligatorios</span>

                          <fieldset> 
                            <label for="semestre" class="grid-2-12">Semestre:  <span class="mandatory">(*)</span></label><?php $utils->getSemestresSelect($db,"semestre"); ?> 
                            <input type="submit" value="consultar" id="consultar" name="consultar"class="first small" />
                         </fieldset>
                    <div id='respuesta_form1_au'></div>
                    
                    </form>
   


<script type="text/javascript">
	$(':submit').click(function(event) {
            
		event.preventDefault();
		var valido= validateForm("#periodo1");
		if(valido){
                    
			sendForm_un();
		}
	
	function sendForm_un(){
                datos = $('#periodo1').serialize();
               // alert (datos);
		$.ajax({
				type: 'POST',
				url: './reportes/recursosFisicos/viewReporteEstudiantesVsComputadores.php',
				async: false,
				data: datos ,                
				success:function(data){					
					$('#respuesta_form1_au').html(data);
                                },
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		}); 
	}
        });
</script>


