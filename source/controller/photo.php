<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function photo_GET($id)
{
    $teacher = new Teacher($id);
    render_view('master', compact('teacher'));
}

function photo_POST($id)
{
    $teacher = new Teacher($id);
    $src = make_image('photo');
    $teacher->update('photo', $src);
    redirect("teacher/$id");
}
