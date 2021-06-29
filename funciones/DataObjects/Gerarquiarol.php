<?php
/**
 * Table Definition for gerarquiarol
 */
require_once 'DB/DataObject.php';

class DataObjects_Gerarquiarol extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'gerarquiarol';                    // table name
    var $codigogerarquiarol;              // string(2)  not_null primary_key
    var $nombregerarquiarol;              // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Gerarquiarol',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
