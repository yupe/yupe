<div class="accordion-group">
    <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $data->id?>" href="#collapseOne<?php echo $data->id?>">
            <?php echo yupe\helpers\YText::characterLimiter(strip_tags($data->theme),250);?>
        </a>
    </div>
    <div id="collapseOne<?php echo $data->id?>" class="accordion-body collapse">
        <div class="accordion-inner">
            <?php echo strip_tags($data->answer);?>
            <span class="label label-info">
                <?php echo CHtml::link(Yii::t('FeedbackModule.feedback','More...'),array('/feedback/contact/faqView','id' => $data->id));?>
            </span>
        </div>
    </div>
</div>