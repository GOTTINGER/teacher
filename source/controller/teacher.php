<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function teacher_GET($id)
{
    $teacher = new Teacher($id);
    $comments = Comment::search()->filterBy('teacher', $id)->find();
    $has_login = $GLOBALS['has_login'];
    render_view('master', compact('teacher', 'courses', 'comments', 'has_login'));
}
