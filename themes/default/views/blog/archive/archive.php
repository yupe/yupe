<?php $this->pageTitle = Yii::t('BlogModule.blog', 'Posts archive'); ?>

<?php $this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Posts') => array('/blog/blog/index/'),
    Yii::t('BlogModule.blog', 'archive'),
); ?>

<p><?php echo Yii::t('BlogModule.blog', 'Posts archive'); ?></p>

<?php foreach($data as $year => $element):?>
    <h2><?php echo $year;?></h2>
    <?php foreach($element as $month => $posts):?>
    	<h3><?php echo $month?></h3>
    	<ul>
	    	<?php foreach($posts as $post):?>
	    		<li>
	    			<span><?php echo date('d.m.Y',$post->publish_date);?></span>
	    			<?php echo CHtml::link($post->title, array('/blog/post/show/','slug' => $post->slug));?>
	    		</li>
	    	<?php endforeach;?>	
	    </ul>	
    <?php endforeach;?>
<?php endforeach;?>