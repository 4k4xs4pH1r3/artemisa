<?php
/**
 * Table Definition for pais
 */
require_once 'DB/DataObject.php';

class DataObjects_Pais extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'pais';                            // table name
    var $idpais;                          // int(11)  not_null primary_key auto_increment
    var $nombrecortopais;                 // string(10)  not_null
    var $nombrepais;                      // string(100)  not_null
    var $codigosappais;                   // string(20)  not_null
    var $codigoestado;                    // string(3)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pais',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
