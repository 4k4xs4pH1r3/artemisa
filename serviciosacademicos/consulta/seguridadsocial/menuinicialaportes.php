<?php
session_start();
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../funciones/phpmailer/class.phpmailer.php");
//require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

?>
<script LANGUAGE="JavaScript">

function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	//history.back();
	document.location.href="<?php echo '../facultades/menuopcion.php';?>";
}
function enviarpagina(){
var pagina;
pagina=form1.menu[document.form1.menu.selectedIndex].value;
//alert(pagina);
form1.action=pagina;
//return false;
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>


<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
//$formulario2=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

//echo "Entro aqui";
?>
<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="" onChange="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
	$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");

	//$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');?>
	<tr>
	<td colspan="2">
	<?php 	
		//$formulario->dibujar_fila_titulo('Asignacion de codigos EPS y ARP','labelresaltado');
  		$formulario->filatmp['listadocierreaportes.php']="Listado de cierre de mes";
  		$formulario->filatmp['marcomasivoasignacionaportes.php']="Asignaciones generales";
  		$formulario->filatmp['marcocentrostrabajo.php']="Centros de trabajo";

 		$formulario->filatmp['listadoestudiantesaportes.php']="Ingreso Masivo";

 		$formulario->filatmp['detalleproceso.php']="Activacion Meses de Cierre";
 		$formulario->filatmp['novedadarpextemporaneo.php']="Novedades por fuera de periodo";
		
		$formulario->filatmp['listadoestudiantesaportesarp.php']="Ingreso masivo ARP";
 		$formulario->filatmp['listadocierreaportesarp.php']="Listado cierre de mes ARP";

		$menu='menu_fila'; $parametros="'menu','".$menu."',''";
		$formulario->dibujar_campo($menu,$parametros,"Opciones","tdtitulogris","escogertipoarp",'requerido');
		$conboton=0;
		$parametrobotonenviar[$conboton]="'submit','Seguir','Seguir','onClick=\"return enviarpagina();\"'";
		$boton[$conboton]='boton_tipo';
		$conboton++;				
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
	
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');
		

	?>	
	</td>
	</tr>
  </table>
</form>