﻿<?php
session_start();
//$rol=$_SESSION['rol'];
$rol=3;
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
//echo "<pre>"; print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("funciones/datos_mail.php");
function detalleobservaciones($numerodetalle,$idpreinscripcion,$objetobase,$formulario,$anular=0) 
{
 
//$_GET['idpreinscripcion']

    $query="SELECT
		ps.idpreinscripcion,
		ps.idpreinscripcionseguimiento,
		ps.observacionpreinscripcionseguimiento observacion,
		ps.fechapreinscripcionseguimiento as Fecha_Contacto,
		ps.fechahastapreinscripcionseguimiento as Fecha_Proximo_Contacto,
		if(u.usuario='wfcortes','Estudiante',u.usuario) as usuario,
		t.nombretipoestudianteseguimiento ObservacionTipo,
			if(ps.idtipodetalleestudianteseguimiento=1,t.nombretipoestudianteseguimiento,CONCAT(t.nombretipoestudianteseguimiento,' / ',tpd.nombretipodetalleestudianteseguimiento)) TipoObservacion
		FROM  usuario u, tipoestudianteseguimiento t,preinscripcionseguimiento ps
			left join tipodetalleestudianteseguimiento tpd
			on ps.idtipodetalleestudianteseguimiento=tpd.idtipodetalleestudianteseguimiento
		WHERE ps.idpreinscripcion='".$idpreinscripcion."'
		AND ps.idusuario = u.idusuario
		AND ps.codigoestado like '1%'
		AND t.codigotipoestudianteseguimiento=ps.codigotipoestudianteseguimiento
		order by idpreinscripcionseguimiento desc
		";
        
        /*print_r($query);
        exit();*/
    $operacionquery=$objetobase->conexion->PageExecute($query, $numerodetalle, 1,false);
    $formulario->dibujar_fila_titulo('Ultimas Observaciones','labelresaltado',4);
    echo "<tr><td colspan='6' align='center'><table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
    $fila["Tipo_De_Observacion"]="";
    $fila["Observacion"]="";				
    $fila["Asesora"]="";
    $fila["Fecha_Contacto"]="";
    $fila["Fecha_Proximo_Contacto"]="";
    //if($anular)
    //$fila["Anular"]="";				//
    $formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);

    $i=0;
    while($datosregistrogrado=$operacionquery->fetchRow()) {
        unset($fila);
        $fila[$datosregistrogrado["TipoObservacion"]]="";
        $fila[$datosregistrogrado["observacion"]]="";				

        $fila[$datosregistrogrado["usuario"]]="";
        $fila[formato_fecha_defecto($datosregistrogrado["Fecha_Contacto"])]="";
        $fila[formato_fecha_defecto($datosregistrogrado["Fecha_Proximo_Contacto"])."."]="";

        //$botonanular="<input type='submit' name='Anular' id='Anular' value='Anular' onclick='envioanula(".$datosregistrogrado["idestudianteseguimiento"].",".$datosregistrogrado["codigoestudiante"].")'>";
        //if($anular)
        //$fila[$botonanular]="";				

        $formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
    }
    echo "</table></td></tr>";
}//fin de funcion detalle observacion

if(isset($_GET['link_origen'])&& (trim($_GET['link_origen'])!='')) {
    $_SESSION['link_origen_preinscripscionseguimiento']=$_GET['link_origen'];
}
?>
<script LANGUAGE="JavaScript">
    function quitarFrame()
    {
        if (self.parent.frames.length != 0)
            self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

    }
    function regresarGET()
    {
<?php
if(!isset($_SESSION['sesion_linkorigen'])) {
    ?>
            document.location.href="<?php echo $_SESSION['link_origen_preinscripscionseguimiento']?>";
    <?php
}
else {
    $_SESSION['link_origen_preinscripscionseguimiento'] = "../../estadisticas/matriculasnew/estadisticas_matriculas_detalle.php?".$_SESSION['sesion_linkorigen'];
    ?>
            document.location.href="<?php echo "../../estadisticas/matriculasnew/estadisticas_matriculas_detalle.php?".$_SESSION['sesion_linkorigen'];?>";
    <?php
}
?>
    }
    function Verificacion()
    {
        if(confirm('Seleccionó anular el registro. ¿Desea continuar?'))
        {
            document.form1.AnularOK.value="OK";
            document.form1.submit();
        }
    }
    function enviarmenu(){
        var formulario=document.getElementById("form1");
        formulario.action="preinscripcion_seguimiento.php#menu";
        formulario.submit();
    }
	


</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<?php
$fechahoy=date("Y-m-d H:i:s");
$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulario($sala,'form1','post','','true');
$formularioseguimiento=new formulariobaseestudiante($sala,'form1','post','','true');

if($_REQUEST['depurar']=="si") {
    $depurar=new SADebug();
    $depurar->trace($formulario,'','');
    $formulario->depurar();
}
$codigoperiodo=$formulario->carga_periodo(4);
//echo "<H1>PERIODO=".$codigoperiodo."</H1>";
$formulario->agregar_tablas('preinscripcion','idpreinscripcion');
if($_REQUEST['observacionpreinscripcionseguimiento']!="") {
    $formulario->agregar_tablas('preinscripcionseguimiento','idpreinscripcionseguimiento',NULL,true);
}
if($_SESSION['MM_Username']!="") {
    $usuario=$formulario->datos_usuario();
}
$ip=$formulario->GetIP();
//carga el formulario
if(isset($_GET['idpreinscripcion']) and $_GET['idpreinscripcion']!="") {
    $_SESSION['idpreinscripcionformulariointeresado']=$_GET['idpreinscripcion'];
}

if(isset($_SESSION['idpreinscripcionformulariointeresado']) and $_SESSION['idpreinscripcionformulariointeresado']!="") {
    $formulario->limites_flechas_tabla_padre_hijo('preinscripcion','preinscripcionseguimiento','idpreinscripcion','idpreinscripcionseguimiento',$_SESSION['idpreinscripcionformulariointeresado']);
    //solo carga un id de la tabla hijo, porque no hay varios seguimientos
    //muestra flechas si aplica
    $maximo=count($_SESSION['array_flechas_tabla_padre_hijo']);
    if($maximo == 1) {
        $formulario->iterar_flechas_tabla_padre_hijo();
        $formulario->cargar_distintivo_condicional('preinscripcion','idpreinscripcion',$_SESSION['idpreinscripcionformulariointeresado'],'codigoestado=100');
        $formulario->cargar_distintivo_condicional_true('preinscripcionseguimiento','idpreinscripcionseguimiento',$_SESSION['contador_flechas'],'codigoestado=100','idpreinscripcion',$_SESSION['idpreinscripcionformulariointeresado']);
    }
    //carga las tablas de manera distintiva, porque hay varios seguimientos
    elseif($maximo >1) {
        $formulario->iterar_flechas_tabla_padre_hijo();
        $formulario->cargar_distintivo_condicional('preinscripcion','idpreinscripcion',$_SESSION['idpreinscripcionformulariointeresado'],'codigoestado=100');
        $formulario->cargar_distintivo_condicional('preinscripcionseguimiento','idpreinscripcionseguimiento',$_SESSION['contador_flechas'],'codigoestado=100','idpreinscripcion',$_SESSION['idpreinscripcionformulariointeresado']);
    }
    $formulario->cambiar_estado('preinscripcion','codigoestado',200,"<script language='javascript'>window.location.href='".$_SESSION['link_origen_preinscripscionseguimiento']."'</script>");
}
else {
    $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'ip','valor'=>$ip);
    $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'codigoestado','valor'=>'100');
    $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'idusuario','valor'=>'1');
    $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'fechapreinscripcion','valor'=>$fechahoy);
    $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'codigoperiodo','valor'=>$codigoperiodo);
    $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'codigoindicadorenvioemailacudientepreinscripcion','valor'=>'100');
}
$codigotipoestudianteseguimiento=$_POST["codigotipoestudianteseguimiento"];
$idtipodetalleestudianteseguimiento=$_POST["idtipodetalleestudianteseguimiento"];

//		$idestudianteseguimiento=$_POST["idestudianteseguimiento"];

?>

<form name="form1" action="" method="POST" id="form1">
    <input type="hidden" name="AnularOK" value="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <caption align="left"><p>
                <?php if(isset($_SESSION['idpreinscripcionformulariointeresado'])) {?>
            <tr>
                <td id="tdtitulogris">Fecha diligenciamiento</td>
                <td><?php echo $formulario->array_datos_cargados['preinscripcion']->fechapreinscripcion?></td>
            </tr>
                <?php }?>
	Registre aquí sus datos personales</p></caption>
        <tr>
            <td colspan="2"><label id="labelresaltado">Datos Obligatorios</label></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('idtrato','Trato','requerido');?></td>
            <td><?php $formulario->combo('idtrato','preinscripcion','post','trato','idtrato','nombretrato',"",'nombretrato','','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('nombresestudiante','Nombre','requerido');?></td>
            <td><?php $formulario->campotexto('nombresestudiante','preinscripcion',50,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('apellidosestudiante',"Apellidos",'requerido');?></td>
            <td><?php $formulario->campotexto('apellidosestudiante','preinscripcion',50,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('emailestudiante','E-mail','');
                $formulario->asterisco('emailestudiante');
                if($_POST['emailestudiante']!="") {
                    $mailvalido=validaciongenerica($_POST['emailestudiante'],'email','',true);
                    if($mailvalido['valido']==0) {
                        $formulario->agregar_validaciones_extra('emailestudiante','email',false,'El mail se encuentra mal digitado');
                    }
                }
                ?></td>
            <td><?php $formulario->campotexto('emailestudiante','preinscripcion',30,'','','','');?><label id="labelresaltado">(Se requiere el E-mail o el Teléfono)</label></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php
                $formulario->etiqueta('telefonoestudiante','Teléfono','');
                $formulario->asterisco('telefonoestudiante');?></td>
            <td><?php $formulario->campotexto('telefonoestudiante','preinscripcion',10,'','','','');?><label id="labelresaltado">(Se requiere el E-mail o el Teléfono)</label></td>
        </tr>
        <tr>
            <td colspan="2"><label id="labelresaltado">Datos opcionales</label></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('tipodocumento','Tipo de documento','');?></td>
            <td><?php $formulario->combo('tipodocumento','preinscripcion','post','documento','tipodocumento','nombredocumento','','nombredocumento','','','','');?></td>
        </tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('numerodocumento','Número documento','');?></td>
        <td><?php $formulario->campotexto('numerodocumento','preinscripcion',20,'','','','');?></td>
        </td>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('expedidodocumento','Expedido en','');?></td>
            <td><?php $formulario->campotexto('expedidodocumento','preinscripcion',20,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('celularestudiante','Celular','');?></td>
            <td><?php $formulario->campotexto('celularestudiante','preinscripcion',10,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('direccionestudiante','Dirección','');?></td>
            <td><?php $formulario->campotexto('direccionestudiante','preinscripcion',40,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('barrioestudiante','Barrio','');?></td>
            <td><?php $formulario->campotexto('barrioestudiante','preinscripcion',20,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('ciudadestudiante','Ciudad','');?></td>
            <td><?php $formulario->combo('ciudadestudiante','preinscripcion','post','ciudad','idciudad','nombreciudad','','nombreciudad','','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('institucionpreinscripcionestudiante','Colegio','');?></td>
            <td><?php $formulario->campotexto('institucionpreinscripcionestudiante','preinscripcion',50,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('gradoestudiante','Grado','');?></td>
            <td><?php $formulario->campotexto('gradoestudiante','preinscripcion',5,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('codigocalendarioestudiante','Calendario','');?></td>
            <td><?php $formulario->combo('codigocalendarioestudiante','preinscripcion','post','calendarioestudiante','codigocalendarioestudiante','nombrecalendarioestudiante','','nombrecalendarioestudiante','','','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('nombreacudientepreinscripcion','Nombre acudiente','');?></td>
            <td><?php $formulario->campotexto('nombreacudientepreinscripcion','preinscripcion',50,'','','','');?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('emailacudientepreinscripcion','Email acudiente','email_norequerido');?></td>
            <td><?php $formulario->campotexto('emailacudientepreinscripcion','preinscripcion',20);?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('telefonoacudientepreinscripcion','Teléfono acudiente','');?></td>
            <td><?php $formulario->campotexto('telefonoacudientepreinscripcion','preinscripcion',10);?></td>
        </tr>
        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('celularacudientepreinscripcion','Celular acudiente','');?></td>
            <td><?php $formulario->campotexto('celularacudientepreinscripcion','preinscripcion',10);?><a name='menu' ></a></td>
        </tr>
        <tr><!--</tr>
                <td id="tdtitulogris"><?php //$formulario->etiqueta('codigoestadopreinscripcionestudiante','Tipo Observación','requerido');?></td>
                <td><?php //$formulario->combo('codigoestadopreinscripcionestudiante','preinscripcion','post','estadopreinscripcionestudiante','codigoestadopreinscripcionestudiante','nombreestadopreinscripcionestudiante','','nombreestadopreinscripcionestudiante');?></td>
	</tr>-->
            <?php
			detalleobservaciones(5,$_GET['idpreinscripcion'],$objetobase,$formularioseguimiento,1);
			
            $campo = "campo_fecha";
            $parametros ="'text','fechahastapreinscripcionseguimiento','".$_POST['fechahastapreinscripcionseguimiento']."','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
            $formularioseguimiento->dibujar_campo($campo,$parametros,"Fecha Proximo Contacto","tdtitulogris",'fechahastapreinscripcionseguimiento','requerido');

            $parametros="'hidden','codigoestadopreinscripcionestudiante','110'";
            $formularioseguimiento->dibujar_campo('boton_tipo',$parametros,"","tdtitulogris",'codigoestadopreinscripcionestudiante');
            $condicion="codigoestado='100'";
            $formularioseguimiento->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoestudianteseguimiento","codigotipoestudianteseguimiento","nombretipoestudianteseguimiento",$condicion);
            $campo='menu_fila';
            $parametros="'codigotipoestudianteseguimiento','".$codigotipoestudianteseguimiento."','onchange=\'enviarmenu();\''";
			
			$formularioseguimiento->dibujar_campo($campo,$parametros,"Tipo Observación","tdtitulogris",'codigotipoestudianteseguimiento','');

            $condicion=" codigoestado='100'
					and codigotipoestudianteseguimiento='".$codigotipoestudianteseguimiento."'";
            $formularioseguimiento->filatmp=$objetobase->recuperar_datos_tabla_fila("tipodetalleestudianteseguimiento","idtipodetalleestudianteseguimiento","nombretipodetalleestudianteseguimiento",$condicion);
            if(is_array($formularioseguimiento->filatmp)) {
                $campo='menu_fila';
                $parametros="'idtipodetalleestudianteseguimiento','".$idtipodetalleestudianteseguimiento."',''";
                $formularioseguimiento->dibujar_campo($campo,$parametros,"Tipo Detalle Observacion","tdtitulogris",'idtipodetalleestudianteseguimiento','');
            }


            $campo="memo";
            $parametros="'observacionpreinscripcionseguimiento','estudianteseguimiento',70,8,'','','',''";
            $formularioseguimiento->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'observacionpreinscripcionseguimiento');
            $formularioseguimiento->cambiar_valor_campo('observacionpreinscripcionseguimiento',$observacionpreinscripcionseguimiento);
            $parametrobotonventanaemergente="'Historial','listado_seguimiento.php','idpreinscripcion=".$_SESSION['idpreinscripcionformulariointeresado']."',700,300,300,150,'yes','yes','no','yes','no'";
            $formularioseguimiento->dibujar_campo('boton_ventana_emergente',$parametrobotonventanaemergente,"","tdtitulogris",'observacionaspiranteseguimiento');
			
            ?>
			
		

<!--<tr>
    <td id="tdtitulogris">
            <?php $formulario->etiqueta('observacionpreinscripcionseguimiento','Observación','');?></td>
    <td>
            <?php $formulario->boton_ventana_emergente('Historial','listado_seguimiento.php','idpreinscripcion='.$_SESSION['idpreinscripcionformulariointeresado'].'',700,300,300,150,'yes','yes','no','yes','no');?>
		</td>
	</tr>-->

        <tr>
            <td id="tdtitulogris"><?php $formulario->etiqueta('codigomodalidadacademica','Modalidad académica','');?></td>
            <td><?php $formulario->combo_valor_por_defecto('codigomodalidadacademica','','','modalidadacademica','codigomodalidadacademica','nombremodalidadacademica','200','codigoestado=100','nombremodalidadacademica','onChange=enviar()','','','La naturaleza de la carrera')?></td>
        </tr>
    </table>
    <br>
    <?php
//mostrar flechas

    if(isset($_POST['codigomodalidadacademica'])) {
       /*$query_carrera="
	SELECT DISTINCT c.codigocarrera, c.nombrecarrera
	FROM carrera c, carreragrupofechainscripcion cgfi
	WHERE
	c.codigocarrera=cgfi.codigocarrera
	AND '$fechahoy '<= cgfi.fechahastacarreragrupofechainformacion
	AND c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
        and cgfi.idcarreragrupofechainscripcion = (
            SELECT max(cgfi.idcarreragrupofechainscripcion)
            FROM carrera c2, carreragrupofechainscripcion cgfi2
            WHERE
            c2.codigocarrera=cgfi2.codigocarrera
            AND '$fechahoy '<= cgfi2.fechahastacarreragrupofechainformacion
            AND c2.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
            AND c2.codigocarrera <> 1
        )
	AND c.codigocarrera <> 1
	ORDER BY c.nombrecarrera
	";*/
    /*$query_carrera="
	SELECT DISTINCT c.codigocarrera, c.nombrecarrera
	FROM carrera c, carreragrupofechainscripcion cgfi
	WHERE
	c.codigocarrera=cgfi.codigocarrera
	AND  cgfi.fechadesdecarreragrupofechainscripcion >= '$fechahoy' 
	AND cgfi.fechahastacarreragrupofechainscripcion <= '$fechahoy '
	AND c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
	AND c.codigocarrera <> 1
	ORDER BY c.nombrecarrera
	";*/
	$query_carrera="
	SELECT DISTINCT c.codigocarrera, c.nombrecarrera
	FROM carrera c, carreragrupofechainscripcion cgfi
	WHERE
	c.codigocarrera=cgfi.codigocarrera
	AND  cgfi.fechahastacarreragrupofechainformacion <='$fechahoy '
        and cgfi.idcarreragrupofechainscripcion =
        (
            SELECT max(cgfi.idcarreragrupofechainscripcion)
            FROM carrera c2, carreragrupofechainscripcion cgfi2
            WHERE
            c2.codigocarrera=cgfi2.codigocarrera
            AND cgfi2.fechahastacarreragrupofechainformacion <='$fechahoy '
            AND c2.codigomodalidadacademica=200
            AND c2.codigocarrera <> 1
        )
	AND c.codigomodalidadacademica=200
	AND c.codigocarrera <> 1
	ORDER BY c.nombrecarrera
                ";
	
	
	$formulario->cuadro_chulitos_bd_query($query_carrera,'Marca aquí las carreras de tu interés','carrera','','','nombrecarrera','codigocarrera','nombrecarrera','preinscripcioncarrera','idpreinscripcioncarrera','codigoestado',100,200,2,"750","wrap");
    
	}
	else{
		
    $query_carrera="
	SELECT DISTINCT c.codigocarrera, c.nombrecarrera
	FROM carrera c, carreragrupofechainscripcion cgfi
	WHERE
	c.codigocarrera=cgfi.codigocarrera
	AND  cgfi.fechahastacarreragrupofechainformacion <='$fechahoy '
        and cgfi.idcarreragrupofechainscripcion =
        (
            SELECT max(cgfi.idcarreragrupofechainscripcion)
            FROM carrera c2, carreragrupofechainscripcion cgfi2
            WHERE
            c2.codigocarrera=cgfi2.codigocarrera
            AND cgfi2.fechahastacarreragrupofechainformacion <='$fechahoy '
            AND c2.codigomodalidadacademica=200
            AND c2.codigocarrera <> 1
        )
	AND c.codigomodalidadacademica=200
	AND c.codigocarrera <> 1
	ORDER BY c.nombrecarrera
                ";
      
		$formulario->cuadro_chulitos_bd_query($query_carrera,'Marca aquí las carreras de tu interés... ','carrera','','','nombrecarrera','codigocarrera','nombrecarrera','preinscripcioncarrera','idpreinscripcioncarrera','codigoestado',100,200,2,"750","wrap");
    
	}

    ?>
    <br>
	
    <?php
    if($_SESSION['rol']=='3') {
        $formulario->cuadro_chulitos_bd('Marque aquí el medio por el cual se enteró','mediocomunicacion','codigoestado=100 and codigomediocomunicacionpadre<>0','nombremediocomunicacion','codigomediocomunicacion','nombremediocomunicacion','preinscripcionmediocomunicacion','idpreinscripcionmediocomunicacion','codigoestado',100,200,4,"750","nowrap");
    }
    ?>
     <input type="submit" name="Enviar" value="Enviar">
    <?php
    $cantidad_llamadas_cuadro_chulitos=2;
    if($_SESSION['rol']==3) {
        echo '<input type="button" name="Regresar" value="Regresar" onClick="regresarGET()">';

    }
    ?>
    <?php if(isset($_SESSION['idpreinscripcionformulariointeresado'])) {
        echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
    }
    ?>
    <?php
    if(isset($_REQUEST['Enviar'])) {
        $formulario->submitir();

        if($_POST['tipodocumento']=="") {
            $formulario->agregar_datos_formulario('preinscripcion','tipodocumento','0');
        }

        if($_POST['codigocalendarioestudiante']=="") {
            $formulario->agregar_datos_formulario('preinscripcion','codigocalendarioestudiante','0');
        }

        if($_POST['telefonoestudiante']=="" and $_POST['emailestudiante']=="") {
            $formulario->agregar_validaciones_extra('telefono_mail','requerido',false,'Teléfono e E-mail');
        }

        $formulario->valida_formulario();
        if($_REQUEST['observacionpreinscripcionseguimiento']!="" or isset($_SESSION['idpreinscripcionformulariointeresado'])) {
            $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'fechapreinscripcionseguimiento','valor'=>$fechahoy);
            if($_SESSION['MM_Username']!="") {
                $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'idusuario','valor'=>$usuario['idusuario']);
            }
            else {
                $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'idusuario','valor'=>'1');
            }
            $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigoestado','valor'=>100);
        }
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigotipoestudianteseguimiento','valor'=>$_POST['codigotipoestudianteseguimiento']);
        if(isset($_POST['idtipodetalleestudianteseguimiento'])&&trim($_POST['idtipodetalleestudianteseguimiento'])!='')
            $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'idtipodetalleestudianteseguimiento','valor'=>$_POST['idtipodetalleestudianteseguimiento']);

        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'idpreinscripcion','valor'=>$_SESSION['idpreinscripcionformulariointeresado']); // ESTA LINEA SE AGREGÓ LUEGO DE HACER LA MIGRACIÓN DE PHP4 A PHP5, SIN ESTA LINEA LA APLICACIÓN NO ES CAPAZ DE LLEVAR ESTE VALOR HASTA LA PARTE DE INSERCIÓN.
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigoestadopreinscripcionestudiante','valor'=>$_POST['codigoestadopreinscripcionestudiante']);
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'observacionpreinscripcionseguimiento','valor'=>$_POST['observacionpreinscripcionseguimiento']);
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'fechahastapreinscripcionseguimiento','valor'=>formato_fecha_mysql($_POST['fechahastapreinscripcionseguimiento']));
        //$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'fechahastapreinscripcionseguimiento','valor'=>$_POST['fechahastapreinscripcionseguimiento']);

        if((!(isset($_SESSION['sesioncodigoprocesovidaestudiante'])))||($_SESSION['sesioncodigoprocesovidaestudiante']==''))
            $_SESSION['sesioncodigoprocesovidaestudiante']='100';

        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigoprocesovidaestudiante','valor'=>$_SESSION['sesioncodigoprocesovidaestudiante']);
        $ids=$formulario->insertar("<script language='javascript'>eliminarFrame('".$_SESSION['link_origen_preinscripscionseguimiento']."')</script>","<script language='javascript'>window.location.href='".$_SESSION['link_origen_preinscripscionseguimiento']."'</script>");
        //$ids=$formulario->insertar('','');
        $datos_sql_preinscripcioncarrera[]=array('campo'=>'idpreinscripcion','valor'=>$_SESSION['idpreinscripcionformulariointeresado']);
        $datos_sql_preinscripcioncarrera[]=array('campo'=>'codigoestado','valor'=>100);
        $formulario->sql_cuadro_chulitos_bd_query($datos_sql_preinscripcioncarrera,'preinscripcioncarrera','codigocarrera','codigoestado',100,200,$cantidad_llamadas_cuadro_chulitos,"<script language='javascript'>quitarFrame()</script>","<script language='javascript'>window.location.href='".$_SESSION['link_origen_preinscripscionseguimiento']."'</script>");
        $datos_sql_preinscripcionmediocomunicacion[]=array('campo'=>'idpreinscripcion','valor'=>'');//porque se mezclan el sql_cuadro_chulitos_bd_query con el sql_cuadro_chulitos_bd
        $datos_sql_preinscripcionmediocomunicacion[]=array('campo'=>'codigoestado','valor'=>100);
        $formulario->sql_cuadro_chulitos_bd($datos_sql_preinscripcionmediocomunicacion,'preinscripcionmediocomunicacion','codigomediocomunicacion','codigoestado',100,200,$cantidad_llamadas_cuadro_chulitos,"<script language='javascript'>quitarFrame()</script>","<script language='javascript'>window.location.href='".$_SESSION['link_origen_preinscripscionseguimiento']."'</script>");

    }
    ?>
</form>
<?php
if($_REQUEST['depurar']=="si") {
    $depurar2=new SADebug();
    $depurar2->trace($formulario,'','');
    $formulario->depurar();
}
?>
