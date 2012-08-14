<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Облачко меток</div>
    </div>
    <div class='portlet-content'>
        <?php if(isset($tags) && $tags != array()): ?>
            <ul>
                <?php
                foreach($tags as $tag => $count)
                {
                    $link = CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag)));
                    echo CHtml::tag('span', array('style' => "font-size:{$count}pt"), $link) . "\n";
                }
                ?>
            </ul>
        <?php endif; ?>
    </div>
</div>