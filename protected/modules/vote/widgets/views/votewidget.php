<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<script type='text/javascript'>
    $(document).ready(function() {
        var model    = '<?php echo $this->model; ?>';
        var model_id = '<?php echo $this->modelId; ?>';
        $('a.vote').click(function(event) {
            event.preventDefault();
            var value = $(this).attr('id');
            $.post(baseUrl + '/index.php/vote/vote/addVote/', {
                'modelType' : model,
                'model_id'  : model_id,
                'value'     : value,
                '<?php echo Yii::app()->request->csrfTokenName; ?>' : '<?php echo Yii::app()->request->csrfToken; ?>'
            }, function(response) {
                response.result
                    ? $('#votes').html('<?php echo Yii::t('VoteModule.vote', 'Ваша оценка'); ?>: <b>' + value + '</b> <?php echo Yii::t('VoteModule.vote', 'спасибо за голос!'); ?>')
                    : alert(response.data);
            }, 'json');
        });
    });
</script>

<div id="votes">
    <?php if ($model !== NULL): ?>
        <p>
            <?php echo Yii::t('VoteModule.vote', 'Ваша оценка'); ?>:
            <b><?php echo $model->value; ?></b>
        </p>
    <?php else: ?>
        <p>
            <?php echo Yii::t('VoteModule.vote', 'Оцените изображение'); ?>:
            <?php foreach (range(1, 5) as $p): ?>
                <?php echo CHtml::link($p, array(), array('class' => 'vote', 'id' => $p)); ?>
            <?php endforeach; ?>
        </p>
    <?php endif; ?>
</div> 