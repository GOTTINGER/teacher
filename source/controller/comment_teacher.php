<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function comment_teacher_POST($id)
{
    $content = _post('content');
    if (!$GLOBALS['has_login'])
        return;
    
    if ($content) {
        $user = $GLOBALS['user'];
        $teacher = new Teacher($id);
        $teacher->comment($content, $user);
    }
    redirect("teacher/$id");
}
