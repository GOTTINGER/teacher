<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function teacher_GET($id)
{
    $teacher = new Teacher($id);
    $comments = Comment::search()->filterBy('teacher', $id)->find();
    render_view('master', compact('teacher', 'comments'));
}
