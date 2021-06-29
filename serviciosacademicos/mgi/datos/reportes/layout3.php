<?php $columns = $utils->getDetalleReporte($db, $data["idsiq_reporte"]); 
    $numC = count($columns);
    if($numC>0){
        $col = $numC;
    } else {
        $col = 1;
    }
    
    //solo php 5.2 pa arriba
    $js_array = json_encode($columns);
?>

<label for="nombre" style="width:190px;">Número de columnas: <span class="mandatory">(*)</span></label>

<?php if(isset($_SESSION["columnas"])){ $col = $_SESSION["columnas"]; getSelectNumbers($col); unset($_SESSION['columnas']); 
 } else { getSelectNumbers($col); }
 
 if($numC>0){ 
    for($i=0; $i < $numC; $i++) {  ?>
        <input type="hidden" id="idColumn<?php echo $columns[$i]["numero_columna"]; ?>" value="<?php echo $columns[$i]["idsiq_detalleReporte"]; ?>" />
    <?php } ?>
    <script type="text/javascript">
        $(document).ready(function() {            
            columnChange();
        });
    </script>
 <?php } ?>
<input type="hidden" name="numColumnas" id="numColumnas" value="1" />

<label for="nombre" style="margin-bottom:10px;width:190px;">Estructura del reporte: <span class="mandatory">(*)</span></label>

    <table align="left" id="estructuraReporte" style="text-align:left;clear:both;margin: 10px 30px;">
        <thead>            
             <tr id="dataColumns">
                <?php if($numC==0){ ?>
                    <th class="column1 pickData"><span>Elegir dato/información</span></th>
                <?php } else { ?>
                    <th class="column1 pickData picked"><span><?php echo $columns[0]["etiqueta_columna"]; ?></span></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <tr id="contentColumns">
                <?php //if($numC==0){ ?>
                    <td class="column1"> </td>
                <?php //} else { ?>
                    <!--<th class="column1 pickCategory"><span>Excluir categorías</span></th>-->
                <?php //} ?>
            </tr>
        </tbody>
        <?php if($data['totalizar_al_final']==1){ ?>
        <tfoot>
             <tr id="totalColumns">
                <td class="column1 total title">Total</td>
            </tr>
        </tfoot>
        <?php } ?>
    </table>

<br/><input type="button" value="Previsualizar" class="preview" id="preview" />

<script type="text/javascript">  
    
    $('#columnas').change(function() {
        columnChange();
    });
    
    function columnChange(){
        var num = parseInt($('select#columnas option:selected').val());
        var numActual = parseInt($('#numColumnas').val());
        //alert(num + " - " + numActual);
        if(num>numActual){
            addColumns(numActual,num-numActual);
        } else if(num<numActual){
            removeColumns(numActual,numActual-num);
        }
        $('#numColumnas').val(num);        
    }
    
    function addColumns(numActual,toAdd){
        <?php echo "var myArray = ". $js_array . ";\n";  ?>
        for (var i=1;i<=toAdd;i++)
        {
            var index = numActual + i;
             
            if(typeof myArray !== "undefined" && myArray.length>=index){
               $('#dataColumns').append('<th class="column'+index+' pickData picked"><span>'+myArray[index-1]["etiqueta_columna"]+'</span></th>');
               //$('#contentColumns').append('<td class="column'+index+'"></td>');
               $('#contentColumns').append('<th class="column'+index+' pickCategory"><span>Excluir categorías</span></th>');
               $('#totalColumns').append('<td class="column'+index+' total"></td>');
            } else {
                //$('#dataColumns').append('<th class="column'+index+' pickData"><span>Elegir dato/información</span></th>');
                if($('.column'+(index-1)).hasClass( "picked" )){
                    $('#dataColumns').append('<th class="column'+index+' pickData"><span>Elegir dato/información</span></th>');
                    $('#contentColumns').append('<td class="column'+index+'"></td>');
                    $('#totalColumns').append('<td class="column'+index+' total"></td>');
                } else {
                    $('#dataColumns').append('<th class="column'+index+' disable"><span>Elegir dato/información</span></th>');
                    $('#contentColumns').append('<td class="column'+index+'"></td>');
                    $('#totalColumns').append('<td class="column'+index+' total"></td>');
                }
            }
        }
    }
    
    function removeColumns(numActual,toRemove){
        for (var i=0;i<toRemove;i++)
        {
            var index = numActual - i;
            $('.column'+index).remove();
        }
    }
    
    //live es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
    $(".pickData").live('click',function(){
        // get number of column
        var column = $(this).attr('class').split(" ");
        column = column[0].replace("column",""); 
        
        var name = "idColumn" + column;
        if($('#'+name).length == 0){
            //open dialog. 
            popup_carga('./formData.php?idReporte='+<?php echo $id; ?>+'&columna='+column+'&columnas='+$('#numColumnas').val()); 
        } else {
            popup_carga('./formData.php?idReporte='+<?php echo $id; ?>+'&columna='+column+'&columnas='+$('#numColumnas').val()+'&id='+$('#'+name).val()); 
        }
    });
    
    $("#preview").bind('click',function(){

        //open dialog. 
        popup_carga('./preview.php?idReporte='+<?php echo $id; ?>); 
    });
    
    //live es porque como estoy creando y quitanto elementos dinamicamente, me los reconozca
    $(".pickCategory").live('click',function(){
        // get number of column
        var column = $(this).attr('class').split(" ");
        column = column[0].replace("column",""); 
        
        var name = "idColumn" + column;
        if($('#'+name).length == 0){
            //open dialog. 
            popup_carga('./formCategory.php?idReporte='+<?php echo $id; ?>+'&columna='+column+'&columnas='+$('#numColumnas').val()); 
        } else {
            //siempre deberia entrar aqui
            popup_carga('./formCategory.php?idReporte='+<?php echo $id; ?>+'&columna='+column+'&columnas='+$('#numColumnas').val()+'&id='+$('#'+name).val()); 
        }
    });
    
</script>