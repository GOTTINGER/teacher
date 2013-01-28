<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function discuss_comment($comment)
{
    if (!$GLOBALS['has_login'])
    	exit;
    $comment = new Comment($comment);
    $content = _post('content');
    if ($content) {
	    $comment->discuss($content, $GLOBALS['user']);
	    $teacherId = $comment->teacher;
	    redirect("teacher/$teacherId/comment/$comment->id");
    }
}
