<?php
class MembersOfBlogWidget extends YWidget
{
    public $blogId;

    public function run()
    {
        $blog = Blog::model()->with('members')->findByPk($this->blogId);

        $this->render('membersofblog', array('model' => $blog));
    }
}