<?php     require_once('../../../Connections/sala2.php');$rutaado = "../../../funciones/adodb/";require_once('../../../Connections/salaado.php'); session_start();  if ($_GET['colegio'] <> "") {    $query_institucioneducativa = "select *    	from institucioneducativa i	    where i.idinstitucioneducativa = '".$_GET['colegio']."'        order by 1";    echo "1111111111";    $institucioneducativa = $db->Execute($query_institucioneducativa);    $totalRows_selgenero = $institucioneducativa->RecordCount();    $row_institucioneducativa = $institucioneducativa->FetchRow();    $codigocolegio =$row_institucioneducativa['idinstitucioneducativa'];    $nombrecolegio =$row_institucioneducativa['nombreinstitucioneducativa'];    $estudio = $_REQUEST['estudio'];    echo "<script language='javascript'>			  window.opener.recargar1('".$codigocolegio."', '".$nombrecolegio."', '".$estudio."');			  window.opener.focus();			  window.close();			  </script>";   }?>