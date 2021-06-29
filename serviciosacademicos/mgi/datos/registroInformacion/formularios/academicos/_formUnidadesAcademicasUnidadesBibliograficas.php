<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-7">
<form action="save.php" method="post" id="form_bibliograficas">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasUnidadesBibliograficas" />
            <input type="hidden" name="action" value="save2" id="action" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Descripción de Otras unidades Bibliográficas</legend>
                
                <div class="formModalidad">
                     <?php include("./_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Descripción de Otras unidades Bibliográficas y de información de las Unidades Académicas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Unidad de Bibliografía y de Información </span></th> 
                            <th class="column" ><span>Descripción</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <tr class="dataColumns">
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Nombre de la Unidad" maxlength="200" tabindex="1" autocomplete="off" value="" />
                                <input type="hidden" name="idsiq_formUnidadesAcademicasUnidadesBibliograficas[]" autocomplete="off" value="" />
                            </td>
                            <td class="column"> 
                                <input type="text" class="grid-11-12 required inputTable" minlength="1" name="descripcion[]" title="Descripcion" maxlength="500" tabindex="1" autocomplete="off" value="" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            <input type="button" class="first small" id="addMoreBibliograficas" value="Agregar otro" style="margin-top:10px">
            <input type="button" class="first small" id="removeBibliograficas" value="Eliminar último" style="margin-top:10px">
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitBibliograficas" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
    getDataBibliograficas("#form_bibliograficas");
   
   $('#addMoreBibliograficas').click(function(event) {
           addTableRow("#form_bibliograficas");
   });
   
   $('#removeBibliograficas').click(function(event) {
       var formName = "#form_bibliograficas";
       var inputName = "input[name='idsiq_formUnidadesAcademicasUnidadesBibliograficas[]']";
       if($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()!=""){
        var id = $(formName + ' table').children('tbody').children('tr:last').find(inputName).val();
        var entity = $(formName + ' #entity').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: './formularios/academicos/saveUnidadesAcademicas.php',
            data: { action: "inactivate", idsiq_formUnidadesAcademicasUnidadesBibliograficas:id, entity:entity },                
                            success:function(data){
                                if (data.success == true){
                                    removeTableRow(formName,inputName);
                                }
                                else{                        
                                    alert("Ocurrio un error");
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
            });  
       } else {
            removeTableRow(formName,inputName);
       }
   });
    
                $('#submitBibliograficas').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_bibliograficas");
                    if(valido){
                        sendFormBibliograficas("#form_bibliograficas");
                    }
                });
                
                $('#form_bibliograficas #mes').add($('#form_bibliograficas #anio')).bind('change', function(event) {
                    getDataBibliograficas("#form_bibliograficas");
                });
                
                $(document).on('change', "#form_bibliograficas #modalidad", function(){
                    getCarreras("#form_bibliograficas");
                    changeFormModalidad("#form_bibliograficas");
                });
                
                $(document).on('change', "#form_bibliograficas #unidadAcademica", function(){
                    getDataBibliograficas("#form_bibliograficas");
                    changeFormModalidad("#form_bibliograficas");
                });
                
                function getDataBibliograficas(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        $(formName + ' table input').each(function() {                                     
                             $(this).val("");                                       
                        });
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData2", entity: entity, campoPeriodo: "codigoperiodo",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    //borro todas las filas
                                    $(formName + ' table').children('tbody').children('tr').remove(); 
                                    for (var i=0;i<data.total;i++)
                                    {                                  
                                        //pinto las nuevas filas
                                        var row = '<tr class="dataColumns">';
                                        row = row + '<td class="column">';
                                        row = row + '<input type="text" class="grid-11-12 required inputTable" minlength="1" name="nombre[]" title="Nombre de la Unidad" maxlength="200" tabindex="1" autocomplete="off" value="'+data.data[i].nombre+'" />';
                                        row = row + '<input type="hidden" name="idsiq_formUnidadesAcademicasUnidadesBibliograficas[]" autocomplete="off" value="'+data.data[i].idsiq_formUnidadesAcademicasUnidadesBibliograficas+'" />';
                                        row = row + '</td><td class="column">';
                                        row = row + '<input type="text" class="grid-11-12 required inputTable" minlength="1" name="descripcion[]" title="Descripcion" maxlength="500" tabindex="1" autocomplete="off" value="'+data.data[i].descripcion+'" />';
                                        row = row + '</td></tr>';
                                        if($(formName + ' table').children('tbody').find('tr:last').length>0){
                                            $(formName + ' table').children('tbody').find('tr:last').after(row);  
                                        } else {
                                            $(formName + ' table').children('tbody').append(row); 
                                        }
                                    }
                                    $(formName + " #action").val("update2");
                                }
                                else{                        
                                    //no se encontraron datos
                                    $(formName + ' table input').each(function() {                                     
                                        $(this).val("");                                       
                                    });
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormBibliograficas(formName){
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                $(formName + ' #codigoperiodo').val(periodo);
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
                                 var i = 0;
                                 $('input[name="idsiq_formUnidadesAcademicasUnidadesBibliograficas[]"]').each(function() {
                                        $(this).val(data.data[i]);
                                        i = i + 1;
                                 }); 
                                 $(formName + " #action").val("update2");
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
