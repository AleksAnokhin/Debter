<?php

namespace Model;

use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;

abstract class Model_result
{

    public static function select($maintable,$cond, $tables,$id)
    {
        $select = (new Select())->setTable($maintable)->setInnerJoin($cond,$tables)
            ->setWhere(['debters.id'=>$id])->setRow();
        if($select) {
            return $select;
        } else {
            return false;
        }
    }
}


?>