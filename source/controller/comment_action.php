<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function comment_action($type, $id)
{
    if (!$GLOBALS['has_login'])
        return;
    
    $title = _post('title');
    $content = _post('content');
    if ($title && $content) {
        $user = $GLOBALS['user'];
        $o = new $type($id);
        $o->comment($title, $content, $user);
    }
    $t = camel2under($type);
    redirect("$t/$id");
}
