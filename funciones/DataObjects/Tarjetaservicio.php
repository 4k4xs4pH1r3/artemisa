<?php
/**
 * Table Definition for tarjetaservicio
 */
require_once 'DB/DataObject.php';

class DataObjects_Tarjetaservicio extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tarjetaservicio';                 // table name
    var $idtarjetaservicio;               // int(11)  not_null primary_key auto_increment
    var $fechatarjetaservicio;            // datetime(19)  not_null binary
    var $codigoareaadministrativa;        // string(15)  not_null multiple_key
    var $responsabletarjetaservicio;      // string(50)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tarjetaservicio',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
