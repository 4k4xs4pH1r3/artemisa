<?php
/**
 * Table Definition for tiposalon
 */
require_once 'DB/DataObject.php';

class DataObjects_Tiposalon extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'tiposalon';                       // table name
    var $codigotiposalon;                 // string(2)  not_null primary_key
    var $nombretiposalon;                 // string(30)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tiposalon',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
