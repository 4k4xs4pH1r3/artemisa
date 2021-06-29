<?php
session_start();
if($_SESSION["codigofacultad"]==404 || $_SESSION["codigofacultad"]==751){ ?>
<script type="text/javascript">location.href = 'resultadosMGI.php';</script>
<?php die(); } else {
$rutaado=("../../../funciones/adodb/");
//echo '<pre>';print_r($_REQUEST);
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuesta/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");
require_once("selecciongrupo.php");

unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true',
        'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',
        "",
        false,
        "../../../../",
        0);
$objetobase=new BaseDeDatosGeneral($sala);
$query = "SELECT codigoperiodo from periodo where codigoestadoperiodo in (3,1) ORDER BY codigoestadoperiodo DESC";
$resultado= $objetobase->conexion->query($query);
$rowperiodo=$resultado->fetchRow();
$_SESSION["codigoperiodo_autoenfermeria"]="".$rowperiodo["codigoperiodo"];//$_SESSION['codigoperiodosesion'];

$objvalidaautoevaluacion=new ValidaEncuesta($objetobase,$_SESSION["codigoperiodo_autoenfermeria"],$_GET['codigoestudiante']);
if($objvalidaautoevaluacion->encuestaCarreraActiva()) {
    if($objvalidaautoevaluacion->validaEncuestaCompleta()) {
        alerta_javascript('Ha finalizado la evaluacion docente,\n Gracias por su colaboracion');
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../prematricula/matriculaautomaticaordenmatricula.php'>";
    }
}
if(isset($_POST["iddocente"])&&$_POST["iddocente"]!='') {
    $objconsultaencuesta=new ConsultaEncuesta($objetobase,$formulario);
    if($_POST["codigoperiodo"]<'20131'){
    $tabla="respuestaautoevaluacion_2012anteriores";
    }
    else{
    $tabla="respuestaautoevaluacion";
    }
    $objconsultaencuesta->setTablaRespuesta($tabla);
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);
    // $_SESSION["codigoestudiante_autoenfermeria"]=$_GET["codigoestudiante"];
    $_SESSION["idgrupo_autoenfermeria"]=$_POST["idgrupo"];


    // $idusuarioencuesta=$_GET["codigoestudiante"]."_".$_POST["codigomateria"]."_".$_SESSION["codigoperiodo_autoenfermeria"];
    $idusuarioencuesta="";
    $objmostrarencuesta=new MostrarEncuesta($idusuarioencuesta,$objetobase,$formulario,$objconsultaencuesta);
   // $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
    $condicion.=" em.idencuesta=e.idencuesta ";
    $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","em.codigomateria",$_POST["codigomateria"]," and ".$condicion,"",0);
    $idencuesta=$datosencuestamateria["idencuesta"];
}

?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <script LANGUAGE="JavaScript">
		
            function enviarrespuesta(obj,idpregunta,idusuario,idencuesta){
                var params="idpregunta="+idpregunta+"&idusuario="+idusuario+"&idencuesta="+idencuesta+"&valorrespuesta="+obj.value;
                //process("../../../funciones/sala_genericas/encuesta/actualizarespuestapregunta.php",params);
                process("actualizarencuestaenfermeria.php",params);
                //alert("actualizarespuestapregunta.php?"+params);
                return true;
            }

            function enviar(){
                //alert(pagina);

                var formulario=document.getElementById("formescogemateria");
                formulario.action="resultadosenfermeria.php";
                //formulario.action="encuestaenfermeria.php";
                //alert(formulario.action);
                formulario.submit();
                //return false;
            }
            function enviarmateria(){
                //alert(pagina);

                var formulario=document.getElementById("formescogemateria");
                var grupo=document.getElementById("iddocente");
                formulario.action="resultadosenfermeria.php";
                grupo.value="";
                //formulario.action="encuestaenfermeria.php";
                //alert(formulario.action);
                formulario.submit();
                //return false;
            }
            function enviarexportar(){
                //alert(pagina);

                var formulario=document.getElementById("formescogemateria");
				//funcion normal de exportacion
                formulario.action="resultadosexportar.php";
				//Para la exportación masiva... mejor en IE por el monton de popups
                //formulario.action="empezarExportacion.php";
				//ponderado por periodo
				//formulario.action="ponderadoTotalResultados.php";
                //alert(formulario.action);
                formulario.submit();
                //return false;
            }


            //open("../seguridad.html" , "ventana1" , "width=290,height=200,scrollbars=NO");
            //quitarFrame()
        </script>
    </head>
    <body>
	
        <?php

        selecciongrupo($objetobase,$formulario,$_SESSION["codigoperiodo_autoenfermeria"]);
        if(isset($_POST["iddocente"])&&$_POST["iddocente"]!='') {
            $objmostrarencuesta->setIdEncuesta($idencuesta);
            $objmostrarencuesta->iniciarEncuestaUsuario();
            $objmostrarencuesta->mostrarTitulosEncuesta();

            $filaadicional["codigoestudiante"]=$_SESSION["codigoestudiante_autoenfermeria"];
            $filaadicional["codigomateria"]=$_SESSION["codigomateria_autoenfermeria"];
            $filaadicional["codigoperiodo"]=$_POST["codigoperiodo"];
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se colocan la tildes en su resoectiva palabra y se adicionan tambien los : al final
         * @since Julio 24, 2018
        */            
            $mensajeninicial="Califique de 1 a 5 las siguientes preguntas relacionadas a la evaluaci&oacute;n de su asignatura:";
            echo "  <form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
        <input type=\"hidden\" name=\"AnularOK\" value=\"\">
        <input type=\"hidden\" name=\"idencuesta\" value=\"".$objmostrarencuesta->idencuesta."\">";

            $cadenaparametros="dp.idprematricula=pr.idprematricula and
                pr.codigoestudiante=r.codigoestudiante and
                pr.codigoperiodo=r.codigoperiodo and
                r.codigomateria=dp.codigomateria and
                r.codigoperiodo='".$_POST["codigoperiodo"]."' and
                g.idgrupo=dp.idgrupo and
                g.numerodocumento=d.numerodocumento and
                g.codigoperiodo='".$_POST["codigoperiodo"]."' and
                g.codigomateria='".$_POST["codigomateria"]."' and
                d.iddocente='".$_POST["iddocente"]."' and ";

            $tablasadicionales=",prematricula pr, detalleprematricula dp,grupo g,docente d";

            $objmostrarencuesta->imprimirResultadosEncuesta($mensajeninicial,$cadenaparametros,$tablasadicionales);
            // $objmostrarencuesta->ingresarTotalPreguntas($tabla,$filaadicional);

            $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
            echo "</form>";
            $mensajeexito="Asignatura Evaluada,\n sus respuestas son utiles para el mejoramiento de nuestra Institución .";
            $mensajefalta="No puede continuar hasta que diligencie toda la encuesta";
            $direccionexito="encuestaenfermeria.php?codigoestudiante=".$_GET["codigoestudiante"];
            $direccionfalta="encuestaenfermeria.php?codigoestudiante=".$_GET["codigoestudiante"];

            //$objmostrarencuesta->guardarEncuesta($mensajeexito, $mensajefalta, $direccionexito, $direccionfalta,$tabla,$filaadicional);

        }
        ?>
        <script type="text/javascript">
            var pathruta='../../../funciones/sala_genericas/ajax/tab/';
<?php

$cadena= "var arraypestanas=Array(";
$con=0;
if(is_array($objmostrarencuesta->arraytitulospestanas))
    foreach($objmostrarencuesta->arraytitulospestanas as $i=>$row) {
        //trim(sacarpalabras(str_replace("de","",str_replace("y","",$row["nombre"])),0,1))

        if($con==0)
            $cadena.="'".substr(($con+1).". ".$row["nombre"],0,13)."...'";
        else
            $cadena.=",'".substr(($con+1).". ".$row["nombre"],0,13)."...'";

        $con++;
    }
$cadena.= ");\n";
echo $cadena;

?>
    initTabs('formularioencuesta',arraypestanas,0,760,400);

    function cambiapestana(pestana){
        //alert("pestana="+pestana);
        //initTabs('formulariohorario',arraypestanas,pestana,760,400);
        showTab('formularioencuesta',pestana);
        return false;
    }

        </script>

    </body>
</html>
<?php } ?>