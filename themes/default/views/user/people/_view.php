<?php //:KLUDGE: Определение дефолтного аватара желательно внести в User::getAvatar ?>
<?php ($avatar = $data->getAvatar( 100 )) || ($avatar = CHtml::image( Yii::app()->theme->baseUrl."/images/default_avatar_100.png", '' )); ?>

<div class="view">
    <b><?=$avatar?></b>
    <br/>
    
    <b><?=CHtml::encode($data->getAttributeLabel('nick_name'))?>:</b>
    <?=CHtml::link(CHtml::encode($data->nick_name), array('people/userInfo', 'username'=>$data->nick_name)); ?>
    <br/>
    
    <b><?=CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
    <?=CHtml::encode($data->creation_date); ?>
    <br/>
    
    <?php //:TODO: Требуется добавить вывод рейтинга и силы пользователя ?>
    <div>Рейтинг: &infin; &nbsp; Сила: &infin;</div>    
</div>
