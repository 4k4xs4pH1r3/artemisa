<?php  
    /*
     * Ivan Dario quintero rios
     * Modified 19 de octubre 2018
     * Ajuste de variables de session y limpieza de codigo inicial
     */
    if (!isset($_SESSION)){ 
        session_start(); 
        include_once('../../../utilidades/ValidarSesion.php'); 
        $ValidarSesion = new ValidarSesion();
        $ValidarSesion->Validar($_SESSION);
    }
    require('../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once('../../../Connections/salaado.php'); 
    
    /*
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Se agregan estas validaciones para que no solo dependa de variables de sesion sino tambien de las consultas
     * que se encuentran en el archivo vistaformularioinscripcion.php ubicado en esta misma ruta.
     * @since Octubre 26, 2018
     */ 
    
    if(isset($_SESSION['inscripcionsession'])){
        $id_inscripcion=$_SESSION['inscripcionsession'];
    }else{
        $id_inscripcion=$idinscripcion;
    }
    if(isset($_SESSION['numerodocumentosesion'])){
        $codigo_inscripcion = $_SESSION['numerodocumentosesion'];
    }else{
        $codigo_inscripcion = $codigoinscripcion;
    }
    if(isset($_SESSION['modalidadacademicasesion'])){
        $modalidad_academica = $_SESSION['modalidadacademicasesion'];
    }else{
        $modalidad_academica = $modalidadacademica;
    }
?>
<html>
    <head>
        <title>.:Aspectos Personales:.</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <script language="JavaScript" src="calendario/javascripts.js"></script>
    </head>
    <body>
        <?php
        if(isset($_REQUEST['inicial'])){ 
            ?>
            <a href="../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $codigo_inscripcion."&codigocarrera=".$_SESSION['codigocarrerasesion'];?>" id="aparencialinknaranja">Inicio</a><br><br>
            <?php
        }

?>

<form name="inscripcion" method="post" action="aspectospersonales.php">

<?php

$query_aspectospersonales = "select *

from tipoestudianteaspectospersonales

order by 2";

$aspectospersonales = $db->Execute($query_aspectospersonales);

$totalRows_aspectospersonales = $aspectospersonales->RecordCount();

$row_aspectospersonales = $aspectospersonales->FetchRow();



$query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo

FROM inscripcionformulario ip, inscripcionmodulo im

WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo

AND ip.codigomodalidadacademica = '".$modalidad_academica."'

AND ip.codigoestado LIKE '1%'

order by posicioninscripcionformulario";

$formularios = $db->Execute($query_formularios);

$totalRows_formularios = $formularios->RecordCount();

$row_formularios = $formularios->FetchRow();

unset($modulos);

unset($nombremodulo);

unset($iddescripcion);

$limitemodulo = $totalRows_formularios;

$cuentamodulos = 1; 

 do{

    $modulos[$cuentamodulos] = $row_formularios['linkinscripcionmodulo'];

    $nombremodulo[$cuentamodulos] = $row_formularios['nombreinscripcionmodulo'];

	$iddescripcion[$cuentamodulos] = $row_formularios['idinscripcionmodulo'];

	//echo $nombremodulo[$cuentamodulos],"/<br>";

	$cuentamodulos++;

 }while($row_formularios = $formularios->FetchRow());

$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion

FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci

WHERE numerodocumento = '$codigoinscripcion'

AND eg.idestudiantegeneral = i.idestudiantegeneral

AND eg.idciudadnacimiento = ci.idciudad

AND i.idinscripcion = e.idinscripcion

AND e.codigocarrera = c.codigocarrera

AND m.codigomodalidadacademica = i.codigomodalidadacademica

and i.codigoestado like '1%' 

AND e.idnumeroopcion = '1'

and i.idinscripcion = '".$id_inscripcion."'"; 

$data = $db->Execute($query_data);

$totalRows_data = $data->RecordCount();

$row_data = $data->FetchRow();

if(isset($_POST['inicial']) or isset($_GET['inicial'])) 

{ // vista previa	  

?>

	<p>FORMULARIO DEL ASPIRANTE</p>

<?php

	 if (isset($_GET['inicial']))

	   {

	      $moduloinicial = $_GET['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 

	   }

	  else

	   {

	      $moduloinicial = $_POST['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">';

	   }

?>

 <table width="70%" border="0" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

 <tr>

 <td>	

<?php 

	require("funcionformulario.php");

	cabecera_formulario($nombremodulo, $cuentamodulos, $modulos, $row_data, 1); 

} 



		  $query_datosgrabados = "SELECT * 

		  FROM estudianteaspectospersonales e,tipoestudianteaspectospersonales t

		  WHERE e.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'

    	  and e.idtipoestudianteaspectospersonales = t.idtipoestudianteaspectospersonales

		  and e.codigoestado like '1%'";			  

	  	 //echo $query_data; 

 		 $datosgrabados = $db->Execute($query_datosgrabados);

		$totalRows_datosgrabados = $datosgrabados->RecordCount();

		$row_datosgrabados = $datosgrabados->FetchRow();

		  if ($row_datosgrabados <> "")

		   { ?>

		       <br><table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

                <tr id="trtitulogris">

					<td>Aspecto</td>

					<td>Descripción</td>					

                    <td>Acción</td>					

                </tr>

		       <?php 			    

				 do{ ?>

			        <tr>

                     <td><?php echo $row_datosgrabados['nombretipoestudianteaspectospersonales'];?></td>

					 <td><?php echo $row_datosgrabados['descripcionestudianteaspectospersonales'];?></td>                     

					 <td>
                         <?php
                         /**
                          * @modifed RubioLeonardo@unbosque.edu.co
                          * @since 28/10/2019
                          * adicion de validacion variable codigoestudiante para identificar acceso como aspirante o como administrativo
                          * si la variable codigoestudiante tiene valor entonces hay acceso es desde el formulario inscripcion, sino es un acceso desde las opciones del estudiante.
                          */

                         if (!isset($_GET["codigoestudiante"])){?>
                         <a onClick="window.open('editaraspectospersonales.php?id=<?php echo $row_datosgrabados['idestudianteaspectospersonales'];?>','mensajes','width=800,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a>

					 <a onClick="window.open('eliminar.php?aspectospersonales&id=<?php echo $row_datosgrabados['idestudianteaspectospersonales'];?>','mensajes','width=730,height=300,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a>
<?php }?>
					 </td>

		         </tr>			   

			    <?php  

				  }while($row_datosgrabados = $datosgrabados->FetchRow());

			   ?>

	    </table> 

<?php

		   }

		   	else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])) 

		   {

		   ?>

<!-- <tr>

<td>Sin datos diligenciados</td>

</tr> -->

<?php

		   }	     	

if(isset($_POST['inicial']) or isset($_GET['inicial'])) 

  { // vista previa	  	  

	 if (isset($_GET['inicial']))

	   {

	      $moduloinicial = $_GET['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_GET['inicial'].'">'; 

	   }

	  else

	   {

	      $moduloinicial = $_POST['inicial'];

	      echo '<input type="hidden" name="inicial" value="'.$_POST['inicial'].'">'; 

	   }	

?>

<br>

<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">

			<tr>

          <td colspan="2" id="tdtitulogris"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>

        </tr>

		 <tr id="trtitulogris">

          <td >Tipo Aspecto*</td>

          <td >Descripci&oacute;n*</td>

	    </tr>

		<tr>

          <td width="51%">

            <select name="aspecto">

              <option value="0" <?php if (!(strcmp("0", $_POST['aspecto']))) {echo "SELECTED";} ?>>Seleccionar</option>

              <?php

				do 

				{  

?>

              <option value="<?php echo $row_aspectospersonales['idtipoestudianteaspectospersonales']?>"<?php if (!(strcmp($row_aspectospersonales['idtipoestudianteaspectospersonales'], $_POST['aspecto']))) {echo "SELECTED";} ?>><?php echo $row_aspectospersonales['nombretipoestudianteaspectospersonales']?></option>

              <?php

                } 

				while($row_aspectospersonales = $aspectospersonales->FetchRow());

				$rows = mysql_num_rows($aspectospersonales);

				?>

            </select>

</td>

          <td width="49%" >

            <input type="text" name="descripcion" size="30" value="<?php echo $_POST['descripcion'];?>">

          </td>

	</tr>        

</table>

</td> 

</tr>   

</table>     	

<script language="javascript">

function grabar()

 {

  document.inscripcion.submit();

 }

</script>

<br><br>



  <!--  <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->

    <!-- <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">

   <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  

   --> 

    <input type="button" value="Enviar" onClick="grabar()">

	<input type="button" value="Vista Previa" onClick="vista()">

	<input type="hidden" name="grabado" value="grabado">   

<br><br>

<?php

      $banderagrabar = 0;   

	  if($moduloinicial > 1)

		{

			$atras = $moduloinicial - 1;

			//echo '<a href="'.$modulos[$atras].'?inicial='.$atras.'"><img src="../../../../imagenes/izquierda.gif" width="20" height="20" alt="Atras"></a>';

		    //echo '<input type="image" src="../../../../imagenes/izquierda.gif" name="atras" value="atras" width="25" height="25" alt="Atras">';

		}

		echo "";		

		if($moduloinicial < $limitemodulo)

		{

			$adelante = $moduloinicial + 1;

			//echo '<a href="'.$modulos[$adelante].'?inicial='.$adelante.'"><img src="../../../../imagenes/derecha.gif" width="20" height="20" alt="Adelante"></a>';

		    //echo '<input type="image" src="../../../../imagenes/derecha.gif" name="adelante" value="adelante" width="25" height="25" alt="Adelante">';

		}

		$banderagrabar_continiar = 0;

		$paginaactual = 1;

		foreach ($_POST as $key => $value)

        {         

		 if (ereg("adelante",$key) or ereg("atras",$key))

          {	  

	        if ($_POST['aspecto'] <> 0 or $_POST['descripcion'] <> "")

	         {	          

		      $banderagrabar_continiar = 1;	        

			 }			 

		  }

		 else

		  if (ereg("Guardar", $key) || ereg("grabado",$key))

		  {

			$banderagrabar_continiar = 1;	 

			$paginaactual = 0;

		  }

        }		

if ($banderagrabar_continiar == 1)

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

       $query_recurso = "INSERT INTO estudianteaspectospersonales(idestudianteaspectospersonales,idestudiantegeneral,idinscripcion,descripcionestudianteaspectospersonales,idtipoestudianteaspectospersonales,codigoestado) 

   	   VALUES(0, '".$row_data['idestudiantegeneral']."','".$row_data['idinscripcion']."', '".$_POST['descripcion']."', '".$_POST['aspecto']."','100')"; 

		//echo "$query_recurso <br>";

		//exit();

		$recurso = $db->Execute($query_recurso);

   	    if ($paginaactual == 0)

		{	   

	     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=aspectospersonales.php?inicial=$moduloinicial'>"; 

	    }

		else

        if (ereg("adelante",$key) or ereg("atras",$key))

        {

          foreach ($_POST as $key => $value)

          {

           if (ereg("adelante",$key))

            {	       

		     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";

		     exit(); 			

	        }

	       else

	       if (ereg("atras",$key))

	        {		    

		     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";

		     exit();			

	        } 

          }

        }

	 }

 }	

else

 if (ereg("adelante",$key) or ereg("atras",$key))

 {

  foreach ($_POST as $key => $value)

    {

     if (ereg("adelante",$key))

       {	       

		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$adelante]."?inicial=".$adelante."'>";

		 exit(); 			

	   }

	 else

	  if (ereg("atras",$key))

	  {		    

		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$modulos[$atras]."?inicial=".$atras."'>";

		  exit();			

	  } 

     }

 }

} // vista previa	  

?>



<script language="javascript">

function recargar(dir)

{

	window.location.reload("aspectospersonales.php"+dir);

	history.go();

}

function vista()

{	

   window.location.reload("vistaformularioinscripcion.php");	

}

</script> 

</form>