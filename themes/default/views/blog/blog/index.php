<?php
Yii::app()->clientScript->registerScript(
    "ajaxToken", "var ajaxToken = " . json_encode(
        Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken
    ) . ";", CClientScript::POS_BEGIN
);
$this->pageTitle = Yii::t('blog', 'Блоги');
$this->breadcrumbs = array(Yii::t('blog', 'Блоги'));
?>

<h1>Блоги <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/');?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/web/images/rss.png" alt="Подпишитесь на обновления" title="Подпишитесь на обновления"></a></h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    )
); ?>