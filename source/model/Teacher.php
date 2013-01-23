<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Teacher extends BasicModel
{
    public static function create($info)
    {
        $info['created=NOW()'] = $info['commented=NOW()'] = null;
        return parent::create($info);
    }
    public function comment($content, User $user)
    {
        $info = compact('user', 'content');
        $info['teacher'] = $this;
        Comment::create($info);
        $this->update(array('commented=NOW()' => null));
    }
}
