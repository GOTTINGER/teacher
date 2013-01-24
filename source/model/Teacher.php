<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class Teacher extends BasicModel
{
    public static function create($info)
    {
        $info['created=NOW()'] = $info['commented=NOW()'] = null;
        $info['photo'] = ROOT.'view/img/photo-placeholder.jpg';
        return parent::create($info);
    }
    
    public function comment($content, User $user)
    {
        $info = compact('user', 'content');
        $info['teacher'] = $this;
        Comment::create($info);
        $this->update(array('commented=NOW()' => null));
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
