<?php
namespace Model\Work;

use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;

abstract class Model_work_executive {

    public static function insert($id,$data,$table)
    {
        $insert = (new Insert())->setTable($table)->setColumns($data)->setValues($data)->setRow();
        if($insert) {
            return true;
        } else {
            return false;
        }
    }
    public static function insertBroaden($id,$payments,$property,$data,$table)
    {
        $insert = (new Insert())->setTable($table)->setColumns($data)->setValues($data)->setRow();
        if($insert) {
            return true;
        } else {
            return false;
        }
    }
}


?>