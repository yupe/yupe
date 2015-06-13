<?php
/* @var $model Page */
/* @var $this PageController */
?>
<?php if ($model->layout): ?>
    <?php $this->layout = "//layouts/{$model->layout}"; ?>
<?php endif; ?>

<?php
$this->title = [$model->title, Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = $this->getBreadCrumbs();
$this->description = $model->description ?: Yii::app()->getModule('yupe')->siteDescription;
$this->keywords = $model->keywords ?: Yii::app()->getModule('yupe')->siteKeyWords;
?>

<h1><?= $model->title; ?></h1>

<?= $model->body; ?>
