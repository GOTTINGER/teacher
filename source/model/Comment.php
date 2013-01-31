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

    public function addContent($content)
    {
        $info = compact('content');
        $info['comment'] = $this;
        Addition::create($info);

        // generate activity
        $info = array(
            'user' => $this->user,
            'action' => 'add',
            'object' => $this,
            'link' => $this);
        $act = Activity::create($info);

        // inform all stack holders
        $conds = array('comment=?' => array($this->id));
        $users = Sdb::fetch('DISTINCT(user)', Discuss::table(), $conds);
        $info = array('activity' => $act);
        foreach ($users as $u) {
            if ($u == $this->user) {
                break; // 不需要通知本人
            }
            $info['user'] = $u;
            Timeline::create($info);
        }
    }

    public function additions()
    {
        return Addition::search()->filterBy('comment', $this)->find();
    }

    public function likeCount()
    {
        return Attitude::search()->filterBy('comment', $this)->filterBy('like', 1)->count();
    }

    public function hateCount()
    {
        return Attitude::search()->filterBy('comment', $this)->filterBy('like', 0)->count();
    }

    public function attitudeByUser($attitude, User $user)
    {
        $map = array('hate' => 0, 'like' => 1);
        return Attitude::search()->filterBy('comment', $this)->filterBy('like', $map[$attitude])->filterBy('user', $user)->count();
    }

    public function discuss($content, User $user)
    {
    	$info = compact('content', 'user');
    	$info['comment'] = $this;
    	$d = Discuss::create($info);

        // generate activity
        $info = array(
            'user' => $user,
            'action' => 'discuss',
            'object' => $this,
            'link' => $d);
        $act = Activity::create($info);

        // inform all stack holders
        $info = array('activity' => $act, 'user' => $this->user);
        Timeline::create($info);
    }

    public function discusses()
    {
    	return Discuss::search()->filterBy('comment', $this)->find();
    }
}
