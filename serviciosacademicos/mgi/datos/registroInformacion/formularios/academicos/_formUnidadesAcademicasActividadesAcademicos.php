<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>

<div id="tabs-12">
<form action="save.php" method="post" id="form_actividadesAcademicos">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasActividadesAcademicos" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasActividadesAcademicos" value="" id="idsiq_formUnidadesAcademicasActividadesAcademicos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Dedicación de los Académicos por actividades</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      //$sectores = $utils->getActives($db,"siq_tipoActividadAcademicos","nombre");
                    $categoriasPadres = $utils->getAll($db,"siq_tipoActividadAcademicos","actividadPadre=0 AND codigoestado=100","nombre"); 
                ?>
                
                <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,16,$('#form_actividadesAcademicos #codigoperiodo').val(),$('#form_actividadesAcademicos #unidadAcademica').val())","popup_verDocumentos(9,16,$('#form_actividadesAcademicos #codigoperiodo').val(),$('#form_actividadesAcademicos #unidadAcademica').val())"); ?>
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Dedicación de los Académicos por actividades</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" colspan="2"><span>Clase De Actividades</span></th> 
                            <th class="column "><span>Horas Semanales</span></th> 
                            <th class="column "><span>Tiempos completos equivalentes</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($rowC = $categoriasPadres->FetchRow()) { 
                                $first = true;
                                $categorias = $utils->getAll($db,"siq_tipoActividadAcademicos","actividadPadre=".$rowC["idsiq_tipoActividadAcademicos"]." AND codigoestado=100","nombre"); 
                                while ($row = $categorias->FetchRow()) { 
                             ?>
                                <tr class="dataColumns">
                                    <?php if($first){ $first = false; ?>
                                        <td class="column borderR" rowspan="<?php echo $categorias->RecordCount(); ?>" > 
                                            <?php echo $rowC["nombre"]; ?> <span class="mandatory">(*)</span>
                                        </td>
                                    <?php } ?>
                                    <td class="column borderR"><?php echo $row["nombre"]; ?> <span class="mandatory">(*)</span>
                                            <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" value="<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />
                                        <input type="hidden" name="idsiq_detalleformUnidadesAcademicasActividadesAcademicos[]" value="" id="idsiq_detalleformUnidadesAcademicasActividadesAcademicos_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />

                                    </td>
                                    <td class="column"> 
                                        <input type="text"  class="grid-5-12 required number" minlength="1" name="numHoras[]" id="numHoras_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" title="Horas Semanales" maxlength="10" tabindex="1" onblur="calculo('numHoras_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>','numAcademicosTCE_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>')" autocomplete="off" value="0" />
                                    </td>
                                    <td class="column"> 
                                        <input type="text"  class="grid-6-12 required number" minlength="1" name="numAcademicosTCE[]" id="numAcademicosTCE_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" title="Académicos de Tiempo Completo" readonly maxlength="10" tabindex="1" autocomplete="off" value="0" />
                                    </td>
                                </tr>
                        <?php } } ?>        
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            <div class="guardar" onmouseover="guardar(this)" title="">
                <div class="vacio"></div>
                <input type="submit" id="submitActividadesAcademicos" value="Guardar datos" class="first" /> 
            </div>
        </form>
</div>

<script type="text/javascript">
    getDataActividadesAcademicos("#form_actividadesAcademicos");
    
    function calculo(Nh,NhTCE){
      var nH1=parseFloat($("#"+Nh).val());
      var nHTCE=nH1/40;
      $("#"+NhTCE).val(nHTCE)
      
    }
        
                $('#submitActividadesAcademicos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_actividadesAcademicos");
                    if(valido){
                        sendFormFormacionActividadesAcademicos("#form_actividadesAcademicos");
                    }
                });
                
                $('#form_actividadesAcademicos #codigoperiodo').bind('change', function(event) {
                    getDataActividadesAcademicos("#form_actividadesAcademicos");
                });
                
                $(document).on('change', "#form_actividadesAcademicos #modalidad", function(){
                    getCarreras("#form_actividadesAcademicos");
                    changeFormModalidad("#form_actividadesAcademicos");
                });
                
                $(document).on('change', "#form_actividadesAcademicos #unidadAcademica", function(){
                    getDataActividadesAcademicos("#form_actividadesAcademicos");
                    changeFormModalidad("#form_actividadesAcademicos");
                });
                
                function getDataActividadesAcademicos(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasActividadesAcademicos").val()!=""){
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var mes = $(formName + ' #codigoperiodo').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #codigoperiodo').val(mes);
                             $(formName + " #action").val("saveDynamic2");
                             $("#idsiq_formUnidadesAcademicasActividadesAcademicos").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_tipoActividadAcademicos",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasActividadesAcademicos").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasActividadesAcademicos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasActividadesAcademicos);
                                        $(formName + " #numHoras_"+data.data[i].idCategory).val(data.data[i].numHoras);
                                        $(formName + " #numAcademicosTCE_"+data.data[i].idCategory).val(data.data[i].numAcademicosTCE);
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    if($("#idsiq_formUnidadesAcademicasActividadesAcademicos").val()!=""){
                            $(formName + ' input[name="idsiq_detalleformUnidadesAcademicasActividadesAcademicos[]"]').each(function() {                                     
                                  $(this).val("");                                       
                             });
                                                var modalidad = $(formName + ' #modalidad').val();
                                                var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                                var mes = $(formName + ' #codigoperiodo').val();
                                                document.forms[formName.replace("#","")].reset();
                                                $(formName + ' #modalidad').val(modalidad);
                                                $(formName + ' #unidadAcademica').val(unidadAcademica);
                                                $(formName + ' #codigoperiodo').val(mes);
                                                $(formName + " #action").val("saveDynamic2");
                                                $("#idsiq_formUnidadesAcademicasActividadesAcademicos").val("");
                                            }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                    }
                }

                function sendFormFormacionActividadesAcademicos(formName){
                activarModalidades(formName);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
							<?php if($permisos["rol"][0]!=1) { ?>
                            desactivarModalidades(formName);
							<?php } ?>
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formUnidadesAcademicasActividadesAcademicos").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformUnidadesAcademicasActividadesAcademicos_"+data.dataCat[i]).val(data.data[i]);
                                 }
                                 $(formName + " #action").val("updateDynamic2");
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
</script>
