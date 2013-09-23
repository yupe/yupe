<?php
/* @var Yii2ProfilingPanel $this */
/* @var array $items */
/* @var string $time */
/* @var string $memory */
?>
<p>Total processing time: <b><?= $time ?></b>; Peak memory: <b><?= $memory ?></b>.</p>

<table class="table table-condensed table-bordered table-striped table-hover table-filtered" style="table-layout:fixed">
	<thead>
	<tr>
		<th style="width:80px">Time</th>
		<th style="width:220px">Category</th>
		<th>Procedure</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($items as $item): ?>
		<tr>
			<td style="width:80px"><?= $item['time'] ?></td>
			<td style="width:220px"><?= CHtml::encode($item['category']) ?></td>
			<td><?= str_repeat('<span class="indent">→</span>', $item['indent']) . CHtml::encode($item['procedure']) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
