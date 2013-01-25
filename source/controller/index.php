<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:24:01 PM
 */

function index()
{
    $recentTeachers = Teacher::search()->orderBy('touched DESC')->find();
    $recentCourses = Course::search()->orderBy('touched DESC')->find();

    render_view('master', compact('recentTeachers', 'recentCourses'));
}
