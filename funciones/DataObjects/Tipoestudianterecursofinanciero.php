<?php
/**
 * Table Definition for tipoestudianterecursofinanciero
 */
require_once 'DB/DataObject.php';

class DataObjects_Tipoestudianterecursofinanciero extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tipoestudianterecursofinanciero';    // table name
    var $idtipoestudianterecursofinanciero;    // int(11)  not_null primary_key auto_increment
    var $nombretipoestudianterecursofinanciero;    // string(50)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tipoestudianterecursofinanciero',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
