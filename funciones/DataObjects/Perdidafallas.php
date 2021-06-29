<?php
/**
 * Table Definition for perdidafallas
 */
require_once 'DB/DataObject.php';

class DataObjects_Perdidafallas extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'perdidafallas';                   // table name
    var $idperdidafallas;                 // int(11)  not_null primary_key auto_increment
    var $fechaperdidafallas;              // datetime(19)  not_null binary
    var $codigoestudiante;                // int(11)  not_null multiple_key
    var $codigoperiodo;                   // string(8)  not_null multiple_key
    var $numeroautorizaperdidafallas;     // int(6)  not_null
    var $fechainicioautorizaperdidafallas;    // datetime(19)  not_null binary
    var $fechafinalautorizaperdidafallas;    // datetime(19)  not_null binary
    var $usuario;                         // string(50)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Perdidafallas',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
