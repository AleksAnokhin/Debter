<?php

namespace Controller;

use Controller\Controller_base as Controller_base;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;
use Model\Model_admin as Model_admin;

class Controller_admin extends Controller_base
{
    private static $name = 'admin';

    public static function main()
    {
        if (Model_admin::checkAdmin()) {
            foreach (self::$pages as $key) {
                if ($key == 'head') {
                    self::render(self::$name, $key, ['css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon]);
                } else {
                    self::render(self::$name, $key);
                }
            }
        } else {
            header('Location:index.php');
        }

    }

    public static function additionalRender($answer)
    {
        if (Model_admin::checkAdmin()) {
            foreach (self::$pages as $key) {
                if ($key == 'head') {
                    self::render(self::$name, $key, ['css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon]);
                } else if ($key == 'main') {
                    self::render(self::$name, $key, ['answer' => $answer]);
                } else {
                    self::render(self::$name, $key);
                }
            }
        } else {
            header('Location:index.php');
        }

    }

    public static function delete_user($post)
    {
        if (isset($post['user']) and $post['user'] !== '') {
            $login = $post['user'];
            Model_admin::delete_user($login);
        } else {
            self::additionalRender('Не указан пользователь');
        }
    }

    public static function bann($post)
    {
        if (isset($post['banned']) and $post['banned'] !== '') {
            $login = $post['banned'];
            Model_admin::bann($login);
        } else {
            self::additionalRender('Не указан пользователь');
        }
    }

    public static function delete_debter($post)
    {
        if (isset($post['debter']) and $post['debter'] !== '') {
            $debter = $post['debter'];
            Model_admin::delete_debter($debter);
        } else {
            self::additionalRender('Не указан должник');
        }
    }

    public static function all_users()
    {
        Model_admin::all_users();
    }
    public static function all_debters()
    {
        Model_admin::all_debters();
    }

}


?>