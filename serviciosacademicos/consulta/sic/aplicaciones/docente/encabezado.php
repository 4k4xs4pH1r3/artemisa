<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
if($_GET["salir"]){
        if(isset($_SESSION['numerodocumento'])) {
?>
    <script type="text/javascript">
        //var lateral = window.parent.frames[1].name;
        window.parent.document.getElementById("frameMovible").cols="240,*"
        //window.parent.frames[1].cols="0";
        //alert(lateral);
    </script>
<?php
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../../facultades/central.php'>";
        }
        else {
            session_unset();
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresodocente.php'>";
        }
	//print_r($_SESSION);
}


$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/clasemenusic.php");
$rutaJS="../../../../funciones/sala_genericas/ajax/jquery/";

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
if(!isset($_SESSION["codigoperiodosesion"])&&$_SESSION["codigoperiodosesion"]==''){
$datosperiodoactivo=$objetobase->recuperar_datos_tabla("periodo p","codigoestadoperiodo","1");
$_SESSION["codigoperiodosesion"]=$datosperiodoactivo["codigoperiodo"];
//$_SESSION["codigoperiodosesion"]="20092";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<head>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
   <link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
    <script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>


<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/ajax.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/context-menu.js"></script> 
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/dragdropmenu/js/drag-drop-folder-tree.js"></script> 

<link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/dragdropmenu/css/drag-drop-folder-tree.css" type="text/css"></link>
<link rel="stylesheet" href="../../../../funciones/sala_genericas/ajax/dragdropmenu/css/context-menu.css" type="text/css"></link>

<script type="text/javascript">
function regresar(){
//alert(window.parent.frames[1].location);
window.parent.location.href="listadodocentesfacultad.php";
}
function salir(){
//alert(window.parent.frames[1].location);
window.parent.location.href="encabezado.php?salir=1";
}
function continuar(){
//alert(window.parent.frames[1].location);
window.parent.continuar();
}
function previsualizar(){
//alert(window.parent.frames[2].location);
window.parent.frames[2].location.href="consultaaprobacion/consultaprobaciondatosdocente.php";
//window.parent.frames[1].saveMyTree();
}
function enviarmodalidad(){
var codigocarrera=document.getElementById("codigocarrera");
var formulario=document.getElementById("form1");
//document.getElementById("tr0")
if(codigocarrera!=null)
codigocarrera.value="";
formulario.submit();
}

</script>

<title>Servicios Acadï¿½micos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body  leftmargin="0"  marginwidth="0" marginheight="0"  topmargin="0">
<form  action="" method="post" id="form1" name="form1">
		
<table align="center" width="100%" bgcolor="#8AB200" height="30" ><!--<TR ><TD align="center" id='tdtitulosic' valign="middle" height="23"><img src="../../imagenes/escudo.gif" height="25"></TR>-->
<TR bgcolor="#F8F8F8" ><TD  valign="top" >
<table  width="100%"><TR bgcolor="#F8F8F8" ><TD  valign="top" align="left" width="30%">


<?php
$usuario=$formulario->datos_usuario();

if($_GET['entrada']){
	echo "<input type='button' onclick='continuar();' value='Continuar'>";

}
else{
	if($_GET["listado"]){
	echo "<input type='button' onclick='regresar();' value='Regresar'>";
	
	
	}
	else{
	echo "<input type='button' onclick='salir();' value='Salir'>";
	}

}
echo "<input type='button' onclick='previsualizar();' value='Previsualizar'>";
?>
</td><td align="center">
&nbsp;La información registrada puede ser adicionada, actualizada o anulada
<!--
<?php
/*
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*//*
if(!isset($_SESSION['sissic_codigomodalidadacademica'])||trim($_SESSION['sissic_codigomodalidadacademica'])=='')
$_SESSION['sissic_codigomodalidadacademica']=$_POST['codigomodalidadacademica'];
else
	if(isset($_POST['codigomodalidadacademica'])&&$_SESSION['sissic_codigomodalidadacademica']!=$_POST['codigomodalidadacademica'])
		$_SESSION['sissic_codigomodalidadacademica']=$_POST['codigomodalidadacademica'];


if(!isset($_SESSION['sissic_codigocarrera'])||trim($_SESSION['sissic_codigocarrera'])==''){
$_SESSION['sissic_codigocarrera']=$_POST['codigocarrera'];
echo "
<script type='text/javascript'>
window.parent.frames[1].location.href='creararbolsic.php';
window.parent.frames[2].location.href='central.php';
</script>
";
}
else	
  if(isset($_POST['codigocarrera'])&&$_SESSION['sissic_codigocarrera']!=$_POST['codigocarrera']){
	$_SESSION['sissic_codigocarrera']=$_POST['codigocarrera'];
echo "
<script type='text/javascript'>

window.parent.frames[1].location.href='creararbolsic.php';
window.parent.frames[2].location.href='central.php';
</script>
";
}
$condicion=" codigomodalidadacademica in ('200','300')";
$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica m","m.codigomodalidadacademica","m.nombremodalidadacademica",$condicion);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$_SESSION['sissic_codigomodalidadacademica']."','onchange=enviarmodalidad();'";
		
$formulario->menu_fila('codigomodalidadacademica',$_SESSION['sissic_codigomodalidadacademica'],'onchange=enviarmodalidad();');
$condicion="";
			if($usuario["idusuario"]==4186||$usuario["idusuario"]==17937){
				$condicion=" codigomodalidadacademica='".$_SESSION['sissic_codigomodalidadacademica']."'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}
			else{
				$condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and c.codigomodalidadacademica='".$_SESSION['sissic_codigomodalidadacademica']."'
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
				$formulario->filatmp[""]="Seleccionar";
			}
	$formulario->menu_fila('codigocarrera',$_SESSION['sissic_codigocarrera'],'onchange=enviar();');
*/
?>
</TD><TD valign="top" align="right"><a href="#"  onclick="save('final','doc')">Exportar</a></TD></TR></table>-->

<br><br></TD></TR>

</table>
</form>
</body>
</html>