<?PHP
$rutaCss="../../";
 $ruta = "../";
 
 global $db;
 
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "../";
    while (!is_file($ruta.'datos/class/Utils_datos.php'))
    {
            $ruta = $ruta."../";
    }
    require_once ($ruta.'datos/class/Utils_datos.php');
	
	# return $db;
?>

        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/demo_table_jui.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="<?php echo $rutaCss; ?>css/styleDatos.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/jquery.fastLiveFilter.js"></script>     
        <!--<script type="text/javascript" language="javascript" src="<?php //echo $rutaCss; ?>js/jquery-ui.js"></script>--> 
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="<?php echo $rutaCss; ?>js/functionsMonitoreo.js"></script> 
  