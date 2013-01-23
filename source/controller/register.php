<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function register_GET()
{
    if ($GLOBALS['has_login'])
        redirect();

    $username = '';
    render_view('master', compact('username'));
}

function register_POST()
{
    $username = _post('username');
    $password = _post('password');

    if ($username && $password) {
        $user = User::create(compact('username', 'password'));
        $user->login();
        redirect();
    }
}
