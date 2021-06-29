<? 
session_start();
require_once("../../../templates/template.php");
$db = getBD();
$utils = new Utils_datos();
if($_REQUEST['semestre']) {
	$query="select	 sch1.clasificacionesinfhuerfana
			,sbu.pregrado
			,sbu.posgrado
			,sbu.egresados
			,sbu.docentes
			,sbu.administrativos
			,sbu.familiares
			,sbu.encuentros_presentacion_oficiales
			,sbu.beneficiarios_comunidades
		from siq_bienestaruniversitario sbu 
		join siq_clasificacionesinfhuerfana sch1 using(idclasificacionesinfhuerfana) 
		join siq_clasificacionesinfhuerfana sch2 on sch1.idpadreclasificacionesinfhuerfana=sch2.idclasificacionesinfhuerfana
		where sbu.semestre=".$_REQUEST['semestre']." and sch2.aliasclasificacionesinfhuerfana='".$_REQUEST['alias']."'";
	$exec= $db->Execute($query);
	if($exec->RecordCount()==0) {
?>
<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el semestre <?=$_REQUEST['semestre']?></p></div>

<?
	} else {
?>
                <table align="center" class="formData last" width="92%">
			<tr id="dataColumns">
				<th colspan="8" style="font-size:20px"><?=$_REQUEST['semestre']?></th>               
			</tr>
			<tr class="dataColumns category">
				<th rowspan="2" class="borderR">Servicio o actividad</th>               
				<th colspan="3" class="borderR">Estudiantes</th>               
				<th rowspan="2" class="borderR">Docentes</th>               
				<th rowspan="2" class="borderR">Administrativos</th>
<?
				if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eads' || $_REQUEST['alias']=='eadcyr') {
?>
					<th rowspan="2" class="borderR">Familiares</th>
<?
				}
				if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eadcyr' || $_REQUEST['alias']=='edvu') {
?>
					<th rowspan="2" class="borderR">Nro. de encuentros o presentaciones oficiales</th>
<?
				}
				if($_REQUEST['alias']=='edvu') {
?>
					<th rowspan="2">Beneficiarios comunidad</th>
<?
				}
?>
			</tr>
			<tr class="dataColumns category">
				<th>Pregado</th>               
				<th>Posgrado</th>
				<th class="borderR">Egresados</th>
			</tr>
<?
			$sum_pregrado=0;
			$sum_posgrado=0;
			$sum_egresados=0;
			$sum_docentes=0;
			$sum_administrativos=0;
			$sum_familiares=0;
			$sum_encuentros_presentacion_oficiales=0;
			$sum_beneficiarios_comunidades=0;
			while($row = $exec->FetchRow()) {
?>
				<tr id="contentColumns" class="row">
					<td class="column borderR"><?=$row['clasificacionesinfhuerfana']?></td>
					<td class="column " align="center"><?=$row['pregrado']?></td>
					<td class="column " align="center"><?=$row['posgrado']?></td>
					<td class="column borderR" align="center"><?=$row['egresados']?></td>
					<td class="column borderR" align="center"><?=$row['docentes']?></td>
					<td class="column borderR" align="center"><?=$row['administrativos']?></td>
<?
					if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eads' || $_REQUEST['alias']=='eadcyr') {
?>
						<td class="column borderR" align="center"><?=$row['familiares']?></td>
<?
					}
					if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eadcyr' || $_REQUEST['alias']=='edvu') {
?>
						<td class="column borderR" align="center"><?=$row['encuentros_presentacion_oficiales']?></td>
<?
					}
					if($_REQUEST['alias']=='edvu') {
?>
						<td class="column" align="center"><?=$row['beneficiarios_comunidades']?></td>
<?
					}
?>
				</tr>
<?
				$sum_pregrado+=$row['pregrado'];
				$sum_posgrado+=$row['posgrado'];
				$sum_egresados+=$row['egresados'];
				$sum_docentes+=$row['docentes'];
				$sum_administrativos+=$row['administrativos'];
				$sum_familiares+=$row['familiares'];
				$sum_encuentros_presentacion_oficiales+=$row['encuentros_presentacion_oficiales'];
				$sum_beneficiarios_comunidades+=$row['beneficiarios_comunidades'];
			} 
?>
			<tr>
				<th class="borderR">Total</th>
				<th ><?=$sum_pregrado?></th>
				<th ><?=$sum_posgrado?></th>
				<th class="borderR"><?=$sum_egresados?></th>
				<th class="borderR"><?=$sum_docentes?></th>
				<th class="borderR"><?=$sum_administrativos?></th>
<?
				if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eads' || $_REQUEST['alias']=='eadcyr') {
?>
					<th class="borderR"><?=$sum_familiares?></th>
<?
				}
				if($_REQUEST['alias']=='eaddiaf' || $_REQUEST['alias']=='eadcyr' || $_REQUEST['alias']=='edvu') {
?>
					<th class="borderR"><?=$sum_encuentros_presentacion_oficiales?></th>
<?
				}
				if($_REQUEST['alias']=='edvu') {
?>
					<th><?=$sum_beneficiarios_comunidades?></th>
<?
				}
?>
			</tr>
		</table>
<?
	}
	exit;
}
?>
<form action="" method="post" id="form3<?=$_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>
<?
			if($_REQUEST['alias']=='eaddiaf')
				echo "Estadísticas área de deportes y actividad física";
			if($_REQUEST['alias']=='eads')
				echo "Estadísticas área de salud";
			if($_REQUEST['alias']=='eadcyr')
				echo "Estadísticas área de cultura y recreación";
			if($_REQUEST['alias']=='edvu')
				echo "Estadísticas de voluntariado universitario";
?>
		</legend>
		<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"semestre"); ?>
		<input type="hidden" name="alias" value="<?=$_REQUEST['alias']?>" />
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form3<?=$_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form3<?=$_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: 'formularios/proyeccionSocial/viewBienestarUniversitarioConsulta.php',
				async: false,
				data: $('#form3<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form3<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
