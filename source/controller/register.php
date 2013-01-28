<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function register_GET()
{
    if ($GLOBALS['has_login'])
        redirect();

    $config = $GLOBALS['config'];
    $genders = $config['gender'];
    $schools = $config['school'];

    render_view('master', compact('genders', 'schools'));
}

function register_POST()
{
    $username = _post('username');
    $password = _post('password');
    $gender = _post('gender');
    $school = _post('school');
    $year = _post('year');

    if ($username && $password && $gender && $school && $year) {
        $user = User::create(compact('username', 'password', 'gender', 'school', 'year'));
        $user->login();
        redirect();
    }
}
