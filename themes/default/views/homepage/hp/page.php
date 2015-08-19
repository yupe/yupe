<?php
/** @var Page $page */

if ($page->layout) {
    $this->layout = "//layouts/{$page->layout}";
}

$this->title = [$page->title, Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('HomepageModule.homepage', 'Pages'),
    $page->title
];
$this->metaDescription = !empty($page->description) ? $page->description : Yii::app()->getModule('yupe')->siteDescription;
$this->metaKeywords = !empty($page->keywords) ? $page->keywords : Yii::app()->getModule('yupe')->siteKeyWords
?>

<h1><?= $page->title; ?></h1>

<?= $page->body; ?>
