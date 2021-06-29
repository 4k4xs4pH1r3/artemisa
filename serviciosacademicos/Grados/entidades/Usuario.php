<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 
 include ('../../../kint/Kint.class.php');
 class Usuario extends Persona{
 	
	/**
	 * @type String 
	 * @access private
	 */
	private $user;
	
	/**
	 * $type String
	 * @access private
	 */
	private $pass;
	
	/**
	 * @type String
	 * @access private
	 */
	private $rol;
	
	/**
	 * @type Carrera
	 * @access private
	 */
	private $carrera;
        
        /*
         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
         * Se agrega al objeto el campo emailusuariofacultad para enviar correos a el email registrado
         * @since  Marzo 14, 2017
        */
	/**
	 * @type String
	 * @access private
	 */
        private $emailusuariofacultad;
	/*FIN MODIFICACION*/
        
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Usuario( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el nombre de usuario del usuario
	 * @param String $usuario
	 * @access public
	 * @return void
	 */
	public function setUser( $user ){
		$this->user = $user;
	}
	
	/**
	 * Retorna el nombre de usuario del usuario
	 * @access public
	 * @return String
	 */
	public function getUser( ){
		return $this->user;
	}
	
	/**
	 * Modifica la clave del usuario
	 * @param String $clave
	 * @access public
	 * @return void
	 */
	public function setPass( $pass ){
		$this->pass = $pass;
	}
	
	/**
	 * Retorna la clave del usuario
	 * @access public 
	 * @return String
	 */
	public function getPass( ){
		return $this->pass;
	}
	
	
	/**
	 * Modifica el rol del usuario 
	 * @param Rol $rol
	 * @access public
	 * @return void
	 */
	public function setRol ( $rol ) {
		$this->rol = $rol;
	}


	/**
	 * Retorna el rol del usuario 
	 * @access public
	 * @return Rol
	 */
	public function getRol (  ) {
		return $this->rol;
	}
	
	/**
	 * Modifica la carrera del usuario 
	 * @param Carrera $carrera
	 * @access public
	 * @return void
	 */
	public function setCarrera ( $carrera ) {
		$this->carrera = $carrera;
	}

	/**
	 * Retorna la carrera del usuario 
	 * @access public
	 * @return Carrera
	 */
	public function getCarrera (  ) {
		return $this->carrera;
	}
        
        /*
         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
         * Se agrega al objeto el campo emailusuariofacultad para enviar correos a el email registrado
         * @since  Marzo 14, 2017
        */
        
	/**
	 * Retorna el email usuario facultad 
	 * @access public
	 * @return String
	 */
	function getEmailusuariofacultad() {
            return $this->emailusuariofacultad;
        }

        /**
	 * Modifica el email usuario facultad 
	 * @param string $emailusuariofacultad
	 * @access public
	 * @return void
	*/
        function setEmailusuariofacultad($emailusuariofacultad) {
            $this->emailusuariofacultad = $emailusuariofacultad;
        }
        /*FIN MODIFICACION*/
        	
	/**
	 * Funcion Autenticar Usuario
	 */
	public function login( ){
		$sql = "SELECT U.idusuario
				FROM usuario U
				WHERE U.usuario = ?
				";
		$this->persistencia->conectar( );
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
	}
	
	
	/**
	 * Busca un usuario por Id
	 * @access public
	 * @return void
	 */
	public function buscarId( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario, R.idrol, R.nombrerol
				FROM usuario U
				INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				INNER JOIN PermisoGrados pg on UR.idrol = pg.RolId
				WHERE U.idusuario = ?";
		/*
		* Ivan Dario quintero Rios <quinteroivan@unbosque.edu.co>
		* Modificado 05 julio 2017 - 12:49:00 
		* Ajuste para validar roles de permisos de grado sin validar los roles especificos
		*/
		//AND R.idrol in (3, 13, 7, 93, 20, 53, 89)
		/*
		* END
		*/
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getId( ) , false );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$rol = new Rol( null );
			$rol->setId( $this->persistencia->getParametro( "idrol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nombrerol" ) );
			$this->setRol( $rol );
		}
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->freeResult( );
		
	}
	
	/**
	 * Busca un usuario por usuario
	 * @access public
	 * @return void
	 */
	public function buscar( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario, R.idrol, R.nombrerol, CU.claveusuario
				FROM usuario U
				INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				INNER JOIN claveusuario CU ON ( CU.idusuario = U.idusuario )
				INNER JOIN PermisoGrados pg on UR.idrol = pg.RolId
				WHERE U.usuario = ?
				AND CU.codigoestado = 100";
		/*
		* Ivan Dario quintero Rios <quinteroivan@unbosque.edu.co>
		* Modificado 05 julio 2017 - 12:49:00 
		* Ajuste para validar roles de permisos de grado sin validar los roles especificos
		*/
		/*AND CU.claveusuario = ?
		AND UR.idrol in (3, 13, 7, 93, 20, 53, 89)*/
		
		/*
		* END
		*/
		
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		//$this->persistencia->setParametro( 1 , $this->getPass( ) , true );		
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$rol = new Rol( null );
			$rol->setId( $this->persistencia->getParametro( "idrol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nombrerol" ) );
			$this->setRol( $rol );
		}
		
		$this->persistencia->freeResult( );
	}
	
	/**
	 * Busca un usuario por usuario
	 * @access public
	 * @return void
	 */
	/*public function buscarUsuarioEstudiante( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario, R.idrol, R.nombrerol, CU.claveusuario
				FROM usuario U
				INNER JOIN rol R ON ( R.idrol = U.codigorol )
				INNER JOIN claveusuario CU ON ( CU.idusuario = U.idusuario )
				WHERE U.usuario = ?
				AND CU.claveusuario = ?
				AND U.codigorol = 1
				AND CU.codigoestado = 100";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		$this->persistencia->setParametro( 1 , $this->getPass( ) , true );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$rol = new Rol( null );
			$rol->setId( $this->persistencia->getParametro( "idrol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nombrerol" ) );
			$this->setRol( $rol );
		}
		
		$this->persistencia->freeResult( );
	}*/
	
	
	
	/**
	 * Actualiza la clave un usuario
	 * @access public
	 * @return void
	 */
	public function actualizarClave ( ) {
		$sql = "UPDATE usuario 
				SET pass_usua = ? 
				WHERE codi_sist = 'CA'
				AND fech_fina is null
				AND logi_usua = ?
				AND iden_pers = ?";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		
		$this->persistencia->setParametro( 0 , $this->getPass( ) , true );
		$this->persistencia->setParametro( 1 , $this->getUser( ) , true );
		$this->persistencia->setParametro( 2 , $this->getId( ) , true );
		
		$this->persistencia->ejecutarUpdate( );
		
		$this->persistencia->confirmarTransaccion( );

	}
	
	
	/**
	 * Busca un usuario por Id
	 * @access public
	 * @return void
	 */
	public function buscarRecuperar( ){
		$sql = "SELECT U.iden_pers, F.nom1_func, F.nom2_func, F.ape1_func, F.ape2_func , U.logi_usua , U.pass_usua , 
						R.codi_rol, R.nomb_rol, R.desc_rol, R.priv_rol
				FROM usuario U, funcionario F, rol R
				WHERE U.logi_usua = ?
				AND U.codi_sist = 'CA'
				AND U.fech_fina is null
				AND F.iden_pers = U.iden_pers
				AND U.codi_rol = R.codi_rol";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getUser( ) , true );
		//echo $this->persistencia->getSQLListo( );
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "iden_pers" ) );
			$this->setNombre1( $this->persistencia->getParametro( "nom1_func" ) );
			$this->setNombre2( $this->persistencia->getParametro( "nom2_func" ) );
			$this->setApellido1( $this->persistencia->getParametro( "ape1_func" ) );
			$this->setApellido2( $this->persistencia->getParametro( "ape2_func" ) );
			$this->setUser( $this->persistencia->getParametro( "logi_usua" ) );
			$this->setPass( $this->persistencia->getParametro( "pass_usua" ) );
			
			$rol = new Rol( null );
			$rol->setId( $this->persistencia->getParametro( "codi_rol" ) );
			$rol->setNombre( $this->persistencia->getParametro( "nomb_rol" ) );
			$rol->setRelacion( $this->persistencia->getParametro( "desc_rol" ) );
			$this->setRol( $rol );
		}
	}


	/**
	 * Consulta Usuarios Decanos, Coordinadores, Secretarios por Facultad
	 * @access public
	 * @return Array
	 */
	public function consultarUsuariosFacultad( $codigoFacultad, $codigoCarrera ){
		$usuarios = array( );
                /*
                 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                 * Se agrega a la seleccion el campo UF.emailusuariofacultad para enviar correos a el email registrado
                 * @since  Marzo 14, 2017
                */
		$sql = "SELECT DISTINCT
					U.usuario, F.codigofacultad, F.nombrefacultad, C.codigocarrera, C.nombrecarrera, UF.emailusuariofacultad
				FROM
					usuario U
				INNER JOIN usuariofacultad UF ON ( U.usuario = UF.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				INNER JOIN carrera C ON ( C.codigocarrera = UF.codigofacultad )
				INNER JOIN facultad F ON ( F.codigofacultad = C.codigofacultad )
				WHERE
					UR.idrol = 93
				AND C.codigomodalidadacademica IN (200,300)
				AND F.codigofacultad = ?
				AND C.codigocarrera = ?
				AND U.idusuario != 47327
				GROUP BY
					U.idusuario";
					
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $codigoFacultad , false );
		$this->persistencia->setParametro( 1 , $codigoCarrera , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		while( $this->persistencia->getNext( ) ){
			$usuario = new Usuario( $this->persistencia );
			$usuario->setUser( $this->persistencia->getParametro( "usuario" ) );
			
			$facultad = new Facultad( null );
			$facultad->setCodigoFacultad( $this->persistencia->getParametro( "codigofacultad" ) );
			$facultad->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ) );
			
			$carrera = new Carrera( null );
			$carrera->setCodigoCarrera( $this->persistencia->getParametro( "codigocarrera" ) );
			$carrera->setNombreCarrera( $this->persistencia->getParametro( "nombrecarrera" ) );
			
			$carrera->setFacultad( $facultad );
			
			$usuario->setCarrera( $carrera );
                        /*
                         * @modified Andres Ariza <arizaandres@unbosque.edu.co>
                         * Se agrega al objeto el campo emailusuariofacultad para enviar correos a el email registrado
                         * @since  Marzo 14, 2017
                        */
                        $usuario->setEmailusuariofacultad( $this->persistencia->getParametro( "emailusuariofacultad" ) );
			/*FIN*/
			$usuarios[ count( $usuarios ) ] = $usuario;
		}
		$this->persistencia->freeResult( );
		
		return 	$usuarios;		
	}


	/**
	 * Buscar Usuario Decano
	 * @param $txtCodigoCarrera
	 * @access public 
	 * @return void
	 */
	public function buscarUsuarioDecano( ){
		$sql = "SELECT DISTINCT U.idusuario, U.nombres, U.apellidos, U.usuario
				FROM usuario U
				INNER JOIN usuariofacultad UF ON ( UF.usuario = U.usuario )
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
                INNER JOIN usuariorol UR ON (UR.idusuariotipo = UT.UsuarioTipoId)
				INNER JOIN rol R ON ( R.idrol = UR.idrol )
				WHERE UF.codigofacultad = ?
				AND U.codigotipousuario = 400
				AND R.idrol = 93
				AND U.nombres like 'De%'
				AND U.fechavencimientousuario >= CURDATE()
				AND U.idusuariopadre = 0";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $this->getCarrera( )->getCodigoCarrera( ) , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setNombres( $this->persistencia->getParametro( "nombres" ) );
			$this->setApellidos( $this->persistencia->getParametro( "apellidos" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
		}
		
		$this->persistencia->freeResult( );
		
	}
	
	/**
	 * Buscar Usuario por Documento
	 * @param $txtNumeroDocumento
	 * @access public 
	 * @return void
	 */
	public function buscarUsuarioDocumento( $txtNumeroDocumento ){
		$sql = "SELECT idusuario, usuario
				FROM usuario
				WHERE numerodocumento = ?
				AND codigotipousuario = 600";
		
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtNumeroDocumento , false );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta( );
		if( $this->persistencia->getNext( ) ){
			$this->setId( $this->persistencia->getParametro( "idusuario" ) );
			$this->setUser( $this->persistencia->getParametro( "usuario" ) );
		}
		
		$this->persistencia->freeResult( );
		
	}

	/**
	 * Consutal emila  usurariofacultad
	 * @param $idUsuario , $idCarrera
	 * @access public 
	 * @return void
	 */
	
	public function consultarEmailusuariofacultad ( $idUsuario , $idCarrera ){

		$sql = "
				SELECT DISTINCT
					UF.emailusuariofacultad
				FROM
					usuario U
				INNER JOIN usuariofacultad UF ON (U.usuario = UF.usuario)
				INNER JOIN UsuarioTipo UT ON (UT.UsuarioId = U.idusuario)
				INNER JOIN usuariorol UR ON (
					UR.idusuariotipo = UT.UsuarioTipoId
				)
				INNER JOIN rol R ON (R.idrol = UR.idrol)
				INNER JOIN carrera C ON (
					C.codigocarrera = UF.codigofacultad
				)
				INNER JOIN facultad F ON (
					F.codigofacultad = C.codigofacultad
				)
				WHERE
					UF.usuario = ?
				AND C.codigocarrera = ?
				AND UF.emailusuariofacultad <> ''
				GROUP BY
					UF.emailusuariofacultad	";		

			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $idUsuario , true );
			$this->persistencia->setParametro( 1 , $idCarrera , true );
			$this->persistencia->ejecutarConsulta( );	
		
			if( $this->persistencia->getNext( ) ){
				$mail = $this->setEmailusuariofacultad( $this->persistencia->getParametro( "emailusuariofacultad" ) );
			}
				$this->persistencia->freeResult( );	
		
		}	
	
 }
?>