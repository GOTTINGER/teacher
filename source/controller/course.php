<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function course_GET($id)
{
    $course = new Course($id);
    $teacher = $course->teacher();
    $has_login = $GLOBALS['has_login'];
    $data = compact('course', 'teacher', 'canStar', 'has_login');
    if ($has_login) {
        $data['myStar'] = $course->starBy($GLOBALS['user']);
    }
    render_view('master', $data);
}
