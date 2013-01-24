<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function edit_teacher_GET($id)
{
    $teacher = new Teacher($id);
    render_view('master', compact('teacher'));
}

function edit_teacher_POST($id)
{
    $description = _post('description');
    $teacher = new Teacher($id);
    if ($description) {
        $teacher->update('description', $description);
    }
    redirect("teacher/$id/edit");
}
