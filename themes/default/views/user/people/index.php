<?php
    $this->pageTitle = Yii::t('UserModule.user','Users');
    $this->breadcrumbs = array(
        Yii::t('UserModule.user','Users'),
    );
?>

<h1><?php echo Yii::t('UserModule.user','Users'); ?></h1>

<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(        
        'method'      => 'get',
        'type'        => 'vertical'     
    ));
 ?>

 <div class="input-append">  
     <?php echo $form->textField($users,'nick_name', array('placeholder' => 'поиск по нику', 'class' => 'span8'));?>
     <button class="btn" type="submit">искать</button>
 </div>

<?php $this->endWidget(); ?>

<?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'dataProvider' => $users->search(),        
        'type'     => 'condensed striped',
        'template' => "{items}\n{pager}",
        'columns'  => array(
        	array(
        		'header' => false,
        		'value'  => 'CHtml::link(CHtml::image($data->getAvatar(90)), array("/user/people/userInfo","username" => $data->nick_name))',
        		'type'   => 'html'
        	),
        	array(
        		'name'   => 'nick_name',
        		'header' => 'Пользователь',
        		'type'   => 'html',
        		'value'  => 'CHtml::link($data->nick_name, array("/user/people/userInfo","username" => $data->nick_name))'
        	),
        	array(
        		'name'   => 'location',
        		'header' => 'Откуда'
        	),
        	array(
        		'header' => 'Был на сайте',
                'name'   => 'last_visit',
        		'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->last_visit, "long", false)'
            ),
            array(
                'header' => 'Присоеденился',
                'name'   => 'registration_date',
                'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->registration_date, "long", false)'
            )
         )
    ));
?>