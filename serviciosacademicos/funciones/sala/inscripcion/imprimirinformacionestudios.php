<?php  /*require('../../../Connections/sala2.php');$sala2 = $sala;$rutaado = "../../../funciones/adodb/";require_once('../../../Connections/salaado.php');*/ @session_start();
$codigoinscripcion = $_SESSION['numerodocumentosesion'];//mysql_select_db($database_sala, $sala2);
$query_niveleducacion = "select *from niveleducacionorder by 2";$niveleducacion = $db->Execute($query_niveleducacion);$totalRows_niveleducacion = $niveleducacion->RecordCount();$row_niveleducacion = $niveleducacion->FetchRow();
//echo '<input type="hidden" name="grabado" value="grabado">';
$query_titulo = "select *from titulowhere codigotitulo <> 1order by 2";$titulo = $db->Execute($query_titulo);$totalRows_titulo = $titulo->RecordCount();$row_titulo = $titulo->FetchRow();
$query_ciudad = "select *from ciudadorder by 3";$ciudad = $db->Execute($query_ciudad);$totalRows_ciudad = $ciudad->RecordCount();$row_ciudad = $ciudad->FetchRow();
//$db->debug = true;
$query_datosgrabados = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
e.codigotitulo, e.ciudadinstitucioneducativa, e.observacionestudianteestudio, e.idestudianteestudio,
ins.nombreinstitucioneducativa, t.nombretitulo, 
e.otrainstitucioneducativaestudianteestudio, e.otrotituloestudianteestudioFROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo tWHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'and e.idniveleducacion = n.idniveleducacionand ins.idinstitucioneducativa = e.idinstitucioneducativaand e.codigotitulo = t.codigotitulo								 and e.codigoestado like '1%'order by anogradoestudianteestudio";			  $datosgrabados = $db->Execute($query_datosgrabados);$totalRows_datosgrabados = $datosgrabados->RecordCount();$row_datosgrabados = $datosgrabados->FetchRow();if($row_datosgrabados <> ""){ ?>		       <table width="670px" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">                <tr>					<td id="tdtitulogris">Nivel</td>					<td id="tdtitulogris">Institución</td>										<td id="tdtitulogris">Titulo</td>					<td id="tdtitulogris">Ciudad</td>					<td id="tdtitulogris">Año</td>					<td id="tdtitulogris">Observaciones</td>                </tr><?php 	do	{ 				 ?>			        <tr>                     <td><?php echo $row_datosgrabados['nombreniveleducacion'];?></td>    				 <td><?php if($row_datosgrabados['idinstitucioneducativa'] != '1'){ echo $row_datosgrabados['nombreinstitucioneducativa'];} else{ echo $row_datosgrabados['otrainstitucioneducativaestudianteestudio'];} ?></td>                     <td><?php if($row_datosgrabados['codigotitulo'] != '1'){ echo $row_datosgrabados['nombretitulo'];} else{ echo $row_datosgrabados['otrotituloestudianteestudio'];}?></td>					  <td><?php echo $row_datosgrabados['ciudadinstitucioneducativa'];?></td>					 <td><?php echo $row_datosgrabados['anogradoestudianteestudio'];?></td>					 <td><?php echo $row_datosgrabados['observacionestudianteestudio'];?></td>					 			        </tr>			   <?php  	}	while($row_datosgrabados = $datosgrabados->FetchRow());?>	    </table> 
<?php}else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])) {?><!-- <tr><td>Sin datos diligenciados</td></tr> --><?php}?>