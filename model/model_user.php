<?php

namespace Model;

use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\DB as DB;
use Helpers\Validators\Regvalidator as RegValidator;
use Controller;
use Controller\Controller_index as Controller_index;
use Controller\Controller_admin as Controller_admin;


class Model_user
{

    private $id;
    private $firstname;
    private $patronymic;
    private $lastname;
    private $email;
    private $login;
    private $password;
    private $session;
    private $token;

    public function __construct($post)
    {
        foreach ($post as $key => $value) {
            if ($key !== 'password2') {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setSession()
    {
        if (isset($_COOKIE['PHPSESSID'])) {
            $this->session = $_COOKIE['PHPSESSID'];
        }
        return $this;
    }

    public function setToken()
    {
        $this->token = getHash();
        return $this;
    }

    public function setPassword()
    {
        if (isset($_POST['password'])) {
            $this->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        return $this;
    }

    public function escapeAll($obj)
    {
        foreach ($obj as $key => $value) {
            $this->$key = DB::escape($value);
        }
        return $this;
    }

    public function insert()
    {
        if (isset($this->firstname) and isset($this->patronymic) and isset($this->lastname) and isset($this->email)
            and isset($this->login) and isset($this->password) and isset($this->session) and isset($this->token)) {
            $data = ['firstname' => $this->firstname, 'patronymic' => $this->patronymic, 'lastname' => $this->lastname
                , 'mail' => $this->email, 'login' => $this->login, 'password' => $this->password, 'roles_id' => 2];
            $sql = (new Insert())->setTable('users')->setColumns($data)->setValues($data)->setRow();
            $this->id = mysqli_insert_id(DB::getDB());
            $data_sess = ['users_id' => $this->id, 'token' => $this->token, 'session' => $this->session];
            $sql_sess = (new Insert())->setTable('users_session')->setColumns($data_sess)->setValues($data_sess)->setRow();
            if ($sql and $sql_sess) {
                return true;
            } else {
                Controller\Controller_reg::mainErr('Не удалось сохранить данные регистрации.');
            }
        }
    }

    public static function checkUser()
    {
        if (isset($_COOKIE['PHPSESSID']) and isset($_SESSION['token'])) {
            $sql = (new Select())->setTable('users')->setInnerJoin(['users_session' => 'users.id=users_session.users_id'], ['users_session'])
                ->setWhere(['session' => $_COOKIE['PHPSESSID'], 'token' => $_SESSION['token']])->setRow();
            if ($sql) {
                return $sql;
            } else {
                unset($_SESSION['token']);
                return false;
            }
        }
    }

    public static function checkLogin($login)
    {
        $sql = (new Select())->setCol(['login'])->setTable('users')->setWhere(['login' => DB::escape($login)])->setRow();
        if ($sql) {
            Controller\Controller_reg::mainErr('Такой логин уже существует.');
            return false;
        } else {
            return true;
        }
    }

    public static function checkMail($mail)
    {
        $sql = (new Select())->setCol(['mail'])->setTable('users')->setWhere(['mail' => DB::escape($mail)])->setRow();

        if ($sql) {
            Controller\Controller_reg::mainErr('Пользователь с таким адресом электронной почты уже существует.');
            return false;
        } else {
            return true;
        }
    }

    public static function checkAuth($login, $password)
    {
        $user = (new Select())->setTable('users')->setWhere(['login' => $login])->setRow();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($role = self::checkRole($user)) {
                    $id = $user['id'];
                    $session = $_COOKIE['PHPSESSID'];
                    $token = getHash();
                    $sql = (new Delete())->setTable('users_session')->setWhere(['users_id' => $id])->setRow();
                    if ($sql) {
                        $data = ['users_id' => $id, 'token' => $token, 'session' => $session];
                        $sql = (new Insert())->setTable('users_session')->setColumns($data)->setValues($data)->setRow();
                        if ($sql) {
                            $_SESSION['token'] = $token;
                            if($role == '2') {
                                header("location:index.php?route=main/start");
                            } else {
                                Controller_admin::main();
                            }
                        } else {
                            Controller\Controller_reg::mainErr('Ошибка в работе с данными. Пожалуйста, повторно зарегистрируйтесь.');
                        }
                    } else {
                        Controller\Controller_reg::mainErr('Ошибка в работе с данными. Пожалуйста, повторно зарегистрируйтесь.');
                    }

                } else {
                    Controller_index::additionalRender('Вы не можете пользоваться данным ресурсом');
                }
            } else {
                Controller\Controller_reg::mainErr('Пороль неверный. Пожалуйста,зарегистрируйтесь.');
            }
        } else {
            Controller\Controller_reg::mainErr('Пользователь с таким логином не существует. Пожалуйста,зарегистрируйтесь.');
        }
    }

    public static function checkQuestion($login)
    {
        $sql = (new Select())->setTable('users')->setWhere(['login' => DB::escape($login)])->setRow();
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public static function checkRole($user)
    {
        $id = $user['id'];
        $tables = ['users'];
        $cond = ['users'=>'users.roles_id=roles.id'];
        $select = (new Select())->setCol(['roles.id'])->setTable('roles')->setInnerJoin($cond,$tables)
            ->setWhere(['users.id'=>$id])->setRow();
        if($select and $select['id'] !== '3') {
          return $select['id'];
        } else {
            return false;
        }
    }
    public static function leave($session)
    {
        $sql = (new Delete())->setTable('users_session')->setWhere(['session'=>$session])->setRow();
        if($sql) {
            unset($_SESSION['token']);
            return true;
        } else {
            return false;
        }
    }
}


?>