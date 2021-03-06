<?php
require_once('nusoap.php');
require('../serviciosacademicos/Connections/sala2.php');
/**
 *==============================================================================
 * Descripción:         Script para el proceso de sonde de PSE.                |
 * Desarrollado por:    Avisortech Ltda.                                       |
 *                      (571) - 3458833 - (571) - 4937039.                     |
 *                      Carrera 26 # 63 a - 22 Piso 5. - Bogotá D.C - Colombia.|
 * Desarrollo para:     Universidad del Bosque. Bogotá D.C - Colombia          |
 * Autor:               Nicolás G. Rico                                        |
 *                      Ing. Desarrollador Avisortech Ltda.                    |
 *                      nicolas.guaneme@avisortech.com                         |
 * Fecha:               15 de Noviembre de 2005.                                 |
 * Versión:             0.1 release.                                           |
 *==============================================================================
 */
/* Conectamos a la base de datos y obtenemos las transacciones que se
   encuentren es estado de PENDING, se opto por dejar todo en este scritp
   por seguridad e integridad con el sistema de PSE, tambien teniendo la
   opcionde de que este script es ejecutado por el sistema operativo bajo un
   ambiente Linux.
*/
// Constantes de conexion a la base de datos
define("_SERVIDOR_", "localhost");
define("_USER_", "root");
define("_PASS_", "");
define("_USER_TYPE_", "1");
define("_SRV_CODE_","10001");
define("_ENTITY_CODE_", "10017");
define("_PAYMENT_SYSTEM_","0");
define("_DB_", "sala");
// Nos conectamos a la base de datos para mirar lo que esta en estado PENDDING
//echo "algo";
$link = mysql_connect($hostname_sala, $username_sala, $password_sala) or die(mysql_error());
mysql_select_db(_DB_,$link);

function disparar_servicio($link, $row)
{	
	// Por cada registro se dispara el servicio
	$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
	$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
	$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
	//echo "soapclient(http://200.31.69.162/corepsem/webservice/MPPWebServices.asmx?WSDL, true,$proxyhost, $proxyport, $proxyusername, $proxypassword);";
	$client = new soapclient("http://68.178.148.167/payment/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
	$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
	$err = $client->getError();
	if($err) 
	{
   		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		//exit();
    	}
	$proxy = $client->getProxy();
   	$param[] = array(
       	'EntityCode'        => _ENTITY_CODE_,
       	'TicketId'          => $row['TicketId']
	);
	//echo "adasdad<br>";
	//print_r($param);
    $result = $client->call('getTransactionInformation', array($param), '', '', true, true);
    // Revisar posibles errores
    if($proxy->fault) 
	{
    	echo '<h2>Fault</h2><pre>';
    	print_r($result);
    	echo '</pre>';
    } 
	else 
	{
   		// Revisar mas errores
   		$err = $proxy->getError();
   		if($err)
		{
   			// Mostrar el error.
   			echo '<h2>Error</h2><pre>' . $err . '</pre>';
   		} 
		else 
		{
           	// Validacion de los estados
           	echo "NEW: <br>";
			print_r($result);
			if ($result['TranState'] == 'OK')
			{
               	if($result['ReturnCode'] == 'SUCCESS')
				{
					//print_r($result);
					// Primero miro cual es el estado actual de la orden y la prematricula
					$query_selestadoorden = "select o.codigoestadoordenpago
					from ordenpago o
					where o.numeroordenpago = '".$result['Reference1']."'";
					$selestadoorden=mysql_query($query_selestadoorden,$link) or die("$query_selestadoorden".mysql_error());
					$totalRows_selestadoorden = mysql_num_rows($selestadoorden);	
					$row_selestadoorden = mysql_fetch_array($selestadoorden);
					$digitoorden = ereg_replace("^[0-9]{1,1}","",$row_selestadoorden['codigoestadoordenpago']);
				  
					$query_selestadoprematricula = "select p.codigoestadoprematricula 
					from prematricula p, ordenpago o
					WHERE o.numeroordenpago = '".$result['Reference1']."'
					and o.idprematricula = p.idprematricula";
					$selestadoprematricula=mysql_query($query_selestadoprematricula,$link) or die("$query_selestadoprematricula".mysql_error());
					$totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);	
					$row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
					$digitoprematricula = ereg_replace("^[0-9]{1,1}","",$row_selestadoprematricula['codigoestadoprematricula']);
					  
					// Actualizamos las tablas
					// 1. Actualización de la tabla LogPagos
					$strQuery = "UPDATE LogPagos SET StaCode = 'OK', TrazabilityCode = '" . $result['TrazabilityCode'] . "',  BankProcessDate = '" . $result['BankProcessDate'] . "', FIName = '" . $result['BankName'] . "'  WHERE TicketId = '" . $row['TicketId'] . "';";
					echo "<h5>$strQuery</h5>";
					$query = mysql_query($strQuery,$link);
						
					// 2. Actualización de la tabla ordenpago
					$strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 4".$digitoorden." 
					WHERE numeroordenpago = '".$result['Reference1']."';";
					$Ordenpago = mysql_query($strOrdenpago,$link);
					
					// 3. Actualización de la tabla prematricula
					$strPrematricula = "UPDATE prematricula p, ordenpago o
					SET p.codigoestadoprematricula = 4".$digitoprematricula."
					WHERE o.numeroordenpago = '".$result['Reference1']."'
					and o.idprematricula = p.idprematricula
					and o.codigoperiodo = p.codigoperiodo;";
					$Prematricula = mysql_query($strPrematricula,$link);
				
					// 3. Actualización de la tabla detalleprematricula
					$strDetallePrematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = 30 
					WHERE numeroordenpago = '".$result['Reference1']."'
					and codigoestadodetalleprematricula like '1%';";
					$DetallePrematricula = mysql_query($strDetallePrematricula,$link);
					
					// 4. Actualización del estado del estudiante a inscrito en caso de pagar el formulario de inscripción
					$query_conceptoorden = "select do.codigoconcepto
					from detalleordenpago do
					WHERE do.numeroordenpago = '".$result['Reference1']."'
					and do.codigoconcepto = '153'";
					$conceptoorden=mysql_query($query_conceptoorden,$link) or die("$query_conceptoorden".mysql_error());
					$totalRows_conceptoorden = mysql_num_rows($conceptoorden);          
					$row_conceptoorden = mysql_fetch_array($conceptoorden);
					if($row_conceptoorden <> "")
					{
						$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
						SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107'
						WHERE o.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = i.idestudiantegeneral 
						AND e.codigocarrera = ec.codigocarrera
						AND i.idinscripcion = ec.idinscripcion
						AND o.numeroordenpago = '".$result['Reference1']."'";
						$inscripcion=mysql_query($query_inscripcion,$link) or die("$query_inscripcion".mysql_error());
					}
					$numeroordenpago = $result['Reference1'];
				
					// El informe del pago se hace con la orden que se paga, si tiene plan de pago la papa no se informa a sap
					$ruta = "../serviciosacademicos/";
					require("../serviciosacademicos/interfacessap/informa_pago_internet.php");
					saprfc_close($rfc);
				 	
					// Si la orden pertenece a un plan de pagos
					$query_plan = "SELECT * FROM ordenpagoplandepago
					WHERE numerorodencoutaplandepagosap = '$numeroordenpago'"; 
					//echo $query_data,"<br>";
					$plan = mysql_query($query_plan,$link) or die(mysql_error());
					$row_plan = mysql_fetch_assoc($plan);
					$totalRows_plan = mysql_num_rows($plan);
						   
					if($row_plan <> "")
					{ //if 2 
						$numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];
							
						$query_selestadoorden = "select o.codigoestadoordenpago
						from ordenpago o
						where o.numeroordenpago = '$numeroordenpago'";
						$selestadoorden=mysql_query($query_selestadoorden,$link) or die("$query_selestadoorden".mysql_error());
						$totalRows_selestadoorden = mysql_num_rows($selestadoorden);	
						$row_selestadoorden = mysql_fetch_array($selestadoorden);
						$digitoorden = ereg_replace("^[0-9]{1,1}","",$row_selestadoorden['codigoestadoordenpago']);
						  
						$query_selestadoprematricula = "select p.codigoestadoprematricula 
						from prematricula p, ordenpago o
						WHERE o.numeroordenpago = '$numeroordenpago'
						and o.idprematricula = p.idprematricula";
						$selestadoprematricula=mysql_query($query_selestadoprematricula,$link) or die("$query_selestadoprematricula".mysql_error());
						$totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);	
						$row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
						$digitoprematricula = ereg_replace("^[0-9]{1,1}","",$row_selestadoprematricula['codigoestadoprematricula']);

						// 2. Actualización de la tabla ordenpago
						$strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 4".$digitoorden." 
						WHERE numeroordenpago = '$numeroordenpago';";
						$Ordenpago = mysql_query($strOrdenpago,$link);
						
						// 3. Actualización de la tabla prematricula
						$strPrematricula = "UPDATE prematricula p, ordenpago o
						SET p.codigoestadoprematricula = 4".$digitoprematricula."
						WHERE o.numeroordenpago = '$numeroordenpago'
						and o.idprematricula = p.idprematricula
						and o.codigoperiodo = p.codigoperiodo;";
						$Prematricula = mysql_query($strPrematricula,$link);
						
						// 3. Actualización de la tabla detalleprematricula
						$strDetallePrematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = 30 
						WHERE numeroordenpago = '$numeroordenpago'
						and codigoestadodetalleprematricula like '1%';";
						$DetallePrematricula = mysql_query($strDetallePrematricula,$link);
						
						// 4. Actualización del estado del estudiante a inscrito en caso de pagar el formulario de inscripción
						$query_conceptoorden = "select do.codigoconcepto
						from detalleordenpago do
						WHERE do.numeroordenpago = '$numeroordenpago'
						and do.codigoconcepto = '153'";
						$conceptoorden=mysql_query($query_conceptoorden,$link) or die("$query_conceptoorden".mysql_error());
						$totalRows_conceptoorden = mysql_num_rows($conceptoorden);          
						$row_conceptoorden = mysql_fetch_array($conceptoorden);
						if($row_conceptoorden <> "")
						{
							$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
							SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107'
							WHERE o.codigoestudiante = e.codigoestudiante
							AND e.idestudiantegeneral = i.idestudiantegeneral 
							AND e.codigocarrera = ec.codigocarrera
							AND i.idinscripcion = ec.idinscripcion
							AND o.numeroordenpago = '$numeroordenpago'";
							$inscripcion=mysql_query($query_inscripcion,$link) or die("$query_inscripcion".mysql_error());
						}
						// if 2
					}
				}
				else if ($result['TranState'] == 'PENDING')
				{
					//die;
				} 
				else 
				{
					// Poner el estado que aparece en el result.
					// Este código lo agregue para modificar la orden en caso de no haber sido aprobada la transacción o fallo de la misma
					// Colocar los update para dejar la orden otraves lista para pagar
					$query_selestadoorden = "select o.codigoestadoordenpago
					from ordenpago o
					where o.numeroordenpago = '".$result['Reference1']."'";
					$selestadoorden=mysql_query($query_selestadoorden,$link) or die("$query_selestadoorden".mysql_error());
					$totalRows_selestadoorden = mysql_num_rows($selestadoorden);	
					$row_selestadoorden = mysql_fetch_array($selestadoorden);
					$digitoorden = ereg_replace("^[0-9]{1,1}","",$row_selestadoorden['codigoestadoordenpago']);
					
					// 2. Actualización de la tabla ordenpago
					$strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 1".$digitoorden." 
					WHERE numeroordenpago = '".$result['Reference1']."'";
					$Ordenpago = mysql_query($strOrdenpago,$link);
					//die;
                }
           	}
			else 
			{
           		// Poner el estado que aparece en el result.
				// Este código lo agregue para modificar la orden en caso de no haber sido aprobada la transacción o fallo de la misma
				// Colocar los update para dejar la orden otraves lista para pagar
				$query_selestadoorden = "select o.codigoestadoordenpago
				from ordenpago o
				where o.numeroordenpago = '".$result['Reference1']."'";
				$selestadoorden=mysql_query($query_selestadoorden,$link) or die("$query_selestadoorden".mysql_error());
				$totalRows_selestadoorden = mysql_num_rows($selestadoorden);	
				$row_selestadoorden = mysql_fetch_array($selestadoorden);
				$digitoorden = ereg_replace("^[0-9]{1,1}","",$row_selestadoorden['codigoestadoordenpago']);
			
				// 2. Actualización de la tabla ordenpago
				$strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 1".$digitoorden." 
				WHERE numeroordenpago = '".$result['Reference1']."'";
				$Ordenpago = mysql_query($strOrdenpago,$link) or die("$strOrdenpago".mysql_error());
				
				// Luego modifico en el Log
				$query_updlog = "UPDATE LogPagos 
				SET StaCode='".$result['TranState']."'
				WHERE Reference1 = '".$result['Reference1']."'
				and TrazabilityCode = '".$row['TicketId']."'";
				$updlog=mysql_query($query_updlog, $link) or die("$query_updlog".mysql_error());
				echo "<br> $query_updlog";
           	}
       		//   print_r($result);
   		}
   	}
   	//$client = null;
   	//unset($client);
	//unset($result);
}
//$strCampos = "TicketId";
$strCampos = "*";
$strConsulta = "SELECT " . $strCampos . " FROM LogPagos WHERE StaCode LIKE 'PEND%'";
$queryres = mysql_query($strConsulta,$link) or die(mysql_error());
//print_r($queryres);
//echo "$strConsulta";
//print_r($queryres);
$total_registros = mysql_num_rows($queryres);
//echo "dsadasd$total_registros";
// Si hay algo comienza la fiesta...
if ($total_registros > 0)
{
	while($row = mysql_fetch_array($queryres))
	{
    	echo "<br><br><br>Reg:";
	 	print_r($row);
		disparar_servicio($link, $row);
  	}
	//echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
	// Final del cliente.*/
} 
else 
{
	die;
}
?>
