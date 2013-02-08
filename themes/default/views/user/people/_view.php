<dl>
    <dt style="float:left;margin-right:10px;height:32px">
        <?php echo CHtml::image($data->getAvatar(32),$data->nick_name,array('width' => 32, 'height' => 32)); ?>
    </dt>
    <dd>
        <?php echo CHtml::link(CHtml::encode($data->nick_name), array('/user/people/userInfo', 'username' => $data->nick_name)); ?>
        <br/>
        <?php
        echo Yii::t('user', 'На сайте с {create_date}', array(
            '{create_date}' => Yii::app()->dateFormatter->formatDateTime($data->creation_date , 'long' , null)
        )) . " ";
        if ($data->last_visit)
            echo Yii::t('user', 'Последний раз замечен {last_visit}', array(
                "{last_visit}" => Yii::app()->dateFormatter->formatDateTime($data->last_visit , 'long' , 'short'),
            ));
        ?>
    </dd>
</dl>