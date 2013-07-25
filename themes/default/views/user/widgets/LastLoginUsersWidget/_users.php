<ul class="unstyled">
    <?php $cnt = count($models); $i = 0; ?>
    <?php foreach ($models as $model): ?>
        <li>
            <?php echo CHtml::image($model->getAvatar(24),$model->nick_name);?>
            <?php echo CHtml::link($model->nick_name, array('/user/people/userInfo/', 'username' => $model->nick_name)); ?>
        </li>
        <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
    <?php endforeach;?>
</ul>