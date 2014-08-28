<?php if ($page->layout): ?>
    <?php $this->layout = "//layouts/{$page->layout}"; ?>
<?php endif; ?>

<?php
/* @var $page Page */
/* @var $this PageController */

$this->pageTitle = $page->title;
$this->breadcrumbs = $this->getBreadCrumbs();
$this->description = $page->description ? : $this->description;
$this->keywords = $page->keywords ? : $this->keywords
?>



<h3><?php echo $page->title; ?></h3>

<p><?php echo $page->body; ?></p>
