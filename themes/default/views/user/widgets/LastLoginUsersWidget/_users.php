<ul class="unstyled">
    <?php $cnt = count($models); $i = 0; ?>
    <?php foreach ($models as $model): ?>
        <li>
            <i class="icon-user"></i>
            <?php echo CHtml::link($model->nick_name, array('/user/people/userInfo/', 'username' => $model->nick_name)); ?>
        </li>
        <?php $i++; if ($i != $cnt) echo '<hr>'; ?>
    <?php endforeach;?>
</ul>