<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
    Yii::app()->getModule('zendsearch')->getCategory() => array(),
    Yii::t('ZendSearchModule.zendsearch', 'Поиск (Zend)') => array('/zendsearch/default/index'),
    Yii::t('ZendSearchModule.zendsearch', 'Управление'),
);

$this->pageTitle = Yii::t('ZendSearchModule.zendsearch', 'Поиск (Zend) - управление');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ZendSearchModule.zendsearch', 'Поиск (Zend)'); ?>
        <small><?php echo Yii::t('ZendSearchModule.zendsearch', 'управление'); ?></small>
    </h1>
</div>
<p>
    <?php echo Yii::t('ZendSearchModule.zendsearch','Модели, которые Вы хотите проиндексировать необходимо описать в конфигурационном файле.');?><br/>
    <?php echo Yii::t('ZendSearchModule.zendsearch','Для создания или обновления индекса нажмите кнопку ниже.');?>
</p>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'ajaxButton',
    'id' => 'create-search',
    'type' => 'primary',
    'label' => Yii::t('ZendSearchModule.zendsearch', 'Обновить поисковый индекс'),
    'loadingText' => Yii::t('ZendSearchModule.zendsearch','Индекс обновляется... Подождите...'),
    'size' => 'large',
    'url' => $this->createUrl('/zendsearch/default/create'),
    'ajaxOptions' => array(
        'type' => 'POST',
        'data' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
        'url' => $this->createUrl('/zendsearch/default/create'),
        'beforeSend' => 'function(){
	       $("#create-search").text("'.Yii::t('ZendSearchModule.zendsearch','Подождите...').'");
	     }',
        'success' => 'js:function(data,status){
            $("#create-search").text("'.Yii::t('ZendSearchModule.zendsearch','Обновить поисковый индекс').'");
            alert(data);
	     }',
    )
));
?>