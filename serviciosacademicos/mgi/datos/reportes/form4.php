<?php
    include("../templates/template.php");
    $text = "Crear Nuevo";
    $edit = false;
    if(isset($_REQUEST["edit"])){
        $text = "Editar";
    }
    $db = writeHeader($text." Reporte",TRUE);
    
    include("./menu.php");
    writeMenu(2);
    
?>
   <link rel="stylesheet" href="../../css/jquery.tooltip.css" />
    <script type="text/javascript" language="javascript" src="../../js/jquery.tooltip.js"></script>     
        <div id="contenido">
            <h2><?php echo $text; ?> Reporte </h2>
            <?php 
                $data = array();
                $action = "";
                $id = $_REQUEST["id"];
                $utils = new Utils_datos();
                $discriminaciones = $utils->getDiscriminacionesIndicador($db,false);
                $modalidades = $utils->getModalidadesAcademicas($db,false);
                $indicadores = $utils->getIndicadoresAsociadosReporte($db,$id,false);
                
                $url = "editar.php?step=3&id=". $id;  
                
                if($id!="" && $id!=null){
                    $data = $utils->getDataEntity("reporte",$id);  
                    $action = "update";                    
                    $edit = true;
                }
            ?>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test" >
                        <input type="hidden" name="entity" value="reporte" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="estado_definicion_reporte" value="4" />
                        <?php
                        if($id!="" && $id!=null ){
                            echo '<input type="hidden" name="idsiq_reporte" id="idsiq_reporte" value="'.$id.'">';
                        }
                        ?>
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Asociar indicadores al reporte</legend>
                            
                            <div class="seccionBox seccionBoxFirst">
                                <label >Tipo:</label>
                                <?php echo $discriminaciones->GetMenu2('idsiq_discriminacionIndicador',null,true,false,1,' id="idsiq_discriminacionIndicador" '); ?>
                            </div>
                            
                            <div class="seccionBox">
                                <label for="nombre" >Modalidad Académica: </label>
                                <select id="modalidadVacia">
                                    <option value=""> </option>
                                </select>                                
                                
                                <?php echo $modalidades->GetMenu2('codigomodalidadacademica',null,true,false,1,' id="modalidadAcademica" style="display:none;"'); ?>
                            </div>
                            
                            <div class="vacio"></div>
                            
                            <div class="seccionBoxFirst">
                                <label style="width:190px">Programa:</label>
                                <select id="programaAcademico" name="codigocarrera" style="max-width:800px">
                                    <option value=""> </option>
                                </select> 
                            </div>
                            
                            <div class="vacio"></div>
                            <input type="hidden" name="totalindicadores" id="totalindicadores" value="" />
                            
                   <table style="border: 0px;margin-left:70px;">  
                    <tr>
                        <td valign="top" colspan="2" style="padding: 0.5em 0 0;">
                                    <legend>Indicadores Disponibles para Asociar</legend>
                                    <div id="fastLiveFilter" style="width:480px; height:520px; overflow: scroll;" >
                                      
                                      <ul id="sortable1" class="connectedSortable" style="min-height: 460px">  
                                      
                                      </ul>
                                   </div>
                        </td>
                        <td  valign="top" colspan="2" style="padding: 0.5em 0 0;">
                                     <legend>Indicadores Asociados</legend>
                                     <div id="indicadoresAsociados" style="width:480px; height:520px; overflow: scroll;">
                                         
                                        <ul id="sortable2" class="connectedSortable" style="min-height: 500px">
                                            <li class="ui-state-highlight" id="0">Arrastrar hasta aquí
                                            </li>
                                            <?php
                                            if (!empty($indicadores)){
                                                    $i=0;
                                                    //var_dump($indicadores);
                                                    foreach($indicadores as $dt_sec){
                                                    // print_r($dt);
                                                           $nombre=$dt_sec['nombre'];
                                                            $dis=$dt_sec['discriminacion'];
                                                            $carrera=$dt_sec['nombrecortocarrera'];
                                                            $id_in=$dt_sec['idsiq_indicador'];
                                                            if ($dis==3){
                                                                $nombre=$nombre.'('.$carrera.')';
                                                            }else{
                                                                $nombre=$nombre.'(Institucional)';
                                                            }
                                                    
                                                        $id=$dt_sec['codigo'];
                                                        echo '<li class="ui-state-default idInd'.$id_in.'" id="'.$id.' ">'.$id.' - '.$nombre;
                                                        //echo '<input type="hidden" name="idsiq_Apreguntaindicador1['.$i.']" id="idsiq_Apreguntaindicador1_'.$i.'" style="width: 50px" value="'.$idpreg.'" >';
                                                        //echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
                                                        echo'</li>';
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                        </ul>
                                     </div>                                    
                        </td>
                    </tr>
                </table>
                            
                        </fieldset>            
                        
                        <input type="button" value="< Anterior" class="previous" id="previous" />
                        <input type="submit" value="Guardar cambios" class="next" />
                        <?php /*if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
                        <?php } else { ?><input type="submit" value="Crear reporte" class="first" /> <?php }*/ ?>
                    </form>
            </div>
           
        </div>

            <script type="text/javascript">
                
                $("#previous").click(function() {
                    window.location.href="<?php echo $url; ?>";
                });
                
                            $(':submit').click(function(event) {
                                event.preventDefault();
                                var valido= validateForm("#form_test");                                
                                if(valido){
                                    sendForm();
                                }
                            });

                            function sendForm(){
                                $.ajax({
                                    dataType: 'json',
                                    type: 'POST',
                                    url: 'process.php',
                                    data: $('#form_test').serialize(),                
                                    success:function(data){
                                        if (data.success == true){   
                                            alert("Los cambios han sido guardados de forma correcta");
                                            window.location.href="index.php";
                                            <?php /*if($edit&&$id!=""){ ?>
                                                window.location.href="form3.php?edit=1&id="+<?php echo $id; ?>;                                 
                                            <?php } else { ?>
                                                window.location.href="form3.php?id="+<?php echo $id; ?>;
                                            <?php }*/ ?>
                                        }
                                        else{                        
                                            $('#msg-error').html('<p>' + data.message + '</p>');
                                            $('#msg-error').addClass('msg-error');
                                        }
                                    },
                                    error: function(data,error,errorThrown){alert(error + errorThrown);}
                                });            
                            }
       
          
          $("#idsiq_discriminacionIndicador").bind('change',function(){
                    //borrar indicadores
                    $('#fastLiveFilter').html("");  
                if($( "#idsiq_discriminacionIndicador" ).val()!="3"){
                    $("#modalidadVacia").attr('style', 'display: block;');
                    $("#modalidadAcademica").attr('style', 'display: none;');
                    $("#programaAcademico").html('<option value=""> </option>');
                    if($( "#idsiq_discriminacionIndicador" ).val()=="1"){
                        displayIndicadores(); 
                    }
                } else {
                    $("#modalidadAcademica").attr('style', 'display: block;');
                    $("#modalidadVacia").attr('style', 'display: none;');
                }
            });
            
            $("#modalidadAcademica").bind('change',function(){
                if($( "#modalidadAcademica" ).val()==""){
                    //borrar indicadores
                    $('#fastLiveFilter').html("");  
                    $("#programaAcademico").html('<option value=""> </option>');
                } else {
                        //busco los programas
                        $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: "../searchs/lookForCareersByModalidad.php",
                                async: false,
                                data: {
                                    modalidad: $("#modalidadAcademica").val()
                                },
                                success:function(data){ 
                                    if(data!=null && data.length>0){
                                        select = "<option value=''></option>";
                                        for (var i=0;i<data.length;i++)
                                        {
                                            select = select+"<option value='"+data[i]["value"]+"'>"+data[i]["label"]+"</option>";      
                                        }
                                        $('#programaAcademico').html(select);
                                    }
                                },
                                error: function(data,error){}
                            }); 
                }
            });
            
            $(function() {
                $( "#sortable1, #sortable2" ).sortable({
                    connectWith: ".connectedSortable",
                    dropOnEmpty: true,
                    //placeholder: "ui-state-highlight",
                    start: function(e,ui){
                        ui.placeholder.height(ui.item.height());
                    }
                });
            });
            
            
            $("#programaAcademico").bind('change',function(){
                if($( "#programaAcademico" ).val()==""){
                    //borrar indicadores
                    $('#fastLiveFilter').html("");                    
                } else {
                        //busco los indicadores
                        displayIndicadores(); 
                }
            });
            
            function displayIndicadores(){
            // alert('hola');
                $('#fastLiveFilter').html("");   
                var ajaxLoader = "<img src='../../images/ajax-loader2.gif' alt='cargando...' style='margin: 5px'/>";           
                var optionValue1 = jQuery("select[name='idsiq_discriminacionIndicador']").val();
                if (optionValue1==3){
                    optionValue = jQuery("select[name='codigocarrera']").val();
                    option=1;
                }else{
                    optionValue = jQuery("select[name='idsiq_discriminacionIndicador']").val();
                    option=3
                }
                jQuery("#fastLiveFilter")
                    .html(ajaxLoader)
                    .load('_generarIndicadores.php', {id: optionValue, opt: option, status: 1, idReporte: $("#idsiq_reporte").val()}, function(response){					
                    if(response) {
                        jQuery("#fastLiveFilter").css('display', '');                    
                    } else {                    
                        jQuery("#fastLiveFilter").css('display', 'none');               
                    }
                });     
            }
            
            $( "#sortable1" ).bind( "sortupdate", function(event, ui) {
            var clases=ui.item.attr('class').split(" "); 
            if(clases.length>1){
                var id=clases[1].replace("idInd",""); 
                var action2 = "inactivate";
                var idReporte = $("#idsiq_reporte").val();
                if($(".idInd"+id).hasClass("noAsociado")){
                    var action2 = "save";
                } 

                var order = 'idIndicador=' + id + '&idReporte='+idReporte+'&action=updateRecordsListings&action2='+action2;
                //alert(order);
                //console.log(ui.item.attr('class'));
                //console.log(ui.item);
                $.post("process.php", order, function(reponse){

                        if($(".idInd"+id).hasClass("noAsociado")){
                            $(".idInd"+id).removeClass("noAsociado");
                        } else {
                            $(".idInd"+id).addClass("noAsociado");
                        }

                }); 
            }
        });

            </script>

<?php writeFooter(); ?>
