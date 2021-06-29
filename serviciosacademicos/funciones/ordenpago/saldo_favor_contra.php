<?php 	 
//unset($saldoafavor); 
//unset($saldoencontra); 

$query_dataestudiante = "SELECT * 
FROM estudiante e,estudiantegeneral eg 
WHERE e.idestudiantegeneral = eg.idestudiantegeneral
and e.codigoestudiante = '".$this->codigoestudiante."'";

//echo $query_dataestudiante;
$dataestudiante = mysql_query($query_dataestudiante, $this->sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
if ($row_dataestudiante <> "")
{
	$numerodocumento = $row_dataestudiante['numerodocumento'];	     
}	
     
$rfcfunction = "ZFKK_OPEN_ITEMS_FOR_ACC_READ";
$entrego = "I_IDNUMBER";
$resultstable = "T_FKKOP";
	 
$rfc = saprfc_open($login);
	
if(!$rfc) 
{
    echo "Failed to connect to the SAP server".saprfc_error();
    exit(1);
}
	
$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

if(!$rfchandle)
{
  	echo "We have failed to discover the function".saprfc_error($rfc);
	exit(1);
}
// traigo la tabla interna de SAP
saprfc_table_init($rfchandle,$resultstable);
// importo el numero de documento a consultar
saprfc_import($rfchandle,$entrego,$numerodocumento); 
	
@$rfcresults = saprfc_call_and_receive($rfchandle);
	
$numrows = saprfc_table_rows($rfchandle,$resultstable);
 
for ($i=1; $i <= $numrows; $i++)
{
	$results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
}	
	 
if ($results <> "")
{  // if 1 
	foreach ($results as $valor => $total)
	{ // foreach 1
		foreach ($total as $valor1 => $total1) 
		{ // foreach 2
			if ($valor1 == "HVORG") 
			{
				$opprincipal = $total1;
			   	//echo $opprincipal,"<br>";
			}
		    if ($valor1 == "TVORG")
			{
				$opparcial = $total1;
			}
			if ($valor1 == "FAEDN")
			{
				$fechavence =  $total1;
			}
			if ($valor1 == "BETRW")
			{
				$valor =  $total1;
			}	 
			if ($valor1 == "OPBEL")
			{
				$contabilizar =  $total1;
			}	 
			if ($valor1 == "PRCTR")
			{
				$cb =  $total1;
			}	     
		} // foreah 2		
		  
		$query_concepto = "SELECT * 
		FROM concepto 
		WHERE cuentaoperacionprincipal = '$opprincipal'
		and cuentaoperacionparcial = '$opparcial'";
		//echo $query_concepto;
		$concepto = mysql_query($query_concepto, $sala) or die("$query_concepto".mysql_error());
		$row_concepto = mysql_fetch_assoc($concepto);
		$totalRows_concepto = mysql_num_rows($concepto);
      
	    $query_carrera = "SELECT * 
		FROM carrera c
		WHERE  c.codigocentrobeneficio = '$cb'
		AND c.codigotipocosto = '100'";
		//echo $query_carrera;
		$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera".mysql_error());
		$row_carrera = mysql_fetch_assoc($carrera);
		$totalRows_carrera = mysql_num_rows($carrera);  
  
        if (! $row_carrera)
		{
			$query_carrera = "SELECT codigocarrera,DATE_FORMAT(CURDATE(),'%Y-%m-%d') AS hoy,fechainicionumeroordeninternasap AS inicio,fechavencimientonumeroordeninternasap AS final 
			FROM numeroordeninternasap
			WHERE numeroordeninternasap = '$cb'
			GROUP BY 1
	        HAVING (inicio <= hoy  AND hoy <=  final) ";
			// echo $query_carrera;
			$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera".mysql_error());
			$row_carrera = mysql_fetch_assoc($carrera);
			$totalRows_carrera = mysql_num_rows($carrera);		
		}
           
		$codigocarrera = $row_carrera['codigocarrera'];
  
        $query_codigoestudiantecarrera = "SELECT * 
		FROM estudiante e, prematricula p
		WHERE e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
		AND e.codigocarrera = '$codigocarrera'
		and p.codigoestudiante = e.codigoestudiante";
		// echo $query_codigoestudiantecarrera;
		$codigoestudiantecarrera = mysql_query($query_codigoestudiantecarrera, $sala) or die("$query_codigoestudiantecarrera".mysql_error());
		$row_codigoestudiantecarrera = mysql_fetch_assoc($codigoestudiantecarrera);
		$totalRows_codigoestudiantecarrera = mysql_num_rows($codigoestudiantecarrera);
		  
		$codigoestudiante =  $row_codigoestudiantecarrera['codigoestudiante'];
		if ($row_concepto <> "")
		{
			if ($row_concepto['codigotipoconcepto'] == '02')
			{
				$saldoafavor[] = array($codigocarrera,$row_concepto['codigoconcepto'],$row_concepto['nombreconcepto'],$fechavence,$valor,$contabilizar,$codigoestudiante); 
			}
			else if ($row_concepto['codigotipoconcepto'] == '01') 
			{
				$saldoencontra[] = array($codigocarrera,$row_concepto['codigoconcepto'],$row_concepto['nombreconcepto'],$fechavence,$valor,$contabilizar,$codigoestudiante);
			}			
		}		  
	} // foreach 1
} // if 1  
	  
//var_dump($results);
?>	 