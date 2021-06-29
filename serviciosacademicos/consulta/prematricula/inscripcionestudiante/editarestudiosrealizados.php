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

<title>.:Inscripciones:.</title>

<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

</head>

<body>

<form name="inscripcion" method="post" action="">

<?php

	$direccion = "estudiosrealizados.php";

	//mysql_select_db($database_sala, $sala);

	$query_niveleducacion = "select *

							 from niveleducacion

							 order by 2";

	$niveleducacion = $db->Execute($query_niveleducacion);

	$totalRows_niveleducacion = $niveleducacion->RecordCount();

	$row_niveleducacion = $niveleducacion->FetchRow();



	$query_institucioneducativa = "select distinct nombreinstitucioneducativa

								   from institucioneducativa

								   where idinstitucioneducativa <> '1'

					 			   order by 1";

	$institucioneducativa = $db->Execute($query_institucioneducativa);

	$totalRows_institucioneducativa = $institucioneducativa->RecordCount();

	$row_institucioneducativa = $institucioneducativa->FetchRow();

	

	$query_titulo = "select *

					 from titulo

					 where codigotitulo <> '1'

					 order by 2";

	$titulo = $db->Execute($query_titulo);

	$totalRows_titulo = $titulo->RecordCount();

	$row_titulo = $titulo->FetchRow();

	

	$query_datosgrabados = "SELECT * 

							FROM estudianteestudio e,institucioneducativa i

							WHERE e.idestudianteestudio =  '".$_GET['id']."'

							and e.idinstitucioneducativa = i.idinstitucioneducativa

							";			  

			//echo $query_data; 

	$datosgrabados = $db->Execute($query_datosgrabados);

	$totalRows_datosgrabados = $datosgrabados->RecordCount();

	$row_datosgrabados = $datosgrabados->FetchRow();

?>

<p>EDITAR</p>

 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

          <tr>

            <td colspan="4" id="tdtitulogris">Nivel:</td>

            <td colspan="2"><select name="niveleducacion">

                <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['idniveleducacion']))) {echo "SELECTED";} ?>>Seleccionar</option>

                <?php

				do 

				{  

?>

                <option value="<?php echo $row_niveleducacion['idniveleducacion']?>"<?php if (!(strcmp($row_niveleducacion['idniveleducacion'],$row_datosgrabados['idniveleducacion']))) {echo "SELECTED";} ?>><?php echo $row_niveleducacion['nombreniveleducacion']?></option>

                <?php

                } 

				while($row_niveleducacion = $niveleducacion->FetchRow());

				?>

              </select>

            </td>

		</tr>

		<tr>

            <td colspan="4" id="tdtitulogris">Titulo:</td>

            <td colspan="2">

			<select name="tituloobtenido">

              <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['codigotitulo']))) {echo "SELECTED";} ?>>Seleccionar</option>

              <?php

				do 

				{  

?>

              <option value="<?php echo $row_titulo['codigotitulo']?>"<?php if (!(strcmp($row_titulo['codigotitulo'], $row_datosgrabados['codigotitulo']))) {echo "SELECTED";} ?>><?php echo $row_titulo['nombretitulo'];?></option>

              <?php				  

                } 

				while($row_titulo = $titulo->FetchRow());

				?>

            </select>

			<br><label id="labelresaltado">Si el titulo no aparece en el listado digitelo en el siguiente campo de texto</label>

		   <input type="text" name="otrotituloestudianteestudio" style="width:100%" value="<?php if(isset($_REQUEST['otrotituloestudianteestudio'])) { echo $_REQUEST['otrotituloestudianteestudio']; } else { echo $row_datosgrabados['otrotituloestudianteestudio']; }?>">

		  </td>

          </tr>

		   <tr>

		   <?php

		   if($row_datosgrabados['idinstitucioneducativa'] == 1)

		   {

		   		$row_datosgrabados['nombrecortoinstitucioneducativa'] = "";

		   }

		   ?>

            <td colspan="6"><label id="labelresaltado">Si conoce el Código asignado por el icfes de la institución Educativa Digitelo  <input name="codigocolegio" type="text"  size="10" maxlength="15" value="<?php echo  $row_datosgrabados['nombrecortoinstitucioneducativa'];?>"><br> 

              De lo contrario Seleccione la Instituci&oacute;n a continuación:</label></td>

          </tr>

          <tr>

            <td colspan="3" id="tdtitulogris">Instituci&oacute;n:</td>

            <td colspan="3"><select name="institucioneducativa">

                <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['idinstitucioneducativa']))) {echo "SELECTED";} ?>>Seleccionar</option>

                <?php

				do 

				{  

?>

                <option value="<?php echo $row_institucioneducativa['nombreinstitucioneducativa']?>"<?php if (!(strcmp($row_institucioneducativa['nombreinstitucioneducativa'], $row_datosgrabados['nombreinstitucioneducativa']))) {echo "SELECTED";} ?>><?php echo $row_institucioneducativa['nombreinstitucioneducativa'];?></option>

                <?php

                } 

				while($row_institucioneducativa = $institucioneducativa->FetchRow());

				?>

              </select>

			     <br><br><label id="labelresaltado">Si la institución no aparece en el listado digitelo en el siguiente campo de texto</label>

		   <input type="text" name="otrainstitucioneducativaestudianteestudio" style="width:100% " value="<?php if(isset($_REQUEST['otrainstitucioneducativaestudianteestudio'])){ echo $_REQUEST['otrainstitucioneducativaestudianteestudio']; } else { echo $row_datosgrabados['otrainstitucioneducativaestudianteestudio']; }?>">

            </td>

          </tr>

		  <!--  <tr>

            <td id="tdtitulogris">Ciudad<label id="labelresaltado">*</label></td>

            <td><span class="style2"><input name="ciudad" type="text" id="ciudad" size="25" maxlength="50" value="<?php echo $_POST['ciudad'];?>"></label></td>            

			<td id="tdtitulogris">A&ntilde;o<label id="labelresaltado">*</label></td>

             <td><span class="style2"><input name="ano" type="text" id="ano" size="2" maxlength="4" value="<?php echo $_POST['ano'];?>"></label></td>

            <td id="tdtitulogris">Observaciones</td>

            <td><input name="observaciones" type="text" id="observaciones" size="35" maxlength="50" value="<?php echo $_POST['observaciones'];?>"> Salón Eje: (A301)</td>

          </tr> -->

		  

		  

         <tr>            

			<td id="tdtitulogris">Ciudad : </td>

            <td ><input name="ciudad" type="text" id="ciudad" size="25" maxlength="50" value="<?php if (isset($row_datosgrabados['ciudadinstitucioneducativa'])) echo $row_datosgrabados['ciudadinstitucioneducativa']; else echo $_POST['ciudad'];?>"></td>

            <td id="tdtitulogris">A&ntilde;o:</td>

            <td><input name="ano" type="text" id="ano" size="2" maxlength="4" value="<?php if (isset($row_datosgrabados['anogradoestudianteestudio'])) echo $row_datosgrabados['anogradoestudianteestudio']; else echo $_POST['ano'];?>">

            </td>

            <td id="tdtitulogris">Observaciones:</td>

            <td><input name="observaciones" type="text" id="observaciones" size="35" maxlength="50" value="<?php if (isset($row_datosgrabados['observacionestudianteestudio'])) echo $row_datosgrabados['observacionestudianteestudio']; else echo $_POST['observaciones'];?>"></td>

          </tr> 

  </table>

<?php

$banderagrabar = 0;

if (isset($_POST['grabado']))

 {	 

	   if ($_POST['codigocolegio'] <> "")

	  {	// if 1 

		 $query_codigoinstitucion = "select *

         from institucioneducativa

         where nombrecortoinstitucioneducativa = '".$_POST['codigocolegio']."'

		 and codigomodalidadacademica = '".$row_datosgrabados['codigomodalidadacademica']."'

		 order by 1";

		//echo $query_codigoinstitucion;

		$codigoinstitucion = $db->Execute($query_codigoinstitucion);

		$totalRows_codigoinstitucion = $codigoinstitucion->RecordCount();

		$row_codigoinstitucion = $codigoinstitucion->FetchRow();

		

		if ($row_codigoinstitucion <> "")

		 {

		    $_POST['institucioneducativa'] = $row_codigoinstitucion['idinstitucioneducativa'];		 

		 }

		else

		 {

		    echo '<script language="JavaScript">alert("El Código de la institución digitado no existe");</script>';	

		    $banderagrabar = 1;

		 }		

	  } // if 1

	 else

	  {

		$query_institucioneducativa1 = "select *

        from institucioneducativa

		where nombreinstitucioneducativa = '".$_POST['institucioneducativa']."'

	    order by 1";

		//echo $query_institucioneducativa1;

		$institucioneducativa1 = $db->Execute($query_institucioneducativa1);

		$totalRows_institucioneducativa1 = $institucioneducativa1->RecordCount();

		$row_institucioneducativa1 = $institucioneducativa1->FetchRow();

		

		 if ($row_institucioneducativa1 <> "")

		  {

		    $_POST['institucioneducativa'] = $row_institucioneducativa1['idinstitucioneducativa'];

		  }

	  }

	 if ($_POST['niveleducacion'] == 0)

	  {

	    echo '<script language="JavaScript">alert("Debe seleccionar el Nivel de educación")</script>';	

		$banderagrabar = 1;

	  }

	 else

	  if ($_POST['tituloobtenido'] == 0 && $_REQUEST['otrotituloestudianteestudio'] == "")

	  {

	    echo '<script language="JavaScript">alert("Debe seleccionar un titulo o digitarlo")</script>';		

		$banderagrabar = 1;

	  }

	 else

	  if (!eregi("^[0-9]{1,15}$", $_POST['ano']) or $_POST['ano'] > date("Y"))

	  {

	    echo '<script language="JavaScript">alert("Año Incorrecto")</script>';		

		$banderagrabar = 1;

	  }      

	else

	 if ($banderagrabar == 0)

	 {	

		   if($_POST['tituloobtenido'] == 0)

			{

				$_POST['tituloobtenido'] = 1;

			}

			if($_POST['institucioneducativa'] == "" || $_POST['institucioneducativa'] == 0)

			{

				$_POST['institucioneducativa'] = 1;

			}

			

		   $base="update estudianteestudio 

		   set idniveleducacion = '".$_POST['niveleducacion']."',

		   anogradoestudianteestudio = '".$_POST['ano']."',

		   idinstitucioneducativa = '".$_POST['institucioneducativa']."',

		   otrainstitucioneducativaestudianteestudio = '".$_POST['otrainstitucioneducativaestudianteestudio']."',

		   codigotitulo = '".$_POST['tituloobtenido']."',

		   otrotituloestudianteestudio = '".$_POST['otrotituloestudianteestudio']."',

		   ciudadinstitucioneducativa = '".$_POST['ciudad']."',

		   observacionestudianteestudio = '".$_POST['observaciones']."'

		   WHERE idestudianteestudio = '".$_POST['id']."'";

		   $sol = $db->Execute($base);	 

		   //echo $base;

		   // exit();

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

</body>

</html>