<div style="margin-bottom: 20px;">
    <h6><span class="label"><?=$data->date;?></span> <?=CHtml::link($data->title, array('/news/news/show', 'title' => $data->alias))?></h6>
    <p>
        <?=$data->short_text; ?>
    </p>
</div>
