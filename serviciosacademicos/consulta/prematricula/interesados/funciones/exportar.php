<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();

require_once("../../../../funciones/clases/motor/motor.php");
$exportar = new matriz($_SESSION[$_GET['arreglo']]);
$exportar->exportar_array($_SESSION[$_GET['arreglo']],$_GET['nombre'],$_GET['formato']);
echo '<script language="javascript">window.close()</script>';

?>
