<?php 
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    $caracteres = $utils->getActives($db,"siq_caracteresConvocatorias","nombre");
$id= $_REQUEST["id"];
$usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
        $aprobacion=true;
    }
        ?>
<div id="tabs-1">
<form action="save.php" method="post" id="form_internos">
            <input type="hidden" name="entity" id="entity" value="formInvestigacionesProyectosInternos" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formInvestigacionesProyectosInternos" value="" id="idsiq_formInvestigacionesProyectosInternos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Proyectos de investigación aprobados en las convocatorias internas</legend>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(".$id.",3,$('#form_internos #codigoperiodo').val())","popup_verDocumentos(".$id.",3,$('#form_internos #codigoperiodo').val())"); ?>
                
            <!--<input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />  -->                 
                
                <div class="vacio"></div>
                
                <table align="center" class="formData" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "4"; else echo "5";?>"><span>Proyectos de Investigación aprobados en las CONVOCATORIAS INTERNAS</span></th>
                            <?php if($aprobacion){ ?>
                            <th class="column"><span>
                                <input type="hidden" value="0" name="VerEscondido" id="VerEscondido" />
				<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
	                   </span></th>  
                           <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2" ><span>Carácter</span></th> 
                            <th class="column borderR" colspan="3"><span>Número de proyectos</span></th> 
                            <th class="column borderR" rowspan="2"><span>Valor ($)</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Presentados</span></th> 
                            <th class="column borderR" ><span>Aprobados</span></th> 
                            <th class="column borderR"><span>Finalizados</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $caracteres->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span> 
                                <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_caracteresConvocatorias"]; ?>" value="<?php echo $row["idsiq_caracteresConvocatorias"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformInvestigacionesProyectosInternos[]" value="" id="idsiq_detalleformInvestigacionesProyectosInternos_<?php echo $row["idsiq_caracteresConvocatorias"]; ?>" />
                             </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numPresentados[]" id="numPresentados_<?php echo $row["idsiq_caracteresConvocatorias"]; ?>" maxlength="40" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numAprobados[]" id="numAprobados_<?php echo $row["idsiq_caracteresConvocatorias"]; ?>" maxlength="40" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text" class="grid-5-12 required number" minlength="1" name="numFinalizados[]" id="numFinalizados_<?php echo $row["idsiq_caracteresConvocatorias"]; ?>" maxlength="40" tabindex="1" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-7-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idsiq_caracteresConvocatorias"]; ?>" maxlength="40" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                         <?php } ?> 
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitInternos" value="Guardar datos" class="first" />
        </form>
</div>
<script type="text/javascript">
    
    var aprobacion = '<?php echo $aprobacion; ?>';
    
    getDataInternos('#form_internos');
    
                $('#submitInternos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_internos");
                    if(valido){
                        sendFormInternos('#form_internos');
                    }
                });
                
               // $('#form_test #codigoperiodo').change(function(event) {
       $('#form_internos #codigoperiodo').bind('change', function(event) {
                    getDataInternos('#form_internos');
                });
                
                function getDataInternos(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_caracteresConvocatorias" }, 
                        success:function(data){
                            if (data.success == true){
                                $("#idsiq_formInvestigacionesProyectosInternos").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                    $(formName + " #idsiq_detalleformInvestigacionesProyectosInternos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformInvestigacionesProyectosInternos);
                                    $(formName + " #numPresentados_"+data.data[i].idCategory).val(data.data[i].numPresentados);
                                    $(formName + " #numAprobados_"+data.data[i].idCategory).val(data.data[i].numAprobados);
                                    $(formName + " #numFinalizados_"+data.data[i].idCategory).val(data.data[i].numFinalizados);
                                    $(formName + " #valor_"+data.data[i].idCategory).val(data.data[i].valor);

                                      if(data.data[i].Verificado=="1"){ 
                                           $(formName + " #Verificado").attr("checked", true);
                                           $(formName + ' #msg-success').html('<p> Ya esta validado</p>');
                                           $(formName + ' #msg-success').removeClass('msg-error');
                                           $(formName + ' #msg-success').css('display','block');
                                           $(formName + " #msg-success").delay(5500).fadeOut(300);
                                           $(formName + " #submitInternos").attr('disabled','disabled');
                                           $(formName + "").find(':input').each(function() {
                                                 $(this).removeAttr("readonly").addClass("disable");
                                                 $(this).removeAttr("disabled").addClass("disable");
                                            });
                                          }else{
                                               
                                              $(formName + "").find(':input').each(function() {
                                                 $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                           // $(formName + " #enviafinanciamiento").removeAttr('disabled','disabled');
                                              $(formName + " #Verificado").attr("checked", false);
                                            }
                                 }
                                 $(formName + " #action").val("updateDynamic2");
                            }
                            else{                        
                                //no se encontraron datos
                               // if($("#idsiq_formInvestigacionesProyectosInternos").val()!=""){     
                                   var anio = $(formName + ' #codigoperiodo').val();
                                   $("#idsiq_formInvestigacionesProyectosInternos").val('');
                                   $(formName + ' input[name="idsiq_detalleformInvestigacionesProyectosInternos[]"]').each(function() { 
                                           // alert($(this).val())
                                            $(this).val("");                                       
                                   });
                                   document.forms[formName.replace("#","")].reset();
                                    $(formName + ' #codigoperiodo').val(anio);
                                    $(formName + " #action").val("saveDynamic2");
                                    $(formName + " #Verificado").attr("checked", false);
                                    $(formName).find(':input').each(function() {
                                                       $(this).removeAttr("readonly").removeClass("disable");
                                            }); 
                                    //$(formName + ' input:checkbox').removeAttr('checked');
                                //}
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });  
                }

                function sendFormInternos(formName){
                $(formName + " input[type=checkbox]:checked" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").attr("disabled","disabled");
                      });

                      $(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
                        var id= $( this ).attr( "id" );
                        $( "#VerEscondido").removeAttr("disabled");
                      });
                      
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/docentes/saveTalentoHumano.php',
                        data: $(formName).serialize(),                
                        success:function(data){
                            if (data.success == true){ 
                                 $("#idsiq_formInvestigacionesProyectosInternos").val(data.message);
                                 $(formName + " #action").val("updateDynamic2");
                                 $('#form_internos #msg-success').css('display','block');
                                 $("#form_internos #msg-success").delay(5500).fadeOut(800);
                            }else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
</script>