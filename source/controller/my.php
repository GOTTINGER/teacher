<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function my_init()
{
    if (!$GLOBALS['has_login'])
        return;
}

function my_GET()
{
    $user = $GLOBALS['user'];
    render_view('master', compact('user'));
}

function my_POST()
{
    $user = $GLOBALS['user'];
    
    $name = _post('name');
    if ($name)
        $user->update('name', $name);

    $newPass = _post('newPass');
    if ($newPass)
        $user->update('name', $newPass);

    redirect('my');
}