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
}
