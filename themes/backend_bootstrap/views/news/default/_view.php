<div style="margin-bottom: 20px;">
    <h6><span class="label"><?php echo $data->date;?></span> <?php echo CHtml::link($data->title, array('/news/news/show', 'title' => $data->alias)); ; ?></h6>
    <p>
        <?php echo $data->short_text; ; ?>
    </p>
</div>
