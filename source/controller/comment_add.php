<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function comment_add_GET($teacher, $comment)
{
    $has_login = $GLOBALS['has_login'];
    if (!$has_login) {
        return;
    }

    $teacher = new Teacher($teacher);
    $comment = new Comment($comment);

    render_view('master', compact('teacher', 'comment', 'has_login'));
}

function comment_add_POST($teacher, $comment)
{
    if (!$GLOBALS['has_login'])
        return;

    $comment = new Comment($comment);
    if ($GLOBALS['user']->id != $comment->user)
        return;

    $content = _post('content');
    if (!$content) {
        return;
    }
    $comment->addContent($content);
    redirect("teacher/$teacher/comment/$comment->id");
}