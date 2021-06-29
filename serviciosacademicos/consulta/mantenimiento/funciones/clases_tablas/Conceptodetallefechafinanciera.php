<?php
/**
 * Table Definition for conceptodetallefechafinanciera
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Conceptodetallefechafinanciera extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'conceptodetallefechafinanciera';    // table name
    var $codigoconceptodetallefechafinanciera;    // string(2)  not_null primary_key
    var $nombreoconceptodetallefechafinanciera;    // string(50)  not_null
    var $codigoestadoconceptodetallefechafinanciera;    // string(2)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Conceptodetallefechafinanciera',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
