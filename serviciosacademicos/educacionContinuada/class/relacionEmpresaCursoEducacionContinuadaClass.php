<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of relacionEmpresaCursoEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class relacionEmpresaCursoEducacionContinuadaClass {
    
    var $idrelacionEmpresaCursoEducacionContinuada = null;
    var $idgrupo = null;
    var $idempresa = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdrelacionEmpresaCursoEducacionContinuada() {
        return $this->idrelacionEmpresaCursoEducacionContinuada;
    }

    public function setIdrelacionEmpresaCursoEducacionContinuada($idrelacionEmpresaCursoEducacionContinuada) {
        $this->idrelacionEmpresaCursoEducacionContinuada = $idrelacionEmpresaCursoEducacionContinuada;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function getIdempresa() {
        return $this->idempresa;
    }

    public function setIdempresa($idempresa) {
        $this->idempresa = $idempresa;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }
        
    public function __destruct() {
        
    }
}
?>
