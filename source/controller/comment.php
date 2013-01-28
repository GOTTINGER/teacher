<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function comment($teacher, $comment)
{
    $teacher = new Teacher($teacher);
    $comment = new Comment($comment);
    $discusses = $comment->discusses();

    $has_login = $GLOBALS['has_login'];

    render_view('master', compact('teacher', 'comment', 'has_login', 'discusses'));
}
