<?php

/**
 * Class JoinBlogWidget
 */
class JoinBlogWidget extends \yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $blog;

    /**
     * @var
     */
    public $user;

    /**
     * @var string
     */
    public $view = 'joinblog';

    /**
     * @throws CException
     */
    public function init()
    {
        if (!$this->blog || !$this->user) {
            throw new CException(Yii::t('BlogModule.blog', 'Set "blogId" and "user" !'));
        }

        parent::init();
    }

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render(
            $this->view,
            ['inBlog' => $this->blog->userIn($this->user->getId(), false), 'user' => $this->user, 'blog' => $this->blog]
        );
    }
}
