<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function comment($teacher, $comment)
{
    $teacher = new Teacher($teacher);
    $comment = new Comment($comment);
    $additions = $comment->additions();
    $discusses = $comment->discusses();

    $has_login = $GLOBALS['has_login'];
    if ($has_login) {
    	$u = $GLOBALS['user'];

    	$comment->likedByMe = $comment->attitudeByUser('like', $u);
    	$comment->hatedByMe = $comment->attitudeByUser('hate', $u);

        $commentedByMe = ($comment->user == $u->id);
    }

    render_view('master', compact('teacher', 'comment', 'has_login', 'discusses', 'commentedByMe', 'additions'));
}
