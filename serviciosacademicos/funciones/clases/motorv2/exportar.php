<?php
session_start();
require_once("motor.php");
$exportar = new matriz($_SESSION[$_GET['arreglo']]);
$exportar->exportar_array($_SESSION[$_GET['arreglo']],$_GET['nombre'],$_GET['formato']);
echo '<script language="javascript">window.close()</script>';
?>
