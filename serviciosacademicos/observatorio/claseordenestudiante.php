<?php
/**************************************************************************************************************************/
/****************************************************/
//													//
//			CLASE ORDENESTUDIANTE					//
//													//
/****************************************************/
/**************************************************************************************************************************/

class Ordenesestudiante
{
	var $sala;
	var $ordenesdepago;
	var $codigoestudiante;
	var $codigoperiodo;
	var $numerodeordenesimpresas;
	var $existenordenesdepago;
   

	function Ordenesestudiante($sala, $codigoestudiante, $codigoperiodo, $cuentaoperacionprincipal = "", $digitoestadoordenpago = "")
	{
		$this->sala = $sala;
		$this->codigoestudiante = $codigoestudiante;
		$this->codigoperiodo = $codigoperiodo;
		$this->numerodeordenesimpresas = 0;
		$this->existenordenesdepago = false;
		// Crea los objetos ordenes de pago para cada estudiante
		if($cuentaoperacionprincipal == "")
		{
			$query_selnumeroordenpago="SELECT numeroordenpago, codigoestudiante, fechaordenpago, idprematricula, fechaentregaordenpago, codigoperiodo, codigoestadoordenpago, codigoimprimeordenpago, observacionordenpago, codigocopiaordenpago, documentosapordenpago, idsubperiodo, documentocuentaxcobrarsap, documentocuentacompensacionsap, fechapagosapordenpago
			FROM ordenpago
			where codigoperiodo = '$this->codigoperiodo'
			and codigoestudiante = '$this->codigoestudiante'
			and (codigoestadoordenpago like '1$digitoestadoordenpago%' or codigoestadoordenpago like '4$digitoestadoordenpago%' or codigoestadoordenpago like '6$digitoestadoordenpago%')";
		}
		else
		{
			$query_selnumeroordenpago="SELECT o.numeroordenpago, o.codigoestudiante, o.fechaordenpago, o.idprematricula, o.fechaentregaordenpago, o.codigoperiodo, o.codigoestadoordenpago, o.codigoimprimeordenpago, o.observacionordenpago, o.codigocopiaordenpago, o.documentosapordenpago, o.idsubperiodo, o.documentocuentaxcobrarsap, o.documentocuentacompensacionsap, o.fechapagosapordenpago
			FROM ordenpago o, detalleordenpago do, concepto c
			where o.codigoperiodo = '$this->codigoperiodo'
			and o.codigoestudiante = '$this->codigoestudiante'
			and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%' or o.codigoestadoordenpago like '6%')
			and do.numeroordenpago = o.numeroordenpago
			and c.codigoconcepto = do.codigoconcepto
			and c.cuentaoperacionprincipal in($cuentaoperacionprincipal)";
		}
		$selnumeroordenpago = mysql_query($query_selnumeroordenpago,$this->sala) or die("$query_selnumeroordenpago<br>".mysql_error());
		$totalRows_selnumeroordenpago = mysql_num_rows($selnumeroordenpago);
		//echo "$query_selnumeroordenpago <br>".$row_ordenpago['numeroordenpago'];

		if($totalRows_selnumeroordenpago != "")
		{
			$this->existenordenesdepago = true;
			while($row_ordenpago = mysql_fetch_array($selnumeroordenpago))
			{
				//echo "$query_selnumeroordenpago <br>as".$row_ordenpago['numeroordenpago'];
				$this->ordenesdepago[] = new Ordenpago($this->sala, $row_ordenpago['codigoestudiante'], $row_ordenpago['codigoperiodo'], $row_ordenpago['numeroordenpago']);
			}
		}
		else
		{
			$this->ordenesdepago[] = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		}
	}

	function existe_conceptoordenesestudiante($concepto)
	{
		foreach($this->$ordenesdepago as $key2 => $ordenpago)
		{
			if($ordenpago->existe_conceptoordenpago($value))
			{
				return true;
			}
		}
		return false;
	}

	// Esta funcion valida si existen conceptos por inscripción
	// Retorna un arreglo asociativo con los conceptos de inscripcion si existen o falso si no hay conceptos
	// La función retorna los conceptos que estan pagos, los que estan por pagar y los que estan en proceso de pago
	function existe_conceptosinscripcion(&$pagos, &$porpagar, &$enproceso, &$sinpagar, &$cuentaconceptos)
	{
		$cuentaestadoconceptos['sinpagar'] = 0;
		$cuentaestadoconceptos['porpagar'] = 0;
		$cuentaestadoconceptos['pagos'] = 0;
		$cuentaestadoconceptos['enproceso'] = 0;

		// Selecciono los conceptos que son para inscripción y valido que existan en ordenes de pago activas para le estudiante
		$query_conceptosinscripcion = "SELECT c.nombreconcepto, c.codigoconcepto
		FROM concepto c
		WHERE c.codigoreferenciaconcepto = '600'";
		/*SELECT c.nombreconcepto, c.codigoconcepto
		FROM concepto c
		WHERE (c.codigoconcepto = '153' or c.codigoconcepto = '152' or c.codigoconcepto = 'C9023')
		SELECT c.nombreconcepto, c.codigoconcepto
		FROM concepto c
		WHERE c.codigoreferenciaconcepto = '600'*/

		//and dop.codigoconcepto = '151'
		//echo "$query_conceptosinscripcion<br>";
		$conceptosinscripcion = mysql_query($query_conceptosinscripcion,$this->sala) or die("$query_conceptosinscripcion<br>".mysql_error());
		$cuentaconceptos = mysql_num_rows($conceptosinscripcion);

		while($row_conceptosinscripcion = mysql_fetch_array($conceptosinscripcion))
		{
			$query_conceptosorden = "SELECT d.codigoconcepto, c.nombreconcepto, o.numeroordenpago, o.codigoestadoordenpago
			FROM detalleordenpago d, concepto c, ordenpago o
			WHERE d.numeroordenpago = o.numeroordenpago
			and c.codigoreferenciaconcepto = '600'
			and c.codigoconcepto = d.codigoconcepto
			and o.codigoestudiante = '$this->codigoestudiante'
			and o.codigoperiodo = '$this->codigoperiodo'
			and d.codigoconcepto = '".$row_conceptosinscripcion['codigoconcepto']."'
			and o.codigoestadoordenpago not like '2%'";
			//and dop.codigoconcepto = '151'
			//echo "$query_conceptosorden<br>";
			$conceptosorden = mysql_query($query_conceptosorden,$this->sala) or die("$query_conceptosorden<br>".mysql_error());
			$totalRows_conceptosorden = mysql_num_rows($conceptosorden);

			// Si el concepto existe en alguna orden para el periodo activo
			if($totalRows_conceptosorden != "")
			{
				$row_conceptosorden = mysql_fetch_array($conceptosorden);
				if(ereg("^1.+$",$row_conceptosorden['codigoestadoordenpago']))
				{
					$porpagar[] = $row_conceptosorden['codigoconcepto'];
					$cuentaestadoconceptos['porpagar'] = $cuentaestadoconcpetos['porpagar']+1;
				}
				if(ereg("^4.+$",$row_conceptosorden['codigoestadoordenpago']))
				{
					$pagos[] = $row_conceptosorden['codigoconcepto'];
					$cuentaestadoconceptos['pagos'] = $cuentaestadoconcpetos['pagos']+1;
				}
				if(ereg("^5.+$",$row_conceptosorden['codigoestadoordenpago']))
				{
					$pagos[] = $row_conceptosorden['codigoconcepto'];
					$cuentaestadoconceptos['pagos'] = $cuentaestadoconcpetos['pagos']+1;
				}
				if(ereg("^6.+$",$row_conceptosorden['codigoestadoordenpago']))
				{
					$enproceso[] = $row_conceptosorden['codigoconcepto'];
					$cuentaestadoconceptos['enproceso'] = $cuentaestadoconcpetos['enproceso']+1;
				}
			}
			else
			{
				//echo "<br>".$row_conceptosinscripcion['codigoconcepto'];
				$sinpagar[] = $row_conceptosinscripcion['codigoconcepto'];
				$cuentaestadoconceptos['sinpagar'] = $cuentaestadoconceptos['sinpagar']+1;
				//echo "<br>".$cuentaestadoconceptos['sinpagar'];
			}
		}
		return $cuentaestadoconceptos;
	}

	function existe_ordenespagas()
	{
		foreach($this->ordenesdepago as $key => $value)
		{
			$value->existe_ordenpago($estado);
			if($estado == "paga")
			{
				return true;
			}
		}
	}

	function existe_ordenesporpagar()
	{
		foreach($this->ordenesdepago as $key => $value)
		{
			$value->existe_ordenpago($estado);
			if($estado == "porpagar")
			{
				return true;
			}
		}
	}

	function existe_ordenesanuladas()
	{
		foreach($this->ordenesdepago as $key => $value)
		{
			$value->existe_ordenpago($estado);
			if($estado == "anulada")
			{
				return true;
			}
		}
	}

	function existe_ordenesenproceso()
	{
		foreach($this->ordenesdepago as $key => $value)
		{
			$value->existe_ordenpago($estado);
			if($estado == "enproceso")
			{
				return true;
			}
		}
	}

	// Muestra las ordenes de pago del estudiante y recibe los respectivos links a donde apunta la orden para ser visualizada
	// segun el caso, si es por pse, muestra el link para pse, si es a ver los datos de la orden sirve para visualizar lo
	function mostrar_ordenespago($ruta, $titulo, $rutaimpresion="")
	{
		require("mostrar_ordenespago.php");
	}
    
    function mostar_ordenpago_api($ruta, $titulo, $rutaimpresion="")
	{ 
		require("mostar_ordenpago_api.php");
        return $Dato;
	}

	function mostrar_ordenespago_resumido($ruta, $titulo, $rutaimpresion="")
	{
		require("mostrar_ordenespago_resumido.php");
	}

	function mostrar_generacionordenesinscripcion($conceptos, $generarambos=false)
	{
		require("mostrar_generacionordenesinscripcion.php");
	}

	// Esta función genera una orden con los concepto a pagar para la inscripción y/o formulario
	function generarordenpago_conceptosinscripcion($conceptos)
	{

		unset($this->ordenesdepago);
		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalconrecargo = $nuevaorden->insertarconceptospecuniarios_inscripcion($conceptos);
		// Para insertar la fecha de inscripciones se deben tener las fechas de pago en fechacarreraconcepto
		$nuevaorden->insertarfechaordenpago($nuevaorden->tomar_fechaconceptosbd($conceptos), $porcentajedetallefechafinanciera=0, $totalconrecargo);
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->ordenesdepago = $nuevaorden;

		$resultado = genera_prodiverso($nuevaorden->sala,$nuevaorden->numeroordenpago);//$numeroordenpago = '1019832';
		//var_dump($resultado); die;
		if($resultado['ERRNUM']!=0 || $resultado['ERRNUM']==='') {
			echo "<script>alert('La orden número '+".$nuevaorden->numeroordenpago."+' no pudo ser creada. Por favor tome nota de este número y contáctese con la universidad para recibir ayuda en este proceso. Gracias.')</script>";
			$nuevaorden->anular_ordenpago();
			exit();
		}
	}

	// Esta función genera una orden con los concepto a pagar para la inscripción y/o formulario
	function generarordenpago_conceptos($conceptos)
	{
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalconrecargo = $nuevaorden->insertarconceptospecuniarios_inscripcion($conceptos);
		// Para insertar la fecha de inscripciones se deben tener las fechas de pago en fechacarreraconcepto
		$nuevaorden->insertarfechaordenpago($nuevaorden->tomar_fechaconceptosbd($conceptos), $porcentajedetallefechafinanciera=0, $totalconrecargo);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
	}

	// Esta función genera una orden con los concepto a pagar para la matricula y recibe los conceptos pecuniarios a generar
	function generarordenpago_matricula()
	{
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalmatricula = $nuevaorden->insertarconcepto_matricula_cohorte();
		// L arefenercia para los conceptos de matricula es 100
		$totalpecuniarios = $nuevaorden->insertarconceptospecuniariosxcodigoreferenciaconcepto(100);
		// Para insertar las fechas de matriculas se deben tener las fechas de pago en fechafinanciera
		$nuevaorden->insertarfechasordenpago_fechafianciera($totalmatricula, $totalpecuniarios);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
	}
    /**********************************************************/
    function generarordenpago_matriculaEducacionContinuada($codigoconcepto,$valordetallecohorte){
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		//$totalmatricula = $nuevaorden->insertarconcepto_matricula_cohorte();
        //Inserta el detalle del al orden de pago
        $nuevaorden->insertardetalleordenpago($codigoconcepto, 1, $valordetallecohorte, 1);
        /********************************************/
        $nuevaorden->insertarprematricula(10);
        $nuevaorden->insertadetalleprematricula();
        /**********************************************/
		// L arefenercia para los conceptos de matricula es 100
		$totalpecuniarios = $nuevaorden->insertarconceptospecuniariosxcodigoreferenciaconcepto(100);
		// Para insertar las fechas de matriculas se deben tener las fechas de pago en fechafinanciera
		$nuevaorden->insertarfechasordenpago_fechafiancieraEducacion($valordetallecohorte);
        //insertarfechasordenpago_fechafiancieraEducacion
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
        
        return $nuevaorden;
	}
    
    /*********************************************************/
	// Esta función genera una orden con los concepto a pagar para la matricula y recibe los conceptos pecuniarios a generar
	// Teniendo en cunta que es para credito y cartera, recibe el procentaje con que se va a cobrar la orden
	function generarordenpago_matriculacyc($porcentaje = 100)
	{
		// Quita todas las ordenes almacenadas en la matricula, queda cloro que no se inserta nada en la prematricula
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);

		// Se inserta el registro de la prematricula
		$nuevaorden->insertarprematricula(10);

		// La orden de pago va a tener el estado 14 que es plan de pagos
		$nuevaorden->codigoestadoordenpago = 14;
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalmatricula = $nuevaorden->insertarconcepto_matricula_cohorte($porcentaje, false);
		// La refenercia para los conceptos de matricula es 100
		$totalpecuniarios = $nuevaorden->insertarconceptospecuniariosxcodigoreferenciaconcepto(100);
		// Para insertar las fechas de matriculas se deben tener las fechas de pago en fechafinanciera
		$nuevaorden->insertarfechasordenpago_fechafianciera($totalmatricula, $totalpecuniarios);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
	}

   function generarordenpago_matriculaabono($porcentaje = 100,$fechadetallefechafinanciera)
	{
		unset($this->ordenesdepago);
		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		$nuevaorden->insertarprematricula(10);
		$nuevaorden->codigoestadoordenpago = 10;
		$nuevaorden->insertarordenpago();
		$totalmatricula = $nuevaorden->insertarconcepto_matricula_cohorte($porcentaje, false);
		$nuevaorden->insertarfechaordenpago($fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalmatricula);
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
		return $nuevaorden->numeroordenpago;
	}

	// Esta función genera una orden con los concepto a pagar para la inscripción y/o formulario, donde los valores del concepto se pasan en un arreglo
	function generarordenpago_conceptosconvalor($conceptos1, $conceptos2)
	{
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalconrecargo = $nuevaorden->insertarconceptospecuniariosvalor_inscripcion($conceptos2);
		// Para insertar la fecha de inscripciones se deben tener las fechas de pago en fechacarreraconcepto
		$nuevaorden->insertarfechaordenpago($nuevaorden->tomar_fechaconceptosbd($conceptos1), $porcentajedetallefechafinanciera=0, $totalconrecargo);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
	}

	// Esta función genera una orden con los concepto a pagar para la inscripción y/o formulario y las cantidades por cada concepto
	function generarordenpago_conceptoscantidad($conceptos, $cantidades, $observacion = "")
	{
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo, 0, 1, 0, 10, '01', $observacion);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalconrecargo = $nuevaorden->insertarconceptospecuniarios_inscripcioncantidad($conceptos, $cantidades);
		//exit();
		// Para insertar la fecha de inscripciones se deben tener las fechas de pago en fechacarreraconcepto
		$nuevaorden->insertarfechaordenpago($nuevaorden->tomar_fechaconceptosbd($conceptos), $porcentajedetallefechafinanciera=0, $totalconrecargo);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
	}

	// Esta función genera una orden con los concepto a pagar para la inscripción y/o formulario, donde los valores del concepto se pasan en un arreglo
	// y las cantidades por cada orden también se pasan en un arreglo
	function generarordenpago_conceptosconvalorcantidad($conceptos1, $conceptos2, $cantidades, $observacion = "")
	{
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo, 0, 1, 0, 10, '01', $observacion);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalconrecargo = $nuevaorden->insertarconceptospecuniariosvalor_inscripcioncantidad($conceptos2, $cantidades);
		// Para insertar la fecha de inscripciones se deben tener las fechas de pago en fechacarreraconcepto
		$nuevaorden->insertarfechaordenpago($nuevaorden->tomar_fechaconceptosbd($conceptos1), $porcentajedetallefechafinanciera=0, $totalconrecargo);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
	}

	// Esta función genera una orden con los conceptos a pagar para cualquier concepto con una fecha definida
	function generarordenpago_conceptos_fecha($conceptos, $cantidades, $fechadepago)
	{
		unset($this->ordenesdepago);

		/*echo "<h1>".$conceptos[0]." 1 ".$cantidades[$conceptos[0]];
		exit();*/
		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		//echo "<h1>idsubperiodo=".$nuevaorden->idsubperiodo."</h1>";
		$nuevaorden->idsubperiodo = $nuevaorden->tomarbd_subperiodo_fecha($fechadepago);
		$nuevaorden->idsubperiododestino = $nuevaorden->idsubperiodo ;
		//echo "<h1>idsubperiodo=".$nuevaorden->idsubperiodo."</h1>";
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalconrecargo = $cantidades[$conceptos[0]];
		$nuevaorden->insertardetalleordenpago($conceptos[0], 1, $cantidades[$conceptos[0]], 3);
		// Para insertar la fecha de inscripciones se deben tener las fechas de pago en fechacarreraconcepto
		$nuevaorden->insertarfechaordenpago($fechadepago, $porcentajedetallefechafinanciera=0, $totalconrecargo);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
	}

	// Esta función genera una orden con los concepto a pagar para la matricula y recibe los conceptos pecuniarios a generar
	function generarordenpago_matricula_fecha($conceptos, $cantidades, $fechadepago)
	{
		unset($this->ordenesdepago);

		$nuevaorden = new Ordenpago($this->sala, $this->codigoestudiante, $this->codigoperiodo);
		// Para insertar la orden de pago se requiere de periodo y subperiodo para la carrera
		$nuevaorden->insertarordenpago();
		// Para insertar los conceptos pecuniarios se requiere valida detallefacturavalorpecuniario, facturavalorpecuniario y conceptos
		$totalconrecargo = $cantidades[$conceptos[0]];
		//$totalmatricula = $nuevaorden->insertarconcepto_matricula_cohorte();
		$nuevaorden->insertardetalleordenpago($conceptos[0], 1, $cantidades[$conceptos[0]], 3);

		// L arefenercia para los conceptos de matricula es 100
		$totalpecuniarios = $nuevaorden->insertarconceptospecuniariosxcodigoreferenciaconcepto(100);
		// Para insertar las fechas de matriculas se deben tener las fechas de pago en fechafinanciera
		$totalconrecargo = $totalconrecargo + $totalpecuniarios;
		$nuevaorden->insertarfechaordenpago($fechadepago, $porcentajedetallefechafinanciera=0, $totalconrecargo);
		//$nuevaorden->insertarfechasordenpago_fechafianciera($totalmatricula, $totalpecuniarios);
		// Para insertar los bancos se debe tener los bancos para el periodo activo, y las cuentas
		$nuevaorden->insertarbancosordenpago();
		$nuevaorden->enviarsap_orden();
		$nuevaorden->ordenesdepago = $nuevaorden;
                return $nuevaorden->ordenesdepago;
	}

	// Valida la generacion de ordenes
	function validar_generacionordenesinscripcion()
	{
		return $this->ordenesdepago[0]->valida_ordeninscripcion();
	}

	// Valida la generacion de ordenes
	function validar_generacionordenesmatricula($Opcion='')
	{
		return $this->ordenesdepago[0]->valida_ordenmatricula($Opcion);
	}

	// Valida la generacion de ordenes
	function validar_generacionordenesvarias($conceptos)
	{
		return $this->ordenesdepago[0]->valida_ordenvarias($conceptos);
	}

	function mostrar_ordenesporpagarvencidas($ruta, $rutaimpresion="")
	{
		foreach($this->ordenesdepago as $key => $orden)
		{
			if(!$orden->ordenvigente())
			{
				//echo "RUTA: $rutaimpresion";
				$orden->mostrar_ordenpagoporpagar($ruta, $rutaimpresion);
			}
		}
	}

	function mostrar_ordenesporpagarvencidas_resumido($ruta, $rutaimpresion="")
	{
		foreach($this->ordenesdepago as $key => $orden)
		{
			if(!$orden->ordenvigente())
			{
				$this->numerodeordenesimpresas++;
				if($this->numerodeordenesimpresas > 1)
				{
					echo '<tr bgcolor="#FEF7ED">';
				}
				//echo "RUTA: $rutaimpresion";
				$orden->mostrar_ordenpagoporpagar_resumido($ruta, $rutaimpresion);
			}
		}
		$this->numerodeordenesimpresas--;
	}

	function mostrar_ordenesporpagarvigentes($ruta, $rutaimpresion="")
	{
		

		foreach($this->ordenesdepago as $key => $orden)
		
		{
			
			
			if($orden->ordenvigente())
			{
				
				
				
				//echo "RUTA: $rutaimpresion";
				$orden->mostrar_ordenpagoporpagar($ruta, $rutaimpresion);
				
			}
		}
	}
    
  	function mostrar_ordenesporpagarvigentes_api($ruta, $rutaimpresion=""){
  	 
			foreach($this->ordenesdepago as $key => $orden){
			
			if($orden->ordenvigente()){
				
				$data[] = $orden->arreglo_ordenpagoporpagar($ruta, $rutaimpresion);
				
			}
		}
       return $data;
	}//function mostrar_ordenesporpagarvigentes_api

	function mostrar_ordenesporpagarvigentes_resumido($ruta, $rutaimpresion="")
	{
		foreach($this->ordenesdepago as $key => $orden)
		{
			//$cuenta++;
			if($orden->ordenvigente())
			{
				$this->numerodeordenesimpresas++;
				if($this->numerodeordenesimpresas > 1)
				{
					echo '<tr bgcolor="#FEF7ED">';
				}
				//echo "RUTA: $rutaimpresion";
				$orden->mostrar_ordenpagoporpagar_resumido($ruta, $rutaimpresion);
			}
		}
		$this->numerodeordenesimpresas--;
	}

	function numerodeordenes()
	{
		return count($this->ordenesdepago);
	}

	function existenordenesdepago()
	{
		foreach($this->ordenesdepago as $key => $value)
		{
			if(!$value->existe_ordenpago($estado))
			{
				return false;
			}
		}
		return true;
	}
}

?>
