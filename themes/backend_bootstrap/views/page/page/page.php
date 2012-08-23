<?php
$this->pageTitle = $page->title;
$this->breadcrumbs = $this->getBreadCrumbs();
?>
<h1><?php echo $page->title;?></h1>

<p><?php echo $page->body;?></p>