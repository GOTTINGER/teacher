<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class User extends BasicModel
{
    public static function create($info)
    {
        $info['name'] = $info['username'];
        $info['password = MD5(?)'] = $info['password'];
        unset($info['password']);
        $info['created=NOW()'] = null;
        return parent::create($info);
    }

    public static function has($username)
    {
        return Pdb::exists(self::$table, array('name=?' => $username));
    }

    public static function check($username, $password)
    {
        $conds = array('username=? AND password=?' => array($username, md5($password)));
        $info = Sdb::fetchRow('*', self::table(), $conds);
        return $info ? new self($info) : false;
    }

    public function checkPassword($password)
    {
        return md5($password) === $this->password;
    }

    public function getByName($username)
    {
        $cond = array('name=?' => $username);
        return new self(Pdb::fetchRow('*', self::$table, $cond));
    }

    public function changePassword($new_password)
    {
        Pdb::update(
            array('password' => md5($new_password)),
            self::$table,
            $this->selfCond());
    }

    public function login()
    {
        $_SESSION['se_user_id'] = $this->id;
    }

    public function logout()
    {
        $_SESSION['se_user_id'] = 0;
    }


    public static function loggingUser()
    {
        if (isset($_SESSION['se_user_id']) && $_SESSION['se_user_id']) {
            return new self($_SESSION['se_user_id']);
        } else {
            return false;
        }
    }

}
