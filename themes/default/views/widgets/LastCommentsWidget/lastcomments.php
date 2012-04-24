<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Последние комментарии</div>
    </div>
    <div class='portlet-content'>
        <ul>
            <?php foreach ($comments as $comment): ?>
            <li><?php echo CHtml::link($comment->text);?></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
