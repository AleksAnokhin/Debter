<?php
namespace Model\Work;

use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;

abstract class Model_work_pretrial_ent {

    public static function insert($id,$stage,$data,$table)
    {
        $insert = (new Insert())->setTable($table)->setColumns($data)->setValues($data)->setRow();
        if($insert) {
            return true;
        } else {
            return false;
        }
    }
    public static function insertBroaden($id,$analysis,$contact,$data,$table)
    {
        $insert = (new Insert())->setTable($table)->setColumns($data)->setValues($data)->setRow();
        if($insert) {
            return true;
        } else {
            return false;
        }
    }
    public static function update($id,$finresult,$restructuring_readiness,$property,$data,$table)
    {
        $update = (new Update())->setTable($table)->setValues($data)
            ->setWhere(['debters_id'=>$id])->setRow();
        if($update) {
            return true;
        } else {
            return false;
        }
    }
}


?>