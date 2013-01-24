<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function add_course_GET()
{
    show_form();
}

function add_course_POST()
{
    $name = _post('name');
    $teacher = _post('teacher');
    $description = _post('description');
    if ($name && $teacher) {
        $course = Course::create(compact('name', 'teacher', 'description'));
        redirect('course/'.$course->id);
    } else {
        show_form();
    }
}

function show_form()
{
    $name = _req('name');
    $teacher = _req('teacher');
    $description = _req('description');
    $teachers = Teacher::search()->find(Searcher::KEY_VALUE_PAIR);
    render_view('master', compact('teachers', 'name', 'teacher', 'description'));
}
