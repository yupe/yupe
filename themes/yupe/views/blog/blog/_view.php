<div class="blog">
    <div class="j"><?=CHtml::link(Yii::t('blog','Читать блог'), $data-> id, array("class"=>"add join-blog")); ?></div>
    <div class="r">471,95</div>
    <div class="c"><a href="#">Железо и гаджеты</a></div>
    <div class="t">
        <div class="h"><?php echo CHtml::link(CHtml::encode($data->name),array('/blog/blog/show/','slug' => $data->slug)); ?></div>
        <div class="p"><?php echo $data->membersCount; echo " ".Yii::t('blog','читатель|читателя|читателей',$data->membersCount); ?> , <?php echo $data->postsCount; echo " ".Yii::t('blog','пост|поста|постов',$data->postsCount); ?></div>
    </div>

</div>