<?php if(count($model->members)):?>
<p>
    <?php echo Yii::t('BlogModule.blog', 'Участники'); ?>:
    <?php foreach ($model->members as $member) : ?>
        <span class="label label-info">
            <?php echo CHtml::link($member->nick_name, array('/user/people/userInfo/', 'username' => $member->nick_name));?>
        </span>
    <?php endforeach;?>
</p>
<?php else : ?>
    <p><?php echo Yii::t('BlogModule.blog', 'Участников нет =('); ?></p>
<?php endif; ?>