<?php  
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php');

@@session_start();

?>

<style type="text/css">

<!--



.Estilo1 {font-family: Tahoma; font-size: 12px}



.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}



.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}



.Estilo4 {color: #FF0000}



-->



</style>



<form name="inscripcion" method="post" action="">



<?php







    $direccion = "experiencia.php";







   mysql_select_db($database_sala, $sala);



   $query_actividad = "select *



					from tipoestudiantelaboral



					order by 2";



	$actividad = mysql_query($query_actividad, $sala) or die("$query_actividad");



	$totalRows_actividad = mysql_num_rows($actividad);



	$row_actividad = mysql_fetch_assoc($actividad);







	$query_ciudad1 = "select *



					 from pais



					 order by 3";



	$ciudad1 = mysql_query($query_ciudad1, $sala) or die("$query_ciudad1");



	$totalRows_ciudad1= mysql_num_rows($ciudad1);



	$row_ciudad1 = mysql_fetch_assoc($ciudad1);







	 $query_datosgrabados = "SELECT *



							 FROM estudiantelaboral



							 WHERE idestudiantelaboral = '".$_GET['id']."'";



	 //echo $query_datosgrabados;



	 $datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_estudios".mysql_error());



	 $totalRows_datosgrabados = mysql_num_rows($datosgrabados);



	 $row_datosgrabados = mysql_fetch_assoc($datosgrabados);



?>



	 <table width="70%" border="0" align="center" cellpadding="3" bordercolor="#003333">



	    <tr class="Estilo3">



          <td colspan="7" bgcolor="#CCDADD"><div align="center">EDITAR</div></td>



       </tr>



        <tr >



          <td width="134" bgcolor="#CEDBDE" class="Estilo2"><div align="center">Actividad:</div></td>



          <td width="203" bgcolor='#FEF7ED'>



		  <select name="actividad">



                <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['idtipoestudiantelaboral']))) {echo "SELECTED";} ?>>Seleccionar</option>



                <?php



				do



				{



?>



                <option value="<?php echo $row_actividad['idtipoestudiantelaboral']?>"<?php if (!(strcmp($row_actividad['idtipoestudiantelaboral'], $row_datosgrabados['idtipoestudiantelaboral']))) {echo "SELECTED";} ?>><?php echo $row_actividad['nombretipoestudiantelaboral'];?></option>



                <?php



                }



				while($row_actividad = mysql_fetch_assoc($actividad));



				$rows = mysql_num_rows($actividad);



					if($rows > 0)



					{



						mysql_data_seek($ciudad, 0);



						$row_actividad = mysql_fetch_assoc($actividad);



					}



				?>



            </select>



		  </td>



         <td width="81" bgcolor="#CEDBDE" class="Estilo2"><div align="center">Pais:</div></td>



          <td colspan="3" bgcolor='#FEF7ED'><select name="ciudadexperiencia">



            <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['idciudad']))) {echo "SELECTED";} ?>>Seleccionar</option>



            <?php



				do



				{



?>



            <option value="<?php echo $row_ciudad1['idpais']?>"<?php if (!(strcmp($row_ciudad1['idpais'], $row_datosgrabados['idciudad']))) {echo "SELECTED";} ?>><?php echo $row_ciudad1['nombrepais'];?></option>



            <?php



                }



				while($row_ciudad1 = mysql_fetch_assoc($ciudad1));



				$rows = mysql_num_rows($ciudad1);



					if($rows > 0)



					{



						mysql_data_seek($ciudad1, 0);



						$row_ciudad1 = mysql_fetch_assoc($ciudad1);



					}



				?>



          </select></td>



        </tr>



        <tr bgcolor="#FFFFFF">



         <td width="134" bgcolor="#CEDBDE" class="Estilo2"><div align="center">Instituci&oacute;n o empresa :</div></td>



          <td bgcolor='#FEF7ED'><input name="institucion" type="text" id="institucion" size="35" maxlength="50" value="<?php if (isset($row_datosgrabados['empresaestudiantelaboral'])) echo $row_datosgrabados['empresaestudiantelaboral']; else echo $_POST['institucion'];?>"></td>



         <td width="81" bgcolor="#CEDBDE" class="Estilo2"><div align="center">Cargo:</div></td>



          <td colspan="3" bgcolor='#FEF7ED'><input name="cargo" type="text" id="cargo" size="35" maxlength="50" value="<?php if (isset($row_datosgrabados['cargoestudiantelaboral'])) echo $row_datosgrabados['cargoestudiantelaboral']; else echo $_POST['cargo'];?>"></td>



        </tr>



		<tr bgcolor="#FFFFFF">



         <td width="134" bgcolor="#CEDBDE" class="Estilo2"><div align="center">Descripci&oacute;n:</div></td>



          <td colspan="5" bgcolor='#FEF7ED'><input name="descripcion" type="text" id="descripcion" size="80" maxlength="100" value="<?php  if (isset($row_datosgrabados['descripcionestudiantelaboral'])) echo $row_datosgrabados['descripcionestudiantelaboral']; else echo $_POST['descripcion'];?>"></td>



        </tr>



 </table>



<?php



$banderagrabar = 0;



 if (isset($_POST['grabado']))



 {



	if ($_POST['actividad'] == 0)



	  {



	    echo '<script language="JavaScript">alert("Debe seleccionar Una actividad")</script>';



		$banderagrabar = 1;



	  }



	 else



	  if ($_POST['ciudadexperiencia'] == 0)
	  {

        /*
        * @modified Luis Dario Gualteros 
        * <castroluisd@unbosque.edu.co>
        * SE REALIZO LA VALIDACIÓN DE LOS CAMPOS INSTITUCIÓN, CARGO Y DESCRIPCIÓN PARA QUE ACEPTE CARACTERES ALFANUMERICOS.
        * @since  December 13, 2016
        */ 

	    echo '<script language="JavaScript">alert("Debe seleccionar el Pais")</script>';

		$banderagrabar = 1;
      } else
	       if ((ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ\.]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ\.]+)*))*$",$_POST['institucion']) and $_POST['institucion'] == ""))
	  {

	    echo '<script language="JavaScript">alert("Debe escribir la Institución o Empresa")</script>';
		$banderagrabar = 1;
	  } else

	   if ((ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['cargo']) and $_POST['cargo'] == ""))
	  {
	    echo '<script language="JavaScript">alert("Debe escribir el cargo")</script>';
		$banderagrabar = 1;
	  }	 else

	   if ((ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['descripcion']) and $_POST['descripcion'] == ""))
	  {
	    echo '<script language="JavaScript">alert("Descripción Incorrecta")</script>';
		$banderagrabar = 1;
	  } else
    //END VALIDACIÓN       
	 if ($banderagrabar == 0)
	 {

	   $base="update estudiantelaboral

	   set descripcionestudiantelaboral = '".$_POST['descripcion']."',

	   cargoestudiantelaboral = '".$_POST['cargo']."',

	   empresaestudiantelaboral = '".$_POST['institucion']."',

	   idciudad = '".$_POST['ciudadexperiencia']."',
	   
       idtipoestudiantelaboral = '".$_POST['actividad']."'


	   WHERE idestudiantelaboral = '".$_POST['id']."'";

	   $sol=mysql_db_query($database_sala,$base);

        echo "<script language='javascript'>
        window.location.href='formulariodeinscripcion.php?".$_SESSION['fppal']."#ancla".$_SESSION['modulosesion']."';
        
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

    <br><br>

    <div align="center">

       <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>

       <input type="hidden" name="grabado" value="grabado">

       <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">

    </div>

</form>