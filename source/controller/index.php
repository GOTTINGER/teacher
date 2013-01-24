<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @file    index
 * @author  ryan <cumt.xiaochi@gmail.com>
 * @created Jun 27, 2012 6:24:01 PM
 */

function index()
{
    $recentCommentedTeachers = Teacher::search()->orderBy('commented DESC')->find();
    $recentTeachers = Teacher::search()->orderBy('id DESC')->find();

    $recentCourses = Course::search()->orderBy('id DESC')->find();
    $recentStaredCourses = Course::search()->orderBy('touched DESC')->find();

    render_view('master', compact('recentTeachers', 'recentCommentedTeachers', 'recentCourses', 'recentStaredCourses'));
}
