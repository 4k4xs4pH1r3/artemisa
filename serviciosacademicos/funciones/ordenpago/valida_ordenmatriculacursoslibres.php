<?php
// Para los ordenes de inscripción se debentener los siguientes datos:
// 1. Que existan los conceptos de inscripción, la matricula tiene el valor 100
if(!$this->existe_conceptosxcodigoreferencia("100"))
{
	$valordeverdad = false;
}
// 2. Que exista valor pecuniario para el periodo y para matricula
if(!$this->existe_valorpecuniarioxcodigoreferencia("100"))
{
	$valordeverdad = false;
}
// 3. Que exista factura para la carrera del estudiante y para el periodo activo
/*if(!$this->existe_facturavalorpecuniario("100"))
{
	//$valordeverdad = false;
}
*/
// 4. Que existan valores pecuniarios para matricula
/*if(!$this->existe_valorpecuniarioxcodigoreferencia("100"))
{
	//$valordeverdad = false;
}*/

// 5. Que exista detalles de facturavalorpecuniario para matricula
/*if(!$this->existe_detallefacturavalorpecuniarioxcodigoreferencia("100"))
{
	//$valordeverdad = false;
}
*/
// 6. Que exista registro en carreraperido para 
if(!$this->existe_carreraperiodo())
{
	$valordeverdad = false;
}
// 7. Que exista subperiodo para la carrera
if(!$this->existe_subperiodo())
{
	$valordeverdad = false;
}
// 8. Que exista bancos para las cuentas de la orden de pago
if(!$this->existe_cuentabanco())
{
	$valordeverdad = false;
}
// 9. Que exista ordeninterna o centrobeneficio para la carrera
if(!@$this->existe_ordeninternaocentrobeneficio($ordeninternaocentrobeneficio, $materiascongrupo))
{
	//$valordeverdad = false;
}
// 10. Que halla registro en fechaeducacioncontinuada
if(!$this->existe_fechaeducacioncontinuada($materiascongrupo))
{
	$valordeverdad = false;
}
// 11. Que hallan fechas en detallefechaeducacioncontinuada
if(!$this->existe_detallefechaeducacioncontinuada($materiascongrupo))
{
	//$valordeverdad = false;
}
// 12. Que tenga cohorteo o valoreducacioncontinuada
if(!$this->existe_cohorte())
{
	$valordeverdad = false;
}
// 13. Que tenga detallecohorte  o valoreducacioncontinuada
if(!$this->existe_detallecohorte())
{
	$valordeverdad = false;
}
// 14. Que exista concexion sap
//if(!$this->existe_conexionsap())
//{
//	$valordeverdad = false;
//}
?>
