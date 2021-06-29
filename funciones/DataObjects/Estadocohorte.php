<?php
/**
 * Table Definition for estadocohorte
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadocohorte extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'estadocohorte';                   // table name
    var $codigoestadocohorte;             // string(2)  not_null primary_key
    var $nombreestadocohorte;             // string(20)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadocohorte',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
