<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar = 0;
$codigocarrera=$_SESSION['codigofacultad'];


        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
        where codigocarrera='$codigocarrera'
        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
        order by nombrecarrera";
        $carrera= $db->Execute($query_carrera);
        $totalRows_carrera = $carrera->RecordCount();
        $row_carrera= $carrera->FetchRow();

      // print_r($_POST);

        $query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo order by 1 desc";
        $periodo = $db->Execute($query_periodo);
        $totalRows_periodo = $periodo->RecordCount();

        


?>
<html>
    <head>

        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
         <SCRIPT language="JavaScript" type="text/javascript">

function prueba()
{
    document.form1.submit();
}
         </SCRIPT>

    </head>
 <body>
     <form action=""  name="form1" method="POST">
             <table  border="0" cellpadding="3" cellspacing="3">
                 <TR>
                     <TD id="tdtitulogris" align="center" colspan="4">
                         <label id="labelresaltadogrande" >PORCENTAJE DE PÉRDIDA POR SEMESTRE <?php echo $row_carrera['nombrecarrera']; ?></label>
                     </TD>
                 </TR>                 
                  <tr>
                      <td  id="tdtitulogris" >Seleccione el Periodo
                      </td>
                      <td>
                          <select name="periodo" id="periodo">
                              <option value="">
                                  Seleccionar
                              </option>
                              <?php while ($row_periodo = $periodo->FetchRow()) { ?>
                              <option value="<?php echo $row_periodo['codigoperiodo']; ?>"
                                  <?php
                                  if ($row_periodo['codigoperiodo'] == $_REQUEST['periodo']) {
                                  echo "Selected";
                                  } ?>>
                              <?php echo $row_periodo['nombreperiodo']; ?>
                              </option><?php } ?>
                          </select>
                      </td>
                  </tr>
                  <TR>
                      <TD  id="tdtitulogris" colspan="2"><input type="submit" name="generar" value="Generar Listado"></TD>
                  </TR>                  
              </table>
         <?php
         if(isset($_REQUEST['generar'])){
             if(isset($_POST['periodo']) && $_POST['periodo']==''){
                 echo '<script language="JavaScript">alert("Debe Seleccionar el periodo.")</script>';
                 $varguardar = 1;
             }
             elseif($varguardar == 0) {

                 echo "<script language='javascript'>
                 window.location.href='listadosemestre.php?codigocarrera=".$codigocarrera."&codigoperiodo=".$_POST['periodo']."&mpcarrera=1';
                </script>";
                
            // require('carreras.php');

             }
         }
         ?>
   </form>
  </body>
</html>
