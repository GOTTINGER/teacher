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
    $data = compact('recentTeachers', 'recentCourses');
    if ($GLOBALS['has_login']) {
	    $timelines = Timeline::search()->filterBy('user', $GLOBALS['user'])->find();
	    $data['timelines'] = $timelines;
    }

    render_view('master', $data);
}
