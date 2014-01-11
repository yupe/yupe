<?php Yii::import('application.modules.comment.CommentModule'); ?>
<div id="comments">
    <?php if(count($comments)):?>
        <?php if (!$this->comment):?>
            <h2>
                <small>
                <?php echo $this->label; ?> <?php echo count($comments); ?>
                <?php echo CHtml::link(
                    CHtml::image(
                        Yii::app()->getAssetManager()->publish(
                            Yii::app()->theme->basePath) . '/web/images/rss.png'
                    ), array(
                        '/comment/commentRss/feed',
                        'model'   => $this->model,
                        'modelId' => $this->modelId
                    )
                   );
                ?>
                </small>
            </h2>            
        <?php endif;?>

        <?php foreach ($comments as $comment):?>

            <?php if(!$this->comment && is_object($comment)):?>
                <?php  $level = $comment->level < 10 ? $comment->level - 2 : 10; ?>                            
            <?php else:?>
                <?php $comment = $this->comment;?>
                <?php $level = 0;?>
            <?php endif;?>
                <div class="comments-item-message comment-body" id="comment-<?php echo $comment->id;?>" style="margin-left: <?php echo (10 * $level); ?>px; " level="<?php echo $level; ?>">
                    <a class="pull-left" href="<?php echo $comment->getAuthorUrl()?>"><?php echo $comment->getAuthorAvatar();?></a> 
                    <ul>
                        <li><?php echo $comment->getAuthorLink();?></li>
                        <li class="time"><time datetime="<?php echo str_replace(' ', '_', $comment->creation_date); ?>"><?php echo Yii::app()->getDateFormatter()->formatDateTime($comment->creation_date, "long", "short"); ?></time></li>                        
                    </ul>
                    <p>
                        <?php echo $comment->getText() ;?>
                        <div>
                            <?php echo CHtml::link(
                                    Yii::t('CommentModule.comment','reply'), 'javascript:void(0);', array(
                                        'rel'     => $comment->id,
                                        'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                                        'class'   => 'reply',
                                        'title'   => Yii::t('CommentModule.comment','Reply')
                                    ));?>
                        </div>            
                    </p>
                </div>
        <?php endforeach;?>
    <?php else:?>        
        <p><?php echo Yii::t('CommentModule.comment','Be first!');?></p>
    <?php endif;?>
</div>
