<?php

class JoinBlogWidget extends \yupe\widgets\YWidget
{
    public $blog;

    public $user;

    public $view = 'joinblog';

    public function init()
    {
        if (!$this->blog || !$this->user) {
            throw new CException(Yii::t('BlogModule.blog', 'Set "blogId" and "user" !'));
        }

        parent::init();
    }

    public function run()
    {
        $this->render(
            $this->view,
            ['inBlog' => $this->blog->userIn($this->user->getId(), false), 'user' => $this->user, 'blog' => $this->blog]
        );
    }
}
