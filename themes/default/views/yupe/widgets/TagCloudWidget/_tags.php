<ul class="inline">
    <?php foreach ($tags as $tag => $count): ?>
        <?php $count += 2; ?>
        <?php $link = CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag))); ?>
        <?php echo CHtml::tag('li',array(), CHtml::tag('span', array('class' => 'label label-info','style' => "font-size:{$count}pt"), $link)); ?>
    <?php endforeach;?>
</ul>

