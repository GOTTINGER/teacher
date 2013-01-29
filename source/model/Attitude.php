<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Attitude extends BasicModel
{
	public static function create($info)
	{
		$s = self::search();
		foreach ($info as $k => $v) {
			if ($k !== '`like`')
				$s->filterBy($k, $v);
		}
		$as = $s->find();

		if ($as) {
			$a = $as[0];
			if ($a->like == $info['`like`']) {
				$a->del();
				return false;
			} else {
				$a->update('`like`', !$a->like);
				return $a;
			}
		} else {
			return parent::create($info);
		}
	}
}
