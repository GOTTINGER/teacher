<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Model extends BasicModel
{
    public static function create($info)
    {
        $info['created=NOW()'] = $info['touched=NOW()'] = null;
        return parent::create($info);
    }
    
    public function comment($title, $content, User $user)
    {
        $key = camel2under(get_called_class());
        $info = compact('user', 'title', 'content');
        $info[$key] = $this;
        Comment::create($info);
        $this->update(array('touched=NOW()' => null));
    }

    public function comments()
    {
        return Comment::search()->filterBy('course', $this)->find();
    }

    public function value()
    {
        return $this->name;
    }

    public function description()
    {
        $content = markdown_parse($this->description);

        // I don't know why it works, but, it DOES work
        $dangerList = array(
            '<script>' => htmlspecialchars('<script>'), 
            '<\/script>' => htmlspecialchars('</script>'));
        foreach ($dangerList as $exp => $replStr) {
            $content = preg_replace('/' . $exp . '/', $replStr, $content);
        }
        return $content;
    }
}
