<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function teacher_GET($id)
{
    $teacher = new Teacher($id);
    $courses = Course::search()->filterBy('teacher', $teacher)->find();
    $comments = Comment::search()->filterBy('teacher', $id)->find();
    render_view('master', compact('teacher', 'courses', 'comments'));
}
