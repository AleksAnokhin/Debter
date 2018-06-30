<?php

namespace model;

use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;

class Model_index
{
    public static function showAbout()
    {
        $sql = (new Select)->setCol(['text'])->setTable('content')
            ->setWhere(['title' => 'about'])->setRow();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public static function showRules()
    {
        $sql = (new Select)->setCol(['text'])->setTable('content')
            ->setWhere(['title' => 'rules'])->setRow();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }
    public static function question($inf)
    {
        $question = ( new Insert() )->setTable('questions')->setColumns( $inf )->setValues(  $inf  )->setRow();
        if($question) {
            return $question;
        } else {
            return false;
        }
    }
}