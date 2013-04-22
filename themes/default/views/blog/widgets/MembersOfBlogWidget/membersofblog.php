<?php
/**
 * Отображение для blog/widgets/lastpostsofblog:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
if ($model === null) :
    echo Yii::t('BlogModule.blog', 'Блог не существует');
elseif (count($model->members) > 0) : ?>
    <p><?php echo Yii::t('BlogModule.blog', 'Участники'); ?>:</p>
    <ul>
        <?php foreach ($model->members as $member) : ?>
            <li>
                <?php echo CHtml::link($member->nick_name, array('/user/people/userInfo/', 'username' => $member->nick_name));?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else : ?>
    <p><?php echo Yii::t('BlogModule.blog', 'Участников нет'); ?></p>
<?php endif; ?>