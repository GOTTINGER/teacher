<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function search()
{
    $type = _get('type') ?: 'teacher';
    $q = _get('q');
    $func = 'search_'.$type;
    if (function_exists($func)) {
        $GLOBALS['view'] = $func;
        call_user_func($func, $q);
    }
}

function search_teacher($q)
{
    $s = Teacher::search();
    if ($q)
        $s = $s->filterBy('name', "%$q%", 'LIKE');
    $school = _get('school');
    if ($school !== '')
        $s = $s->filterBy('school', $school);
    $teachers = $s->find();
    render_view('master', compact('teachers', 'q'));
}

function search_course($q)
{
    $courses = Course::search()->filterBy('name', "%$q%", 'LIKE')->find();
    render_view('master', compact('courses', 'q'));
}
