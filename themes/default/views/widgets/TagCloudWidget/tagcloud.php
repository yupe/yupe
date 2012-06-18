<div class='portlet'>
    <div class='portlet-decoration'>
        <div class='portlet-title'>Облачко тегов</div>
    </div>
    <div class='portlet-content'>
        <ul>
            <?php
            foreach($tags as $tag => $count)
            {
                $link=CHtml::link(CHtml::encode($tag), array('/posts/','tag' => CHtml::encode($tag)));
                echo CHtml::tag('span', array(
                    'style'=>"font-size:{$count}pt",
                ), $link)."\n";
            }
            ?>
        </ul>
    </div>
</div>



