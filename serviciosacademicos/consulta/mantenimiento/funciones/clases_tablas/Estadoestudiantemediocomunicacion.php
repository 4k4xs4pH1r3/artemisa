<?php
/**
 * Table Definition for estadoestudiantemediocomunicacion
 */
require_once 'DB/DataObject.php';

class DataObjects_Estadoestudiantemediocomunicacion extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'estadoestudiantemediocomunicacion';    // table name
    public $codigoestadoestudiantemediocomunicacion;    // string(3)  not_null primary_key
    public $nombreestadoestudiantemediocomunicacion;    // string(50)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Estadoestudiantemediocomunicacion',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
