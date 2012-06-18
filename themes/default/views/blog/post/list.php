<?php $this->pageTitle = 'Список записей'; ?>


<?php
$this->breadcrumbs = array(
    'Блоги' => array('/blogs/'),
    'список записей'
);
?>

<p>Записи с меткой <b><?php echo $tag;?></b>...</p>

<?php foreach($posts as $post):?>
    <?php $this->renderPartial('_view',array('data' => $post));?>
<?php endforeach;?>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>




