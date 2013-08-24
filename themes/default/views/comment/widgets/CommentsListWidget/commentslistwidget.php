<div id="comments">
<?php if(count($comments)):?>
    <?php if (!$this->comment):?>
        <strong><?php echo $this->label; ?> <?php echo count($comments); ?></strong>
        <?php echo CHtml::link(CHtml::image(Yii::app()->theme->baseUrl.'/web/images/rss.png'),array('/comment/rss/feed','model' => $this->model, 'modelId' => $this->modelId));?>
    <?php endif;?>

    <?php foreach ($comments as $comment):?>

        <?php if(!$this->comment && is_object($comment)):?>
            <?php $level = $comment->level-2; ?>
        <?php else:?>
            <?php $comment = $this->comment;?>
            <?php $level = 1;?>
        <?php endif;?>

        <div style="margin-left: <?php echo (20 * $level); ?>px; " level="<?php echo $level; ?>">
            <div class="well well-small" id="comment_<?php echo $comment->id;?>_<?php echo str_replace(' ', '_', $comment->creation_date); ?>">
                <div class="avatar">
                    <?php echo $comment->getAuthorAvatar();?>
                </div>
                <div class="comment-body">
                    <div class="author">
                        <?php echo $comment->getAuthorLink();?> <?php echo Yii::t('comment', 'написал');?>
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
                    <div class="time"> <?php echo $comment->creation_date; ?> </div>
                    <div class="content"> <?php echo $comment->getText() ;?> </div>
                </div>
            </div>
        </div>

    <?php endforeach;?>


<?php else:?>
    <p><?php echo $this->label; ?> <?php echo Yii::t('comment', 'пока нет, станьте первым!');?>
<?php endif;?>

</div>

