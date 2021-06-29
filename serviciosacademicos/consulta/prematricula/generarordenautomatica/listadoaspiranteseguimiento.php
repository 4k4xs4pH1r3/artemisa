<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/motor/motor.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php' ); 
function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
$query="SELECT 
es.codigoestudiante,
es.idestudianteseguimiento, 
CONCAT(MID(es.observacionestudianteseguimiento,1,20),'...') as observacion,
es.fechaestudianteseguimiento as fecha,
p.nombrecortoproceso as proceso,
u.usuario as usuario,
t.nombretipoestudianteseguimiento TipoObservacion
FROM estudianteseguimiento es, usuario u, proceso p, tipoestudianteseguimiento t
WHERE es.codigoestudiante='".$_GET['codigoestudiante']."'
AND es.idusuario = u.idusuario
AND es.codigoestado=100
AND es.idproceso=p.idproceso
AND t.codigotipoestudianteseguimiento=es.codigotipoestudianteseguimiento
";
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
$motor = new matriz($array_interno,'Listado seguimientos del aspirante');
$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('observacion','listadoaspiranteseguimiento.php','detalleobservacionaspiranteseguimiento.php','observacion de la observacion','idestudianteseguimiento',"codigoestudiante=".$_GET['codigoestudiante']);

$motor->mostrar();
?>
