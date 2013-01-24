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
}
