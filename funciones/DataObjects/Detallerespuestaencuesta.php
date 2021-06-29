<?php
/**
 * Table Definition for detallerespuestaencuesta
 */
require_once 'DB/DataObject.php';

class DataObjects_Detallerespuestaencuesta extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'detallerespuestaencuesta';        // table name
    var $iddetallerespuestaencuesta;      // int(11)  not_null primary_key auto_increment
    var $idindicadorpreguntaaspecto;      // int(11)  not_null multiple_key
    var $idrespuestaencuesta;             // int(11)  not_null multiple_key
    var $idpreguntasubpregunta;           // string(3)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Detallerespuestaencuesta',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
