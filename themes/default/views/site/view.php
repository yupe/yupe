<?php
$this->breadcrumbs = [
    $model->title,
];
$this->pageTitle = $model->name;
?>

<?php $this->renderPartial('_view', ['data' => $model]); ?>

<div id="comments">
    <?php if ($model->commentCount >= 1): ?>
        <h3><?php echo ($model->commentCount > 1) ? $model->commentCount . ' comments' : 'One comment'; ?></h3>
        <?php $this->renderPartial(
            '_comments',
            [
                'post'     => $model,
                'comments' => $model->comments,
            ]
        ); ?>
    <?php endif; ?>

    <h3>Leave a Comment</h3>

    <?php if (Yii::app()->user->hasFlash('commentSubmitted')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
        </div>
    <?php else: ?>
        <?php $this->renderPartial('/comment/_form', ['model' => $comment]); ?>
    <?php endif; ?>

</div><!-- comments -->
