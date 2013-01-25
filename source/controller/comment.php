<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function comment($type, $id)
{
    if (!$GLOBALS['has_login'])
        return;
    
    $content = _post('content');
    if ($content) {
        $user = $GLOBALS['user'];
        $o = new $type($id);
        $o->comment($content, $user);
    }
    $t = camel2under($type);
    redirect("$t/$id");
}
