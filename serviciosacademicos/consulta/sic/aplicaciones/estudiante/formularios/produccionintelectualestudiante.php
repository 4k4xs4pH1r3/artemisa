<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

$rutaado=("../../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/tabla.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/dibujaformulario.php");

$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../../../funciones/sala_genericas/";


$objetobase=new BaseDeDatosGeneral($sala);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>

<link rel="stylesheet" type="text/css" href="../../../../../estilos/sala.css">
	<link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip.css" media="screen" type="text/css">
	<link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip-demo.css" media="screen" type="text/css">

<script type="text/javascript" src="../../../../../funciones/sala_genericas/funciones_javascript.js"></script>
	<style type="text/css">

	#ajax_tooltipObj .ajax_tooltip_arrow{	/* Left div for the small arrow */
		background-image:url('../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/images/arrow.gif');
		width:20px;
		position:absolute;
		left:0px;
		top:0px;
		background-repeat:no-repeat;
		background-position:left;
		z-index:1000005;
		height:60px;
	}
	</style>

	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-dynamic-content.js"></script>
	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax.js"></script>
	<script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-tooltip.js"></script>

<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../../funciones/clases/formulario/globo.js"></script>
<title>Servicios Academicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script LANGUAGE="JavaScript">
function enviartipoproduccion()
{
var formulario=document.getElementById("form1");
formulario.action="produccionintelectualestudiante.php?Nuevo_Registro=1&idformulario=<?php echo $_GET["idformulario"]; ?>";
formulario.submit();

}
</script>
</head>
<body>
<?php
/*echo "_POST<pre>";
print_r($_POST);
echo "</pre>";*/
echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";


	$usuario=$formulario->datos_usuario();

$condicion=" and codigoestado like '1%'";
	$datosformulario=$objetobase->recuperar_datos_tabla("formulario f","idformulario",$_GET["idformulario"],$condicion,"",0);

$formulario->dibujar_fila_titulo(strtoupper($datosformulario["nombreformulario"]),'labelresaltado',"2","align='center'");

$formulario->dibujar_fila_titulo($datosformulario["descripcionformulario"],'tdtituloencuestadescripcion',"2","align='left'","td");
	echo "<tr><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

	$condicion=" and d.codigoestado like '1%'
			and d.codigotipoproduccionintelectual=t.codigotipoproduccionintelectual
			order by fechapublicacionproduccionintelectualestudiante desc";

	$resultado=$objetobase->recuperar_resultado_tabla("produccionintelectualestudiante d,tipoproduccionintelectual t","d.idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],$condicion,"",0);
		$fila["Codigo"]="";
		$fila["Titulo del producto"]="";
		$fila["Tipo de producci&oacute;n"]="";
		$fila["Identificador producto"]="";
		$fila["Fecha de publicación"]="";




		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

	while($row=$resultado->fetchRow()){
		unset($fila);
		$enlacedetalle="<a href='produccionintelectualestudiante.php?idproduccionintelectualestudiante=".$row["idproduccionintelectualestudiante"]."&idformulario=".$_GET["idformulario"]."'>".$row["idproduccionintelectualestudiante"]."</a>";
		$fila[]=$enlacedetalle;
		$fila[]=$row["nombreproduccionintelectualestudiante"];
		$fila[]=$row["nombretipoproduccionintelectual"];
		$fila[]=$row["numeroproduccionintelectualestudiante"];
		$fila[]=$row["fechapublicacionproduccionintelectualestudiante"];

		$formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
		$tieneformacion=1;
	}

	echo "<tr><td align='center' colspan='20'><input type='submit' name='Nuevo_Registro' id='Nuevo_Registro' value='Nuevo Registro'/> </td></tr>";
	if($tieneformacion)
	{
		$mensaje="No registra mas informacion de Producción Intelectual";
	}
	else
	{
		$mensaje="No ha tenido Producción Intelectual";
	}
	echo "<tr><td align='center' colspan='20'><input type='submit' name='No_Aplica' id='No_Aplica' value='".$mensaje."'/> </td></tr>";




	echo "</table></td><tr>";


$muestraformulario=0;
if($_REQUEST["Enviar"]){
$muestraformulario=1;
}


if($_REQUEST["Nuevo_Registro"]){
$muestraformulario=1;
//echo "<h1>ENTRO A ANULAR  idestimulodocente ID=".$muestraformulario."</h1>";

	if(isset($_GET["idproduccionintelectualestudiante"])&&trim($_GET["idproduccionintelectualestudiante"])!=''){
		unset($_POST);
		unset($_GET["idproduccionintelectualestudiante"]);
	}

$_REQUEST["Anulado"]=0;
$_REQUEST["Nuevo_Registro"]=1;
}

if(isset($_GET["idproduccionintelectualestudiante"])&&trim($_GET["idproduccionintelectualestudiante"])!=''){
$muestraformulario=1;
//echo "<h1>ENTRO A VERIFICAR ID=".$muestraformulario."</h1>";
}
if($datosdedicacionexterna=$objetobase->recuperar_datos_tabla("produccionintelectualestudiante","idproduccionintelectualestudiante",$_GET["idproduccionintelectualestudiante"],"","",0)){
 if($datosdedicacionexterna["codigoestado"]=="200"){
	$muestraformulario=0;
		//echo "<h1>ENTRO 1 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
	}

}
if($_REQUEST["Anulado"]){
$muestraformulario=0;
//echo "<h1>ENTRO 2 A CAMBIAR MUESTRA=".$muestraformulario."</h1>";
}


$objdibujaformulario=new DibujaFormulario("produccionintelectualestudiante",$_GET["idproduccionintelectualestudiante"],$sala,$_GET["idformulario"],$formulario);

if($muestraformulario){

	$arrayquitacolumnas[0]="idestudiantegeneral";
	$arrayquitacolumnas[1]="codigoestado";
	$arrayquitacolumnas[2]="codigotipoproduccionintelectual";






	if(is_array($_POST)&&count($_POST)>0){
		$codigotipoproduccionintelectual=$_POST["codigotipoproduccionintelectual"];
	}
	else{
		$codigotipoproduccionintelectual=$objdibujaformulario->recuperarValorCampo("codigotipoproduccionintelectual");
	}

    //echo "<pre>"; print_r($objdibujaformulario->columnasnombres); echo "</pre>";
    switch($codigotipoproduccionintelectual){
        case "100":
            $mensaje="No hacer nada";
            $objdibujaformulario->columnasnombres[2]="Nombre de la Revista";
            $objdibujaformulario->columnasnombres[3]="Titulo del Artículo";
            $objdibujaformulario->columnasnombres[5]="Revista Indexada";
            $objdibujaformulario->columnasnombres[6]="ISSN";
        break;
        case "101":
            $mensaje="No hacer nada";
            $objdibujaformulario->columnasnombres[2]="Nombre de la Revista";
            $objdibujaformulario->columnasnombres[3]="Titulo del Artículo";
            $objdibujaformulario->columnasnombres[5]="Revista Indexada";
            $objdibujaformulario->columnasnombres[6]="ISSN";
        break;
        case "200":
            $objdibujaformulario->columnasnombres[2]="Nombre del Libro";
            $objdibujaformulario->columnasnombres[6]="ISBN";
            $arrayquitacolumnas[3]="tituloproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","tituloproduccionintelectualestudiante"," ","");
            $arrayquitacolumnas[4]="esindexadaproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
        break;
        case "201":
            $objdibujaformulario->columnasnombres[2]="Nombre del Libro";
            $objdibujaformulario->columnasnombres[3]="Nombre del Capítulo";
            $objdibujaformulario->columnasnombres[6]="ISBN";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
        break;
        case "300":
            $objdibujaformulario->columnasnombres[2]="Nombre de la Ponencia";
            $objdibujaformulario->columnasnombres[3]="Medio de Publicación";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
            $arrayquitacolumnas[4]="numeroproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
            $formulario->boton_tipo("hidden","numeroproduccionintelectualestudiante"," ","");
        break;
        case "400":
            $objdibujaformulario->columnasnombres[2]="Nombre del Producto Artístico";
            $objdibujaformulario->columnasnombres[6].=" Artístico";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
        break;
        case "401":
            $objdibujaformulario->columnasnombres[2]="Nombre del Producto Artístico Musical";
            $objdibujaformulario->columnasnombres[6].=" Artístico Musical";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
        break;
        case "402":
            $objdibujaformulario->columnasnombres[2]="Nombre de la Rese&ntilde;a";
            $objdibujaformulario->columnasnombres[6]="Número de Identificación de la Rese&ntilde;a";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
        break;
        case "500":
            $objdibujaformulario->columnasnombres[2]="Nombre del Proyecto";
            $objdibujaformulario->columnasnombres[6]="Número de Identificación del Proyecto";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
        break;
        case "600":
            $objdibujaformulario->columnasnombres[2]="Nombre del Material";
            $objdibujaformulario->columnasnombres[6]="Número de Identificación de la Revisión";
            $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
            $arrayquitacolumnas[4]="numeroproduccionintelectualestudiante";
            $arrayquitacolumnas[5]="tituloproduccionintelectualestudiante";
            $arrayquitacolumnas[6]="fechapublicacionproduccionintelectualestudiante";
          
            $formulario->boton_tipo("hidden","fechapublicacionproduccionintelectualestudiante","0000-00-00",""); 
            $formulario->boton_tipo("hidden","numeroproduccionintelectualestudiante","","");
            $formulario->boton_tipo("hidden","tituloproduccionintelectualestudiante","","");
            $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");
        break;
        default:
        $arrayquitacolumnas[3]="esindexadaproduccionintelectualestudiante";
        $formulario->boton_tipo("hidden","esindexadaproduccionintelectualestudiante","0","");

        break;
	}
	//echo "<pre>sdasdasdasdasdasd"; print_r($objdibujaformulario); echo "</pre>";

	$objdibujaformulario->quitarcolumnas($arrayquitacolumnas);
	$formulario->boton_tipo("hidden","idestudiantegeneral",$_SESSION['sissic_idestudiantegeneral'],"");
	$formulario->boton_tipo("hidden","codigoestado","100","");



	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoproduccionintelectual t","codigotipoproduccionintelectual","nombretipoproduccionintelectual"," codigoestado like '1%'",'',0);

	$formulario->filatmp[""]="Seleccionar";
	$campo='menu_fila'; $parametros="'codigotipoproduccionintelectual','".$codigotipoproduccionintelectual."','onchange=enviartipoproduccion();'";
	$formulario->dibujar_campo($campo,$parametros,"Tipo de Produccion","tdtitulogris",'codigotipoproduccionintelectual','requerido');

	if(isset($codigotipoproduccionintelectual)&&trim($codigotipoproduccionintelectual)!=''){
        //echo "<pre>"; print_r($objdibujaformulario); echo "</pre>";
        //$objdibujaformulario->arraycolumnasnombres['produccionintelectualestudiante']['nombreproduccionintelectualestudiante']="Nombre de la Revista";

        $objdibujaformulario->muestraFormulario();
        $objdibujaformulario->columnas[]="idestudiantegeneral";
        $objdibujaformulario->columnas[]="codigoestado";
        $objdibujaformulario->columnas[]="codigotipoproduccionintelectual";
        switch($codigotipoproduccionintelectual){
            case "200":
            $objdibujaformulario->columnas[]="tituloproduccionintelectualestudiante";
            break;
            case "201":
            $objdibujaformulario->columnas[]="esindexadaproduccionintelectualestudiante";
            break;
            case "300":
            $objdibujaformulario->columnas[]="esindexadaproduccionintelectualestudiante";
            $objdibujaformulario->columnas[]="numeroproduccionintelectualestudiante";
            break;
            case "600":
            $objdibujaformulario->columnas[]="numeroproduccionintelectualestudiante";
            $objdibujaformulario->columnas[]="tituloproduccionintelectualestudiante";
            $objdibujaformulario->columnas[]="fechapublicacionproduccionintelectualestudiante";            break;
            default:
            $objdibujaformulario->columnas[]="esindexadaproduccionintelectualestudiante";
            break;
        }
        $objdibujaformulario->botonesEnvio();
	}
}

	if(isset($_REQUEST["No_Aplica"])){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>	
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}
	if($objdibujaformulario->ingresarModificacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}

	if($objdibujaformulario->ingresarNuevo()){


	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."'>";
	echo "<script type='text/javascript'>
		window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
	</script>";

	}
	if($objdibujaformulario->ingresarAnulacion()){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$_SERVER["REQUEST_URI"]."&Anulado=1'>";
	}

echo "</table>";
echo "</form>";
?>
</body>
</html>