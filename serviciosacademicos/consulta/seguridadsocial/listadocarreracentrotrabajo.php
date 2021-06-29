<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
}

</script>
<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/motor/motor.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];

$query="select cc.idcarreracentrotrabajo, ct.nombrecentrotrabajoarp, ct.porcentajecotizacionarp,  c.nombrecortocarrera from 
centrotrabajoarp ct, carreracentrotrabajoarp cc, carrera c 
where ct.idcentrotrabajoarp=cc.idcentrotrabajoarp and
c.codigocarrera=cc.codigocarrera and
cc.codigoestado like '1%'
order by cc.idcarreracentrotrabajo desc
";

$objetobase=new BaseDeDatosGeneral($sala);
$condicion="and es.idestudiantegeneral=eg.idestudiantegeneral
			and eg.tipodocumento=do.tipodocumento";
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante es, estudiantegeneral eg, documento do","es.codigoestudiante",$_SESSION['sesion_codigoestudiante'],$condicion);

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
while ($row_operacion=$operacion->fetchRow());
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado de relaciones Carrera-Centrotrabajo ");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('idcarreracentrotrabajo','asignacioncentrotrabajo.php','asignacioncentrotrabajo.php','','idcarreracentrotrabajo',"codigoestudiante=".$_GET['codigoestudiante']."&modificar=1",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
?>
