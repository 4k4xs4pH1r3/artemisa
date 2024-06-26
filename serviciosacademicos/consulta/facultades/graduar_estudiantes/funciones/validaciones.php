<?php
function validacion_pazysalvo($codigoestudiante,$sala)
{
	mysql_select_db($database_sala, $sala);
	$query_pazysalvo = "select p.idpazysalvoestudiante, e.codigocarrera
	from pazysalvoestudiante p, detallepazysalvoestudiante d, estudiante e
	where e.codigoestudiante = '$codigoestudiante'
	and p.idpazysalvoestudiante = d.idpazysalvoestudiante
	and d.codigoestadopazysalvoestudiante like '1%'
	and e.idestudiantegeneral = p.idestudiantegeneral";
	//echo $query_pazysalvo,"<br>";
	$pazysalvo = mysql_query($query_pazysalvo,$sala) or die (mysql_error());
	$totalRows_pazysalvo = mysql_num_rows($pazysalvo);
	$row_pazysalvo = mysql_fetch_array($pazysalvo);
	if($totalRows_pazysalvo==0)
	{
		return "no";
	}//echo $query_pazysalvo;
	else
	{
		return "si";
	}
}

function validacion_documentos($codigocarrera,$codigogenero,$codigoestudiante,$sala,&$documentacionpendiente)
{
	$query_documentos = "SELECT d.nombredocumentacion, d.iddocumentacion
	from documentacion d,documentacionfacultad df
	where d.iddocumentacion = df.iddocumentacion
	and df.codigocarrera = '$codigocarrera'
	and df.fechainiciodocumentacionfacultad <= '".date("Y-m-d")."'
	and df.fechavencimientodocumentacionfacultad >= '".date("Y-m-d")."'
	AND (df.codigogenerodocumento = '300' 
	OR df.codigogenerodocumento = '$codigogenero')";
	//echo $query_documentos,"<br>";
	//exit();
	$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
	$totalRows_documentos = mysql_num_rows($documentos);
	//echo $query_documentos;
	while($row_documentos = mysql_fetch_assoc($documentos))
	{
		// Selecciona los documentos para la facultad que posee un estudiante
		$query_documentosestudiante = "SELECT d.codigotipodocumentovencimiento
		FROM documentacionestudiante d,documentacionfacultad df,tipovencimientodocumento t
	    where d.codigoestudiante = '$codigoestudiante'
		and d.iddocumentacion = '".$row_documentos['iddocumentacion']."'
		AND d.codigotipodocumentovencimiento = '100' 
		and d.iddocumentacion = df.iddocumentacion
		AND d.codigotipodocumentovencimiento = t.codigotipovencimientodocumento";
		$documentosestudiante = mysql_query($query_documentosestudiante, $sala) or die("$query_documentosestudiante".mysql_error());
		$totalRows_documentosestudiante = mysql_num_rows($documentosestudiante);
		$row_documentosestudiante = mysql_fetch_assoc($documentosestudiante);
		//echo $query_documentosestudiante;echo "<br>";
		//echo  $totalRows_documentosestudiante;
		//print_r($row_documentosestudiante); echo "<br>";
		$documentacionpendiente[] = array('codigoestudiante'=>$codigoestudiante,'documentacion'=>$row_documentos['nombredocumentacion']);
		if($totalRows_documentosestudiante == "")
		{
			return "si";
		}
		else if($row_documentosestudiante['codigotipodocumentovencimiento'] == '100')
		{
			return "no";
			continue;
		}
		else
		{
			return "si";
		}
		//echo $row_documentos['nombredocumentacion'];
		//echo "<br>";
		//echo $pendiente;
	}
}
// Esta funcion recibe el estudiante, la materia que se quiere verificar, el plan de estudios donde se encuentra la materia y la base de datos.
function materiaaprobada($codigoestudiante, $codigomateria, $idplanestudio, $reprobada, $sala)
{
	$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
	FROM notahistorico n, materia m
	WHERE n.codigoestudiante = '$codigoestudiante'
	AND m.codigomateria = n.codigomateria
	AND (n.codigomateria = '$codigomateria' OR n.codigomateriaelectiva = '$codigomateria')
	and n.codigoestadonotahistorico like '1%'
	ORDER BY 4 ";
	//echo "$query_materianota<br>";
	$materianota=mysql_query($query_materianota, $sala) or die("$query_materianota");
	$totalRows_materianota = mysql_num_rows($materianota);
	// Entra si la materia tienen nota historica para este estudiante
	// Sino busca la materia equivalente
	if($totalRows_materianota != "")
	{
		while($row_materianota = mysql_fetch_array($materianota))
		{
			// Si la nota es aprobada retorna verdadero
			if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria'])
			{
				$reprobada = false;
				return "aprobada";
			}
			else
			{
				$reprobada = true;
			}
		}
	}
	$query_materiaequivalente = "select r.idplanestudio, r.codigomateriareferenciaplanestudio
	from referenciaplanestudio r
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '$codigomateria'
	and r.codigotiporeferenciaplanestudio like '3%'";
	//echo "$query_materiaequivalente<br>";
	$materiaequivalente=mysql_query($query_materiaequivalente, $sala) or die("$query_materiaequivalente");
	$totalRows_materiaequivalente = mysql_num_rows($materiaequivalente);
	// Si tiene materia equivalente entra a hacer lo mismo, es decir a mirar si la equivalente esta aprobada
	// Para el sigiente plan de estudios de la carrera donde aparezca esta materia
	// Sino retorna falso
	if($totalRows_materiaequivalente != "")
	{
		while($row_materiaequivalente = mysql_fetch_array($materiaequivalente))
		{
			$codigoequivalente = $row_materiaequivalente['codigomateriareferenciaplanestudio'];
			$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
			FROM notahistorico n, materia m
			WHERE n.codigoestudiante = '$codigoestudiante'
			AND m.codigomateria = n.codigomateria
			AND (n.codigomateria = '$codigoequivalente' OR n.codigomateriaelectiva = '$codigoequivalente')
			and n.codigoestadonotahistorico like '1%'
			ORDER BY 4 ";
			//echo "$query_materianota<br>";
			$materianota=mysql_query($query_materianota, $sala) or die("$query_materianota");
			$totalRows_materianota = mysql_num_rows($materianota);
			// Entra si la materia tienen nota historica para este estudiante
			// Sino busca la materia equivalente
			if($totalRows_materianota != "")
			{
				while($row_materianota = mysql_fetch_array($materianota))
				{
					// Si la nota es aprobada retorna verdadero
					if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria'])
					{
						$reprobada = false;
						return "aprobada";
					}
					else
					{
						$reprobada = true;
					}
				}
			}
		}
	}
	else
	{
		//$reprobada = false;
		return "porver";
	}
	if($reprobada)
	{
		return "reprobada";
	}
	else
	{
		//$reprobada = false;
		return "porver";
	}
}
?>

<?php
function generarcargaestudiante($codigoestudiante,$sala,&$materiaspendientes)
{
	// Proceso para generar la carga académica
	// Toma todas las materias del plan de estudios
	$query_materiasplanestudio = "select d.idplanestudio, d.codigomateria, m.nombremateria, m.codigoindicadorgrupomateria,
	d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 
	t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio
	from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t
	where p.codigoestudiante = '$codigoestudiante'
	and p.idplanestudio = d.idplanestudio
	and p.codigoestadoplanestudioestudiante like '1%'
	and d.codigoestadodetalleplanestudio like '1%'
	and d.codigomateria = m.codigomateria
	and d.codigotipomateria = t.codigotipomateria
	order by 4,3";
	//and d.codigotipomateria not like '5%'
	//and d.codigotipomateria not like '4%'";
	//echo "$query_materiasplanestudio<br>";
	$materiasplanestudio=mysql_query($query_materiasplanestudio, $sala) or die("$query_materiasplanestudio");
	$totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);
	$rowmateriasplanestudio=mysql_fetch_assoc($materiasplanestudio);
	//print_r($rowmateriasplanestudio);
	//echo "Total: $totalRows_materiasplanestudio<br>";
	$quitarmateriasdelplandestudios = "";
	if($totalRows_materiasplanestudio != "")
	{
		// Este arreglo sirve para guardar el semestre que mas se repite
		// Tomo el maximo numero de semestres del plan de estudio
		$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre
	from planestudio";
		$semestreplanes=mysql_query($query_semestreplanes, $sala) or die("$query_semestreplanes");
		$totalRows_semestreplanes = mysql_num_rows($semestreplanes);
		$row_semestreplanes = mysql_fetch_array($semestreplanes);
		for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++)
		{
			$semestre[$semestreini] = 0;
		}
		$numerocreditoselectivas = 0;
		$tieneelectivas = false;
		$tieneenfasis = false;
		$estudiantetieneenfasis = false;
		// String que va a guardar las materias del plan de estudios para quitarselas a las electivas libres, en caso de existir una obligatoria
		$quitarmateriasdelplandestudios = "";
		while($row_materiasplanestudio = mysql_fetch_array($materiasplanestudio))
		{
			$idplan = $row_materiasplanestudio['idplanestudio'];
			//echo $row_materiasplanestudio['codigomateria']."<br>";
			$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiasplanestudio['codigomateria']."'";
			if($row_materiasplanestudio['codigotipomateria'] == '4')
			{
				$numerocreditoselectivas = $numerocreditoselectivas + $row_materiasplanestudio['numerocreditosdetalleplanestudio'];
				$electivaslibresplan[] = $row_materiasplanestudio;
				$tieneelectivas = true;
			}
			else
			{
				// Mira si cada materia n ha sido aprobada para meterla en la carga
				// Por el momento toma totas las materias
				//$reprobada=true;
				if($row_materiasplanestudio['codigotipomateria'] != '5')
				{
					//echo "materiaaprobada($codigoestudiante, ".$row_materiasplanestudio['codigomateria'].", ".$row_materiasplanestudio['idplanestudio'].", $reprobada, $sala<br>";
					@$estadomateria = materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'], $row_materiasplanestudio['idplanestudio'], $reprobada, $sala);
					if($estadomateria == "porver")
					{
						$materiasporver[] = $row_materiasplanestudio;
						//echo "entro <br>";
					}
					else if($estadomateria == "reprobada")
					{
						//echo "REPRO: $reprobada : ".$row_materiasplanestudio['codigomateria']."<br>";
						// Estas materias son obligatorias
						$materiasobligatorias[] = $row_materiasplanestudio;
						// Selección de la carga obligatoria
						$cargaobligatoria[] = $row_materiasplanestudio['codigomateria'];
						$materiasporver[] = $row_materiasplanestudio;
						$semestre[$row_materiasplanestudio['semestredetalleplanestudio']]++;
					}
					else if($estadomateria == "aprobada")
					{
						//echo "bien<br>";
						$materiaspasadas[] = $row_materiasplanestudio;
					}
					else
					{
						echo "error";
					}
				}
				else if($row_materiasplanestudio['codigotipomateria'] == '5')
				{
					// Aqui es para las lineas de enfasis
					$tieneenfasis = true;
					// Primero miro si el estudiante ya tiene linea de enfasis.
					$query_poseelineaenfasis = "select le.idlineaenfasisplanestudio
				from lineaenfasisestudiante le
				where le.codigoestudiante = '$codigoestudiante'";
					//and d.codigotipomateria not like '5%'
					//and d.codigotipomateria not like '4%'";
					//echo "$query_materiasplanestudio<br>";
					$poseelineaenfasis=mysql_query($query_poseelineaenfasis, $sala) or die("$query_poseelineaenfasis");
					$totalRows_poseelineaenfasis = mysql_num_rows($poseelineaenfasis);
					if($totalRows_poseelineaenfasis != "")
					{
						// Selecciona las materias de la línea y efectua el proceso de carga para esas materias
						$estudiantetieneenfasis = true;
					}
				}
			}
			$idplanestudioini = $row_materiasplanestudio['idplanestudio'];
		}
		if($estudiantetieneenfasis)
		{
			// Selecciona las materias de la linea de enfasis de este estudiante las cuales deben estar activas
			$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio,
			d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
			d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
			t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
			from detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisestudiante l
			where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
			and d.codigotipomateria = t.codigotipomateria
			and l.idplanestudio = d.idplanestudio
			and l.codigoestudiante = '$codigoestudiante'
			and l.idlineaenfasisplanestudio = d.idlineaenfasisplanestudio
			and d.codigoestadodetallelineaenfasisplanestudio like '1%'
			group by 3
			order by 2,5";
			//and d.codigotipomateria not like '5%'
			//and d.codigotipomateria not like '4%'";
			//echo "$query_materiaslineaenfasis<br>";
			$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
			$totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
		}
		else if($tieneenfasis)
		{
			// Selecciona todas las materias del plan de estudio que son enfais
			// Es decir toma todos los enfasis
			$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio,
			d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
			d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
			t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
			from detallelineaenfasisplanestudio d, materia m, lineaenfasisplanestudio l, tipomateria t
			where d.idplanestudio = '$idplan'
			and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
			and d.codigotipomateria = t.codigotipomateria
			and l.idplanestudio = d.idplanestudio
			group by 3
			order by 2,5";
			//and d.codigotipomateria not like '5%'
			//and d.codigotipomateria not like '4%'";
			//echo "$query_materiaslineaenfasis<br>";
			$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
			$totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
		}
		if(@$totalRows_materiaslineaenfasis != "")
		{
			while($row_materiaslineaenfasis = mysql_fetch_array($materiaslineaenfasis))
			{
				$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
				@$estadomateria = materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada, $sala);
				if($estadomateria == "porver")
				{
					$materiasporver[] = $row_materiaslineaenfasis;
					//echo "entro <br>";
				}
				else if($estadomateria == "reprobada")
				{
					// No la puse por que no hay linea de enfasis
					//echo "REPRO: $reprobada : ".$row_materiasplanestudio['codigomateria']."<br>";
					// Estas materias son obligatorias
					$materiasobligatorias[] = $row_materiaslineaenfasis;
					// Selección de la carga obligatoria
					$cargaobligatoria[] = $row_materiaslineaenfasis['codigomateria'];
					$materiasporver[] = $row_materiaslineaenfasis;
					$semestre[$row_materiaslineaenfasis['semestredetalleplanestudio']]++;
				}
				else if($estadomateria == "aprobada")
				{
					//echo "bien<br>";
					$materiaspasadas[] = $row_materiaslineaenfasis;
				}
				else
				{
					echo "error";
				}
			}
		}
		@$materiasafiltrar = $materiasporver;
		//print_r($materiasporver);
		@$materiasconprerequisito = $materiasporver;
		@$materiasobigatoriasquitar = $materiasobligatorias;
		// Solamente se filtran las materias por ver, es decir las sugeridas
		if(isset($materiasafiltrar))
		{
			foreach($materiasafiltrar as $key1 => $value1)
			{
				// Debe tomar las materias que no tengan prerequisito, o el prerequisito este aprobado
				// Las materias del anterior arreglo deben filtrarse por las que no tengan prerequisito o el prerequisito este aprobado.
				// Mejor dicho si el prereqisito de una materia no se encuentra en este mismo arreglo se acepta la materia si no No.
				$query_materiasprerequisito = "select r.codigomateriareferenciaplanestudio
				from referenciaplanestudio r
				where r.idplanestudio = '".$value1['idplanestudio']."'
				and r.codigomateria = '".$value1['codigomateria']."'
				and r.codigotiporeferenciaplanestudio like '1%'
				and r.codigoestadoreferenciaplanestudio = '101'";
				//echo "$query_materiasprerequisito<br>";
				$materiasprerequisito=mysql_query($query_materiasprerequisito, $sala) or die("$query_materiasprerequisito");
				$totalRows_materiasprerequisito = mysql_num_rows($materiasprerequisito);
				if($totalRows_materiasprerequisito != "")
				{
					$tieneprerequisito = false;
					//echo "<br>PAPA: ".$value1['codigomateria']."";
					while($row_materiasprerequisito = mysql_fetch_array($materiasprerequisito))
					{
						// Cada una de las materias prerequisitos se busca en el arreglo, si esta no incluye la materia
						foreach($materiasconprerequisito as $key2 => $value2)
						{
							//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
							if($row_materiasprerequisito['codigomateriareferenciaplanestudio'] == $value2['codigomateria'])
							{
								//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
								$tieneprerequisito = true;
								//return;
							}
						}
					}
					if(!$tieneprerequisito)
					{
						$quitarobligatoria = false;
						if(isset($materiasobigatoriasquitar))
						{
							foreach($materiasobigatoriasquitar as $key3 => $value3)
							{
								//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
								if($value1['codigomateria'] == $value3['codigomateria'])
								{
									//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
									$quitarobligatoria = true;
								}
							}
						}
						if(!$quitarobligatoria)
						{
							$materiaspropuestas[] = $value1;
							// Selección de la carga obligatoria
							$cargaobligatoria[] = $value1['codigomateria'];
							$semestre[$value1['semestredetalleplanestudio']]++;
						}
					}
				}
				else
				{
					$quitarobligatoria = false;
					if(isset($materiasobigatoriasquitar))
					{
						foreach($materiasobigatoriasquitar as $key3 => $value3)
						{
							//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
							if($value1['codigomateria'] == $value3['codigomateria'])
							{
								//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
								$quitarobligatoria = true;
							}
						}
					}
					if(!$quitarobligatoria)
					{
						$materiaspropuestas[] = $value1;
						// Selección de la carga obligatoria
						$cargaobligatoria[] = $value1['codigomateria'];
						$semestre[$value1['semestredetalleplanestudio']]++;
					}
				}
			}
		}
		else
		{
			//echo '<h1 align="center">El estudiante no tiene materias para ver</h1>';
		}
	}
	else
	{
		//echo "Este estudiante no tiene asignado un plan de estudios";
		//exit();
	}

	if(isset($materiasporver))
	{
		foreach($materiasporver as $llave => $valor)
		{
			$materiaspendientes[]=array('codigoestudiante'=>$codigoestudiante,'codigomateria'=>$valor['codigomateria'],'nombremateria'=>$valor['nombremateria']);
		}
		return "si";
		//echo "debematerias";
	}
	else
	{
		return "no";
	}
}
function validacion_saldo_sap($codigoestudiante,$database_sala,$sala,$rfc,$login,$rfchandle,&$deudassap)
{
	//echo $codigoestudiante;
	$debe=false;
	mysql_select_db($database_sala, $sala);
	unset($saldoafavor);
	unset($saldoencontra);

	$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna,hostestadoconexionexterna,numerosistemaestadoconexionexterna,
	mandanteestadoconexionexterna,usuarioestadoconexionexterna,passwordestadoconexionexterna
	from estadoconexionexterna e
	where e.codigoestado like '1%'";
	$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
	$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
	$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
	//print_r($row_estadoconexionexterna);
	if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
	{
		$host = $row_estadoconexionexterna['hostestadoconexionexterna'];
		$sistema = $row_estadoconexionexterna['numerosistemaestadoconexionexterna'];
		$mandante =  $row_estadoconexionexterna['mandanteestadoconexionexterna'];
		$usuario = $row_estadoconexionexterna['usuarioestadoconexionexterna'];
		$clave = $row_estadoconexionexterna['passwordestadoconexionexterna'];

		$login = array (                              // Set login data to R/3
		"ASHOST"=>"$host",             // application server host name
		"SYSNR"=>"$sistema",                     // system number
		"CLIENT"=>"$mandante",                    // client
		"USER"=>"$usuario",                  // user
		"PASSWD"=>"$clave",
		"CODEPAGE"=>"1100");              // codepage
		$rfc = saprfc_open($login);
		if(!$rfc)
		{
			// We have failed to connect to the SAP server
			//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
			//exit(1);
		}

	}
	//echo $mandante;
	$query_dataestudiante = "SELECT *
       FROM estudiante e,estudiantegeneral eg 
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral
   	   and e.codigoestudiante = '".$codigoestudiante."'";
	// echo $query_dataestudiante;
	$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
	$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
	$totalRows_dataestudiante = mysql_num_rows($dataestudiante);

	if ($row_dataestudiante <> "")
	{
		$numerodocumento = $row_dataestudiante['idestudiantegeneral'];
	}
	$rfcfunction = "ZFKK_OPEN_ITEMS_FOR_ACC_READ";
	$entrego = "I_GPART";
	$resultstable = "T_FKKOP";

	$rfc = saprfc_open($login);

	if(!$rfc)
	{
		// echo "Failed to connect to the SAP server".saprfc_error();
	}
	@$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

	if(!$rfchandle)
	{
		// echo "We have failed to discover the function".saprfc_error($rfc);
	}
	// traigo la tabla interna de SAP
	@saprfc_table_init($rfchandle,$resultstable);
	// importo el numero de documento a consultar
	@saprfc_import($rfchandle,$entrego,$numerodocumento);

	@$rfcresults = saprfc_call_and_receive($rfchandle);

	$numrows = saprfc_table_rows($rfchandle,$resultstable);
	//echo $numrows;
	for ($i=1; $i <= $numrows; $i++)
	{
		$results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
	}
	if ($results <> "")
	{  // if 1
		foreach ($results as $valor => $total)
		{ // foreach 1
			foreach ($total as $valor1 => $total1)
			{ // foreach 2
				if ($valor1 == "HVORG")
				{
					$opprincipal = $total1;
					// echo $opprincipal,"<br>";
				}
				if ($valor1 == "TVORG")
				{
					$opparcial = $total1;
				}
				if ($valor1 == "FAEDN")
				{
					$fechavence =  $total1;
				}
				if ($valor1 == "BETRW")
				{
					$valor =  $total1;
				}
				if ($valor1 == "OPBEL")
				{
					$contabilizar =  $total1;
				}
				if ($valor1 == "PRCTR")
				{
					$cb =  $total1;
				}
			} // foreah 2

			$query_concepto = "SELECT *
		   FROM concepto 
		   WHERE cuentaoperacionprincipal = '$opprincipal'
		   and cuentaoperacionparcial = '$opparcial'";
			// echo $query_concepto,"<br>";
			$concepto = mysql_query($query_concepto, $sala) or die("$query_concepto".mysql_error());
			$row_concepto = mysql_fetch_assoc($concepto);
			$totalRows_concepto = mysql_num_rows($concepto);

			$codigocarrera = "";

			$query_carrera = "SELECT *
		   FROM carrera c
		   WHERE  c.codigocentrobeneficio = '$cb'
		   AND c.codigotipocosto = '100'";
			//echo $query_carrera;
			$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera".mysql_error());
			$row_carrera = mysql_fetch_assoc($carrera);
			$totalRows_carrera = mysql_num_rows($carrera);

			if (! $row_carrera)
			{
				$query_carrera = "SELECT m.codigocarrera
			   FROM numeroordeninternasap n,grupo g,materia m
			   WHERE numeroordeninternasap = '$cb'
			   AND g.idgrupo = n.idgrupo
			   AND m.codigomateria = g.codigomateria";
				// echo $query_carrera;
				$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera".mysql_error());
				$row_carrera = mysql_fetch_assoc($carrera);
				$totalRows_carrera = mysql_num_rows($carrera);
			}
			$codigocarrera = $row_carrera['codigocarrera'];

			if ($codigocarrera == "")
			{
				$codigocarrera = $row_dataestudiante['codigocarrera'];
			}
			$query_codigoestudiantecarrera = "SELECT *
		   FROM estudiante e, prematricula p
		   WHERE e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
		   AND e.codigocarrera = '$codigocarrera'
		   and p.codigoestudiante = e.codigoestudiante";
			//echo $query_codigoestudiantecarrera,"<br><br><br>";
			$codigoestudiantecarrera = mysql_query($query_codigoestudiantecarrera, $sala) or die("$query_codigoestudiantecarrera".mysql_error());
			$row_codigoestudiantecarrera = mysql_fetch_assoc($codigoestudiantecarrera);
			$totalRows_codigoestudiantecarrera = mysql_num_rows($codigoestudiantecarrera);
			$codigoestudiante =  $row_codigoestudiantecarrera['codigoestudiante'];
			if ($row_concepto <> "")
			{
				if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98')
				{
					$row_concepto['codigoconcepto'] = '154';
				}
				// echo $row_concepto['codigoconcepto'],"-",$codigocarrera;
				if ($row_concepto['codigotipoconcepto'] == '02')
				{
					$saldoafavor[] = array('codigoestudiante'=>$codigoestudiante,'codigocarrera'=>$codigocarrera,'concepto'=>$row_concepto['codigoconcepto'],'nombreconcepto'=>$row_concepto['nombreconcepto'],'fechavence'=>$fechavence,'valor'=>$valor,'contabilizar'=>$contabilizar);
				}
				else
				if ($row_concepto['codigotipoconcepto'] == '01')
				{
					$saldoencontra[] = array('codigoestudiante'=>$codigoestudiante,'codigocarrera'=>$codigocarrera,'codigoconcepto'=>$row_concepto['codigoconcepto'],'nombreconcepto'=>$row_concepto['nombreconcepto'],'fechavence'=>$fechavence,'valor'=>$valor,'contabilizar'=>$contabilizar);
					//echo "debe";
					$deudassap=$saldoencontra;

				}
			} // foreach 1
		} // if 1
	}
	if(!is_array($saldoencontra))
	{
		return "no";
	}
	else
	{
		return "si";
	}
}
function validacion_pago_derechos_grado($codigoestudiante,$sala)
{
	$query_valida_pago_derechos_grado="
	SELECT count(c.codigoconcepto) as cantidad
	FROM
	concepto c, ordenpago op, detalleordenpago dop
	WHERE
	op.numeroordenpago=dop.numeroordenpago
	AND	op.codigoestudiante='".$codigoestudiante."'
	AND c.codigoconcepto=dop.codigoconcepto
	AND c.codigoconcepto='108'
	AND op.codigoestadoordenpago like '4%'
	";
	//echo $query_valida_pago_derechos_grado,"<br>";
	$valida_pago_derechos_grado=mysql_query($query_valida_pago_derechos_grado) or die(mysql_error.$query_valida_pago_derechos_grado);
	$row_valida_pago_derechos_grado=mysql_fetch_assoc($valida_pago_derechos_grado);
	$cantidad=$row_valida_pago_derechos_grado['cantidad'];
	//print_r($row_valida_pago_derechos_grado);
	//echo $row_valida_pago_derechos_grado['cantidad'],"<br>";
	if($cantidad==0)
	{
		return "si";//debe
	}
	else
	{
		return "no";//nodebe
	}
}
function validacion_estado_egreso($codigoestudiante,$sala)
{
	$query_egreso="SELECT e.codigoestudiante FROM estudiante e
	WHERE e.codigoestudiante='$codigoestudiante'
	AND e.codigosituacioncarreraestudiante=104
	";
	$egreso=mysql_query($query_egreso) or die(mysql_error().$query_egreso);
	$numRows_egreso=mysql_num_rows($egreso);
	if($numRows_egreso==1)
	{
		return "si";
	}
	elseif($numRows_egreso==0)
	{
		return "no";
	}
}
?>

