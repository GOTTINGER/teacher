<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

function user_GET($id)
{
    $user = new User($id);
    $comments = Comment::search()->filterBy('user', $user)->find();
    render_view('master', compact('user', 'comments'));
}