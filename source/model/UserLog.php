<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
class UserLog
{
    public static $table = 'user_log';

    public static function table()
    {
        return self::$table;
    }

    public function add($args)
    {
        $args['time = NOW()'] = null;
        Pdb::insert($args, self::$table);
    }

    public static function history()
    {
        return safe_array_map(function ($info) {
            $info['user'] = new User($info['user']);
            return $info;
        }, Pdb::fetchAll('*', self::$table));
    }

    public static function userLogin($user_id)
    {
        $arr = array(
            'subject' => $user_id,
            'action' => 'Login',
            'info' => i($_SERVER['REMOTE_ADDR']), // ip
            'time=NOW()' => null
        );
        Pdb::insert($arr, self::$table);
    }
}
