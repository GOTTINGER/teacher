<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function teachers_GET()
{
    $teachers = Teacher::search()->find();
    render_view('master', compact('teachers'));
}
