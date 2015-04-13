<?php
$this->title = [$page->title, Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('HomepageModule.homepage', 'Pages'),
    $page->title
];
$this->metaDescription = !empty($page->description) ? $page->description : $this->description;
$this->metaKeywords = !empty($page->keywords) ? $page->keywords : $this->keywords
?>

<h1><?php echo $page->title; ?></h1>

<?php echo $page->body; ?>
