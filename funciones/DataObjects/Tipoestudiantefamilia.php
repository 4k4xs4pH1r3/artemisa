<?php
/**
 * Table Definition for tipoestudiantefamilia
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoestudiantefamilia extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoestudiantefamilia';           // table name
    var $idtipoestudiantefamilia;         // int(11)  not_null primary_key auto_increment
    var $nombretipoestudiantefamilia;     // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoestudiantefamilia',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
