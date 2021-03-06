<?php

require_once('nusoap.php');
require('../serviciosacademicos/Connections/sala2.php');
/**
 * ==============================================================================
 * Descripciï¿½n:         Script para el proceso de sonde de PSE.                |
 * Desarrollado por:    Avisortech Ltda.                                       |
 *                      (571) - 3458833 - (571) - 4937039.                     |
 *                      Carrera 26 # 63 a - 22 Piso 5. - Bogotï¿½ D.C - Colombia.|
 * Desarrollo para:     Universidad del Bosque. Bogotï¿½ D.C - Colombia          |
 * Autor:               Nicolï¿½s G. Rico                                        |
 *                      Ing. Desarrollador Avisortech Ltda.                    |
 *                      nicolas.guaneme@avisortech.com                         |
 * Fecha:               15 de Noviembre de 2005.                                 |
 * Versiï¿½n:             0.1 release.                                           |
 * ==============================================================================
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
define("_SRV_CODE_", "10001");
define("_ENTITY_CODE_", "10017");
define("_PAYMENT_SYSTEM_", "0");
define("_DB_", "sala");
// Nos conectamos a la base de datos para mirar lo que esta en estado PENDDING
//echo "algo";
$link = mysql_connect($hostname_sala, $username_sala, $password_sala) or die(mysql_error());
mysql_select_db(_DB_, $link);

function escribeLog($cadena) {
    $fecha = date("d-m-Y");
    $archivo = "SondaUBosque-" . $fecha . ".log";
    $fp = fopen($archivo, "a");
    $write = fputs($fp, $cadena);
    fclose($fp);
}

//$strCampos = "TicketId";
$strCampos = "*";
$strConsulta = "SELECT " . $strCampos . " FROM LogPagos WHERE StaCode LIKE 'PEND%'";
$queryres = mysql_query($strConsulta, $link) or die(mysql_error());
//print_r($queryres);
//echo "$strConsulta";
//print_r($queryres);
$total_registros = mysql_num_rows($queryres);
//echo "dsadasd$total_registros";
// Si hay algo comienza la fiesta...
if ($total_registros > 0) {
    while ($row = mysql_fetch_array($queryres)) {
        echo "<br><br><br>Reg:";
        print_r($row);
        disparar_servicio($link, _DB_, $row);
    }
}

function disparar_servicio($link, $database_sala, $row) {
    global $hostname_sala, $database_sala, $username_sala, $password_sala;
    static $salaobjecttmp;
    // Por cada registro se dispara el servicio
    $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
    $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
    $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
    //echo "soapclient(http://200.31.69.162/corepsem/webservice/MPPWebServices.asmx?WSDL, true,$proxyhost, $proxyport, $proxyusername, $proxypassword);";
    $client = new soapclient("http://pse.unbosque.edu.co/ecollect/webservice/MPPServices.asmx?WSDL", true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
    //$client = new soapclient("http://68.178.148.205/corepsem/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
    $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
    $err = $client->getError();
    if ($err) {
        echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        //exit();
    }
    $proxy = $client->getProxy();
    $param[] = array(
        'EntityCode' => _ENTITY_CODE_,
        'TicketId' => $row['TicketId']
    );
    //mysql_select_db($database_sala, $link);
    //echo "adasdad<br>";
    //print_r($param);
    $result = $client->call('getTransactionInformation', array($param), '', '', true, true);
    // Revisar posibles errores
    if ($proxy->fault) {
        echo '<h2>Fault</h2><pre>';
        print_r($result);
        echo '</pre>';
    } else {
        // Revisar mas errores
        $err = $proxy->getError();
        if ($err) {
            // Mostrar el error.
            echo '<h2>Error</h2><pre>' . $err . '</pre>';
        } else {
            // Validacion de los estados
            echo "<br>NEW: <br>";
            print_r($result);
            if ($result['TranState'] == 'OK') {
                if ($result['ReturnCode'] == 'SUCCESS') {
                    //print_r($result);
                    // Primero miro cual es el estado actual de la orden y la prematricula
                    $query_selestadoorden = "select o.codigoestadoordenpago
					from ordenpago o
					where o.numeroordenpago = '" . $result['Reference1'] . "'";
                    $selestadoorden = mysql_query($query_selestadoorden, $link) or die("$query_selestadoorden" . mysql_error());
                    $totalRows_selestadoorden = mysql_num_rows($selestadoorden);
                    $row_selestadoorden = mysql_fetch_array($selestadoorden);
                    $digitoorden = ereg_replace("^[0-9]{1,1}", "", $row_selestadoorden['codigoestadoordenpago']);

                    $query_selestadoprematricula = "select p.codigoestadoprematricula
					from prematricula p, ordenpago o
					WHERE o.numeroordenpago = '" . $result['Reference1'] . "'
					and o.idprematricula = p.idprematricula";
                    $selestadoprematricula = mysql_query($query_selestadoprematricula, $link) or die("$query_selestadoprematricula" . mysql_error());
                    $totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);
                    $row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
                    $digitoprematricula = ereg_replace("^[0-9]{1,1}", "", $row_selestadoprematricula['codigoestadoprematricula']);

                    // Actualizamos las tablas
                    // 1. Actualizaciï¿½n de la tabla LogPagos
                    $strQuery = "UPDATE LogPagos SET StaCode = 'OK', TrazabilityCode = '" . $result['TrazabilityCode'] . "',  BankProcessDate = '" . $result['BankProcessDate'] . "', FIName = '" . $result['BankName'] . "'  WHERE TicketId = '" . $row['TicketId'] . "';";
                    echo "<h5>$strQuery</h5>";
                    $query = mysql_query($strQuery, $link);

                    // 4. Actualizaciï¿½n del estado del estudiante a inscrito en caso de pagar el formulario de inscripciï¿½n
                    $query_conceptoorden = "select dor.codigoconcepto
					from detalleordenpago dor, concepto co
					WHERE dor.numeroordenpago = '" . $result['Reference1'] . "'
					and dor.codigoconcepto = co.codigoconcepto
                                        and co.cuentaoperacionprincipal in ('153')";
                    $conceptoorden = mysql_query($query_conceptoorden, $link) or die("$query_conceptoorden" . mysql_error());
                    $totalRows_conceptoorden = mysql_num_rows($conceptoorden);
                    $row_conceptoorden = mysql_fetch_array($conceptoorden);
                    if ($row_conceptoorden <> "") {
                        /*mysql_select_db(_DB_, $link);
                        echo "<br>ASDASDASD";
                        */
                        require_once('../serviciosacademicos/funciones/funcion_inscribir.php');
                        hacerInscripcion_pse($result['Reference1']);
                        /*$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
						SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107', e.codigoperiodo = o.codigoperiodo
						WHERE o.codigoestudiante = e.codigoestudiante
						AND e.idestudiantegeneral = i.idestudiantegeneral
						AND e.codigocarrera = ec.codigocarrera
						AND i.idinscripcion = ec.idinscripcion
						AND o.numeroordenpago = '" . $result['Reference1'] . "'";
                        $inscripcion = mysql_query($query_inscripcion, $link) or die("$query_inscripcion" . mysql_error());*/
                    }


                    // 2. Actualizaciï¿½n de la tabla ordenpago
                    $strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 4" . $digitoorden . "
					WHERE numeroordenpago = '" . $result['Reference1'] . "';";
                    $Ordenpago = mysql_query($strOrdenpago, $link) or die("$strOrdenpago<br>".mysql_error());

                    // 3. Actualizaciï¿½n de la tabla prematricula
                    $strPrematricula = "UPDATE prematricula p, ordenpago o
					SET p.codigoestadoprematricula = 4" . $digitoprematricula . "
					WHERE o.numeroordenpago = '" . $result['Reference1'] . "'
					and o.idprematricula = p.idprematricula
					and o.codigoperiodo = p.codigoperiodo;";
                    $Prematricula = mysql_query($strPrematricula, $link);

                    // 3. Actualizaciï¿½n de la tabla detalleprematricula
                    echo $strDetallePrematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = 30
					WHERE numeroordenpago = '" . $result['Reference1'] . "'
					and codigoestadodetalleprematricula like '1%';";
                    $DetallePrematricula = mysql_query($strDetallePrematricula, $link);

                    $numeroordenpago = $result['Reference1'];

                    // El informe del pago se hace con la orden que se paga, si tiene plan de pago la papa no se informa a sap
                    $sala = $link;
                    //mysql_select_db(_DB_, $link);
                    $ruta = "../serviciosacademicos/";
                    require("../serviciosacademicos/interfacessap/informa_pago_internet.php");
                    saprfc_close($rfc);

                    // Si la orden pertenece a un plan de pagos
                    echo $query_plan = "SELECT * FROM ordenpagoplandepago
					WHERE numerorodencoutaplandepagosap = '$numeroordenpago'";
                    //echo $query_data,"<br>";
                    $plan = mysql_query($query_plan, $link) or die(mysql_error());
                    $row_plan = mysql_fetch_assoc($plan);
                    $totalRows_plan = mysql_num_rows($plan);
                    $numeroordenpagohijo = $numeroordenpago;

                    if ($row_plan <> "") { //if 2
                        $numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];

                        $query_selestadoorden = "select o.codigoestadoordenpago
						from ordenpago o
						where o.numeroordenpago = '$numeroordenpago'";
                        $selestadoorden = mysql_query($query_selestadoorden, $link) or die("$query_selestadoorden" . mysql_error());
                        $totalRows_selestadoorden = mysql_num_rows($selestadoorden);
                        $row_selestadoorden = mysql_fetch_array($selestadoorden);
                        $digitoorden = ereg_replace("^[0-9]{1,1}", "", $row_selestadoorden['codigoestadoordenpago']);

                        $query_selestadoprematricula = "select p.codigoestadoprematricula
						from prematricula p, ordenpago o
						WHERE o.numeroordenpago = '$numeroordenpago'
						and o.idprematricula = p.idprematricula";
                        $selestadoprematricula = mysql_query($query_selestadoprematricula, $link) or die("$query_selestadoprematricula" . mysql_error());
                        $totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);
                        $row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
                        $digitoprematricula = ereg_replace("^[0-9]{1,1}", "", $row_selestadoprematricula['codigoestadoprematricula']);

                                               // 4. Actualizaciï¿½n del estado del estudiante a inscrito en caso de pagar el formulario de inscripciï¿½n
                        $query_conceptoorden = "select dor.codigoconcepto
						from detalleordenpago dor, concepto con
						WHERE dor.numeroordenpago = '$numeroordenpago'
                                                and dor.codigoconcepto = con.codigoconcepto
						and con.cuentaoperacionprincipal = '153'";
                        $conceptoorden = mysql_query($query_conceptoorden, $link) or die("$query_conceptoorden" . mysql_error());
                        $totalRows_conceptoorden = mysql_num_rows($conceptoorden);
                        $row_conceptoorden = mysql_fetch_array($conceptoorden);

                        $query_planes = "update ordenpagoplandepago
						set codigoindicadorprocesosap = '300'
						WHERE numerorodencoutaplandepagosap = '$numeroordenpagohijo'";
                        $planes = mysql_query($query_planes, $link) or die("$query_planes" . mysql_error());

                        if ($row_conceptoorden <> "") {
                            require_once('../serviciosacademicos/funciones/funcion_inscribir.php');
                            hacerInscripcion_pse($result['Reference1']);
                           /* $query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
							SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107', e.codigoperiodo = o.codigoperiodo
							WHERE o.codigoestudiante = e.codigoestudiante
							AND e.idestudiantegeneral = i.idestudiantegeneral
							AND e.codigocarrera = ec.codigocarrera
							AND i.idinscripcion = ec.idinscripcion
							AND o.numeroordenpago = '$numeroordenpago'";
                            $inscripcion = mysql_query($query_inscripcion, $link) or die("$query_inscripcion" . mysql_error());*/
                        }

                        // 2. Actualizaciï¿½n de la tabla ordenpago
                        echo $strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 4" . $digitoorden . "
						WHERE numeroordenpago = '$numeroordenpago';";
                        $Ordenpago = mysql_query($strOrdenpago, $link);

                        // 3. Actualizaciï¿½n de la tabla prematricula
                        $strPrematricula = "UPDATE prematricula p, ordenpago o
						SET p.codigoestadoprematricula = 4" . $digitoprematricula . "
						WHERE o.numeroordenpago = '$numeroordenpago'
						and o.idprematricula = p.idprematricula
						and o.codigoperiodo = p.codigoperiodo;";
                        $Prematricula = mysql_query($strPrematricula, $link);

                        // 3. Actualizaciï¿½n de la tabla detalleprematricula
                        $strDetallePrematricula = "UPDATE detalleprematricula SET codigoestadodetalleprematricula = 30
						WHERE numeroordenpago = '$numeroordenpago'
						and codigoestadodetalleprematricula like '1%';";
                        $DetallePrematricula = mysql_query($strDetallePrematricula, $link);

                        // 3.1 Le hace update a las materias del hijo
                        $query_detalleprematricula = "UPDATE detalleprematricula
						set codigoestadodetalleprematricula = '30'
						where numeroordenpago = '$numeroordenpagohijo'
						and codigoestadodetalleprematricula like '1%'";
                        $detalleprematricula = mysql_db_query($database_sala, $query_detalleprematricula) or die("$query_detalleprematricula" . mysql_error());

                        $log = "Ejecuto en:" . $fecha . " - TicketId: " . $row . " - TrazabilityCode: " . $result['TrazabilityCode'] . " - TranState: OK - SrvCode: 100 - PaymentDesc: " . $result['PaymentDesc'] . " - TransValue: " . $result['TransValue'] . " - TransVatValue: " . $result['TransVatValue'] . " - Reference1: " . $result['Reference1'] . " - Reference2: " . $result['Reference2'] . " - Reference3: " . $result['Reference3'] . " - BankProcessDate: " . $result['BankProcessDate'] . " - BankName: " . $result['BankName'] . " - ReturnCode: " . $result['ReturnCode'] . "\n";
                        escribeLog($log);
                        // if 2
                    }
                } else if ($result['TranState'] == 'PENDING') {
                    $log = "Ejecuto en:" . $fecha . " - TicketId: " . $row . " - TrazabilityCode: " . $result['TrazabilityCode'] . " - TranState: OK - SrvCode: 100 - PaymentDesc: " . $result['PaymentDesc'] . " - TransValue: " . $result['TransValue'] . " - TransVatValue: " . $result['TransVatValue'] . " - Reference1: " . $result['Reference1'] . " - Reference2: " . $result['Reference2'] . " - Reference3: " . $result['Reference3'] . " - BankProcessDate: " . $result['BankProcessDate'] . " - BankName: " . $result['BankName'] . " - ReturnCode: " . $result['ReturnCode'] . "\n";
                    escribeLog($log);
                } else {
                    // Poner el estado que aparece en el result.
                    // Este cï¿½digo lo agregue para modificar la orden en caso de no haber sido aprobada la transacciï¿½n o fallo de la misma
                    // Colocar los update para dejar la orden otraves lista para pagar
                    $query_selestadoorden = "select o.codigoestadoordenpago
					from ordenpago o
					where o.numeroordenpago = '" . $result['Reference1'] . "'";
                    $selestadoorden = mysql_query($query_selestadoorden, $link) or die("$query_selestadoorden" . mysql_error());
                    $totalRows_selestadoorden = mysql_num_rows($selestadoorden);
                    $row_selestadoorden = mysql_fetch_array($selestadoorden);
                    $digitoorden = ereg_replace("^[0-9]{1,1}", "", $row_selestadoorden['codigoestadoordenpago']);

                    // 2. Actualizaciï¿½n de la tabla ordenpago
                    $strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 1" . $digitoorden . "
					WHERE numeroordenpago = '" . $result['Reference1'] . "'";
                    $Ordenpago = mysql_query($strOrdenpago, $link);
                    //die;
                    $log = "Ejecuto en:" . $fecha . " - TicketId: " . $row . " - TrazabilityCode: " . $result['TrazabilityCode'] . " - TranState: OK - SrvCode: 100 - PaymentDesc: " . $result['PaymentDesc'] . " - TransValue: " . $result['TransValue'] . " - TransVatValue: " . $result['TransVatValue'] . " - Reference1: " . $result['Reference1'] . " - Reference2: " . $result['Reference2'] . " - Reference3: " . $result['Reference3'] . " - BankProcessDate: " . $result['BankProcessDate'] . " - BankName: " . $result['BankName'] . " - ReturnCode: " . $result['ReturnCode'] . "\n";
                    escribeLog($log);
                }
            } else {
                // Poner el estado que aparece en el result.
                // Este cï¿½digo lo agregue para modificar la orden en caso de no haber sido aprobada la transacciï¿½n o fallo de la misma
                // Colocar los update para dejar la orden otraves lista para pagar
                $query_selestadoprematricula = "select p.codigoestadoprematricula
				from prematricula p, detalleprematricula d
				WHERE d.numeroordenpago = '" . $row['Reference1'] . "'
				and d.idprematricula = p.idprematricula";
                $selestadoprematricula = mysql_query($query_selestadoprematricula, $link) or die("$query_selestadoprematricula" . mysql_error());
                $totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);
                $row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
                $digitoprematricula = ereg_replace("^[0-9]{1,1}", "", $row_selestadoprematricula['codigoestadoprematricula']);

                $query_detalleprematricula = "UPDATE detalleprematricula
				set codigoestadodetalleprematricula = '1" . $digitoprematricula . "'
				where numeroordenpago = '" . $row['Reference1'] . "'
				and codigoestadodetalleprematricula like '1%'";
                $detalleprematricula = mysql_query($query_detalleprematricula, $link) or die("$query_detalleprematricula" . mysql_error());

                $query_selestadoorden = "select o.codigoestadoordenpago
				from ordenpago o
				where o.numeroordenpago = '" . $row['Reference1'] . "'";
                $selestadoorden = mysql_query($query_selestadoorden, $link) or die("$query_selestadoorden" . mysql_error());
                $totalRows_selestadoorden = mysql_num_rows($selestadoorden);
                $row_selestadoorden = mysql_fetch_array($selestadoorden);
                $digitoorden = ereg_replace("^[0-9]{1,1}", "", $row_selestadoorden['codigoestadoordenpago']);

                // 2. Actualizaciï¿½n de la tabla ordenpago
                $strOrdenpago = "UPDATE ordenpago SET codigoestadoordenpago = 1" . $digitoorden . "
				WHERE numeroordenpago = '" . $row['Reference1'] . "'";
                $Ordenpago = mysql_query($strOrdenpago, $link) or die("$strOrdenpago" . mysql_error());

                if ($result['ReturnCode'] == '') {
                    $result['ReturnCode'] = 'PENDING';
                }
                // Luego modifico en el Log
                $query_updlog = "UPDATE LogPagos
				SET StaCode = '" . $result['ReturnCode'] . "'
				WHERE Reference1 = '" . $row['Reference1'] . "'
				and TicketId = '" . $row['TicketId'] . "'";
                $updlog = mysql_query($query_updlog, $link) or die("$query_updlog" . mysql_error());
                echo "<br> $query_updlog";
                $log = "Ejecuto en:" . $fecha . " - TicketId: " . $row . " - TrazabilityCode: " . $result['TrazabilityCode'] . " - TranState: OK - SrvCode: 100 - PaymentDesc: " . $result['PaymentDesc'] . " - TransValue: " . $result['TransValue'] . " - TransVatValue: " . $result['TransVatValue'] . " - Reference1: " . $result['Reference1'] . " - Reference2: " . $result['Reference2'] . " - Reference3: " . $result['Reference3'] . " - BankProcessDate: " . $result['BankProcessDate'] . " - BankName: " . $result['BankName'] . " - ReturnCode: " . $result['ReturnCode'] . "\n";
                escribeLog($log);
            }
            //   print_r($result);
        }
    }
    //$client = null;
    //unset($client);
    //unset($result);
}

?>
