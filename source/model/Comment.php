<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Comment extends BasicModel
{
    public static function create($info)
    {
        $info['created=NOW()'] = null;
        return parent::create($info);
    }

    public function discuss($content, User $user)
    {
    	$info = compact('content', 'user');
    	$info['comment'] = $this;
    	Discuss::create($info);
    	d(Sdb::log());
    }

    public function discusses()
    {
    	return Discuss::search()->filterBy('comment', $this)->find();
    }
}
