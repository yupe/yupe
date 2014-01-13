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