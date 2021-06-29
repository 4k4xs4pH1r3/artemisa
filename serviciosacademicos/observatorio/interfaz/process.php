<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
/////////////////busca la ruta del managerentity
$ruta = '';
while (!is_file($ruta.'ManagerEntity.php')){
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');

///////////trae el id del usuario //////////*
$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
//$entity->debug = true;
$data_u = $entity->getData();

$userid = $data_u[0]['idusuario'];


$table = $_REQUEST['entity'];
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : '';
$currentdate  = date("Y-m-d H:i:s");
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$_POST['ip'] = $REMOTE_ADDR;
$idname= "idobs_".$table;
$id_nam=$_REQUEST[$idname];

$entity = new ManagerEntity($table,"observatorio");
//echo $_REQUEST[$idname].'--->'.$idname.'<--->';
if ($table=='grupos'){
    if(!empty($_POST['codigomodalidadacademica1'])){
        $_POST['codigomodalidadacademica']=$_POST['codigomodalidadacademica1'];
    }
     if(!empty($_POST['codigocarrera1'])){
       $_POST['codigocarrera']=$_POST['codigocarrera1'];
    }
}
if($action=='inactivate' and !empty($_REQUEST['id_del'])){
 
    $_POST[$idname]=$_REQUEST['id_del'];
    $_REQUEST[$idname]=$_REQUEST['id_del'];
    $entity->SetEntity($_POST);
    $entity->fieldlist[$idname]['pkey']=$_REQUEST[$idname];
    //$entity->debug = true;
    $entity->deleteRecord();
    $id=$_REQUEST[$idname];
}else{
    if(!empty($id_nam)){
            ////*********para eliminar o modificar normalmente*******/////////
            $entity->SetEntity($_POST);
            $entity->fieldlist[$idname]['pkey']=$_REQUEST[$idname];
            if($action=='inactivate'){
              // $entity->debug = true;
                $entity->deleteRecord();
                $id=$_REQUEST[$idname];
            }else{
                
               // $entity->debug = true;        
                $entity->updateRecord();
                $id=$_REQUEST[$idname];
                
            }
        $result='Se modifico exitosamente';
    }else{
        $d=$entity->SetEntity($_POST);
        $_POST['fechacreacion'] = $currentdate;
        $_POST['usuariocreacion'] = $userid;
        /////////****insertar normal******/////////
        $entity->SetEntity($_POST);
        //$entity->debug = true;
        $id=$entity->insertRecord();
        $result='Se registro exitosamente';
    }
}
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>