<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

// login out
function logout()
{
    // 因为可能时间久远，用户已经session失效，但依然点击了注销按钮
    if ($GLOBALS['has_login'] && isset($GLOBALS['user']) && is_object($GLOBALS['user'])) {
        $GLOBALS['user']->logout();
    }
    redirect();
}
