<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
 require('../../../Connections/sala2.php'); 

$rutaado = "../../../funciones/adodb/";

require_once('../../../Connections/salaado.php'); 



@@session_start();



$direccion = "aspectospersonales.php";  



$query_aspectospersonales = "select *

from tipoestudianteaspectospersonales

order by 2";

$aspectospersonales = $db->Execute($query_aspectospersonales);

$totalRows_aspectospersonales = $aspectospersonales->RecordCount();

$row_aspectospersonales = $aspectospersonales->FetchRow();

	

$query_datosgrabados = "SELECT * 

			                FROM estudianteaspectospersonales e,tipoestudianteaspectospersonales t

							WHERE e.idestudianteaspectospersonales = '".$_GET['id']."'

							and e.idtipoestudianteaspectospersonales = t.idtipoestudianteaspectospersonales

							";			  

$datosgrabados = $db->Execute($query_datosgrabados);

$totalRows_datosgrabados = $datosgrabados->RecordCount();

$row_datosgrabados = $datosgrabados->FetchRow(); 

?>

<html>

<head>

<title>.:Apectos Personales:.</title>

<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

<script language="JavaScript" src="calendario/javascripts.js"></script>

</head>

<body>

<form name="inscripcion" method="post" action="">

<p>EDITAR</p>

<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

		 <tr id="trtitulogris">

          <td>Tipo Aspecto</td>

          <td>Descripci&oacute;n</td>

    </tr>

		<tr>

          <td width="51%">

            <select name="aspecto">

              <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['idtipoestudianteaspectospersonales']))) {echo "SELECTED";} ?>>Seleccionar</option>

              <?php

				do 

				{  

?>

              <option value="<?php echo $row_aspectospersonales['idtipoestudianteaspectospersonales']?>"<?php if (!(strcmp($row_aspectospersonales['idtipoestudianteaspectospersonales'], $row_datosgrabados['idtipoestudianteaspectospersonales']))) {echo "SELECTED";} ?>><?php echo $row_aspectospersonales['nombretipoestudianteaspectospersonales']?></option>

              <?php

                } 

				while($row_aspectospersonales = $aspectospersonales->FetchRow());

				?>

            </select>

</td>

          <td width="49%" >

            <input type="text" name="descripcion" size="50" value="<?php if (isset( $row_datosgrabados['descripcionestudianteaspectospersonales'])) echo  $row_datosgrabados['descripcionestudianteaspectospersonales']; else echo $_POST['descripcion'];?>">

          </td>

	</tr>        

</table>

<?php

$banderagrabar = 0;

if (isset($_POST['grabado']))

 {	

	 if ($_POST['aspecto'] == 0)

	  {

	    echo '<script language="JavaScript">alert("Debe seleccionar el tipo de aspecto")</script>';	

		$banderagrabar = 1;

	  }

	 else

	  if ($_POST['descripcion'] == "")

	  {

	    echo '<script language="JavaScript">alert("Describa el tipo de Aspecto")</script>';		    		  

		$banderagrabar = 1;

	  }

	else

	 if ($banderagrabar == 0)

	 {   

	   $base="update estudianteaspectospersonales 

	   set idtipoestudianteaspectospersonales = '".$_POST['aspecto']."',

	   descripcionestudianteaspectospersonales = '".$_POST['descripcion']."'

	   WHERE idestudianteaspectospersonales = '".$_POST['id']."'";

	   $sol = $db->Execute($base);	 



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

<!--    <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->

   <input type="hidden" name="grabado" value="grabado">   

   <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"> 

 

</form>