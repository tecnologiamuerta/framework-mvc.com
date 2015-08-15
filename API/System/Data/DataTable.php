<?php
namespace System\Data;

use \System\Data\DataRow;

class DataTable{
    public $TableName;
    public $Columns;
    public $Rows;
    
    public function __construct($tableName){
        $this->TableName = $tableName;
    }
}