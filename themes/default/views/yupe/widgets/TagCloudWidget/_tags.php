<ul class="inline">
    <?php
    foreach ($tags as $tag => $count) {
        $count += 2;
        $link = CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag)));
        echo CHtml::tag('li',array(), CHtml::tag('span', array('class' => 'label label-info','style' => "font-size:{$count}pt"), $link));
    }
    ?>
</ul>

