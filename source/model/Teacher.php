<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Teacher extends Model
{
	public function school()
	{
		return $GLOBALS['config']['school'][$this->school];
	}

	public function comment($title, $content, User $user)
	{
		$c = parent::comment($title, $content, $user);

		// generate activity
		$info = array(
		    'user' => $user,
		    'action' => 'comment',
		    'object' => $this,
		    'link' => $c);
		$act = Activity::create($info);

		// inform all stack holders
		$users = Sdb::fetch('user', Comment::table(), array('teacher=?' => array($this->id)));
		$info = array('activity' => $act);
		foreach ($users as $u) {
			$info['user'] = $u;
			Timeline::create($info);
		}
	}
}
