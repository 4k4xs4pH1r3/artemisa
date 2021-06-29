<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class EstudianteGeneral{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idEstudiante;
	
	/**
	 * @type TipoDocumento
	 * @access private
	 */
	private $tipoDocumento;
	
	/**
	 * @type int
	 * @access private
	 */
	private $numeroDocumento;
	
	/**
	 * @type String
	 * @access private
	 */
	private $expedidoDocumento;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreEstudiante;
	
	/**
	 * @type String
	 * @access private
	 */
	private $apellidoEstudiante;
	
	/**
	 * @type Ciudad
	 * @access private
	 */
	private $ciudad;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaNacimiento;
	
	/**
	 * @type String
	 * @access private
	 */
	private $direccion;
	
	/**
	 * @type int
	 * @access private
	 */
	private $telefono;
	
	/**
	 * @type int
	 * @access private
	 */
	private $celular;	
	
	/**
	 * @type string
	 * @access private
	 */
	private $email;
	
	/**
	 * @type string
	 * @access private
	 */
	private $emailSecundario;
	
	/**
	 * @type string
	 * @access private
	 */
	private $emailPadre;
	
	/**
	 * @type string
	 * @access private
	 */
	private $estadoCivilEstudiante;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoActualizaDato;
	
	/**
	 * @type Genero
	 * @access private
	 */
	private $genero;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function EstudianteGeneral( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del estudiante
	 * @param int $idEstudiante
	 * @access public
	 * @return void
	 */
	public function setIdEstudiante( $idEstudiante ){
		$this->idEstudiante = $idEstudiante;
	}
	
	/**
	 * Retorna el identificador del estudiante
	 * @access public
	 * @return int
	 */
	public function getIdEstudiante( ){
		return $this->idEstudiante;
	}
	
	/**
	 * Modifica el tipo de documento del estudiante
	 * @param TipoDocumento $tipoDocumento
	 * @access public
	 * @return void
	 */
	public function setTipoDocumento( $tipoDocumento ){
		$this->tipoDocumento = $tipoDocumento;
	}
	
	/**
	 * Retorna el tipo de documento del estudiante
	 * @access public 
	 * @return TipoDocumento
	 */
	public function getTipoDocumento( ){
		return $this->tipoDocumento;
	}
	
	/**
	 * Modifica el numero de documento del estudiante
	 * @param int $numeroDocumento
	 * @access public
	 * @return void
	 */
	public function setNumeroDocumento( $numeroDocumento ){
		$this->numeroDocumento = $numeroDocumento;
	}
	
	/**
	 * Retorna el numero de documento del estudiante
	 * @access public
	 * @return int
	 */
	public function getNumeroDocumento( ){
		return $this->numeroDocumento;
	}
	
	/**
	 * Modifica el lugar de expedición del documento
	 * @param string $expedidoDocumento
	 * @access public
	 * @return void
	 */
	public function setExpedicion( $expedidoDocumento ){
		$this->expedidoDocumento = $expedidoDocumento;
	}
	
	/**
	 * Retorna el el lugar de expedición del documento
	 * @access public
	 * @return String
	 */
	public function getExpedicion( ){
		return $this->expedidoDocumento;
	}
	
	/**
	 * Modifica el nombre del estudiante
	 * @param string $nombreEstudiante
	 * @access public
	 * @return void
	 */
	public function setNombreEstudiante( $nombreEstudiante ){
		$this->nombreEstudiante = $nombreEstudiante;
	}
	
	/**
	 * Retorna el nombre del Estudiante
	 * @access public
	 * @return String
	 */
	public function getNombreEstudiante( ){
		return $this->nombreEstudiante;
	}
	
	/**
	 * Modifica el apellido del estudiante
	 * @param string $apellidoEstudiante
	 * @access public
	 * @return void
	 */
	public function setApellidoEstudiante( $apellidoEstudiante ){
		$this->apellidoEstudiante = $apellidoEstudiante;
	}
	
	/**
	 * Retorna el apellido del estudiante
	 * @access public
	 * @return string
	 */
	public function getApellidoEstudiante( ){
		return $this->apellidoEstudiante;
	}
	
	/**
	 * Modifica la ciudad del estudiante
	 * @param Ciudad $ciudad
	 * @access public
	 * @return void
	 */
	public function setCiudad( $ciudad ){
		$this->ciudad = $ciudad;
	}
	
	/**
	 * Retorna la ciudad del estudiante
	 * @access public
	 * @return Ciudad
	 */
	public function getCiudad( ){
		return $this->ciudad;
	}
	
	/**
	 * Modifica la fecha de nacimiento del estudiante
	 * @param date $fechaNacimiento
	 * @access public
	 * @return void
	 */
	public function setFechaNacimiento( $fechaNacimiento ){
		$this->fechaNacimiento = $fechaNacimiento;
	}
	
	/**
	 * Retorna la fecha de nacimiento del estudiante
	 * @access public
	 * @return date
	 */
	public function getFechaNacimiento( ){
		return $this->fechaNacimiento;
	}
	
	/**
	 * Modifica la dirección del estudiante
	 * @param string $direccion
	 * @access public
	 * @return void
	 */
	public function setDireccion( $direccion ){
		$this->direccion = $direccion;
	}
	
	/**
	 * Retorna la dirección del estudiante
	 * @access public
	 * @return string
	 */
	public function getDireccion( ){
		return $this->direccion;
	}
	
	/**
	 * Modifica el telefono del estudiante
	 * @param int $$telefono
	 * @access public
	 * @return void
	 */
	public function setTelefono( $telefono ){
		$this->telefono = $telefono;
	}
	
	/**
	 * Retorna el telefono del estudiante
	 * @access public
	 * @return int
	 */
	public function getTelefono( ){
		return $this->telefono;
	}
	
	/**
	 * Modifica el celular del estudiante
	 * @param int $celular
	 * @access public
	 * @return void
	 */
	public function setCelular( $celular ){
		$this->celular = $celular;
	}
	
	/**
	 * Retorna el celular del estudiante
	 * @access public
	 * @return int
	 */
	public function getCelular( ){
		return $this->celular;
	}
	
	/**
	 * Modifica el email del estudiante
	 * @param string $email
	 * @access public
	 * @return void
	 */
	public function setEmail( $email ){
		$this->email = $email;
	}
	
	/**
	 * Retorna el email del estudiante
	 * @access public
	 * @return string
	 */
	public function getEmail( ){
		return $this->email;
	}
	
	/**
	 * Modifica el email secundario del estudiante
	 * @param string $emailSecundario
	 * @access public
	 * @return void
	 */
	public function setEmailSecundario( $emailSecundario ){
		$this->emailSecundario = $emailSecundario;
	}
	
	/**
	 * Retorna el email secundario del estudiante
	 * @access public
	 * @return string
	 */
	public function getEmailSecundario( ){
		return $this->emailSecundario;
	}
	
	/**
	 * Modifica el email del padre del estudiante
	 * @param string $emailPadre
	 * @access public
	 * @return void
	 */
	public function setEmailPadre( $emailPadre ){
		$this->emailPadre = $emailPadre;
	}
	
	/**
	 * Retorna el email del padre del estudiante
	 * @access public
	 * @return string
	 */
	public function getEmailPadre( ){
		return $this->emailPadre;
	}
	
	/**
	 * Modifica el estado civil del estudiante
	 * @param string $estadoCivilEstudiante
	 * @access public
	 * @return void
	 */
	public function setEstadoCivilEstudiante( $estadoCivilEstudiante ){
		$this->estadoCivilEstudiante = $estadoCivilEstudiante;
	}
	
	/**
	 * Retorna el estado civil del estudiante
	 * @access public
	 * @return string
	 */
	public function getEstadoCivilEstudiante( ){
		return $this->estadoCivilEstudiante;
	}
	
	/**
	 * Modifica el estado de actualización de los datos
	 * @param int $estadoActualizaDato
	 * @access public
	 * @return void
	 */
	public function setEstadoActualizaDato( $estadoActualizaDato ){
		$this->estadoActualizaDato = $estadoActualizaDato;
	}
	
	/**
	 * Retorna el estado de actualización de los datos
	 * @access public
	 * @return string
	 */
	public function getEstadoActualizaDato( ){
		return $this->estadoActualizaDato;
	}
	
	
	/**
	 * Modifica el genero de los estudiante
	 * @param int $genero
	 * @access public
	 * @return void
	 */
	public function setGenero( $genero ){
		$this->genero = $genero;
	}
	
	/**
	 * Retorna el genero de los estudiante
	 * @access public
	 * @return string
	 */
	public function getGenero( ){
		return $this->genero;
	}
	
	/**
	 * Actualizar Email Estudiante
	 * @param int $txtIdRegistroGrado, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function actualizarEstudianteEmailSecundario( $txtEmailAlterno, $txtIdEstudiante ){
		
		$sql = "UPDATE estudiantegeneral
					SET email2estudiantegeneral = ?,
					fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
				WHERE idestudiantegeneral = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $txtEmailAlterno , true );
		$this->persistencia->setParametro( 1 , $txtIdEstudiante , false );
		//echo $this->persistencia->getSQLListo( );
		$estado = $this->persistencia->ejecutarUpdate( );
		
		if( $estado )
			$this->persistencia->confirmarTransaccion( );
		else	
			$this->persistencia->cancelarTransaccion( );
					
		//$this->persistencia->freeResult( );
		return $estado;
	}
	
	
		
  }
?>