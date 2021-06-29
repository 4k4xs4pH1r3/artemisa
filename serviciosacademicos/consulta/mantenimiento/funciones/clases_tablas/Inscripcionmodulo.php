<?php
/**
 * Table Definition for inscripcionmodulo
 */
require_once 'DB/DataObject.php';

class DataObjects_Inscripcionmodulo extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'inscripcionmodulo';               // table name
    public $idinscripcionmodulo;             // int(11)  not_null primary_key auto_increment
    public $nombreinscripcionmodulo;         // string(100)  not_null
    public $descripcioninscripcionmodulo;    // blob(16777215)  not_null blob
    public $linkinscripcionmodulo;           // string(200)  not_null
    public $codigoestado;                    // string(3)  not_null multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Inscripcionmodulo',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
