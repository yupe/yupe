<?php Yii::import('application.modules.comment.CommentModule'); ?>

<div id="comments" class="comments-list">
    <?php if (count($comments)): ?>
        <h2>
            <small>
                <?php echo $this->label; ?> <?php echo count($comments); ?>
                <?php echo CHtml::link(
                    CHtml::image(Yii::app()->getTheme()->getAssetsUrl() . "/images/rss.png"),
                    array(
                        '/comment/commentRss/feed',
                        'model'   => $this->model,
                        'modelId' => $this->modelId
                    )
                );
                ?>
            </small>
        </h2>

        <?php foreach ($comments as $comment): ?>
            <?php $level = $comment->getLevel(); ?>
            <div class="comments-item <?php echo $level == 0 ? '' : 'comments-item-child' ?>"
                 style="margin-left: <?php echo(30 * $level); ?>px;">
                <div class="comments-item-main" id="comment-<?php echo $comment->id; ?>" level="<?php echo $level; ?>">
                    <div class="comments-item-avatar">
                        <a href="<?php echo $comment->getAuthorUrl() ?>"><?php echo $comment->getAuthorAvatar(); ?></a>
                    </div>
                    <div class="comments-item-top">
                        <div class="comments-item-author">
                            <?php echo $comment->getAuthorLink(); ?>
                            <span class='comments-item-date'>
                                    <time datetime="<?php echo str_replace(
                                        ' ',
                                        '_',
                                        $comment->creation_date
                                    ); ?>"><?php echo Yii::app()->getDateFormatter()->formatDateTime(
                                            $comment->creation_date,
                                            "long",
                                            "short"
                                        ); ?></time>
                                </span>
                        </div>
                    </div>
                    <div class="comments-item-message">
                        <?php echo trim($comment->getText()); ?>
                        <div>
                            <?php echo CHtml::link(
                                Yii::t('CommentModule.comment', 'reply'),
                                'javascript:void(0);',
                                array(
                                    'rel'     => $comment->id,
                                    'data-id' => $comment->id . '_' . str_replace(' ', '_', $comment->creation_date),
                                    'class'   => 'reply',
                                    'title'   => Yii::t('CommentModule.comment', 'Reply')
                                )
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?php echo Yii::t('CommentModule.comment', 'Be first!'); ?></p>
    <?php endif; ?>
</div>
