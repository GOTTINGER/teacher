<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Course extends BasicModel
{
    public static function create($info)
    {
        $info['created=NOW()'] = null;
        return parent::create($info);
    }

    public function star($star, User $user)
    {
        $info = compact('user', 'star');
        $info['course'] = $this;
        CourseStar::create($info);
        $cs = CourseStar::search()->filterBy('course', $this)->find();
        $css = array_map(function ($c) {
            return $c->star;
        }, $cs);
        $average = array_sum($css) / count($css);
        d($average);
        $this->update('star', $average);
        return $this->star;
    }
}
