    
    <div id="contenidoSecundario">
            <h2>Responsables del Indicador</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text">
                        <span>Asignar nuevo responsable</span>                
                    </button>
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Cambiar responsabilidad</span>                
                    </button>
                    <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                        <span>Eliminar responsable</span>                
                    </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width: 100%;">
                    <thead>
                        <tr>                 
                            <th>Usuario Responsable</th>
                            <th>Apellido Usuario Responsable</th>
                            <th>Tipo de Responsabilidad</th>
                            <th>Usuario Modificación</th>
                            <th>Fecha Modificación</th>                           
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
        </div>

<script type="text/javascript">
        var oTable;
        var aSelected = [];           
                      
        $(document).ready(function() {  
            var sql;
            //el id no cuenta, entonces desde nombre empieza en 0
            sql="SELECT g.idsiq_responsableIndicador,c.nombres,c.apellidos,t.nombre,g.usuario_modificacion,g.fecha_modificacion FROM siq_responsableIndicador g ";
            sql+='inner join usuario c on c.idusuario = g.idUsuarioResponsable ';
            sql+='inner join siq_tipoResponsabilidad t on t.idsiq_tipoResponsabilidad = g.idTipoResponsabilidad ';
            
              oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "oLanguage": {
                    "sEmptyTable": "No se encontraron datos."
                },
                "bServerSide": true,                
                "sAjaxSource": "<?php echo $rutaProcessing; ?>server_processing.php?active=true&table=siq_responsableIndicador&sql="+sql+"&wh=g.idIndicador&vwh=<?php echo $_REQUEST["id"]; ?>&tableNickname=g&join=true",
                "aaSorting": [[ 4, "desc" ]],
                "aoColumnDefs": [ 
                    
						{ "bSearchable": true, "bVisible": false, "aTargets": [ 1 ] },
						{ "bSearchable": false, "sClass": "column_center", "bVisible": true, "aTargets": [ 3 ] },
						{ "fnRender": function ( oObj ) { return oObj.aData[0]+" "+oObj.aData[1];
                                                    }, "bSearchable": true, "sClass": "column_center", "bVisible": true, "aTargets": [ 0 ] },
                                                { "sClass": "column_center", "aTargets": [ 4,2 ] }
					],
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#contenidoSecundario').width();  
                            this.width(maxWidth);
                        }
            });
                        
            $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                }
             } );
             
             $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {assignResponsable(<?php echo $_REQUEST["id"]; ?>);}                
            } );
            
            $('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteResponsable("responsableIndicador");}                
            } );
            
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {
                      if(aSelected.length==1){
                            var id = aSelected[0];
                            id=id.substring(4,id.length);
                            window.location.href= "responsable.php?action=update&id="+<?php echo $_REQUEST["id"]; ?>+"&idResponsable="+id;
                      } else{
                            return false;
                      }                  
                }                
            });
            
      } );
      
        //Para que al cambiar el tamaño de la página se arreglen las tablas
        $(window).resize(function() {
            resizeWindow('#contenidoSecundario',oTable);
        });        
</script>
