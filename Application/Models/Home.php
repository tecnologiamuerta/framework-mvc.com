<?php

namespace Models;

use \System\Data\Model;
use \System\Annotations\Table;

/**
 * Table("TA_Credenciales")
*/
class Home extends Model{
    private $data;
    
    public function __construct(){
        parent::__construct();
        /*$this->Connect();
        if($this->IsConnected()){
            $this->Query("select * from TA_Credenciales");
        }*/
    }
}