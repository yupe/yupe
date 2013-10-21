<ul class="unstyled">
    <?php $cnt = count($models); $i = 0; ?>
    <?php foreach ($models as $model): ?>
        <li>
            <?php echo CHtml::image(
                $model->getAvatar($this->avatarSize), $model->nick_name, array(
                    'width'  => $this->avatarSize,
                    'height' => $this->avatarSize,
                )
            );?>
            <?php echo CHtml::link($model->getFullName(), array('/user/people/userInfo/', 'username' => $model->nick_name)); ?>
        </li>
        <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
    <?php endforeach;?>
</ul>