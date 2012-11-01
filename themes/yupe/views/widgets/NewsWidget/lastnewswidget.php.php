<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Новости</div>
    </div>
    <div class='portlet-content'>
        <ul>
            <?php foreach ($news as $new): ?>
            <li><?php echo CHtml::link($new->title, array('/news/news/show/', 'title' => $new->alias));?></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
