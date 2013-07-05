<div class="tagscloud-widget">
    <ul class="inline">
        <?php
        foreach ($tags as $tag => $count) {
            $count += 2;
            $link = CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag)));
            echo CHtml::tag('span', array('style' => "font-size:{$count}pt"), $link) . "\n";
        }
        ?>
    </ul>
</div>