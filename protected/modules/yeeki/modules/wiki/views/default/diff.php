<h1>
	<?php echo CHtml::link(CHtml::encode($uid), array('view', 'uid' => $uid))?>
	diff for
	<?php echo CHtml::link('r'.$r1->id, array('view', 'uid' => $uid, 'rev' => $r1->id))?>
	→
	<?php echo CHtml::link('r'.$r2->id, array('view', 'uid' => $uid, 'rev' => $r2->id))?>
</h1>

<div class="wiki-diff"><?php echo $diff?></div>