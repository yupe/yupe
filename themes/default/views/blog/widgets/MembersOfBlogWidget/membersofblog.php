<?php if(count($model->members)):?>
<p>
    <?php echo Yii::t('BlogModule.blog', 'Участники'); ?>:
    <?php foreach ($model->members as $member) : ?>
        <?php echo CHtml::link($member->nick_name, array('/user/people/userInfo/', 'username' => $member->nick_name));?>
    <?php endforeach;?>
</p>
<?php else : ?>
    <p><?php echo Yii::t('BlogModule.blog', 'Участников нет'); ?></p>
<?php endif; ?>