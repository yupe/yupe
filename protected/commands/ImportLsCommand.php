<?php
Yii::import('application.modules.user.models.*');
Yii::import('application.modules.yupe.components.*');
Yii::import('application.modules.yupe.models.*');
Yii::import('application.modules.blog.models.*');
Yii::import('application.modules.comment.models.*');
Yii::import('application.modules.yupe.helpers.*');

// for livestreet url mapping
//'/blog/<slug>'     => 'blog/blog/show', 
//'/blog/<blog_name>/<id>.html' => 'blog/post/view',
//'/profile/<username:\w+>/' => 'user/people/userInfo',
//'/tag/<tag>'  => 'blog/post/list',
//'/people'     => 'user/people/index'

class ImportLsCommand extends CConsoleCommand
{

    public function run()
    {
        $this->actionUsers();
        $this->actionBlogs();
        $this->actionTags();
        $this->actionPosts();         
        $this->actionComments(); 
        $this->actionMembers();
    }
   

    public function actionUsers()
    {       
        $data = Yii::app()->ls->createCommand('SELECT * FROM prefix_user')->queryAll();

        $transaction = Yii::app()->db->beginTransaction();

        User::model()->deleteAll();

        try
        {
            foreach($data as $user) {

                echo "Import user with ncik '{$user['user_login']}' !\n";

                if(!isset( $user['user_login'],  $user['user_password'])) {
                    echo "Skip user...\n";
                    continue;
                }

                $status = $user['user_activate'] == 1 ? 1 : 2;

                $genderMap = array(
                    'woman' => 2,
                    'man'   => 1
                );

                $gender = isset($genderMap[$user['user_profile_sex']]) ? $genderMap[$user['user_profile_sex']] : 0;

                $location = array($user['user_profile_country'], $user['user_profile_region'], $user['user_profile_city']);

                $about = $user['user_profile_about'] ? $user['user_profile_about'] : '';

                $changeDate = $user['user_profile_date'] ? $user['user_profile_date'] : new CDbExpression('NOW()');

                $email = $user['user_mail'] ? $user['user_mail'] : md5($user['user_login']);

                $avatar = null;

                if($user['user_profile_avatar']) {

                  $url = parse_url($user['user_profile_avatar']);

                  if(!empty($url['path'])) {
                    $avatar = str_replace('/uploads/','', $url['path']);
                  }
                }

                Yii::app()->db->createCommand('
                    INSERT INTO {{user_user}} (id, nick_name, email, hash, registration_date, status, gender, location, birth_date, about, change_date, avatar, last_visit)
                                       VALUES(:id,:nick_name,:email,:hash, :registration_date, :status, :gender, :location, :birth_date, :about, :change_date, :avatar, :last_visit)
                ')->bindValue(':id', $user['user_id'])
                  ->bindValue(':nick_name', $user['user_login'])
                  ->bindValue(':email', $email)
                  ->bindValue(':hash',sha1($user['user_password']))
                  ->bindValue(':registration_date',$user['user_date_register'])
                  ->bindValue(':status', $status)
                  ->bindValue(':gender',$gender)
                  ->bindValue(':location', implode(' ', $location))
                  ->bindValue(':birth_date', $user['user_profile_birthday'])
                  ->bindValue(':about', $about)
                  ->bindValue(':change_date', $changeDate)
                  ->bindValue(':avatar', $avatar)
                  ->bindValue(':last_visit', $user['user_profile_date'])
                  ->execute();
            }

            $transaction->commit();
        }
        catch(Exception $e)
        {
            CVarDumper::dump($e);
            $transaction->rollback();
            die;
        }
    }

    public function actionBlogs()
    {
        $data = Yii::app()->ls->createCommand('SELECT * FROM prefix_blog')->queryAll();

        $transaction = Yii::app()->db->beginTransaction();

        try
        {
            Blog::model()->deleteAll();

            foreach($data as $blog) {

                echo "Import blog  '{$blog['blog_title']}' !\n";

                $slug = $blog['blog_url'] ? $blog['blog_url'] : yupe\helpers\YText::translit($blog['blog_title']);

                $updateDate = $blog['blog_date_edit'] ? $blog['blog_date_edit'] : $blog['blog_date_add'];

                $icon = '';

                if($blog['blog_avatar']) {
                    $url = parse_url($blog['blog_avatar']);

                    if(!empty($url['path'])) {
                      $icon = str_replace('/uploads/','', $url['path']);
                    }
                }

                $type = $blog['blog_type'] == 'personal' ? Blog::TYPE_PRIVATE : Blog::TYPE_PUBLIC;

                Yii::app()->db->createCommand('
                   INSERT INTO {{blog_blog}} (id, name, slug, description, create_user_id, update_user_id, create_date, update_date, icon, type)
                               VALUES (:id, :name, :slug, :description, :create_user_id, :update_user_id, :create_date, :update_date, :icon, :type)
                ')
                  ->bindValue(':id', $blog['blog_id'])
                  ->bindValue(':name',$blog['blog_title'])
                  ->bindValue(':slug', $slug)
                  ->bindValue(':description', strip_tags($blog['blog_description']))
                  ->bindValue(':create_user_id',$blog['user_owner_id'])
                  ->bindValue(':update_user_id',$blog['user_owner_id'])
                  ->bindValue(':create_date', strtotime($blog['blog_date_add']))
                  ->bindValue(':update_date', strtotime($updateDate))
                  ->bindValue(':icon', $icon)
                  ->bindValue(':type', $type) 
                  ->execute();
            }

            $transaction->commit();
        }
        catch(Exception $e)
        {
            CVarDumper::dump($e);
            $transaction->rollback();
            die;
        }
    }

    public function actionPosts()
    {
        $data = Yii::app()->ls->createCommand('SELECT * FROM prefix_topic pt JOIN prefix_topic_content ptc ON pt.topic_id = ptc.topic_id ')->queryAll();

        $transaction = Yii::app()->db->beginTransaction();

        try {

           foreach ($data as $post) {

               echo "Import post '{$post['topic_title']}'\n";

               $status = $post['topic_publish'] ? 1 : 0;

               $extra = unserialize($post['topic_extra']);

               $url = isset($extra['url']) ? $extra['url'] : '';

               $tags = explode(',',$post['topic_tags']);

               Yii::app()->db->createCommand('
                    INSERT INTO {{blog_post}} (id, blog_id, title, slug, content, create_user_id, update_user_id, access_type, status, create_date, update_date, publish_date, quote, link)
                           VALUES (:id, :blog_id, :title, :slug, :content, :create_user_id, :update_user_id, :access_type, :status, :create_date, :update_date, :publish_date, :quote, :link)
              ')->bindValue(':id', $post['topic_id'])
                ->bindValue(':blog_id', $post['blog_id'])
                ->bindValue(':title', $post['topic_title'])
                ->bindValue(':slug', yupe\helpers\YText::translit($post['topic_title']))
                ->bindValue(':content', $post['topic_text'])
                ->bindValue(':create_user_id', $post['user_id'])
                ->bindValue(':update_user_id', $post['user_id'])
                ->bindValue(':access_type', Post::ACCESS_PUBLIC)
                ->bindValue(':status', $status)
                ->bindValue(':create_date',strtotime($post['topic_date_add']))
                ->bindValue(':update_date',strtotime($post['topic_date_edit']))
                ->bindValue(':publish_date',strtotime($post['topic_date_add']))
                ->bindValue(':quote', $post['topic_text_short'])
                ->bindValue(':link', $url)
                ->execute(); 

                if(!empty($tags)) {
                    foreach ($tags as $tag) {
                       $tdata = Tag::model()->find('name = :name', array(':name' => $tag));

                       if(null === $tdata) {
                           $tdata = new Tag;
                           $tdata->name = strip_tags($tag);
                           $tdata->save(); 
                       }

                       Yii::app()->db->createCommand('
                          INSERT INTO {{blog_post_to_tag}} (post_id, tag_id) VALUES (:post_id, :tag_id)
                       ')->bindValue(':post_id', $post['topic_id'])
                         ->bindValue(':tag_id', $tdata->id)->execute();
                    }  
                }
           }

           $transaction->commit();
          
        }
        catch (Exception $e) 
        {
            CVarDumper::dump($e);
            $transaction->rollback();
            die;
        }      
    }

    public function actionTags()
    {
         $data = Yii::app()->ls->createCommand('
              SELECT DISTINCT topic_tag_text  FROM prefix_topic_tag
         ')->queryAll();  

         $transaction = Yii::app()->db->beginTransaction();     

         try 
         {
           
           Tag::model()->deleteAll();

           foreach ($data as $tag) {
             Yii::app()->db->createCommand(
               'INSERT INTO yupe_blog_tag (name) VALUES (:name)'
             )->bindValue(':name',strip_tags($tag['topic_tag_text']))->execute();
           }

           $transaction->commit();
         }
         catch (Exception $e) 
         {
              CVarDumper::dump($e);
              $transaction->rollback();
              die;
         }  
    }

    public function actionComments()
    {
        $data = Yii::app()->ls->createCommand('SELECT * FROM prefix_comment')->queryAll();

        $transaction = Yii::app()->db->beginTransaction();

         try
         {
             Comment::model()->deleteAll();

             foreach ($data as $comment) {

                $status = $comment['comment_delete'] == 1 ? Comment::STATUS_DELETED : Comment::STATUS_APPROVED;

                $user = User::model()->findByPk($comment['user_id']);

                $name = $user ? $user->nick_name : '';

                $email = $user ? $user->email : '';
                
                Yii::app()->db->createCommand('
                  INSERT INTO {{comment_comment}} (id, parent_id,user_id,model, model_id, creation_date, text, level, lft, rgt, status, name, email, root)
                               VALUES (:id, :parent_id, :user_id, :model, :model_id, :creation_date, :text, :level, :lft, :rgt, :status, :name, :email, :root)
               ')->bindValue(':id', $comment['comment_id'])
                 ->bindValue(':parent_id', $comment['comment_pid'])
                 ->bindValue(':user_id', $comment['user_id'])
                 ->bindValue(':model', 'Post')
                 ->bindValue(':model_id', $comment['target_id'])
                 ->bindValue(':creation_date', $comment['comment_date'])
                 ->bindValue(':text', strip_tags($comment['comment_text']))
                 ->bindValue(':root', $comment['comment_pid'])     
                 ->bindValue(':level', $comment['comment_level'])                 
                 ->bindValue(':lft', $comment['comment_left'])
                 ->bindValue(':rgt', $comment['comment_right'])
                 ->bindValue(':status', $status)
                 ->bindValue(':name', $name)
                 ->bindValue(':email',$email)
                 ->execute();
             }

             $transaction->commit();
         }
         catch (Exception $e) 
         {
              CVarDumper::dump($e);
              $transaction->rollback();
              die;
         }
    }

    public function actionMembers()
    {
       $data = Yii::app()->ls->createCommand('SELECT * FROM prefix_blog_user')->queryAll();

       $transaction = Yii::app()->db->beginTransaction();

       try
       {
           UserToBlog::model()->deleteAll();
           
           foreach ($data as $member) {
              $model = new UserToBlog;
              $model->user_id = $member['user_id'];
              $model->blog_id = $member['blog_id'];
              $model->save();
           } 

           $transaction->commit(); 
       }
       catch(Exception $e)
       {
           $transaction->rollback(); 
           CVarDumper::dump($e);
           die();
       }
    }
}