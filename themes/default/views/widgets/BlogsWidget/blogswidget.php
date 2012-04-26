<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Блоги</div>
    </div>
    <div class='portlet-content'>
        <ul>
            <?php foreach ($blogs as $blog): ?>
            <li><?php echo CHtml::link($blog->name, array('/blog/blog/show/', 'slug' => $blog->slug));?></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
