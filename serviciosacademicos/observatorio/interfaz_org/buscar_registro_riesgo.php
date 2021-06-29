<?php
include('../templates/templateObservatorio.php');
//include_once ('funciones_datos.php');
 //  $db=writeHeaderBD();
   $db=writeHeader('Observatorio',true,'');
    include("../class/toolsFormClass.php");
    $tipo=$_REQUEST['tipo'];
   ?>
<script>
     $(document).ready( function () {
				var oTable = $('#customers').dataTable( {
                                        "sDom": '<"H"Cfrltip>',
                                        "bJQueryUI": false,
                                        "bProcessing": true,
   					"sScrollX": "100%",
					"bScrollCollapse": true,
                                        "bPaginate": true,
                                        "sPaginationType": "full_numbers",
					"oColReorder": {
						"iFixedColumns": 1
					},
                                        "oColVis": {
                                                "buttonText": "Ver/Ocultar Columns",
                                                 "aiExclude": [ 0 ]
                                          }

				} );
				//new FixedColumns( oTable );
                                
                                new FixedColumns( oTable, {
                                         "iLeftColumns": 4,
                                         "iLeftWidth": 500
				} );
                                <?php if($tipo!='C'){?>
                                 var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                                <?php } ?>
                         $('#demo').before( oTableTools.dom.container );
    });


</script>
<?php
$periodo=$_REQUEST['periodo'];
$modalidad=$_REQUEST['modalidad'];
$facultad=$_REQUEST['facultad'];
$ndocente=$_REQUEST['ndocente'];
$nestudiante=$_REQUEST['nestudiante'];
$semestre=$_REQUEST['semestre'];
$nivel=$_REQUEST['nivel'];
$causas=$_REQUEST['causas'];
$carrera=$_REQUEST['carrera'];


$wp=''; $wm=''; $wf=''; $wd=''; $we=''; $ws=''; $wn=''; $wca=''; $wcf=''; $wcp=''; $woc='';
if (!empty($periodo)) $wp=" and r.codigoperiodo='".$periodo."' ";
if (!empty($modalidad) or $modalidad!=0) $wm=" and c.codigomodalidadacademica='".$modalidad."' ";
if (!empty($facultad) or $facultad!=0) $wf=" and c.codigofacultad='".$facultad."' ";
if (!empty($ndocente)) $wd=" and d.numerodocumento='".$ndocente."' ";
if (!empty($nestudiante)) $we=" and e.numerodocumento='".$nestudiante."' ";
if (!empty($semestre)) $ws=" and  es.semestre in (".$semestre.")";
if (!empty($nivel)) $wn=" and tr.idobs_tiporiesgo in (".$nivel.")";
if (!empty($causas)) $wca=" and ro.idobs_causas in (".$causas.") ";
if (!empty($carrera)) $wc=" and c.codigocarrera in (".$carrera.") ";

   $query_carrera = "SELECT r.idobs_registro_riesgo, e.numerodocumento, nombresestudiantegeneral, apellidosestudiantegeneral,  
                            nombredocente, apellidodocente, d.numerodocumento as numerodocumentodocente,
                     es.semestre, es.codigocarrera, c.nombrecarrera, m.nombremodalidadacademica, fa.nombrefacultad,
                     f.nombrecausas as causas, t.nombretipocausas,  tr.nombretiporiesgo, observacionesregistro_riesgo, intervencionregistro_riesgo,
                     r.idobs_herramientas_deteccion, h.nombre as deteccion, e.idestudiantegeneral
                     FROM `obs_registro_riesgo` as r 
                     INNER JOIN obs_registro_riesgo_causas as ro on (r.idobs_registro_riesgo=ro.idobs_registro_riesgo)
                     INNER JOIN obs_tiporiesgo AS tr on (r.idobs_tiporiesgo=tr.idobs_tiporiesgo)
                     INNER JOIN estudiantegeneral as e on (r.codigoestudiante=e.idestudiantegeneral) 
                     INNER JOIN estudiante as es on (e.idestudiantegeneral=es.idestudiantegeneral)
                     INNER JOIN carrera as c on (es.codigocarrera=c.codigocarrera)
                     INNER JOIN facultad as fa on (c.codigofacultad=fa.codigofacultad)
                     INNER JOIN modalidadacademica as m on (c.codigomodalidadacademica=m.codigomodalidadacademica and m.codigoestado=100)
                     INNER JOIN usuario as u on (r.usuariocreacion=u.idusuario)
                     INNER JOIN obs_herramientas_deteccion as h on (h.idobs_herramientas_deteccion=r.idobs_herramientas_deteccion)
                     LEFT JOIN docente as d on (d.numerodocumento=u.numerodocumento) 
                     LEFT JOIN obs_causas as f on (f.idobs_causas=ro.idobs_causas and f.codigoestado=100) 
                     LEFT JOIN obs_tipocausas as t on (f.idobs_tipocausas=t.idobs_tipocausas)
                     WHERE r.codigoestado=100 and r.estado=1
                    ".$wp." ".$wm." ".$wf."
                    ".$wd." ".$we." ".$ws."
                    ".$wn." ".$wca." ".$wc."
                    group by e.numerodocumento order by r.fechacreacion desc";
//echo $query_carrera;
   $data_in= $db->Execute($query_carrera);
 ?>
<div id="demo" style=" width: 1000px;">
<table cellpadding="0" cellspacing="0" border="1" class="display" id='customers' style=" font-size: 10px;  " width="100%">
    <thead style=" background: #eff0f0">
        <td>Acciones</td>
        <td>N Identificacion</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>Semestre</td>
        <td>Carrera</td>
        <td>Facultad</td>
        <td>Modalidad Academica</td>
        <td>Nivel de Riesgo</td>
        <td>Nombre Docente</td> 
        <td>Apellido Docente</td> 
        <td>Herramienta de Deteccion</td> 
        
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){    
            ?>
                 <tr>
                     <td> 
                         <?php
                         if ($tipo=='R'){
                         ?>
                          <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_registro_riesgo.php?id=row_<?php echo $dt['idobs_registro_riesgo'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                          <!--<button type="button" id="eliminar" name="eliminar" title="Eliminar" onclick="deleteRegistro('registro_riesgo','<?php echo $dt['idobs_registro_riesgo'] ?>','listar_registro_riesgo.php')"><img src="../img/eliminar.png" width="20px" height="20px"  /></button>-->
                         <?php
                         }
                         if ($tipo=='S'){
                         ?>
                          <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_seguimiento.php?id_res=<?php echo $dt['idobs_registro_riesgo'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                          <!--<button type="button" id="eliminar" name="eliminar" title="Eliminar" onclick="deleteRegistro('registro_riesgo','<?php echo $dt['idobs_registro_riesgo'] ?>','listar_registro_riesgo.php')"><img src="../img/eliminar.png" width="20px" height="20px"  /></button>-->
                         <?php
                         }
                         if ($tipo=='SE'){
                         ?>
                          <button type="button" id="editar" name="editar" title="Editar" onclick="updateForm3('form_seguimiento_estudiante.php?id_estu=<?php echo $dt['idestudiantegeneral'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                          <!--<button type="button" id="eliminar" name="eliminar" title="Eliminar" onclick="deleteRegistro('registro_riesgo','<?php echo $dt['idobs_registro_riesgo'] ?>','listar_registro_riesgo.php')"><img src="../img/eliminar.png" width="20px" height="20px"  /></button>-->
                         <?php
                         }
                         if ($tipo=='C'){
                         echo toolsFormClass::getForm('checkbox','resgitro_riesgo','',$dt['numerodocumento'] ); 
                         }
                         
                         if ($tipo=='P'){
                             $sqlpi="SELECT * FROM obs_primera_instancia WHERE idobs_registro_riesgo='".$dt['idobs_registro_riesgo']."'    ";
                            // echo $sqlpi; 
                             $data_pi= $db->Execute($sqlpi);
                             $E_data = $data_pi->GetArray();
                             $E_data=$E_data[0];
                             $idpi=$E_data['idobs_primera_instancia'];
                             $cat=count($E_data);
                             if ($cat==0){

                            ?>
                             <button type="button" id="crear" name="crear" title="Primera Instancia" onclick="updateForm3('form_primera_instancia.php?id_res=<?php echo $dt['idobs_registro_riesgo'] ?>')"><img src="../img/agregar.png" width="20px" height="20px"  /></button>
                            <?php
                            }else{
                              ?>
                             <button type="button" id="editar" name="editar" title="Crear Tutorias" onclick="updateForm3('form_tutorias.php?id_pi=<?php echo $idpi ?>&id_res=<?php echo $dt['idobs_registro_riesgo'] ?>')"><img src="../img/editar.png" width="20px" height="20px"  /></button>
                            <?php  
                            }
                         }
                         ?>
                     </td>
                            <td><?php echo $dt['numerodocumento'] ?></td>
                            <td><?php echo $dt['nombresestudiantegeneral'] ?></td>
                            <td><?php echo $dt['apellidosestudiantegeneral'] ?></td>
                            <td><?php echo $dt['semestre'] ?></td>
                            <td><?php echo $dt['nombrecarrera'] ?></td>
                            <td><?php echo $dt['nombrefacultad'] ?></td>
                            <td><?php echo $dt['nombremodalidadacademica'] ?></td>
                            <td><?php echo $dt['nombretiporiesgo'] ?></td>
                            <td><?php echo $dt['nombredocente'] ?></td> 
                            <td><?php echo $dt['apellidodocente'] ?></td> 
                            <td><?php echo $dt['deteccion'] ?></td> 
                        </tr>
            <?php
            $i++;
        }
    ?>
    </tbody>
</table>
    <br><br>
    <?php
    if($tipo=='C'){
        echo toolsFormClass::getForm('lbox','form_send_citaciones.php','1','Enviar Citaciones','formCitaciones','bcita','650','550');
    }
    ?>
</div>