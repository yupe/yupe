<?php
/* @var $comment Comment */
$level = $comment->getLevel()
?>

<div class="comments-item <?= $level > 0 ? 'comments-item-child' : '' ?>"
     data-level="<?= $level; ?>"
     data-pid="<?= $comment->parent_id; ?>"
     data-id="<?= $comment->id; ?>"
     style="margin-left: <?=(30 * $level); ?>px;">

    <div class="comments-item-main">
        <div class="comments-item-avatar">
            <a href="<?= $comment->getAuthorUrl() ?>"><?= $comment->getAuthorAvatar(); ?></a>
        </div>
        <div class="comments-item-top">
            <div class="comments-item-author">
                <?= $comment->getAuthorLink(); ?>
                <span class='comments-item-date'>
                    <time datetime="<?= str_replace(' ', '_', $comment->create_time); ?>">
                        <?= Yii::app()->getDateFormatter()->formatDateTime(
                            $comment->create_time,
                            'long',
                            'short'
                        ); ?>
                    </time>
                </span>
            </div>
        </div>
        <div class="comments-item-message">
            <?= trim($comment->getText()); ?>
            <div>
                <?= CHtml::link(
                    Yii::t('CommentModule.comment', 'reply'),
                    '#',
                    [
                        'rel' => $comment->id,
                        'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->create_time),
                        'class' => 'reply',
                        'title' => Yii::t('CommentModule.comment', 'Reply')
                    ]
                ); ?>
            </div>

        </div>
    </div>
</div>
