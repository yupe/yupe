<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Последнее в блогах</div>
    </div>
    <div class='portlet-content'>
        <ul>
            <?php foreach ($posts as $post): ?>
            <li><?php echo CHtml::link($post->title, array('/blog/post/show/', 'slug' => $post->slug));?></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
