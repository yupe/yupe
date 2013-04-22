<?php
class MembersOfBlogWidget extends YWidget
{
    public $blogID;

    public function run()
    {
        $blog = Blog::model()->with('members')->findByPk($this->blogID);

        $this->render('membersofblog', array('model' => $blog));
    }
}