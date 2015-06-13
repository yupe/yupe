<div class="yupe-widget-header">
    <i class="glyphicon glyphicon-user"></i>

    <h3><?= Yii::t('UserModule.user', 'Users'); ?></h3>
</div>

<div class="yupe-widget-content" id="users-widget">
    <ul class="unstyled">
        <?php $cnt = count($models);
        $i = 0; ?>
        <?php foreach ($models as $model): { ?>
            <li>
                <?= CHtml::image(
                    $model->getAvatar($this->avatarSize),
                    $model->nick_name,
                    [
                        'width'  => $this->avatarSize,
                        'height' => $this->avatarSize,
                    ]
                );?>
                <?= CHtml::link(
                    $model->getFullName(),
                    ['/user/people/userInfo/', 'username' => $model->nick_name]
                ); ?>
            </li>
            <?php $i++;
            if ($i != $cnt) {
                echo '<hr>';
            } ?>
        <?php } endforeach; ?>
    </ul>
</div>
