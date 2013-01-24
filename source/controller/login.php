<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function login_init()
{
    $GLOBALS['msg'] = '';
}

function login_POST()
{
    $username = _post('username');
    $password = _post('password');

    if ($user = User::check($username, $password)) {
        $user->login();

        $back_url = _get('back_url') ?: DEFAULT_LOGIN_REDIRECT_URL;
        redirect($back_url);
    } else {
        $GLOBALS['msg'] = $GLOBALS['config']['error']['info']['USERNAME_OR_PASSWORD_INCORRECT'];
    }
}

function login_end()
{
    // if user is already logged in, 
    // to index since we didn't provide such a link
    if ($GLOBALS['has_login']) {
        redirect(); // to index
    }

    $username = _req('username');
    render_view('master', array('msg' => $GLOBALS['msg'], 'username' => $username));
}
