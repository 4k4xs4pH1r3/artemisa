<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formUnidadesAcademicasAulasVirtualesClass
 *
 * @author proyecto_mgi_cp
 */
class formUnidadesAcademicasAulasVirtualesClass {
    
    var $idsiq_formUnidadesAcademicasAulasVirtuales = null;
    var $codigoperiodo = null;
    var $codigocarrera = null;
    var $numAsignaturas = null;
    var $numAulasVirtuales = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formUnidadesAcademicasAulasVirtuales() {
        return $this->idsiq_formUnidadesAcademicasAulasVirtuales;
    }

    public function setIdsiq_formUnidadesAcademicasAulasVirtuales($idsiq_formUnidadesAcademicasAulasVirtuales) {
        $this->idsiq_formUnidadesAcademicasAulasVirtuales = $idsiq_formUnidadesAcademicasAulasVirtuales;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getNumAsignaturas() {
        return $this->numAsignaturas;
    }

    public function setNumAsignaturas($numAsignaturas) {
        $this->numAsignaturas = $numAsignaturas;
    }

    public function getNumAulasVirtuales() {
        return $this->numAulasVirtuales;
    }

    public function setNumAulasVirtuales($numAulasVirtuales) {
        $this->numAulasVirtuales = $numAulasVirtuales;
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
