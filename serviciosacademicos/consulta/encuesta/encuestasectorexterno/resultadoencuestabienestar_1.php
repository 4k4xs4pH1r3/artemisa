<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuestav2/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ValidaEncuesta.php");
//require_once("seleccionmateria.php");
ini_set('max_execution_time','6000');

unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");
$idencuesta = '46';
//$_GET['idusuario']='74282602';
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
$objvalidaautoevaluacion = new ValidaEncuesta($objetobase, '20111', '1');
$objvalidaautoevaluacion->setIdEncuesta($idencuesta);
$tabla = "respuestainstitucionaldocente";
$objvalidaautoevaluacion->setTablaRespuesta($tabla);

if (!$objvalidaautoevaluacion->encuentraEstudianteEncuestaBienestar($_GET['idusuario'])) {
    echo "<script type='text/javascript'>parent.continuar();</script>";
}
//if($objvalidaautoevaluacion->encuestaCarreraActiva()){
//}
//if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
$objconsultaencuesta = new ConsultaEncuesta($objetobase, $formulario);

$objconsultaencuesta->setTablaRespuesta($tabla);
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);
$_SESSION["codigoestudiante_autoenfermeria"] = $_GET["codigoestudiante"];
$_SESSION["codigomateria_autoenfermeria"] = $_POST["codigomateria"];
$idusuarioencuesta = $_GET['idusuario'];
$objmostrarencuesta = new MostrarEncuesta($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuesta);

/* $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
  $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$_POST["codigomateria"]."'";
  $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",8," and ".$condicion,"",0);
 */


//}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
        <style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
        <link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>


        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>
        <script type="text/javascript" src="funciones.js"></script>
        <script LANGUAGE="JavaScript">

        </script>
    </head>
    <body>
    <center>
<?php
$objmostrarencuesta->setIdEncuesta($idencuesta);
//$condicion = " and t.idestudiantegeneral=eg.idestudiantegeneral ";
//$resultadousuarioencuesta = $objetobase->recuperar_resultado_tabla("tmpestudianteencuestabienestar t,estudiantegeneral eg", "1", "1", $condicion, "", 0);
$i = 0;
$j = 0;
$condicion =" and g.numerodocumento=d.numerodocumento 
                  and g.numerodocumento <>'1'group by d.numerodocumento";

$resultadousuarioencuesta=$objetobase->recuperar_resultado_tabla("docente d, grupo g","g.codigoperiodo",'20111',$condicion,'',0);

while ($rowusuarioencuesta = $resultadousuarioencuesta->fetchRow()) {
   
$usuarioencuesta[] = $rowusuarioencuesta['numerodocumento'];
//$rowusuarioencuesta['idestudiantegeneral']="63903";
$objvalidaautoevaluacion->setUsuario($rowusuarioencuesta['numerodocumento']);
$preguntasfacultades = $objvalidaautoevaluacion->validaPreguntasFaltantes();
    /* echo "<pre>";
      print_r($preguntasfacultades);
      echo "</pre>"; */
    if (!is_array($preguntasfacultades) ||
            (count($preguntasfacultades) < 1)) {
        // alerta_javascript('Ha finalizado la encuesta,\n Gracias por su colaboracion');
       //  echo ($i++).")".$rowusuarioencuesta['idestudiantegeneral']."-".$rowusuarioencuesta['numerodocumento']."<br>";
        //echo "<script type='text/javascript'>parent.continuar();</script>";
        $i++;
         $usuariorespuesta[] = $rowusuarioencuesta['numerodocumento'];
       // exit();
        //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../educacioncontinuada/certificadoymemorias.php?documento=" . $datosasistente['documentoasistente'] . "&iddiploma=" . $datosasistente['iddiploma'] . "'>";
    } else {
        // alerta_javascript('No ha finalizado la encuesta');
         $j++;
        //echo ($j++).")".$rowusuarioencuesta['idestudiantegeneral']."<br>";
        //echo ($j++) . ")" . $rowusuarioencuesta['idestudiantegeneral'] . "-" . $rowusuarioencuesta['numerodocumento'] . "-faltan " . count($preguntasfacultades) . " preguntas<br>";
    }
}
/*echo "usuariorespuesta<pre>";
print_r($usuariorespuesta);
echo "</pre>";*/
//exit();
//$usuariorespuesta[] = "74282602";
$objmostrarencuesta->objconsultaencuesta->setArregloUsuario($usuariorespuesta);
$objmostrarencuesta->iniciarEncuestaUsuario();
$objmostrarencuesta->imprimirResultadosEncuesta($tituloinicial = "", $cadenaparametros, $tablasadicionales);

echo "Docentes y Directivos que resolvieron completamente la encuesta " . $i;
echo "<br>Docentes y Directivos que faltan " . $j;
//$objmostrarencuesta->objconsultaencuesta->setArregloUsuario($usuarioencuesta);
?>
    </center>
</body>
</html>
