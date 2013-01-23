<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function add_teacher_GET()
{
    show_form();
}

function add_teacher_POST()
{
    $name = _post('name');
    $gender = _post('gender');
    $description = _post('description');
    if ($name && $gender) {
        $teacher = Teacher::create(compact('name', 'gender', 'description'));
        redirect('teacher/'.$teacher->id);
    } else {
        show_form();
    }
}

function show_form()
{
    $genders = $GLOBALS['config']['gender'];
    $name = _req('name');
    $gender = _req('gender');
    $description = _req('description');
    render_view('master', compact('genders', 'name', 'gender', 'description'));
}
