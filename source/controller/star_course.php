<?php
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function star_course($id)
{
    if (!$GLOBALS['has_login'])
        return;
    $star = _req('star');
    if ($id && $star) {
        $user = $GLOBALS['user'];
        $course = new Course($id);
        $star = $course->star($star, $user);
    }
}
