<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("funciones/ObtenerDatos.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 
//define('RELATIVE_PATH','../../../../funciones/clases/html2fpdf/');
//require_once(RELATIVE_PATH.'html2fpdf.php');
define('FPDF_FONTPATH','../../../../funciones/clases/fpdf/font/');
require('../../../../funciones/clases/fpdf/fpdf.php');
require_once("../../../../funciones/sala_genericas/clasedocumentopdf.php");
function RecuperarResultadosEstudiante($objetobase,$objetotablaadmisiones,$idadmision,$codigoestudiante){



$condicion=" and dea.codigotipodetalleadmision=ta.codigotipodetalleadmision";

$tablas=" detalleadmision dea, tipodetalleadmision ta";
$resultado=$objetobase->recuperar_resultado_tabla($tablas,"dea.idadmision",$idadmision,$condicion,"",0);
$i=0;

while($row=$resultado->fetchRow()){

$arrayresultadoestudiante[$i]=$objetotablaadmisiones->ObtenerResultadoExamen($codigoestudiante,$idadmision,$row["codigotipodetalleadmision"]);
$arrayresultadoestudiante[$i]["nombreprueba"]=$row["nombredetalleadmision"];
$arrayresultadoestudiante[$i]["tipodetalleadmision"]=$row["codigotipodetalleadmision"];
$arrayresultadoestudiante[$i]["porcentaje"]=$row["porcentajedetalleadmision"];
if($row["codigotipodetalleadmision"]=="4")
$arrayresultadoestudiante[$i]["total_preguntas"]=100;
$i++;



}



return $arrayresultadoestudiante;
}

function encuentra_array_materias($objetobase,$objetotablaadmisiones){
 
 
if($codigocarrera!="todos")
$carreradestino="AND c.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";

if($codigomateria!="todos")
	$materiadestino= "AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino= "";

$query=" SELECT idadmision,codigoestudiante,concat(apellidosestudiantegeneral,' ',nombresestudiantegeneral) nombre,numerodocumento documento,fechanacimiento,nombreestadoestudianteadmision estado, nombregenero genero,nombreinstitucioneducativa Institucion,nombreestadoestudianteadmision estado,sum(ponderado) puntaje
FROM (
(select a.idadmision,e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
eg.numerodocumento,
round(SUM(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado),2) resultado,

(select da2.iddetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4 and da2.codigoestado like '1%') codigotipoprueba,
(select da2.nombredetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4 and da2.codigoestado like '1%') tipoprueba,
(select da2.porcentajedetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4 and da2.codigoestado like '1%') porcentaje,
truncate((SUM(dr.notadetalleresultadopruebaestado) / count(dr.notadetalleresultadopruebaestado)*((select da2.porcentajedetalleadmision from detalleadmision da2 where da2.idadmision=a.idadmision and da2.codigotipodetalleadmision=4 and da2.codigoestado like '1%')/100))+0.006,2) ponderado,  
ge.nombregenero,
ie.nombreinstitucioneducativa, 
eea.nombreestadoestudianteadmision,
eg.fechanacimientoestudiantegeneral fechanacimiento

from carrera c, subperiodo sp, admision a, estudianteadmision ea,  estudiante e,detalleadmision da, detallesitioadmision dsa,horariodetallesitioadmision hdsa,detalleestudianteadmision dea,carreraperiodo cp,estadoestudianteadmision eea,estudiantegeneral eg
left join resultadopruebaestado rp on rp.idestudiantegeneral=eg.idestudiantegeneral
left join detalleresultadopruebaestado dr on dr.idresultadopruebaestado = rp.idresultadopruebaestado
left join asignaturaestado ae on dr.idasignaturaestado = ae.idasignaturaestado AND ae.codigoestado like '1%'
left join genero ge on ge.codigogenero=eg.codigogenero
left join estudianteestudio ee on ee.idestudiantegeneral=eg.idestudiantegeneral
left join institucioneducativa ie on ee.idinstitucioneducativa=ie.idinstitucioneducativa and ie.codigomodalidadacademica='".($_SESSION['admisiones_codigomodalidadacademica']-100)."'
where 
ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision and
c.codigocarrera=a.codigocarrera and
sp.idsubperiodo=a.idsubperiodo and
cp.codigocarrera=c.codigocarrera and
cp.idcarreraperiodo=sp.idcarreraperiodo and
a.idadmision=ea.idadmision and
ea.codigoestudiante=e.codigoestudiante and
e.idestudiantegeneral=eg.idestudiantegeneral and

da.iddetalleadmision=dsa.iddetalleadmision and
dsa.idadmision=a.idadmision and
hdsa.iddetallesitioadmision=dsa.iddetallesitioadmision and
dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision and
dea.idestudianteadmision=ea.idestudianteadmision and
cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
cp.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
dea.codigoestado like '1%' and
da.codigoestado like '1%' and
dsa.codigoestado like '1%' and 
hdsa.codigoestado like '1%' 
group by e.codigoestudiante)

UNION ALL

(select a.idadmision,e.codigoestudiante,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
eg.numerodocumento,
(max(dea.resultadodetalleestudianteadmision)/da.totalpreguntasdetalleadmision * 100) resultado,
da.iddetalleadmision codigotipoprueba,
da.nombredetalleadmision tipoprueba,
da.porcentajedetalleadmision porcentaje,
round((max(dea.resultadodetalleestudianteadmision)/da.totalpreguntasdetalleadmision * 100)*(porcentajedetalleadmision/100),2) ponderado,
ge.nombregenero ,
(select nombreinstitucioneducativa from institucioneducativa ie where  ee.idinstitucioneducativa=ie.idinstitucioneducativa and ie.codigomodalidadacademica='200' ) nombreinstitucioneducativa,
eea.nombreestadoestudianteadmision,
eg.fechanacimientoestudiantegeneral fechanacimiento

from carrera c, subperiodo sp,  estudianteadmision ea,  estudiante e, horariodetallesitioadmision hdsa,detalleestudianteadmision dea,carreraperiodo cp,estudiantegeneral eg,genero ge,
admision a,estudianteestudio ee,estadoestudianteadmision eea,detallesitioadmision dsa
left join detalleadmision da on da.idadmision=dsa.idadmision and da.iddetalleadmision=dsa.iddetalleadmision
where 
ea.codigoestadoestudianteadmision=eea.codigoestadoestudianteadmision and
ee.idestudiantegeneral=eg.idestudiantegeneral and
 ge.codigogenero=eg.codigogenero and
c.codigocarrera=a.codigocarrera and
sp.idsubperiodo=a.idsubperiodo and
cp.codigocarrera=c.codigocarrera and
cp.idcarreraperiodo=sp.idcarreraperiodo and
a.idadmision=ea.idadmision and
ea.codigoestudiante=e.codigoestudiante and
e.idestudiantegeneral=eg.idestudiantegeneral and

dsa.idadmision=a.idadmision and
hdsa.iddetallesitioadmision=dsa.iddetallesitioadmision and
dea.idhorariodetallesitioadmision=hdsa.idhorariodetallesitioadmision and
dea.idestudianteadmision=ea.idestudianteadmision and
cp.codigoperiodo=".$_SESSION['admisiones_codigoperiodo']." and
cp.codigocarrera=".$_SESSION['admisiones_codigocarrera']." and
dea.codigoestado like '1%' and
da.codigoestado like '1%' and
dsa.codigoestado like '1%' and 
hdsa.codigoestado like '1%' 
group by  ea.idestudianteadmision,da.iddetalleadmision
) 

) tabla1
group by codigoestudiante
order by nombre";

	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	$i=0;
	while ($row_operacion=$operacion->fetchRow())
	{
		$arrayresultadoestudiante=RecuperarResultadosEstudiante($objetobase,$objetotablaadmisiones,$row_operacion["idadmision"],$row_operacion["codigoestudiante"]);
		$resultadoicfes=$objetotablaadmisiones->ObtenerResultadoIcfes($row_operacion["codigoestudiante"]);		
		/*echo "arrayresultadoestudiante<pre>";
			print_r($arrayresultadoestudiante);
		echo "</pre>";
		exit();*/
		$fechanacimiento=formato_fecha_defecto(sacarpalabras($row_operacion["fechanacimiento"],0,0));
		$edadmeses=(int) (diferencia_fechas($fechanacimiento,date("d/m/Y"),"meses",0)/12);
		$row_operacion["fechanacimiento"]=$fechanacimiento;
		unset($row_operacion["fechanacimiento"]);

		$rowtmp["edad"]=$edadmeses;
		$row_operacion=InsertarColumnaFila($row_operacion,$rowtmp,6);
		unset($rowtmp);
		$rowtmp["estado"]=$row_operacion["estado"];
		unset($row_operacion["estado"]);
		$row_operacion=InsertarColumnaFila($row_operacion,$rowtmp,7);
		unset($rowtmp);

		$arrayponderado[]=$row_operacion["puntaje"];
		unset($row_operacion["codigoestudiante"]);
		unset($row_operacion["idadmision"]);
		if($resultadoicfes<=1){
			$array_interno[$i]=$row_operacion;
			
			foreach($arrayresultadoestudiante as $conprueba => $filaprueba){
	
				$nombrecolumna="(".sacarpalabras($filaprueba["nombreprueba"],0,0)."x/".$filaprueba["total_preguntas"].")_".$filaprueba["porcentaje"]."%";
				if($arrayresultadoestudiante[$conprueba]["tipodetalleadmision"]!="4"){
					$array_interno[$i][$nombrecolumna]=$filaprueba["resultado"];
				}
				else{
					if(isset($resultadoicfes)&&trim($resultadoicfes)!='')
					$array_interno[$i][$nombrecolumna]=$resultadoicfes;
				}
			}
			//$array_interno[$i]["ICFES"]=$row_operacion["puntajeicfes"];
		$i++;
		}
	}

/*asort($arrayponderado);
//echo "Ponderado<pre>";
//print_r($arrayponderado);
//echo "</pre>";
for($i=0;$i<count($array_interno);$i++){
	$j=count($arrayponderado)+1;
	foreach($arrayponderado as $orden=>$valor){
	$j--;
	if($i==$orden)
		$array_interno[$i]["Puesto"]=$j;
	}
}*/
return $array_interno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$objetotablaadmisiones=new TablasAdmisiones($sala);
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_SESSION['admisiones_codigocarrera'],"","",0);

$vigilada = utf8_decode("Vigilada Mineducación");

$tituloprincipal="LISTADO POR ORDEN EN PUNTAJE\n PROCESO DE ADMISIONES PERIODO ".$_SESSION['admisiones_codigoperiodo']." ".$datoscarrera["nombrecarrera"]." \n ".$vigilada."  ";


$objetopdfhtml=new DocumentoPDF($tituloprincipal,'L');
    $objetopdfhtml->anchofuente=3;
    $objetopdfhtml->tamanofuente=5;
    $objetopdfhtml->saltolinea=4;
    $objetopdfhtml->lineasxpagina=42;
    $objetopdfhtml->mostrarpiefecha=0;
    $objetopdfhtml->mostrarpiepagina=1;
    $objetopdfhtml->mostrarenumeracion=1;
//$objetopdfhtml=new HTML2FPDF('P','mm','A4',7);

$cantidadestmparray=encuentra_array_materias($objetobase,$objetotablaadmisiones);
$objetopdfhtml->CargarArray($cantidadestmparray);




//$objetopdfhtml->DibujarTitulo($tituloprincipal);
$objetopdfhtml->DibujarFilas($tituloprincipal);

$objetopdfhtml->CerrarDocumento();

?>
