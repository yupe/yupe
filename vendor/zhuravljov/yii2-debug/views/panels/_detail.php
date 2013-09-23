<?php
/* @var Yii2DebugPanel $this */
/* @var string $caption */
/* @var array $values */
?>
<h3><?= $caption ?></h3>
<?php if (!empty($values)): ?>
	<table class="table table-condensed table-bordered table-striped table-hover" style="table-layout: fixed;">
		<thead>
			<tr>
				<th style="width: 300px;">Name</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($values as $name => $value): ?>
			<tr>
				<th style="width:300px;word-break:break-all;">
					<?= CHtml::encode($name) ?>
				</th>
				<td>
					<div style="overflow:auto">
					<?php
						if (is_string($value)) {
							echo CHtml::encode($value);
						} elseif ($this->highlightCode) {
							echo $this->highlightPhp(var_export($value, true));
						} else {
							echo CHtml::encode(var_export($value, true));
						}
						?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<p>Empty</p>
<?php endif; ?>