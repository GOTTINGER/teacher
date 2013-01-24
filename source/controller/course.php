<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function course_GET($id)
{
    $course = new Course($id);
    $teacher = $course->teacher();
    render_view('master', compact('course', 'teacher'));
}
