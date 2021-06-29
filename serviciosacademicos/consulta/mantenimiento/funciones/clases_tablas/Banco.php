<?php
/**
 * Table Definition for banco
 */
require_once '../funciones/pear/DB/DataObject.php';

class DataObjects_Banco extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'banco';                           // table name
    var $codigobanco;                     // string(3)  not_null primary_key
    var $nombrebanco;                     // string(25)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Banco',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
