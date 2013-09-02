<div id="comments">
<?php if(count($comments)):?>
    <?php if (!$this->comment):?>
        <strong><?php echo $this->label; ?> <?php echo count($comments); ?></strong>
        <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/web/images/rss.png'),array('/comment/rss/feed','model' => $this->model, 'modelId' => $this->modelId));?>
    <?php endif;?>

    <?php foreach ($comments as $commentArray):?>

        <?php if(!$this->comment && isset($commentArray['childOf'])):?>
            <?php $comment = $commentArray['row'];?>
            <?php $level = count($commentArray['childOf']);?>
        <?php else:?>
            <?php $comment = $this->comment;?>
            <?php $level = 1;?>
        <?php endif;?>

        <div style="margin-left: <?php echo (20 * $level); ?>px; " level="<?php echo $level; ?>">
            <div class="well well-small" id="comment_<?php echo $comment->id;?>_<?php echo str_replace(' ', '_', $comment->creation_date); ?>">

                <div class="comment-body">
                    <div class="author">
                        <div class="pull-left">
                            <a href="<?php echo $comment->getAuthorUrl()?>"><?php echo $comment->getAuthorAvatar();?></a>
                            <br/>
                            <?php echo $comment->getAuthorLink();?>
                        </div>

                        <span style="float: right">
                            <?php echo CHtml::link(
                                '<i class="icon-bullhorn"></i>', 'javascript:void(0);', array(
                                    'rel'     => $comment->id,
                                    'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                                    'class'   => 'commentParrent',
                                    'title'   => Yii::t('comment','Ответить')
                            ));?>
                        </span>
                    </div>
                    <div class="time"> <?php echo Yii::app()->getDateFormatter()->formatDateTime($comment->creation_date, "long", "short"); ?> </div>
                    <div class="media-body"> <?php echo $comment->getText() ;?> </div>
                </div>
            </div>
        </div>

    <?php endforeach;?>


<?php else:?>
    <p><?php echo $this->label; ?> <?php echo Yii::t('comment', 'пока нет, станьте первым!');?>
<?php endif;?>

</div>

