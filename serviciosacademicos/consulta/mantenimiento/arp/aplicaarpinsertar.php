<?php 
//print_r($_POST);
require_once('../../../Connections/sala2.php');
require_once('../funciones/validacion.php');
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
?>
<?php
mysql_select_db($database_sala, $sala);
$query_sel_modalidadacademica = "SELECT * FROM modalidadacademica where codigomodalidadacademica='".$_GET['modalidadacademica']."'";

$sel_modalidadacademica = mysql_query($query_sel_modalidadacademica, $sala) or die(mysql_error());
$row_sel_modalidadacademica = mysql_fetch_assoc($sel_modalidadacademica);
$totalRows_sel_modalidadacademica = mysql_num_rows($sel_modalidadacademica);

mysql_select_db($database_sala, $sala);
$query_tomaideempresasalud = "SELECT idempresasalud, nombreempresasalud FROM empresasalud";
$tomaideempresasalud = mysql_query($query_tomaideempresasalud, $sala) or die(mysql_error());
$row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud);
$totalRows_tomaideempresasalud = mysql_num_rows($tomaideempresasalud);

mysql_select_db($database_sala, $sala);
$query_tomatipoconcepto = "SELECT codigoconcepto, nombreconcepto FROM concepto where codigoreferenciaconcepto='100' order by nombreconcepto ASC";
$tomatipoconcepto = mysql_query($query_tomatipoconcepto, $sala) or die(mysql_error());
$row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto);
$totalRows_tomatipoconcepto = mysql_num_rows($tomatipoconcepto);
?>
<script language="javascript">
function enviar()
{
	document.aplicaarp.submit()
}
</script>
  <script language="javascript">
  function HabilitarTodos(chkbox, seleccion)
  {
  	for (var i=0;i < document.forms[0].elements.length;i++)
  	{
  		var elemento = document.forms[0].elements[i];
  		if(elemento.type == "checkbox")
  		{
  			if (elemento.title == "carreras")
  			{
  				elemento.checked = chkbox.checked
  			}
  		}
  	}
  }
</script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<form name="aplicaarp" method="post" action="">

  <p align="center" class="Estilo3">ARP - INSERTAR REGISTROS</p>
  <table width="85%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" height="100%" border="0" align="center" cellpadding="3" bordercolor="#FFFFFF">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo</div></td>
          <td bgcolor='#FEF7ED' class="Estilo1"><div align="center"><?php echo $_GET['codigoperiodo']?></div></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica </div></td>
          <td bgcolor='#FEF7ED' class="Estilo1"><div align="center"><?php echo $row_sel_modalidadacademica['nombremodalidadacademica'];?>&nbsp;</div></td>
        </tr>
        <tr>
          <td width="51%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Aplicaci&oacute;n Masiva</div></td>
          <td width="49%" bgcolor='#FEF7ED' class="Estilo1"><div align="center">SI
                  <input name="masivo" type="radio" value="si"<?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){echo 'checked="checked"';}?>/>
        NO
        <input name="masivo" type="radio" value="no" <?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){echo 'checked="checked"';}?> />
          </div></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input type="submit" name="Submit" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
          </tr>
        <tr><?php if(isset($_POST['masivo']) and $_POST['masivo']=='no'){ mysql_select_db($database_sala, $sala);
        $query_sel_codigocarrera = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
		WHERE c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' 
	AND c.codigocarrera NOT IN (SELECT codigocarrera FROM aplicaarp where codigotipoaplicaarp='100' and codigoperiodo='".$_GET['codigoperiodo']."')  ORDER BY c.nombrecarrera asc";
        $sel_codigocarrera = mysql_query($query_sel_codigocarrera, $sala) or die($query_sel_codigocarrera.mysql_error());
        $row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera);
$totalRows_sel_codigocarrera = mysql_num_rows($sel_codigocarrera);?>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione carreras</div>
              <div align="center"></div></td>
          <td bgcolor="#CCDADD" class="Estilo2" align="center">
                 <select name="selcodigocarrera" id="selcodigocarrera" onchange="enviar()">
                  <option value="">Seleccionar</option>
                  <?php
                  do {
?>
                  <option value="<?php echo $row_sel_codigocarrera['codigocarrera']?>"<?php if(isset($_POST['selcodigocarrera'])){if($_POST['selcodigocarrera'] == $row_sel_codigocarrera['codigocarrera']){echo "selected";}}?>><?php echo $row_sel_codigocarrera['nombrecarrera']?></option>
                  <?php
                  } while ($row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera));
                  $rows = mysql_num_rows($sel_codigocarrera);
                  if($rows > 0) {
                  	mysql_data_seek($sel_codigocarrera, 0);
                  	$row_sel_codigocarrera = mysql_fetch_assoc($sel_codigocarrera);
                  }
?>
                </select>
                <?php } ?>
                <?php if(isset($_POST['masivo']) and $_POST['masivo']=='si' or isset($_POST['Enviar'])){ 
                	mysql_select_db($database_sala, $sala);
                	$query_carrerapormodalidad = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
WHERE c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' 
AND c.codigocarrera NOT IN (SELECT codigocarrera FROM aplicaarp where codigotipoaplicaarp='100' and codigoperiodo='".$_GET['codigoperiodo']."') ORDER BY c.nombrecarrera asc";
                	$carrerapormodalidad = mysql_query($query_carrerapormodalidad, $sala) or die($query_sel_codigocarrera.mysql_error());
                	$row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad);
                	$totalRows_carrerapormodalidad = mysql_num_rows($carrerapormodalidad);
   ?>
           </td>
        </tr>
        <tr>
		<?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){ ?>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione carreras</div></td>
          <td bgcolor="#CCDADD" class="Estilo2" align="center"><?php if(isset($_POST['masivo']) and $_POST['masivo']=='si'){ ?>
            Seleccionar Todo
              <input type="checkbox" name="checkbox" value="checkbox" onClick="HabilitarTodos(this)">
              <?php } ?></td> <?php } ?>
        </tr>
        <?php 
        do{
        	$chequear="";
        	if(isset($_POST['Enviar'])){
        		foreach($_POST as $vpost => $valor)
        		{
        			if (ereg("^carreras".$row_carrerapormodalidad['codigocarrera']."$",$vpost))
        			{
        				$chequear="checked";

        			}
        		}
        	}
        	//print_r($row_carrerapormodalidad);
        	echo "<tr><td class='Estilo1'>".$row_carrerapormodalidad['nombrecarrera']."&nbsp;</td>
		  <td><div align='center'><input type='checkbox' title='carreras' name='carreras".$row_carrerapormodalidad['codigocarrera']."' $chequear value='".$row_carrerapormodalidad['codigocarrera']."'>&nbsp;</div></td></tr>";}
        	while ($row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad));
	  ?>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
              <input type="submit" name="Enviar" value="Enviar" />
&nbsp;
          </div></td>
        </tr>
        <?php } ?>
      </table></td>
    </tr>
  </table>
  <br>
  <?php if (isset($_POST['Enviar']) or isset($_POST['selcodigocarrera'])){ ?>
  <table width="85%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre Aplica ARP<span class="Estilo4">*</span> </div></td>
          <td bgcolor='#FEF7ED'><p class="style2">
              <input name="nombreaplicaarp" type="text" id="nombreaplicaarp" />
          </p></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Empresa de Salud<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><select name="idempresasalud" id="idempresasalud">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $row_tomaideempresasalud['idempresasalud']?>"><?php echo $row_tomaideempresasalud['nombreempresasalud']?></option>
              <?php
              } while ($row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud));
              $rows = mysql_num_rows($tomaideempresasalud);
              if($rows > 0) {
              	mysql_data_seek($tomaideempresasalud, 0);
              	$row_tomaideempresasalud = mysql_fetch_assoc($tomaideempresasalud);
              }
?>
            </select>
          </td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Porcentaje Aplica ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="porcentajeaplicaarp" type="text" id="porcentajeaplicaarp" /></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor fijo Aplica ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="valorfijoaplicaarp" type="text" id="valorfijoaplicaarp" /></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Valor base Aplica ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="valorbaseaplicaarp" type="text" id="valorbaseaplicaarp"></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><select name="codigoconcepto" id="codigoconcepto">
              <option value="">Seleccionar</option>
              <?php
              do {
?>
              <option value="<?php echo $row_tomatipoconcepto['codigoconcepto']?>"><?php echo $row_tomatipoconcepto['nombreconcepto']?></option>
              <?php
              } while ($row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto));
              $rows = mysql_num_rows($tomatipoconcepto);
              if($rows > 0) {
              	mysql_data_seek($tomatipoconcepto, 0);
              	$row_tomatipoconcepto = mysql_fetch_assoc($tomatipoconcepto);
              }
?>
            </select>
          </td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Semestre inicio de aplicaci&oacute;n ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="semestreinicioaplicaarp" type="text" id="semestreinicioaplicaarp" size="4" /></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Semestre final de aplicaci&oacute;n ARP<span class="Estilo4">*</span></div></td>
          <td bgcolor='#FEF7ED'><input name="semestrefinalaplicaarp" type="text" id="semestrefinalaplicaarp" size="4" /></td>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
              <input name="Guardar" type="submit" id="Guardar" value="Guardar" />
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <?php } ?>
  
<p>&nbsp;</p>
</form>

<?php 
if (isset($_POST['Guardar']) and  $_POST['masivo']=='no')
{
	//echo "entro";
	$fechaaplicaarp=date("Y-m-d H:i:s");
	$val_nombreaplicaarp=validar($_POST['nombreaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el Nombre Aplica ARP")</script>', true);
	$val_idempresadesalud=validar($_POST['idempresasalud'],"requerido",'<script language="javascript">alert("No ha ingresado la empresa de salud")</script>', true);
	$val_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el porcentaje de aplicación ARP")</script>', true);
	$val_num_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"flotante",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicación ARP")</script>', true);
	$val_numflot_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"porcentaje",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicación ARP")</script>', true);
	$val_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor fijo de aplicación ARP")</script>', true);
	$val_num_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor fijo de aplicación ARP")</script>', true);
	$val_concepto=validar($_POST['codigoconcepto'],"requerido",'<script language="javascript">alert("No ha ingresado el concepto de aplicación ARP")</script>', true);
	$val_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre inicio de aplicación ARP")</script>', true);
	$val_num_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre inicio de aplicación ARP")</script>', true);
	$val_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre final de aplicación ARP")</script>', true);
	$val_num_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre final de aplicación ARP")</script>', true);
	$val_semestres=validadosnumeros($_POST['semestreinicioaplicaarp'],$_POST['semestrefinalaplicaarp'],"mayor",'<script language="javascript">alert("El Semestre inicial de aplicación ARP no puede ser mayor al semestre final de aplicación  ARP")</script>',true);
	$val_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor base de aplicación ARP")</script>', true);
	$val_num_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor base de aplicación ARP")</script>', true);
	if($val_nombreaplicaarp==true
	and $val_idempresadesalud==true
	and $val_porcentajeaplicaarp==true
	and $val_num_porcentajeaplicaarp==true
	and $val_numflot_porcentajeaplicaarp==true
	and $val_valorfijoaplicaarp==true
	and $val_num_valorfijoaplicaarp==true
	and $val_concepto==true
	and $val_semestreinicio==true
	and $val_num_semestreinicio==true
	and $val_semestrefinal==true
	and $val_num_semestrefinal==true
	and $val_semestres==true
	and $val_valorbaseaplicaarp==true
	and $val_num_valorbaseaplicaarp==true){
		//echo "valido";
		$query_fechas_periodo = "SELECT sp.idsubperiodo,sp.fechainicioacademicosubperiodo,sp.fechafinalacademicosubperiodo,sp.fechainiciofinancierosubperiodo,sp.fechafinalfinancierosubperiodo
		FROM subperiodo sp, carreraperiodo cp
		WHERE
		cp.codigoperiodo='".$_GET['codigoperiodo']."'
		AND sp.codigoestadosubperiodo like '1%'
		AND sp.idcarreraperiodo=cp.idcarreraperiodo
		AND cp.codigocarrera='".$_POST['selcodigocarrera']."'
		";
		
		$fechas_periodo = mysql_query($query_fechas_periodo, $sala);
		$row_fechas=mysql_fetch_assoc($fechas_periodo);
		
		$query_insertar_aplicaarp="insert into aplicaarp(nombreaplicaarp,codigocarrera,codigoperiodo,idempresasalud,valorbaseaplicaarp,
			porcentajeaplicaarp,valorfijoaplicaarp,fechaaplicaarp,fechainicioaplicaarp,fechafinalaplicaarp,codigotipoaplicaarp,codigoconcepto,
			semestreinicioaplicaarp,semestrefinalaplicaarp) 
			values ('".$_POST['nombreaplicaarp']."','".$_POST['selcodigocarrera']."','".$_GET['codigoperiodo']."',
			'".$_POST['idempresasalud']."','".$_POST['valorbaseaplicaarp']."','".$_POST['porcentajeaplicaarp']."','".$_POST['valorfijoaplicaarp']."',
			'".$fechaaplicaarp."','".$row_fechas['fechainiciofinancierosubperiodo']."','".$row_fechas['fechafinalfinancierosubperiodo']."','100','".$_POST['codigoconcepto']."',
			'".$_POST['semestreinicioaplicaarp']."','".$_POST['semestrefinalaplicaarp']."')";
		//echo $query_insertar_aplicaarp;
		$insertar_aplicaarp=mysql_query($query_insertar_aplicaarp,$sala) or die ($query_insertar_aplicaarp.mysql_error());
		if($insertar_aplicaarp)
		{
			echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
			echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica']."');</script>";
		}
		else
		{
			echo $query_insertar_aplicaarp.mysql_error();
		}
	}
	else
	{
		echo "<script language='javascript'>history.go(-1);</script>";
	}
}

    ?>
  <?php 
  if (isset($_POST['Guardar']) and $_POST['masivo']=='si')
  {
  	$val_nombreaplicaarp=validar($_POST['nombreaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el Nombre Aplica ARP")</script>', true);
  	$val_idempresadesalud=validar($_POST['idempresasalud'],"requerido",'<script language="javascript">alert("No ha ingresado la empresa de salud")</script>', true);
  	$val_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el porcentaje de aplicación ARP")</script>', true);
  	$val_num_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"flotante",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicación ARP")</script>', true);
  	$val_numflot_porcentajeaplicaarp=validar($_POST['porcentajeaplicaarp'],"porcentaje",'<script language="javascript">alert("No ha ingresado correctamente el porcentaje de aplicación ARP")</script>', true);
  	$val_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor fijo de aplicación ARP")</script>', true);
  	$val_num_valorfijoaplicaarp=validar($_POST['valorfijoaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor fijo de aplicación ARP")</script>', true);
  	$val_concepto=validar($_POST['codigoconcepto'],"requerido",'<script language="javascript">alert("No ha ingresado el concepto de aplicación ARP")</script>', true);
  	$val_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre inicio de aplicación ARP")</script>', true);
  	$val_num_semestreinicio=validar($_POST['semestreinicioaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre inicio de aplicación ARP")</script>', true);
  	$val_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el semestre final de aplicación ARP")</script>', true);
  	$val_num_semestrefinal=validar($_POST['semestrefinalaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el semestre final de aplicación ARP")</script>', true);
  	$val_semestres=validadosnumeros($_POST['semestreinicioaplicaarp'],$_POST['semestrefinalaplicaarp'],'<script language="javascript">alert("El Semestre inicial de aplicación ARP no puede ser mayor al semestre final de aplicación  ARP")</script>',true);
  	$val_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"requerido",'<script language="javascript">alert("No ha ingresado el valor base de aplicación ARP")</script>', true);
  	$val_num_valorbaseaplicaarp=validar($_POST['valorbaseaplicaarp'],"numero",'<script language="javascript">alert("No ha ingresado correctamente el valor base de aplicación ARP")</script>', true);  	if($val_nombreaplicaarp==true
  	and $val_idempresadesalud==true
  	and $val_porcentajeaplicaarp==true
  	and $val_num_porcentajeaplicaarp==true
  	and $val_numflot_porcentajeaplicaarp==true
  	and $val_valorfijoaplicaarp==true
  	and $val_num_valorfijoaplicaarp==true
  	and $val_concepto==true
  	and $val_semestreinicio==true
  	and $val_num_semestreinicio==true
  	and $val_semestrefinal==true
  	and $val_num_semestrefinal==true
  	and $val_semestres==true
  	and $val_valorbaseaplicaarp==true
  	and $val_num_valorbaseaplicaarp==true){
  		mysql_select_db($database_sala, $sala);
  		$query_carrerapormodalidad_in = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera FROM carrera c
			WHERE c.codigomodalidadacademica = '".$_GET['modalidadacademica']."' 
			AND c.codigocarrera NOT IN (SELECT codigocarrera FROM aplicaarp where codigotipoaplicaarp='100')";
  		$carrerapormodalidad_in = mysql_query($query_carrerapormodalidad_in, $sala) or die($query_carrerapormodalidad_in.mysql_error());
  		$row_carrerapormodalidad_in = mysql_fetch_array($carrerapormodalidad_in);
  		$fechaaplicaarp=date("Y-m-d H:i:s");
  		do{

  			foreach($_POST as $vpost => $valor)
  			{
  				if (ereg("carreras".$row_carrerapormodalidad['codigocarrera']."",$vpost))
  				{
				
  		$query_fechas_periodo = "SELECT sp.idsubperiodo,sp.fechainicioacademicosubperiodo,sp.fechafinalacademicosubperiodo,sp.fechainiciofinancierosubperiodo,sp.fechafinalfinancierosubperiodo
		FROM subperiodo sp, carreraperiodo cp
		WHERE
		cp.codigoperiodo='".$_GET['codigoperiodo']."'
		AND sp.codigoestadosubperiodo like '1%'
		AND sp.idcarreraperiodo=cp.idcarreraperiodo
		AND cp.codigocarrera='".$_POST[$vpost]."'
		";
		//echo $query_fechas_periodo,"<br>";
		
  		$fechas_periodo = mysql_query($query_fechas_periodo, $sala);
		$row_fechas=mysql_fetch_assoc($fechas_periodo);
		
		//print_r($row_fechas);
		echo "<br>";

  					$query_insertar_aplicaarp="insert into aplicaarp(nombreaplicaarp,codigocarrera,codigoperiodo,idempresasalud,
						valorbaseaplicaarp,porcentajeaplicaarp,valorfijoaplicaarp,fechaaplicaarp,fechainicioaplicaarp,fechafinalaplicaarp,codigotipoaplicaarp,codigoconcepto,
						semestreinicioaplicaarp,semestrefinalaplicaarp) 
						values ('".$_POST['nombreaplicaarp']."','".$_POST[$vpost]."','".$_GET['codigoperiodo']."',
						'".$_POST['idempresasalud']."','".$_POST['valorbaseaplicaarp']."','".$_POST['porcentajeaplicaarp']."','".$_POST['valorfijoaplicaarp']."',
						'".$fechaaplicaarp."','".$row_fechas['fechainiciofinancierosubperiodo']."','".$row_fechas['fechafinalfinancierosubperiodo']."','100','".$_POST['codigoconcepto']."',
						'".$_POST['semestreinicioaplicaarp']."','".$_POST['semestrefinalaplicaarp']."')";
  					//echo $query_insertar_aplicaarp;echo "<br>";
  					$insertar_aplicaarp=mysql_query($query_insertar_aplicaarp,$sala)  or die ($query_insertar_aplicaarp.mysql_error());;
  					if($insertar_aplicaarp){}else{echo $query_insertar_aplicaarp.mysql_error();}
  				}
  			}
  		}
  		while ($row_carrerapormodalidad = mysql_fetch_assoc($carrerapormodalidad));
  		echo "<script language='javascript'>alert('Datos insertados correctamente')</script>";
  		echo "<script language='javascript'>window.location.reload('aplicaarpconsultar.php?codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica']."');</script>";
  	}
  	else
  	{
  		echo "<script language='javascript'>history.go(-1);</script>";
  	}
  }
    ?>
 <?php if(isset($_POST['Regresar'])){
 	echo "<script language='javascript'>window.location.reload('menu.php');</script>";
 }
?>


<?php
@mysql_free_result($sel_modalidadacademica);

@mysql_free_result($sel_codigocarrera);


?>
