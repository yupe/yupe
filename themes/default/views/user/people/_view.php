<div class="media">
    <?php echo CHtml::link(CHtml::image($data->getAvatar(90), $data->nick_name, array('class' => 'thumbnail media-object')),
        array('/user/people/userInfo/', 'username' => $data->nick_name),
        array('class' => 'pull-left')
    ); ?>

    <div class="media-body">
        <div class="well well-small">
            <ul class="inline">
                <li>
                    <i class="icon-user"></i> <?php echo CHtml::link($data->getFullName(), array('/user/people/userInfo/', 'username' => $data->nick_name));?>
                </li>
                <li>
                    <i class="icon-calendar"></i> <?php echo Yii::app()->dateFormatter->format(
                        'dd MMMM yyyy',
                        $data->last_visit
                    ); ?>
                </li>
            </ul>
        </div>

    </div>
</div>