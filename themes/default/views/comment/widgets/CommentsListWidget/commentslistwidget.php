<?php Yii::import('application.modules.comment.CommentModule'); ?>
<div id="comments">
<?php if(count($comments)):?>
    <?php if (!$this->comment):?>
        <strong><?php echo $this->label; ?> <?php echo count($comments); ?></strong>
        <?php echo CHtml::link(
            CHtml::image(
                Yii::app()->getAssetManager()->publish(
                    Yii::app()->theme->basePath) . '/web/images/rss.png'
            ), array(
                '/comment/commentRss/feed',
                'model'   => $this->model,
                'modelId' => $this->modelId
            )
        ); ?>
    <?php endif;?>

    <?php foreach ($comments as $comment):?>

        <?php if(!$this->comment && is_object($comment)):?>
            <?php  $level = ($comment->level < 10 ) ? $comment->level : 10; ?>            
        <?php else:?>
            <?php $comment = $this->comment;?>
            <?php $level = 1;?>
        <?php endif;?>
            <div class="well well-small comment-body" id="comment_<?php echo $comment->id;?>_<?php echo str_replace(' ', '_', $comment->creation_date); ?>" style="margin-left: <?php echo (10 * $level); ?>px; " level="<?php echo $level; ?>">
                    <a class="pull-left" href="<?php echo $comment->getAuthorUrl()?>"><?php echo $comment->getAuthorAvatar();?></a> 
                    <ul>
                        <li><?php echo $comment->getAuthorLink();?></li>
                        <li class="time icon-time"><time datetime="<?php echo str_replace(' ', '_', $comment->creation_date); ?>"><?php echo Yii::app()->getDateFormatter()->formatDateTime($comment->creation_date, "long", "short"); ?></time></li>
                        <li class="comment-botton-right">
                            <?php echo CHtml::link(
                            '<i class="icon-bullhorn"></i>', 'javascript:void(0);', array(
                                'rel'     => $comment->id,
                                'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                                'class'   => 'commentParrent',
                                'title'   => Yii::t('CommentModule.comment','Reply')
                            ));?>
                        </li>
                    </ul>
                <p><?php echo $comment->getText() ;?></p>
            </div>
    <?php endforeach;?>
<?php else:?>
    <p><?php echo $this->label; ?> <?php echo Yii::t('CommentModule.comment','be first!');?>
<?php endif;?>
</div>
