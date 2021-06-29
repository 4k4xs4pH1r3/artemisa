<?php
function ordennespago($codigoestudiante,$numeroordenpago,$salatmp)
{

$factura=new FPDF("P","cm","Letter");
$factura->SetAutoPageBreak(1);

$factura->AddFont('code128','','code128.php');

for($j=0;$j<count($codigoestudiante);$j++)
{
$_GET["numeroordenpago"]=$numeroordenpago[$j];
$factura->SetTextColor(0,0,0);
$factura->SetFont('Arial','B',10);
$factura->SetMargins(1,1,2);

//echo "<BR>NUMERO DE ID=".$j;
$factura->AddPage();
$datos=new datos_ordenpago($salatmp,$codigoestudiante[$j],$numeroordenpago[$j]);
//print_r($datos);
$datos->obtener_datos_estudiante();
$datos->obtener_conceptos();
$fechas=$datos->fechas_pago();
//listar($fechas);
$datos->obtener_materias();
$datos->armar_referencia();
$codigosbarras=$datos->generar_codigobarras_base();
$titulosbarras=$datos->generar_titulobarras_base();

/************Imagenes***************/
$factura->Image('../../../../imagenes/estudiante_pdf.jpg',0.6,3,0.25,2.03);
$factura->Image('../../../../imagenes/secretariaacademica_pdf.jpg',0.6,9,0.25,3.5);
$factura->Image('../../../../imagenes/banco_pdf.jpg',0.6,20.5,0.35,1.2);
$factura->Image('../../../../imagenes/tijeras.png',0.5,8.15,0.4);
$factura->Image('../../../../imagenes/tijeras.png',0.5,12.82,0.4);
$factura->Image('../../../../imagenes/logo.jpg',1.05,1,1);
$factura->Image('../../../../imagenes/logo.jpg',1.05,8.75,1);
$factura->Image('../../../../imagenes/logo.jpg',1.05,13.43,1);//logo tercer bloque
/********************************************/
/************rectangulos************/
$factura->Rect(1,0.9,11,2,"");
$factura->Rect(1,2.9,11,5.1,"");
$factura->Rect(1,8.65,19,4,"");
$factura->Rect(1,8.65,11,4,"");
$factura->Rect(1,13.3,19,2.5,"");//tercer bloque
$factura->Rect(1,13.3,11,2.5,"");//tercer bloque
$factura->Rect(1,19,19,7,"");//tercer bloque
$factura->Rect(12,0.9,8,7.1,"");
$factura->Rect(14,19,6,7,"");
/********************************************/
//print_r($factura);
/************rayitas cortadas************/
$largo=0.15;
$espaciado=0.25;
$x1=0;
$x2=$x1+$largo;
for($i = 0; $i <= 86; $i++)
{
	$factura->Line($x1, 8.3, $x2, 8.3);
	//echo $x1," ",$x2,"<br>";
	$x1=$x1+$espaciado;
	$x2=$x2+$espaciado;
}

$largo=0.15;
$espaciado=0.25;
$x1=0;
$x2=$x1+$largo;
for($i = 0; $i <= 86; $i++)
{
	$factura->Line($x1, 13, $x2, 13);
	$x1=$x1+$espaciado;
	$x2=$x2+$espaciado;
}
/********************************************/
//**CUADRITOS**//
$factura->Rect(19.5,1,0.32,0.32,"");
$factura->Rect(19.5,1.4,0.32,0.32,"");
$factura->Rect(19.5,1.82,0.32,0.32,"");

$factura->Rect(19.5,8.75,0.32,0.32,"");
$factura->Rect(19.5,9.15,0.32,0.32,"");
$factura->Rect(19.5,9.57,0.32,0.32,"");

$factura->Rect(19.5,13.42,0.32,0.32,"");
$factura->Rect(19.5,13.8,0.32,0.32,"");
$factura->Rect(19.5,14.2,0.32,0.32,"");
/********************************************/
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionnumeroordenpagouniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');

$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$datos->estudiante['semestreprematricula'],1,0,'L');

if(($datos->conceptos[0]["codigoconcepto"]==159||$datos->conceptos[0]["codigoconcepto"]=='C9076'||$datos->conceptos[0]["codigoconcepto"]=='C9077') && $datos->estudiante['fechaentregaordenpago']!='0000-00-00')
{
    $cadenafecha=fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha=explode("de",$cadenafecha);
    $factura->Cell(3,0.3,"".strtoupper($arraycadenafecha[1]." de ").$arraycadenafecha[2],1,0,'L');
}
else
    $factura->Cell(3,0.3,"PERIODO ".$datos->estudiante['codigoperiodo'],1,0,'L');

$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,$datos->estudiante['nombre'],1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
$factura->SetY(2.9);//posicion vertical inicial para empezar a colocar los conceptos
foreach ($datos->conceptos as $llave => $valor)
{
	$factura->Cell(9,0.3,$valor['nombreconcepto'],0,0,'L');
	$factura->Cell(2,0.3,money_format('%(#10n',$valor['valorconcepto']),0,1,'L');
}


//temporal info posgrados
$factura->SetFont('Arial','B',7);
$factura->SetY(5.5);
if($datos->codigomodalidadacademica==300){
	$factura->ln(0.3);
	$factura->MultiCell(11,0.3,'SEÑOR RESIDENTE LE RECORDAMOS QUE PARA LEGALIZAR  LA MATRICULA  ES OBLIGATORIO REALIZAR  LA  AFILIACION A LA EPS Y ARP EN  LA  DIVISION DE POSTGRADOS.');
}
//fin temporal
$factura->SetY(6.8);

$factura->SetFont('Arial','B',6);
$factura->Cell(6,0.3,"PAGO TOTAL: ",1,0,'L');
$factura->Cell(5,0.3,money_format('%(#10n',$datos->fechas[0]['valorapagar']),1,1,'L');

foreach ($datos->fechas as $llave => $valor)
{
	$factura->Cell(6,0.3,$valor['nombreplazo']." ".$valor['fechaordenpago'],1,0,'L');
	$factura->Cell(5,0.3,money_format('%(#10n',$valor['valorapagar']),1,1,'L');
}
$factura->SetFont('Arial','',4);
$factura->SetY(8.05);
$factura->Cell(20.65,0.2,"PARA SU VALIDEZ DEBE TENER EL TIMBRE DE LA REGISTRADORA Y EL SELLO DE RECIBIDO",0,0,'C');


/*primer bloque*/
$factura->SetY(1);//posicion vertical inicial para empezar a colocar el bloque derecho
$factura->SetLeftMargin(12);
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE CREDITO",0,1,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE BOGOTA",0,1,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCOLOMBIA",0,1,'L');
$factura->SetFont('Arial','',7);
$factura->SetFont('Arial','B',6);
$factura->SetY(2.3);
$factura->Cell(8,0.3,"RECIBO DE PAGO No.      ".$numeroordenpago[$j],1,1,'L');
$factura->SetFont('Arial','',6);
$factura->Cell(8,0.3,"PROGRAMA: ".$datos->estudiante['nombrecarrera'],1,1,'L');


$factura->SetY(2.9);//posicion vertical inicial para empezar a colocar las materias
foreach($datos->materias as $llave => $valor)
{
	$factura->Cell(9.65,0.3,$valor['codigomateria']." ".strtoupper($valor['nombremateria']),0,1,'L');

}
//***********final primer bloque /*************************


//segunda casila

$factura->setxy(1,8.75);
$factura->SetLeftMargin(1);
//2 encabezado
$factura->SetFont('Arial','B',10);
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionuniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$datos->estudiante['semestreprematricula'],1,0,'L');

if(($datos->conceptos[0]["codigoconcepto"]==159||$datos->conceptos[0]["codigoconcepto"]=='C9076'||$datos->conceptos[0]["codigoconcepto"]=='C9077') && $datos->estudiante['fechaentregaordenpago']!='0000-00-00')
{
    $cadenafecha=fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha=explode("de",$cadenafecha);
    $factura->Cell(3,0.3,"".strtoupper($arraycadenafecha[1]." de ").$arraycadenafecha[2],1,0,'L');
}
else
    $factura->Cell(3,0.3,"PERIODO ".$datos->estudiante['codigoperiodo'],1,0,'L');

$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'C');
$factura->Cell(9.5,0.3,$datos->estudiante['nombre'],1,1,'C');
$factura->SetFont('Arial','B',6);
$factura->Cell(11,0.3,"DESCRIPCION DEL PAGO",1,1,'C');
$factura->SetY(10.95);
$factura->SetFont('Arial','B',6);
$factura->Cell(6,0.3,"PAGO TOTAL: ",1,0,'L');
$factura->Cell(5,0.3,money_format('%(#10n',$datos->fechas[0]['valorapagar']),1,1,'L');
foreach ($datos->fechas as $llave => $valor)
{
	$factura->Cell(6,0.3,$valor['nombreplazo']." ".$valor['fechaordenpago'],1,0,'L');
	$factura->Cell(5,0.3,money_format('%(#10n',$valor['valorapagar']),1,1,'L');
}
$factura->SetFont('Arial','',4);
$factura->SetY(12.7);
$factura->Cell(20.65,0.2,"ENTREGAR ESTE VOLANTE EN LA SECRETARIA ACADEMICA. EL SOLO PAGO DE LA MATRICULA NO SUPONE COMPROMISO ACADEMICO",0,0,'C');
$factura->SetY(13.45);

$factura->SetY(8.75);
$factura->SetLeftMargin(12);

$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE CREDITO",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE BOGOTA",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCOLOMBIA",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',6);
$factura->SetY(10.05);
$factura->Cell(8,0.3,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','',6);
$factura->Cell(8,0.3,"PROGRAMA: ".$datos->estudiante['nombrecarrera'],1,1,'L');

/***************************************************Ultimo Bloque**************************************/
$factura->SetLeftMargin(1);

$factura->SetY(13.42);//pos inicio vertical ultimo bloque

$factura->SetFont('Arial','B',10);
$factura->Cell(11,0.3,$universidad->nombreuniversidad,0,1,'C');
$factura->SetFont('Arial','',5);
$factura->Cell(11,0.2,$universidad->personeriauniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->direccionuniversidad,0,1,'C');
$factura->Cell(11,0.2,$universidad->nituniversidad,0,1,'C');
$factura->Ln(0.1);
$factura->SetFont('Arial','',6);
$factura->Cell(3,0.3,"ID ".$datos->estudiante['idestudiantegeneral'],1,0,'L');
$factura->Cell(2,0.3,"SEM. ".$datos->estudiante['semestreprematricula'],1,0,'L');

if(($datos->conceptos[0]["codigoconcepto"]==159||$datos->conceptos[0]["codigoconcepto"]=='C9076'||$datos->conceptos[0]["codigoconcepto"]=='C9077') && $datos->estudiante['fechaentregaordenpago']!='0000-00-00')
{
    $cadenafecha=fechaatextofecha(formato_fecha_defecto($datos->estudiante['fechaentregaordenpago']));
    $arraycadenafecha=explode("de",$cadenafecha);
    $factura->Cell(3,0.3,"".strtoupper($arraycadenafecha[1]." de ").$arraycadenafecha[2],1,0,'L');
}
else
    $factura->Cell(3,0.3,"PERIODO ".$datos->estudiante['codigoperiodo'],1,0,'L');

$factura->Cell(3,0.3,"IDENT. ".$datos->estudiante['nombrecortodocumento']." ".$datos->estudiante['numerodocumento'],1,1,'L');
$factura->Cell(1.5,0.3,"NOMBRE: ",1,0,'fC');
$factura->Cell(9.5,0.3,$datos->estudiante['nombre'],1,1,'C');
$factura->Cell(11,0.3,"PROGRAMA:             ".$datos->estudiante['nombrecarrera'],1,1,'L');

$factura->SetY(13.42);//pos inicio vertical ultimo bloque
$factura->SetLeftMargin(12);

$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE CREDITO",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCO DE BOGOTA",0,1,'L');
$factura->SetFont('Arial','',7);

$factura->SetFont('Arial','B',9);
$factura->Cell(4,0.4,"BANCOLOMBIA",0,1,'L');

$factura->SetFont('Arial','B',6);
$factura->ln(0.10);
$factura->Cell(8,0.3,"RECIBO DE PAGO No.      ".$_GET['numeroordenpago'],1,1,'L');
$factura->SetFont('Arial','B',10);
$factura->Cell(8,0.65,"REFERENCIA ".$datos->referencia,0,1,'L');
$factura->SetFont('Arial','',7);
/*****************************cuadro forma de pago**********************************************/
$factura->SetXY(1,16);
$factura->SetLeftMargin(1);
$factura->Cell(14,0.5,"FORMA DE PAGO",1,0,'C');
$factura->Cell(1,0.5,"FECHA",1,0,'C');
$factura->SetTextColor(192,192,192);
$factura->Cell(4,0.5,"A                  M                  D",1,1,'C');
$factura->SetTextColor(0,0,0);
$factura->Cell(5,1.5,"CHEQUES",1,1,'C');
$factura->Cell(14,0.5,"                          EFECTIVO",1,1,'L');
$factura->Cell(14,0.5,"                       TOTAL PAGADO",1,1,'L');

$factura->SetXY(6,16.5);
$factura->SetLeftMargin(6);
$factura->Cell(3,0.5,"COD. BANCO",1,1,'C');
$factura->Cell(3,0.5,"",1,1,'C');
$factura->Cell(3,0.5,"",1,1,'C');


$factura->SetXY(9,16.5);
$factura->SetLeftMargin(9);
$factura->Cell(6,0.5,"NO. CUENTA",1,1,'C');
$factura->Cell(6,0.5,"",1,1,'C');
$factura->Cell(6,0.5,"",1,1,'C');

$factura->SetXY(15,16.5);
$factura->SetLeftMargin(15);
$factura->Cell(5,0.5,"VALOR",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');
$factura->Cell(5,0.5,"",1,1,'C');

//*********************************************************************barras
$factura->SetY(19.25);//posición vertical inicial codigos de barra
$factura->SetLeftMargin(1);
$factura->SetFont('code128','',28);
$factura->SetX(1);
$contador_barras=0;
foreach($codigosbarras as $llave => $valor)
{
	$factura->SetFont('arial','',8);
	$factura->Cell(19,1.0,"               ".$datos->fechas[$contador_barras]['nombreplazo_2']."                           ".$datos->fechas[$contador_barras]['fechaordenpago']."                           ".money_format('%(#10n',$datos->fechas[$contador_barras]['valorfechaordenpago']),0,1,'L');
	$prueba =  new ean128($valor);
	$ean128=$prueba->codificar();
	$factura->SetFont('code128','',34);
	$factura->Cell(19,0.7,$ean128,0,1,'L');
	$factura->SetFont('arial','',8);
	$factura->Cell(19,0.4,"            ".$titulosbarras[$contador_barras],0,1,'L');
	$contador_barras++;
}
$factura->sety(17.40);
$factura->SetFont('Arial','',4);
$factura->sety(25.75);
$factura->Cell(20.65,0.2,"                                                                      PAGUESE UNICAMENTE EN CHEQUE DE GERENCIA O EFECTIVO - NO SE ACEPTAN PAGOS PARCIALES",0,0,'L');

$factura->SetFont('Arial','',8);
//$factura->Cell(5,1.2,"EFECTIVO ",1,0,'L');
//$factura->Cell(3.6,1.2,"",1,1,'C');
//$factura->Cell(5,1.2,"VALOR A PAGAR ",1,1,'L');
$factura->SetTextColor(192,192,192);
$factura->SetXY(12.5,6);
$factura->Cell(7,1.2,"ESPACIO TIMBRE DE CAJA",0,0,'C');
$factura->SetXY(12.5,11);
$factura->Cell(7,1.2,"ESPACIO TIMBRE DE CAJA",0,0,'C');
$factura->SetXY(13.5,22);
$factura->Cell(7,1.2,"ESPACIO TIMBRE DE CAJA",0,0,'C');

}
$factura->Output('ordenenespensioncolegio.pdf','I');
}


?>