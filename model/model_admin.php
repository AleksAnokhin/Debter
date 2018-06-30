<?php

namespace Model;

use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;
use Controller\Controller_admin as Controller_admin;

abstract class Model_admin
{

    public static function checkAdmin()
    {
        if (isset($_SESSION['token']) and $_COOKIE['PHPSESSID']) {
            $token = $_SESSION['token'];
            $tables = ['users_session'];
            $cond = ['users_session' => 'users.id=users_session.users_id'];
            $select = (new Select())->setCol(['users.roles_id'])->setTable('users')
                ->setInnerJoin($cond, $tables)->setWhere(['users_session.token' => $token])->setRow();
            if ($select) {
                $role = $select['roles_id'];
                if ($role !== '1') {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function delete_user($login)
    {
        $delete = (new Delete())->setTable('users')->setWhere(['login' => $login])->setRow();
        if ($delete and mysqli_affected_rows(DB::getDB()) > 0) {
            Controller_admin::additionalRender('Пользователь удален');
        } else {
            Controller_admin::additionalRender('Пользователь не найден');
        }
    }
    public static function delete_debter($debter)
    {
        $delete = (new Delete())->setTable('debters')->setWhere(['name' => $debter])->setRow();
        if ($delete and mysqli_affected_rows(DB::getDB()) > 0) {
            Controller_admin::additionalRender('Должник удален');
        } else {
            Controller_admin::additionalRender('Данный должник не найден');
        }
    }
    public static function  bann($login)
    {
        $update = (new Update())->setTable('users')->setValues(['roles_id' => 3])
            ->setWhere(['login' => $login])->setRow();
        if ($update and mysqli_affected_rows(DB::getDB()) > 0) {
            Controller_admin::additionalRender('Пользователь заблокирован');
        } else {
            Controller_admin::additionalRender('Пользователь не найден');
        }
    }
    public static  function  all_users()
    {
        $select = (new Select())->setTable('users')->setRowAll();
        if($select and mysqli_affected_rows(DB::getDB()) > 0) {
            echo json_encode($select,JSON_UNESCAPED_UNICODE);
        } else {
            $data = ['result'=>false];
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }
    public static  function  all_debters()
    {
        $select = (new Select())->setTable('debters')->setRowAll();
        if($select and mysqli_affected_rows(DB::getDB()) > 0) {
            echo json_encode($select,JSON_UNESCAPED_UNICODE);
        } else {
            $data = ['result'=>false];
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }
}


?>