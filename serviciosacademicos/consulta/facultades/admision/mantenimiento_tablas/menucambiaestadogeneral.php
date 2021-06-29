<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
//print_r($_SESSION);
?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>

<script language="javascript">
function cambia_tipo()
{ 
//alert("Entra Cambio tipo")
    //tomo el valor del select del tipo elegido 
    var tipo 
    tipo = document.form1.tipo[document.form1.tipo.selectedIndex].value 
    //miro a ver si el tipo est? definido 
    if (tipo == 1)
	{
		window.location.reload("admision_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	} 
	if (tipo == 2)
	{
		window.location.reload("AsignacionAutomaticaSalones.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	} 
	if (tipo == 3)
	{
		window.location.reload("listado_general.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 4)
	{
		window.location.reload("listado_general_noasignados.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 5)
	{
		window.location.reload("menu_subirexamen.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 6)
	{
		window.location.reload("calcula_listado_resultados.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 7)
	{
		window.location.reload("calcula_listado_resultados.php?admitir&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 8)
	{
		window.location.reload("calcula_listado_resultados.php?cambioestado&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 9)
	{
		window.location.reload("calcula_listado_resultados.php?asignaestado&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 10)
	{
		window.location.reload("listado_general_interesados.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}
	if (tipo == 11)
	{
		window.location.reload("menu_subirarchivosegundaopcion.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&link_origen=menu.php"); 
	}


}
</script>

<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<?php
unset($_SESSION['admisioncodigocarrera']);
unset($_SESSION['admisioncodigoperiodo']);
unset($_SESSION['admisioncodigomodalidadacademica']);

$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once('../../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');

$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
$validaciongeneral=true;
class carrera extends ADODB_Active_Record {}
class periodo extends ADODB_Active_Record {}
class modalidadacademica extends ADODB_Active_Record {}
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);


$idmenuopcion=163;
$usuario=$formulario->datos_usuario();

/*$condicion=" and u.usuario=ur.usuario 
			and ur.idrol=p.idrol".
		   " and p.idmenuopcion=".$idmenuopcion;*/
$condicion=" and u.idusuario=ut.UsuarioId
            and ut.CodigoTipoUsuario = ur.idusuariotipo
			and ur.idrol=p.idrol".
		   " and p.idmenuopcion=".$idmenuopcion;
if($datosrolusuario=$objetobase->recuperar_datos_tabla("usuario u, usuariorol ur, permisorol p, UsuarioTipo ut","u.idusuario",$usuario['idusuario'],$condicion,'',0)){


$modalidadacademica=new modalidadacademica('modalidadacademica');
$row_modalidadacademica=$modalidadacademica->Find('codigoestado=100 order by nombremodalidadacademica asc');
$carrera=new carrera('carrera');
if($_GET['codigomodalidadacademica']!="todos")
{
	$row_carrera=$carrera->Find("codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
}
else
{
	$row_carrera=$carrera->Find("codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
}
$periodo=new periodo('periodo');
//$periodo=$sala->GetActiveRecords('periodo');
$row_periodo=$periodo->Find('codigoperiodo <> 1 order by codigoperiodo desc');
?>
<form name="form1" method="get" action="">
  <p align="left" class="Estilo3">MENU PARAMETRIZACION ADMISIONES</p>
  <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
          <tr>
          <td width="14%" nowrap id="tdtitulogris">Modalidad acad&eacute;mica </td>
          <td width="86%"><select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_GET['codigomodalidadacademica']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php foreach ($row_modalidadacademica as $llave => $valor){?>
              <option value="<?php echo $valor->codigomodalidadacademica;?>"<?php if($valor->codigomodalidadacademica==$_GET['codigomodalidadacademica']){echo "Selected";}?>><?php echo $valor->nombremodalidadacademica?></option>
              <?php }?>
            </select>
              <?php $validacion['codigomodalidadacademica']=validaciongenerica($_GET['codigomodalidadacademica'], "requerido", "Modalidad académica");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Programa</td>
          <td class="amarrillento"><select name="codigocarrera" id="codigocarrera">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_GET['codigocarrera']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php foreach ($row_carrera as $llave => $valor){?>
              <option value="<?php echo $valor->codigocarrera?>"<?php if($valor->codigocarrera==$_GET['codigocarrera']){echo "Selected";}?>><?php echo $valor->nombrecarrera?></option>
              <?php };?>
            </select>
              <?php $validacion['codigocarrera']=validaciongenerica($_GET['codigocarrera'],"requerido","Programa");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Periodo</td>
          <td class="amarrillento"><select name="codigoperiodo" id="codigoperiodo">
              <option value="">Seleccionar</option>
              <?php foreach ($row_periodo as $llave => $valor){?>
              <option value="<?php echo $valor->codigoperiodo?>"<?php if($valor->codigoperiodo==$_GET['codigoperiodo']){echo "Selected";}?>><?php echo $valor->codigoperiodo?></option>
              <?php }?>
            </select>
              <?php $validacion['codigoperiodo']=validaciongenerica($_GET['codigoperiodo'],"requerido","Periodo");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Acción</td>
          <td class="amarrillento"><select name="tipo" id="tipo">
            <option value="">Seleccionar</option>
			<option value="10"<?php if($_GET['tipo']==10){echo "Selected";}?>>Listado estado general</option>
          </select>
		  <?php $validacion['accion']=validaciongenerica($_GET['tipo'],"requerido","Acción");?></td>
		  </td>
        </tr>
        <tr>
          <td colspan="2" nowrap><div align="center" class="verde">
              <input name="Continuar" type="submit" id="Continuar" value="Continuar">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
          </div></td>
        </tr>
  </table>
</form>
<?php if(isset($_GET['Restablecer'])){?>
<script language="javascript">window.location.reload("menu.php")</script>
<?php } ?>
<?php
if(isset($_GET['Continuar']))
{
	foreach ($validacion as $key => $valor){/*echo $valor['valido'];*/if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		/**
		 * Si existe array de recarga, se podrá recargar de nuevo
		 */
		$array_recarga[]=array('variable'=>'codigoperiodo','valor_variable'=>$_GET['codigoperiodo']);
		$array_recarga[]=array('variable'=>'codigomodalidadacademica','valor_variable'=>$_GET['codigomodalidadacademica']);
		$array_recarga[]=array('variable'=>'codigocarrera','valor_variable'=>$_GET['codigocarrera']);
		$_SESSION['archivo_ejecuta_recarga']='tabla_estadisticas_matriculas.php';
		$_SESSION['array_recarga']=$array_recarga;
		$_SESSION['codigoperiodo_seleccionado']=$_GET['codigoperiodo'];
		$_SESSION['codigocarrera']=$_GET['codigocarrera'];
		$_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
		$_SESSION['accion']=$_GET['accion'];
		//echo '<script language="javascript">window.location.href("admision_listado.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&link_origen=menu.php");</script>';
		echo '<script language="javascript">cambia_tipo();</script>';
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}

}
else{
	echo "<script language='javascript'>alert('Ud no tiene permiso para ver esta opcion');</script>";
}

?>
