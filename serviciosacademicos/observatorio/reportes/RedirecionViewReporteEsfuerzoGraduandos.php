<?php

/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

//var_dump (is_file('../templates/templateObservatorio.php'));
include("../../ReportesAuditoria/templates/mainjson.php");
include("../templates/templateObservatorio.php");
include('../../mgi/datos/class/Utils_datos.php');
$Titulo = 'Esfuerzo de Formaci&oacute;n';
writeHeader($Titulo,false,"Esfuerzo de Graduacion",1,'',$db);
$utils = new Utils_datos();

$UrlView='1';
?>
<div align="center">
<?PHP 
include(dirname(__FILE__)."/../../mgi/datos/reportes/reportes/estudiantes/viewReporteEsfuerzoGraduandos.php");
?>
</div>
