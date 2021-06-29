<?php 
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php');
require_once('../../../funciones/errores_horario.php'); 
mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadmateriasgrupos.php');

$idplanestudio = $_GET['planestudio'];
$codigocarrera = $_SESSION['codigofacultad'];

/*$query_selgrupomateria = "select g.idgrupomateria, g.nombregrupomateria
from grupomateria g";
//echo "$query_selsemestre<br>";
$selgrupomateria = mysql_db_query($database_sala, $query_selgrupomateria) or die("$query_selgrupomateria".mysql_error());
$totalRows_selgrupomateria = mysql_num_rows($selgrupomateria);
*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Buscar Materia</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {font-size: 14}
.Estilo3 {font-family: Tahoma; font-size: 14; }
.Estilo4 {font-size: 12}
.Estilo5 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo6 {
	font-family: Tahoma;
	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {font-family: Tahoma; font-size: 10px; }
.Estilo9 {font-family: Tahoma; font-size: 12px; }
-->
</style>
</head>
<body>
<?php echo '
<script language="javascript">
function cambia_tipo()
{ 
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (tipo == 1)
	{
		window.location.reload("buscarmateria.php?planestudio='.$idplanestudio.'&busqueda=nombre"); 
	} 
    if (tipo == 2)
	{
		window.location.reload("buscarmateria.php?planestudio='.$idplanestudio.'&busqueda=codigo"); 
    }  
} 

function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (busca != 0)
	{
		window.location.reload("buscarmateria.php?planestudio='.$idplanestudio.'&"+busca); 
	} 
} 
</script>';
?>
<div align="center">
<form name="f1" action="buscarmateria.php" method="get">
  <input type="hidden" name="planestudio" value="<?php echo $idplanestudio; ?>">
  <p class="Estilo1 Estilo2"><strong>B&Uacute;SQUEDA DE MATERIA </strong></p>
  <table width="400" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td width="210" bgcolor="#C5D5D6" class="Estilo3">
	  <div align="center" class="Estilo4"><span class="Estilo5">Búsqueda por:</span>	        <select name="tipo" onChange="cambia_tipo()">
		    <option value="0">Seleccionar</option>
		    <option value="1">Nombre</option>
		    <option value="2">Código</option>
            <?php
/*while($row_selgrupomateria = mysql_fetch_array($selgrupomateria))
{
?>
		    <option value="<?php echo "grupo".$row_selgrupomateria['idgrupomateria']; ?>"><?php echo $row_selgrupomateria['nombregrupomateria']; ?></option>
            <?php
}
*/
?>
	        </select>
	&nbsp;
	    </div></td>
	<td width="173" class="Estilo6">&nbsp;<?php
if(isset($_GET['busqueda']))
{
	if($_GET['busqueda']=="nombre")
	{
		echo "Digite un Nombre : <input name='busqueda_nombre' type='text'>";
	}
	if($_GET['busqueda']=="codigo")
	{
		echo "Digite un Código : <input name='busqueda_codigo' type='text'>";
	}
?></td>
  </tr>
  <tr>
  	<td colspan="2" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;<input type="button" value="Cancelar" onClick="window.close()"></td>
  </tr>
<?php
}
if(isset($_GET['buscar']))
{
?>
</table>
<p align="center" class="Estilo1"><input type="button" value="Cancelar" onClick="window.close()"></p>
<p align="center" class="Estilo9"><strong>Seleccione la materia de la siguiente tabla: </strong></p>
<table width="400" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo9"><strong>Código Materia</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo9"><strong>Nombre Materia</strong>&nbsp;</td>
  </tr>
<?php
	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT d.codigomateria, m.nombremateria, 
		d.semestredetalleplanestudio*1 AS semestredetalleplanestudio, 
		t.nombretipomateria, d.numerocreditosdetalleplanestudio
		FROM detalleplanestudio d, materia m, tipomateria t
		WHERE d.codigoestadodetalleplanestudio LIKE '1%'
		AND d.codigomateria = m.codigomateria
		AND d.codigotipomateria = t.codigotipomateria
		AND d.idplanestudio = '$idplanestudio'
		and m.nombremateria like '$nombre%' 
		ORDER BY 3,2";
		//echo "$query_solicitud<br>";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = false;
	}
	if(isset($_GET['busqueda_codigo']))
	{
		$codigo = $_GET['busqueda_codigo'];
		$query_solicitud = "SELECT d.codigomateria, m.nombremateria, 
		d.semestredetalleplanestudio*1 AS semestredetalleplanestudio, 
		t.nombretipomateria, d.numerocreditosdetalleplanestudio
		FROM detalleplanestudio d, materia m, tipomateria t
		WHERE d.codigoestadodetalleplanestudio LIKE '1%'
		AND d.codigomateria = m.codigomateria
		AND d.codigotipomateria = t.codigotipomateria
		AND d.idplanestudio = '$idplanestudio'
		and m.codigomateria like '$codigo%' 
		ORDER BY 3,2";
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_codigo'] == "")
			$vacio = false;
	}
	if(!$vacio)
	{
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$nombremateria = $solicitud["nombremateria"];
			$codigomateria = $solicitud["codigomateria"];
			echo "<tr>
				<td align='center'><font face='Tahoma' size='2'><a href='buscarmateria.php?planestudio=$idplanestudio&aceptar=$codigomateria'>$codigomateria&nbsp;</a></font></td>
				<td align='center'><font face='Tahoma' size='2'>$nombremateria&nbsp;</font></td>
			</tr>";
		}
		echo '<tr><td colspan="3" align="center"><input type="button" value="Cancelar" onClick="window.close()"></td></tr>';
	}
?>
</table>
<p class="Estilo8">
<?php
}
/*		echo "<script language='javascript'>  window.location.reload('creditos.php?busqueda_credito=".$sol."&buscar=Buscar')</script>";
*/
if(isset($_GET['aceptar']))
{
	$materiaseleccionada = $_GET['aceptar'];
	echo "?planestudio=$idplanestudio&filtro=materiaunica&materiaelegida=$materiaseleccionada";
	echo "<script language='javascript'>
			window.opener.recargar('?planestudio=$idplanestudio&filtro=materiaunica&materiaelegida=$materiaseleccionada');
			window.opener.focus();
			window.close();
	  </script>";
}
?></p>
</form>
</div>
</body>
</html>
