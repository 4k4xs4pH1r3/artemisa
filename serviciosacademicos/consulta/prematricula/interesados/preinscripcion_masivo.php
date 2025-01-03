<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
set_time_limit(10000000000);
//error_reporting(E_ALL);

// Para ejecutar este archivo debe pasarle por el get el periodo en el cual quiere ingresar la base de datos
// artemisa.unbosque.edu.co/html/serviciosacademicos/consulta/prematricula/interesados/preinscripcion_masivo.php?periodo_sesion=20111
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/sala/auditoria/auditoria.php');
require_once("../../../funciones/clases/phpmailer/class.phpmailer.php");
include($rutazado.'zadodb-pager.inc.php');
if(isset($_SESSION['debug_sesion']))
{
    $db->debug = true;
}
//print_r($_SESSION);
if($_SESSION['MM_Username'] != 'admintecnologia')
{
    echo "No tiene permiso";
    exit();
}
//$db->debug = true;
require_once("funciones/datos_mail.php");
function obtenerTrato($trato)
{
    if(ereg("orita",$trato))
    {
        $idtrato = 3;
    }
    else if(ereg("genier",$trato))
    {
        $idtrato = 4;
    }
    else if(ereg("octor",$trato))
    {
        $idtrato = 2;
    }
    else
    {
        $idtrato = 1;
    }
    return $idtrato;
}

$auditoria = new auditoria();

if($auditoria->usuario == '')
    $auditoria->idusuario = 1;
$fechahoy = date("Y-m-d H:i:s");
if(isset($_REQUEST['periodo_sesion']))
    $codigoperiodo = $_REQUEST['periodo_sesion'];

$sql = "SELECT t.idprospecto, t.TRATO, t.NOMBRES, t.APELLIDOS, t.`TIPO DE DOC`, t.DOCUMENTO, t.`CORREO ELECTRONICO`, t.TELEFONO, t.CELULAR, t.CIUDAD, t.OBSERVACION, t.`MODALIDAD ACAD`, t.C1, t.C2, t.C3, t.C4, t.C5, t.C6
FROM tmpprospecto t
where t.correoenviado = ''";
//and ps.idusuario <> '1'
$rta = $db->Execute($sql);
$totalRows_rta = $rta->RecordCount();
//print_r($db);

if($totalRows_rta > 0)
{
    //echo $totalRows_rta;
    //print_r($db);
    while($row_rta = $rta->FetchRow())
    {
        // Insertar en preinscripcion
        if($auditoria->idusuario == '')
            $auditoria->idusuario = 1;
        //print_r($row_rta);
        //echo "$totalRows_rta";
        //exit();
        $idtrato = obtenerTrato($row_rta['TRATO']);


        if($row_rta['TIPO DE DOC'] == '')
            $row_rta['TIPO DE DOC'] = 0;
        $ins_query = "insert into preinscripcion(idpreinscripcion, fechapreinscripcion, numerodocumento, tipodocumento, codigoperiodo, idtrato, apellidosestudiante, nombresestudiante, ciudadestudiante, telefonoestudiante, celularestudiante, emailestudiante, codigoestadopreinscripcionestudiante, idusuario, ip, codigoestado, codigoindicadorenvioemailacudientepreinscripcion, idempresa, idtipoorigenpreinscripcion)
        values(0, now(), '".$row_rta['DOCUMENTO']."', '".$row_rta['TIPO DE DOC']."', '$codigoperiodo', '$idtrato', '".$row_rta['APELLIDOS']."', '".$row_rta['NOMBRES']."', '".$row_rta['CIUDAD']."', '".$row_rta['TELEFONO']."', '".$row_rta['CELULAR']."', '".$row_rta['CORREO ELECTRONICO']."',  '300', '$auditoria->idusuario', '$auditoria->ip', '100', '100', '1', '1')";
        $ins = $db->Execute($ins_query);
        $idpreinscripcion = $db->Insert_ID();
        if($row_rta['OBSERVACION'] != '')
        {
            $ins_query = "insert into preinscripcionseguimiento(idpreinscripcionseguimiento, idpreinscripcion, observacionpreinscripcionseguimiento, fechapreinscripcionseguimiento, idusuario, codigoestado, Idtipodetalleestudianteseguimiento, codigotipoestudianteseguimiento, fechahastapreinscripcionseguimiento, codigoprocesovidaestudiante)
            values(0, '$idpreinscripcion', '".$row_rta['OBSERVACION']."', now(), '$auditoria->idusuario', '100', '1', '999', now(), '100')";
            $ins = $db->Execute($ins_query);
        }

        unset($array_carreras_chuliadas);

        for($i = 1; $i <= 6; $i++)
        {
            if($row_rta['C'.$i] != '')
            {
                $array_carreras_chuliadas[] = $row_rta['C'.$i];
                $ins_query = "insert into preinscripcioncarrera(`idpreinscripcioncarrera`, `idpreinscripcion`, `codigocarrera`, `codigoestado`)
                values(0, '$idpreinscripcion', '".$row_rta['C'.$i]."', '100')";
                $ins = $db->Execute($ins_query);
            }
        }
        if($row_rta['CORREO ELECTRONICO'] != "")
        {
            //verificar que carreras chulió el interesado
            //si chulio 1 se instancia el objeto ObtenerDatosMail con el codigocarrera chuliado,
            //si no, pailas, se manda el generico, con codigocarrera 1
            //Instanciar mailer

            $prueba = new ObtenerDatosMail($db,$array_carreras_chuliadas,2,$depura_correo);
            $trato = $row_rta['TRATO'];
            $correo = $prueba->Construir_correo($row_rta['CORREO ELECTRONICO'],$row_rta['NOMBRES']." ".$row_rta['APELLIDOS'],$trato);
            //$seguimiento=$prueba->Construir_correo_seguimiento($row_rta['NOMBRES']." ".$row_rta['APELLIDOS'],$idpreinscripcion);
            if($depura_correo==true)
            {
                exit();
            }
        }
        $upd_query = "update tmpprospecto
        set correoenviado = 'ENVIADO'
        where idprospecto = '".$row_rta['idprospecto']."'";
        $upd = $db->Execute($upd_query);
    }
}

?>
