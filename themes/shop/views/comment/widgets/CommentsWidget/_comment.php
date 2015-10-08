<?php
/* @var $comment Comment */
$level = $comment->getLevel()
?>

<div class="product-review-item">
    <div class="product-review-user"><span class="product-review-user__name"><?= $comment->getAuthorLink(); ?></span>
    </div>
    <div class="product-review-item__stat">
        <div data-rate='4' class="rating">
            <div class="rating__label">4</div>
            <div class="rating__corner">
                <div class="rating__triangle"></div>
            </div>
        </div>
    </div>
    <div class="product-review-item__stat">
        <div class="product-review-item__text"><?= trim($comment->getText()); ?></div>
    </div>
    <div class="product-review-item__footer">
        <?= Yii::app()->getDateFormatter()->formatDateTime(
            $comment->create_time,
            'long',
            'short'
        ); ?>
    </div>
</div>
