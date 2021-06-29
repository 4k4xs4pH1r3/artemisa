<?PHP  
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 

$actionID = $_REQUEST["actionID"];
switch($actionID){
	case 'Rechazar':{
		require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		$userid=$Usario_id->fields['id'];
		
		$id       = $_GET['id'];
		$estado   = $_GET['estado'];	
		$Tipo     = $_GET['Tipo'];			   
		$doc_id   = $_GET['doc_id'];
		
		#####################################
		
		if($estado==1){
			####################################################
			
				   $SQL_VF='SELECT  
		
								
						    version_final,
							rechazado
						
							FROM 
							
							siq_archivo_documento
							
							WHERE
							
							tipo_documento="'.$Tipo.'"
							AND
							siq_documento_id="'.$doc_id.'"
							AND
							codigoestado=100
							AND
							idsiq_archivodocumento="'.$id.'"';
			
		if($Result_VF=&$db->Execute($SQL_VF)===false){
				$a_vectt['val']			='FALSE';
				$a_vectt['descrip']		='Error en el SQl de los Version final...<br>'.$SQL_VF;
				echo json_encode($a_vectt);
				exit;
			}
		
		
		if(!$Result_VF->EOF){
				
				if($Result_VF->fields['version_final']==1){
				
						$a_vectt['val']			='EXISTE';
						#$a_vectt['descrip']		='Error en el SQl de los Version final...<br>'.$SQL_VF;
						echo json_encode($a_vectt);
						exit;
				}
				
				if($Result_VF->fields['version_final']==0 && $Result_VF->fields['rechazado']==0){
					
					
				     $SQL_Update_VF='UPDATE siq_archivo_documento
									 SET    rechazado="'.$estado.'" , changedate=NOW(), userid_estado="'.$userid.'"
									 WHERE  idsiq_archivodocumento="'.$id.'"  AND  codigoestado=100 ';
								
								if($Version_Final=&$db->Execute($SQL_Update_VF)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
										echo json_encode($a_vectt);
										exit;
									}
									
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
					echo json_encode($a_vectt);
					exit;
					
					}	
				
			}else{
				
				
				
				     $SQL_Update_VF='UPDATE siq_archivo_documento
									 SET    rechazado="'.$estado.'" , changedate=NOW(), userid_estado="'.$userid.'"
									 WHERE  idsiq_archivodocumento="'.$id.'"  AND  codigoestado=100 ';
								
								if($Version_Final=&$db->Execute($SQL_Update_VF)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
										echo json_encode($a_vectt);
										exit;
									}
									
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
					echo json_encode($a_vectt);
					exit;
				
				}
			
			#####################################################
			}else{
				
					$SQL_Update_VF='UPDATE siq_archivo_documento
									 SET    rechazado="'.$estado.'" , changedate=NOW(), userid_estado="'.$userid.'"
									 WHERE  idsiq_archivodocumento="'.$id.'"  AND  codigoestado=100 ';
								
								if($Version_Final=&$db->Execute($SQL_Update_VF)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
										echo json_encode($a_vectt);
										exit;
									}
									
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
					echo json_encode($a_vectt);
					exit;
				
				}
			
		}break;
	case 'Modificar_New':{
		global $db, $C_Documento_Ver,$userid;
		
		MainGeneral();
		JsGeneral();
		$C_Documento_Ver->Modificar_New($_REQUEST['Docuemto_id'],$_REQUEST['Fecha_ini'],$_REQUEST['Fecha_fin']);
		}break;
	case 'Ver':{
		global $db, $C_Documento_Ver,$userid;
		
		MainGeneral();
		JsGeneral();
		
		$C_Documento_Ver->Ver($_REQUEST['Docuemto_id'],$_REQUEST['VF'],$_REQUEST['RH'],$_REQUEST['Fecha_ini'],$_REQUEST['Fecha_fin']);
		}break;
	case 'NuevoModificar':{
		global $db, $C_Documento_Ver,$userid,$C_Utils_monitoreo;
		
		MainGeneral();
		JsGeneral();
		$C_Documento_Ver->New_Modificar($_REQUEST['Docuemto_id']);
		}break;
	case 'Modificar_UP':{
		global $db, $C_Documento_Ver,$userid;
		
		
		MainGeneral();
		JsGeneral();
		
		
		$idForm  = $_REQUEST['idFormulario'];
                $numTab  = $_REQUEST['tab'];
                $periodo  = $_REQUEST['periodo'];
		
		$SQL_D='SELECT idsiq_documento_infoHuerfana FROM siq_documento_infoHuerfana WHERE idFormulario="'.$idForm.'"  AND numPestana="'.$numTab.'" AND periodo="'.$periodo.'" AND codigoestado=100';
		
		if($Result=&$db->Execute($SQL_D)===false){
				echo 'Error en el SQL De buscar el Documento...<br>'.$SQL_D;
				die;
			}
		
		$C_Documento_Ver->Principal($Result->fields['idsiq_documento'],$idForm,$numTab,$periodo);
		
		
		}break;
	case 'Version_final':{
		
		require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		$userid=$Usario_id->fields['id'];
		
		$id       = $_GET['id'];
		$estado   = $_GET['estado'];	
		$Tipo     = $_GET['Tipo'];			   
		$doc_id   = $_GET['doc_id'];
		
		#####################################
		
		if($estado==1 && $Tipo!=3){
				
								  $SQL_VFr='SELECT  
		
								
											version_final,
											rechazado
											
											FROM 
											
											siq_archivo_documento
											
											WHERE
											
											tipo_documento="'.$Tipo.'"
											AND
											siq_documento_id="'.$doc_id.'"
											AND
											codigoestado=100
											AND
											idsiq_archivodocumento="'.$id.'"';
								
							if($Result_Version=&$db->Execute($SQL_VFr)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en el SQl de los Version final...<br>'.$SQL_VF;
									echo json_encode($a_vectt);
									exit;
								}
								
			
	
								
		 
		  
	if(!$Result_Version->EOF){	  
		  
				if($Result_Version->fields['version_final']==1){
					$a_vectt['val']			='EXISTE';
					#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
					echo json_encode($a_vectt);
					exit;
				}
				if($Result_Version->fields['version_final']==0 && $Result_Version->fields['rechazado']==1){
					$a_vectt['val']			='NODEBE';
					#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
					echo json_encode($a_vectt);
					exit;
				}
				if($Result_Version->fields['version_final']==0 && $Result_Version->fields['rechazado']==0){
			
			
				 $SQL_Update_VF='UPDATE siq_archivo_documento
								 SET    version_final="'.$estado.'" , changedate=NOW(), userid_estado="'.$userid.'"
								 WHERE  idsiq_archivodocumento="'.$id.'"  AND  codigoestado=100 ';
							
							if($Version_Final=&$db->Execute($SQL_Update_VF)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
									echo json_encode($a_vectt);
									exit;
								}
								
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
				echo json_encode($a_vectt);
				exit;
				
				}	
	}else{ 
		
			     $SQL_Update_VF='UPDATE siq_archivo_documento
								 SET    version_final="'.$estado.'" , changedate=NOW(), userid_estado="'.$userid.'"
								 WHERE  idsiq_archivodocumento="'.$id.'"  AND  codigoestado=100 ';
							
							if($Version_Final=&$db->Execute($SQL_Update_VF)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
									echo json_encode($a_vectt);
									exit;
								}
								
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
				echo json_encode($a_vectt);
				exit;
		
		}
				
			}else{
					
				     $SQL_Update_VF='UPDATE siq_archivo_documento
									 SET    version_final="'.$estado.'" , changedate=NOW(), userid_estado="'.$userid.'"
									 WHERE  idsiq_archivodocumento="'.$id.'"  AND  codigoestado=100 ';
								
								if($Version_Final=&$db->Execute($SQL_Update_VF)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
										echo json_encode($a_vectt);
										exit;
									}
									
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error al Cambiar el estado de la version final....<br>'.$SQL_Update_VF;
					echo json_encode($a_vectt);
					exit;	
				
				}
			
		}break;
	case 'Valida_VF':{
		require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		
	
		$id   = $_GET['id'];				   
		
						   $SQL_VF='SELECT  

						
									version_final
									
									FROM 
									
									siq_archivo_documento
									
									WHERE
									
									siq_documento_id="'.$id.'"
									AND
									codigoestado=100
									AND
									version_final=1';
						
					if($Result_VF=&$db->Execute($SQL_VF)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Buscar si Hay version final....<br>'.$SQL_VF;
							echo json_encode($a_vectt);
							exit;
						}	
				if(!$Result_VF->EOF){
						$a_vectt['val']			='TRUE';
						$a_vectt['descrip']		='Por Favor Desactive la Version Final Existente..!';
						echo json_encode($a_vectt);
						exit;
					}		
								
		}break;
	case 'Eliminar_Documento':{
		require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		$userid=$Usario_id->fields['id'];
		
		$id  = $_GET['id_detalle'];
		$id_C = $_GET['id'];
		$SQL_Delete='UPDATE  siq_archivo_documento_infoHuerfana
					 SET     codigoestado=200, changedate=NOW(), userid_modificacion="'.$userid.'"
					 WHERE   idsiq_archivo_documento_infoHuerfana="'.$id.'" ';
					 
				if($Delete_Archivo=&$db->Execute($SQL_Delete)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Eliminar El Documento....<br>'.$SQL_Delete;
						echo json_encode($a_vectt);
						exit;
					}
					
					
			 							  $SQL_Num_Archivo='SELECT     

															COUNT(idsiq_archivo_documento_infoHuerfana) 
															
															FROM 
															
															siq_archivo_documento_infoHuerfana
															
															WHERE
															
															siq_documento_id="'.$id_C.'"
															AND
															codigoestado=100';
															
												if($Num_Archivos=&$db->Execute($SQL_Num_Archivo)===false){
														$a_vectt['val']			='FALSE';
														$a_vectt['descrip']		='Error al Contar los archivo....<br>'.$SQL_Num_Archivo;
														echo json_encode($a_vectt);
														exit;
													}	
													
									if($Num_Archivos->fields[0]==0){
										
											
											 $Delete_SQL='UPDATE siq_documento_infoHuerfana
														 SET    codigoestado=200, userid_modificacion="'.$userid.'",changedate=NOW()
														 WHERE  idsiq_documento_infoHuerfana="'.$id_C.'"';
														 
														 if($Delete_Docuemto=&$db->Execute($Delete_SQL)===false){
															 	$a_vectt['val']			='FALSE';
																$a_vectt['descrip']		='Error al Eliminar cabecera del documento....<br>'.$Delete_SQL;
																echo json_encode($a_vectt);
																exit;
															 }
											
											$a_vectt['val']			='TRUE';
											$a_vectt['descrip']		='Se Han Eliminado Todos los Documentos Correctamente...!';
											$a_vectt['Estado']      = '4';
											echo json_encode($a_vectt);
											exit;	
											}					 
			
			$a_vectt['val']			='TRUE';
			$a_vectt['descrip']		='Se Ha Eliminado El Documento Correctamente...!';
			echo json_encode($a_vectt);
			exit;		
			
		}break;
	case 'Archivos':{
		global $db,$C_Documento_Ver,$C_Utils_monitoreo;

		MainGeneral();
		#JsGenral();
		$C_Documento_Ver->Archivos($_GET['id'],$_GET['ver'],$_GET['vf'],$_GET['rh'],$_GET['fecha_ini'],$_GET['fecha_fin']);
		}break;
	default:{
		global $db, $C_Documento_Ver,$userid;
		
		
		MainGeneral();
		JsGeneral();
		
		
		$idForm  = $_REQUEST['idFormulario'];
                $numTab  = $_REQUEST['tab'];
                $periodo  = $_REQUEST['periodo'];
                if(isset($_REQUEST['carrera'])){
                    $carrera = $_REQUEST['carrera'];
		
                    $SQL_D='SELECT idsiq_documento_infoHuerfana FROM siq_documento_infoHuerfana WHERE idFormulario="'.$idForm.'"  AND numPestana="'.$numTab.'" AND periodo="'.$periodo.'" AND codigoestado=100 AND codigocarrera="'.$carrera.'"';
                } else {
                    $carrera = null;
                    $SQL_D='SELECT idsiq_documento_infoHuerfana FROM siq_documento_infoHuerfana WHERE idFormulario="'.$idForm.'"  AND numPestana="'.$numTab.'" AND periodo="'.$periodo.'" AND codigoestado=100 AND codigocarrera IS NULL';
                }
		if($Result=&$db->Execute($SQL_D)===false){
				echo 'Error en el SQL De buscar el Documento...<br>'.$SQL_D;
				die;
			}
		
		$C_Documento_Ver->Principal($Result->fields['idsiq_documento_infoHuerfana'],$idForm,$numTab,$periodo,$carrera);
		
		
		}break;
	}
function MainGeneral(){
	global $db, $C_Documento_Ver,$userid,$C_Utils_monitoreo;
	    require_once('../../Connections/sala2.php');
    	$rutaado = "../../funciones/adodb/";
        require_once('../../Connections/salaado.php');
		
		include ('../monitoreo/class/Utils_monitoreo.php'); $C_Utils_monitoreo = new Utils_monitoreo();
		include('Documento_VerHuerfana.class.php'); $C_Documento_Ver =new Documento_Ver();
	
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		$userid=$Usario_id->fields['id'];
	}
	
function JsGeneral(){
	
	?>
    

    <style type="text/css" title="currentStyle">
                @import "../css/normalize.css";
                @import "../../css/demo_page.css";
                @import "../../css/demo_table_jui.css";
                @import "../../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>
    <script type="text/javascript" src="../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
    <script src="../js/jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="../js/jquery_ui/js/jquery-ui.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <link rel="stylesheet" rev="stylesheet" href="../js/jquery_ui/css/ui-lightness/jquery-ui.custom.css" media="all" />
    <!--<link rel="stylesheet" href="../css/Style_Bosque.css" type="text/css" />-->
                      
    <script>
		function Ventana_OPen(id,i){
			$( "#"+id+'_'+i ).dialog();
			}
    	function Open(id,vf,rh){
            id = typeof id !== 'undefined' ? id : '';
            vf = typeof vf !== 'undefined' ? vf : '';
            rh = typeof rh !== 'undefined' ? rh : '';
			if($('#Otro').is(':checked')){
					var ver = 1;
				}else{
						var ver = 0;
					}
				
				$('#Update').css('display','block');
									
				$.ajax({
					   type: 'GET',
					   url: 'Documento_VerHuerfana.html.php',
					   data:({actionID: 'Archivos',id:id,ver:ver,vf:vf,rh:rh}),
					   success: function(data){
						 $('#Contenedor_archivos').css('display','inline');  
						 $('#Contenedor_archivos').html(data);
					   } 
					});
			}
		function Close(){
				$('#Contenedor_archivos').css('display','none');
			}	
		function Ventana(url){
				popUp_3(url,'1500','800');
			}
		function Final_Vesrion(id,i){
				var Num_Archivos = $('#Num_Archivos').val();
				if($('#Version_final_'+i).is(':checked')){//IF
					
					var estado = 1;
					
					/****************************************************/
					
					$.ajax({/*Ajax*/
						   type: 'GET',
						   url: 'Documento_VerHuerfana.html.php',
						   dataType: 'json',
						   data:({actionID: 'Version_final',id:id,estado:estado}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){/*Data*/
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}
						   	}/*Data*/ 
						});	/*Ajax*/
					
					/****************************************************/
					
					for(j=0;j<Num_Archivos;j++){//For
							if(j!=i){//if
									
									$('#Version_final_'+j).attr('disabled',true);
									
								}//if
						}//For
				}else{
					
					var estado = 0;
					
					/****************************************************/
					
					$.ajax({/*Ajax*/
						   type: 'GET',
						   url: 'Documento_VerHuerfana.html.php',
						   dataType: 'json',
						   data:({actionID: 'Version_final',id:id,estado:estado}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){/*Data*/
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}
						   	}/*Data*/ 
						});	/*Ajax*/
					
					/****************************************************/
					
						for(j=0;j<Num_Archivos;j++){//For
							
									
									$('#Version_final_'+j).attr('disabled',false);
									
						}//For
		
		
					}//IF
					
					
		
					
			}
	/*function Ver_Box(){
		
		
			
		if($('#Otro').is(':checked')){
				$('#TR_Cargar').css('visibility','visible');
				$('#Tr_URL').css('visibility','collapse');
				$('#Tr_Modifcar').css('visibility','collapse');
				$('#tr_Cargar_New').css('visibility','visible');
			}	
	}*/
function Ver_Box(){
	
	var id = $('#id_Documento').val();
			$.ajax({
				   type: 'GET',
				   url: 'Documento_VerHuerfana.html.php',
				   dataType: 'json',
				   data:({actionID: 'Valida_VF',id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
					 	if(data.val=='FALSE'){
								alert(data.descrip);
								return false;
							}else{
									alert(data.descrip);
									$('#Otro').attr('checked',false);
									$('#Tr_Op').css('visibility','collapse');
									return false;
								}
				   } 
				});
	
	var Num_Archivos = $('#Num_Archivos').val();
	
	for(j=0;j<Num_Archivos;j++){
			if($('#Version_final_'+j).is(':checked')){
					alert('Por Favor Desactive la Version Final Existente..!');
					$('#Otro').attr('checked',false);
					$('#Tr_Op').css('visibility','collapse');
					return false;
				}
		}
		
	
		if($('#Otro').is(':checked')){
				$('#Tr_Op').css('visibility','visible');
				$('#TR_Cargar').css('visibility','visible');
				$('#tr_Cargar_New').css('visibility','visible');
				
					for(j=0;j<Num_Archivos;j++){
						$('#Version_final_'+j).attr('disabled',true);
					}
			}else{
				$('#Tr_Op').css('visibility','collapse');	
					for(j=0;j<Num_Archivos;j++){
						$('#Version_final_'+j).attr('disabled',false);
					}
				}
	}
function Eliminar(id_detalle,id,op){
	
	if(op==0){
			var Confirm = confirm('Desea Eliminar el Documento ....?');
		}else{
				var Confirm = confirm('Desea Eliminar el URL ....?');
			}
	
	if(Confirm){
			$.ajax({
				   type: 'GET',
				   url: 'Documento_VerHuerfana.html.php',
				   dataType: 'json',
				   data:({actionID: 'Eliminar_Documento',id_detalle:id_detalle,id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
					 	if(data.val=='FALSE'){
								alert(data.descrip);
								return false;
							}else{
									alert(data.descrip);
									Open(id);
								}
				   } 
				});
	     }
	}
function Download(url){
		//window.location.href='Descargar_Documento.php?Documento_id='+id;/usr/local/apache2/htdocs/html/serviciosacademicos/mgi/SQI_Documento
		popUp_3(url,'1500','800');
	}							
function ValidarSubt(){
		
		if($('#Otro').is(':checked')){
			
				
						
						if(!$.trim($('#file').val())){
							
								alert('Carge el Archivo Por Favor...!');
								return false;
							
							}
							
						if($('#Tipo_Carga').val()==-1){
								
								alert('Seleccione un Tipo Archivo...!');
								return false;
								
							}
						
						if(!$.trim($('#Descripcion').val())){
							
								alert('Ingrese una Descripcion...!');
								return false;
							
							}	
							
					
			
			}
		
		if($('#rechazado').is(':checked')){
				
				if(!$.trim($('#Observ').val())){
					
						alert('Ingrese una Observacion ...!');
						return false;
					
					}
				
			}	

		return true;	
		
	}
	
function Modificar(){
		
		if($('#Otro').is(':checked')){
			
				if($('#URL_id').is(':checked')){
					
						if(!$.trim($('#url_Ubicacion').val())){
							
								alert('Ingrese una Direccion URL ...!');
							
							}
						
						if($('#Tipo_URl').val()==-1){
								
								alert('Seleccione un Tipo Archivo...!');
								return false;
								
							}	
						
						if(!$.trim($('#Descripcion').val())){
							
								alert('Ingrese una Descripcion...!');
								return false;
							
							}		
					
					}
			
			}
			
			if($('#rechazado').is(':checked')){
					if(!$.trim($('#Observ').val())){
							alert('Ingrese una Observacion...!');
							return false;
						}
				}
				
		/****************************************************/		
		
		var User_id        = $('#User_id').val();
		var id_Documento   = $('#id_Documento').val()
		var id_factor      = $('#id_factor').val();
		var id_Caract      = $('#id_Caract').val();
		var id_aspecto     = $('#id_aspecto').val();
		var id_indicador   = $('#id_indicador').val();
		
		if($('#Otro').is(':checked')){
				var url_Ubicacion  = $('#url_Ubicacion').val();
				var Tipo_URl       = $('#Tipo_URl').val();
				var Descripcion    = $('#Descripcion').val();
			}else{
				var url_Ubicacion  = '';
				var Tipo_URl       = '';
				var Descripcion    = '';
				}
				
		/*if($('#revision').is(':checked')){
				var estado  = 0;
			}else if($('#rechazado').is(':checked')){
				var estado  = 1;
			}else if($('#Actualizado').is(':checked')){
				var estado  = 2;
			}else{
				var estado  = 3;
				}*/
			
		var Observ = $('#Observ').val();	
				
					
		
		/****************************************************/		
		
		$.ajax({/*Ajax*/
			   type: 'GET',
			   url: 'Documento_VerHuerfana.html.php',
			   dataType: 'json',
			   data:({actionID: 'Modificar_Doc',User_id:User_id,
			   									id_Documento:id_Documento,
												id_factor:id_factor,
												id_Caract:id_Caract,
												id_aspecto:id_aspecto,
												id_indicador:id_indicador,
												url_Ubicacion:url_Ubicacion,
												Tipo_URl:Tipo_URl,
												Descripcion:Descripcion,
												Observ:Observ}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			   success: function(data){/*Data*/
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								//location.href='Reporte_Documento.html.php';
							}
			    } /*Data*/
			});/*Ajax*/
								
	/********************************************************************/
	}

function validar_tipo(dato,Tp,An,Ax){
		
		var Tipo_indicador = $('#Tipo_indicador').val();
		var Anexo          = $('#Anexo').val();
		var Analisi        = $('#Analisi').val();
		
		switch(dato){  
				case '0':{
					if(Tipo_indicador!=1){
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador no es Documental...!');
							return false;
						}
					}break;
				case '1':{
					if(Tipo_indicador!=1){
						if(Analisi!='1'){
							
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador  No tiene \n Asociado un Documento de Analisis...!');
							return false;
						   }
						}else{
							  
								if(Analisi!=1){
								
								$('#Tipo_Carga').val('-1');
								$('#Tipo_URl').val('-1');
								alert('Error este indicador No tiene \n Asociado un Documento de Analisis...!');
								return false;
							   }
							}
					}break;
				case '2':{
					if(Tipo_indicador!=1){
						if(Anexo!=1){
							
							$('#Tipo_Carga').val('-1');
							$('#Tipo_URl').val('-1');
							alert('Error este indicador  No tiene \n Asociado un Documento Anexo...!');
							return false;
						   }
						}else{
								if(Anexo!=1){
								
								$('#Tipo_Carga').val('-1');
								$('#Tipo_URl').val('-1');
								alert('Error este indicador  No tiene \n Asociado un Documento Anexo...!');
								return false;
							   }
							}
					}break;
				case'3':{
					
					 if(Tp!=1){
							if(Ax!=1 && An!=1){
									alert('El Indicador Selecionado No es de Tipo Documental y No tiene asociado \n un Documento Analisis o Anexo');
									return false;
								}
						}
					}break;
			}
		
	}
function VerObservacio(){
		if($('#rechazado').is(':checked')){
				$('#Tr_Obs').css('visibility','visible');
				$('#TR_Box_Obs').css('visibility','visible');
				$('#Obliga').css('display','inline');
				$('#aprobado').attr('disabled',true);
			}else{
				$('#Tr_Obs').css('visibility','collapse');
				$('#TR_Box_Obs').css('visibility','collapse');
				$('#Obliga').css('display','none');
				$('#aprobado').attr('disabled',false);
				}
	}
function Ver_Caja_Obs(){
		if($('#aprobado').is(':checked')){
				$('#Tr_Obs').css('visibility','visible');
				$('#TR_Box_Obs').css('visibility','visible');
				$('#rechazado').attr('disabled',true);
			}else{
				$('#Tr_Obs').css('visibility','collapse');
				$('#TR_Box_Obs').css('visibility','collapse');
				$('#rechazado').attr('disabled',false);
				}
	}		
	
function afuera(){
	
		location.href='Reporte_Documento.html.php';
	}

function Modificar_new(){
		
		if($('#Otro').is(':checked')){
			
				if($('#URL_id').is(':checked')){
					
						if(!$.trim($('#url_Ubicacion').val())){
							
								alert('Ingrese una Direccion URL ...!');
							
							}
						
						if($('#Tipo_URl').val()==-1){
								
								alert('Seleccione un Tipo Archivo...!');
								return false;
								
							}	
						
						if(!$.trim($('#Descripcion').val())){
							
								alert('Ingrese una Descripcion...!');
								return false;
							
							}		
					
					}
			
			}
			
			if($('#rechazado').is(':checked')){
					if(!$.trim($('#Observ').val())){
							alert('Ingrese una Observacion...!');
							return false;
						}
				}
				
		/****************************************************/		
		
		var User_id        = $('#User_id').val();
		var id_Documento   = $('#id_Documento').val()
		var id_factor      = $('#id_factor').val();
		var id_Caract      = $('#id_Caract').val();
		var id_aspecto     = $('#id_aspecto').val();
		var id_indicador   = $('#id_indicador').val();
		
		if($('#Otro').is(':checked')){
				var url_Ubicacion  = $('#url_Ubicacion').val();
				var Tipo_URl       = $('#Tipo_URl').val();
				var Descripcion    = $('#Descripcion').val();
			}else{
				var url_Ubicacion  = '';
				var Tipo_URl       = '';
				var Descripcion    = '';
				}
				
		/*if($('#revision').is(':checked')){
				var estado  = 0;
			}else if($('#rechazado').is(':checked')){
				var estado  = 1;
			}else if($('#Actualizado').is(':checked')){
				var estado  = 2;
			}else{
				var estado  = 3;
				}*/
			
		var Observ = $('#Observ').val();	
				
					
		
		/****************************************************/		
		
		$.ajax({/*Ajax*/
			   type: 'GET',
			   url: 'Documento_VerHuerfana.html.php',
			   dataType: 'json',
			   data:({actionID: 'Modificar_Doc',User_id:User_id,
			   									id_Documento:id_Documento,
												id_factor:id_factor,
												id_Caract:id_Caract,
												id_aspecto:id_aspecto,
												id_indicador:id_indicador,
												url_Ubicacion:url_Ubicacion,
												Tipo_URl:Tipo_URl,
												Descripcion:Descripcion,
												Observ:Observ}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			   success: function(data){/*Data*/
					if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
						}else{
								alert(data.descrip);
								location.href='Reporte_Documento.html.php';
							}
			    } /*Data*/
			});/*Ajax*/
								
	/********************************************************************/
	}
	function AvilitarCheckd(id,doc_id){
			
			var Tipo  = $('#Tipo_'+id).val();
			
			if($('#Avilita_'+id).is(':checked')){
				/**************************************************/
					
					
					var estado = 1;
					
						$.ajax({/*Ajax*/
							   type: 'GET',
							   url: 'Documento_VerHuerfana.html.php',
							   dataType: 'json',
							   data:({actionID:'Version_final',id:id,estado:estado,Tipo:Tipo,doc_id:doc_id}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){/*Data*/
									
									switch(data.val){
												case 'FALSE':{
														alert(data.descrip);
														return false;
													}break;
												case 'EXISTE':{
														alert('Ya Existe Un Documento Como Ultima Version de este Tipo...!');
														$('#Avilita_'+id).attr('checked',false);
														return false;
													}break;	
												case 'NODEBE':{
														alert('No Se Puede Ya Que Este Documento Esta Rechazado...!');
														$('#Avilita_'+id).attr('checked',false);
														return false;
													}break;	
												case 'TRUE':{
														alert('Documento Selecionado Como Ultima Version De Este Tipo...');
													}break;	
											}/*switch*/
									
								} /*Data*/
							});/*Ajax*/
					
				/**************************************************/
				}else{
					/**************************************************/
						
							var estado = 0;
					
							$.ajax({/*Ajax*/
								   type: 'GET',
								   url: 'Documento_VerHuerfana.html.php',
								   dataType: 'json',
								   data:({actionID:'Version_final',id:id,estado:estado,Tipo:Tipo,doc_id:doc_id}),
								   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
								   success: function(data){/*Data*/
								   		switch(data.val){
												case 'FALSE':{
														alert(data.descrip);
														return false;
													}break;
												case 'EXISTE':{
														alert('Ya Existe Un Documento Como Version Final de este Tipo...!');
														$('#Avilita_'+id).attr('checked',false);
														return false;
													}break;	
												case 'NODEBE':{
														alert('No Se Puede Ya Que Esta Rechazado...!');
														$('#Avilita_'+id).attr('checked',false);
														return false;
													}break;	
												case 'TRUE':{
														alert('Documento ha Desmarcado Correctamente...');
													}break;	
											}/*switch*/
										
									} /*Data*/
								});/*Ajax*/
							
					/**************************************************/
					}
			
		}
	function AvilitarRechazo(id,doc_id){
		
			var Tipo  = $('#Tipo_'+id).val();
			
			if($('#Rechazo_'+id).is(':checked')){
				/**************************************************/
					
					
					var estado = 1;
					
						$.ajax({/*Ajax*/
							   type: 'GET',
							   url: 'Documento_VerHuerfana.html.php',
							   dataType: 'json',
							   data:({actionID:'Rechazar',id:id,estado:estado,Tipo:Tipo,doc_id:doc_id}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){/*Data*/
							   
							   		switch(data.val){
										case 'FALSE':{
												alert(data.descrip);
												return false;
											}break;
										case 'EXISTE':{
												alert('Ya Este Documento Esta Marcado Como Ultima Version \n Y No Se Debe Rechazar...!');
												$('#Rechazo_'+id).attr('checked',false);
												return false;
											}break;	
										case 'TRUE':{
												alert('Se Ha Rechazado El Documento Correctamente...');
											}break;	
									}/*switch*/
										
								} /*Data*/
							});/*Ajax*/
					
				/**************************************************/
				}else{
					/**************************************************/
						
							var estado = 0;
					
							$.ajax({/*Ajax*/
								   type: 'GET',
								   url: 'Documento_VerHuerfana.html.php',
								   dataType: 'json',
								   data:({actionID:'Rechazar',id:id,estado:estado,Tipo:Tipo,doc_id:doc_id}),
								   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
								   success: function(data){/*Data*/
										switch(data.val){
											case 'FALSE':{
													alert(data.descrip);
													return false;
												}break;
											case 'EXISTE':{
													alert('Ya Existe Un Documento Como Ultima Version ...!');
													$('#Rechazo_'+id).attr('checked',false);
													return false;
												}break;	
											case 'TRUE':{
													alert('Se Ha Desmarcado El Documento Correctamente...');
												}break;	
										}/*switch*/
									} /*Data*/
								});/*Ajax*/
							
					/**************************************************/
					}
		
		}
	function CambiarDoc(j){
		
			if(j==1){
				$('#tipoDoc').html('10 Mb Max / PDF');
				}else{
					$('#tipoDoc').html('10 Mb Max / Word');
					}
		
		} 			
    </script>
   <?PHP
}
?>