<?php $this->pageTitle = 'Список записей'; ?>

<p>Записи с тегом <b><?php echo $tag;?></b>...</p>

<?php foreach($posts as $post):?>
    <?php $this->renderPartial('_view',array('data' => $post));?>
<?php endforeach;?>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>




