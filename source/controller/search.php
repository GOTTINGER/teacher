<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function search()
{
    $type = _get('type');
    $q = _get('q');
    if (!$q || !$type)
        return;
    $func = 'search_'.$type;
    if (function_exists($func)) {
        $GLOBALS['view'] = $func;
        call_user_func($func, $q);
    }
}

function search_teacher($q)
{
    $teachers = Teacher::search()->filterBy('name', "%$q%", 'LIKE')->find();
    render_view('master', compact('teachers', 'q'));
}

function search_course($q)
{
    $courses = Course::search()->filterBy('name', "%$q%", 'LIKE')->find();
    render_view('master', compact('courses', 'q'));
}
