<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
@@session_start();
?>
<html>
<head>
<title>.:Recurso Financiero:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<form name="inscripcion" method="post" action="">
<?php
   $direccion = "recursofinanciero.php";  
    $query_tipoestudianterecursofinanciero = "select *
					                          from tipoestudianterecursofinanciero
					                          order by 2";
	$tipoestudianterecursofinanciero = $db->Execute($query_tipoestudianterecursofinanciero);
	$totalRows_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->RecordCount();
	$row_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->FetchRow();

	$query_datosgrabados = "SELECT * 
							FROM estudianterecursofinanciero e 
							WHERE e.idestudianterecursofinanciero = '".$_GET['id']."'";    
	$datosgrabados = $db->Execute($query_datosgrabados);
	$totalRows_datosgrabados = $datosgrabados->RecordCount();
	$row_datosgrabados = $datosgrabados->FetchRow();
?>
<p>EDITAR</p>
<table width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
		 <tr id="trtitulogris">
          <td>Tipo de Recurso</td>
          <td>Descripci&oacute;n</td>
    </tr>
		<tr>
          <td width="51%">
		   <select name="tipoestudianterecursofinanciero">
                <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['idtipoestudianterecursofinanciero']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
				do 
				{  
?>
                <option value="<?php echo $row_tipoestudianterecursofinanciero['idtipoestudianterecursofinanciero']?>"<?php if (!(strcmp($row_tipoestudianterecursofinanciero['idtipoestudianterecursofinanciero'],$row_datosgrabados['idtipoestudianterecursofinanciero']))) {echo "SELECTED";} ?>><?php echo $row_tipoestudianterecursofinanciero['nombretipoestudianterecursofinanciero']?></option>
                <?php
                } 
				while($row_tipoestudianterecursofinanciero = $tipoestudianterecursofinanciero->FetchRow());
				?>
            </select> 
		  </td>
          <td width="49%" ><input type="text" name="descripcion" size="70" value="<?php if (isset($row_datosgrabados['descripcionestudianterecursofinanciero'])) echo $row_datosgrabados['descripcionestudianterecursofinanciero']; else $_POST['descripcion'];?>"></td>
	</tr>        
</table>
<?php
$banderagrabar = 0;
if (isset($_POST['grabado']))
 {	
	 if ($_POST['tipoestudianterecursofinanciero'] == 0)
	  {
	    echo '<script language="JavaScript">alert("Debe seleccionar el tipo de recurso")</script>';	
		$banderagrabar = 1;
	  }
	 else
	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['descripcion']) and $_POST['descripcion'] <> ""))
	  {
	    echo '<script language="JavaScript">alert("Describa el tipo de recurso")</script>';		    		  
		$banderagrabar = 1;
	  }
	else
	 if ($banderagrabar == 0)
	 {
	       $base="update estudianterecursofinanciero 
		   set idtipoestudianterecursofinanciero = '".$_POST['tipoestudianterecursofinanciero']."',
		   descripcionestudianterecursofinanciero = '".$_POST['descripcion']."'
		   WHERE idestudianterecursofinanciero = '".$_POST['id']."'";		  
		   $sol=mysql_db_query($database_sala,$base);
		   
		   echo "<script language='javascript'>
				window.opener.recargar('".$direccion."');
				window.opener.focus();
				window.close();
				</script>"; 	 
	 }
 }	
?>

<script language="javascript">
function grabar()
 {
  document.inscripcion.submit();
 }
</script>
<br>
<input type="button" value="Enviar" onClick="grabar()"><input type="button" value="Cerrar" onClick="window.close()">
   <!-- <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->
   <input type="hidden" name="grabado" value="grabado">   
   <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"> 
</form>  	