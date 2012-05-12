<?php /** @var $pages WikiPage[] */?>
<?php $namespace=null?>
<ol>
<?php foreach($pages as $page):?>
	<?php if($page->namespace != $namespace):?>
		</ol>
		<h2><?php echo $page->namespace ?></h2>
		<ol>
	<?php $namespace = $page->namespace; endif?>
	<li>
		<?php echo CHtml::link(CHtml::encode($page->page_uid), array('view', 'uid' => $page->page_uid))?>
	</li>
<?php endforeach?>
</ol>