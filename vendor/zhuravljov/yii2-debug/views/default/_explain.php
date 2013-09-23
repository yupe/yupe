<?php
/**
 * @var DefaultController $this
 * @var CDbConnection $connection
 * @var array $explainRows
 */

// Пробелы после знаков препинания для компактного вывода в таблицу
if ($connection->driverName == 'mysql') {
	foreach ($explainRows as &$row) {
		foreach ($row as &$cell) {
			$cell = preg_replace('/\s*[,:;]\s*/', '$0 ', $cell);
			$cell = preg_replace('/\s*[\[({]\s*/', ' $0', $cell);
			$cell = preg_replace('/\s*[\])}]\s*/', '$0 ', $cell);
			$cell = preg_replace('/([\[({])\s+([\[({])/', '$1$2', $cell);
			$cell = preg_replace('/([\])}])\s+([\])}.,:;])/', '$1$2', $cell);
		}
		unset($cell);
	}
	unset($row);
}
?>
<?php if (($first = reset($explainRows)) !== false): ?>
	<table class="table table-condensed table-bordered">
		<thead>
		<tr>
			<?php foreach (array_keys($first) as $key): ?>
				<th><?= CHtml::encode($key) ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($explainRows as $row): ?>
			<tr>
				<?php foreach ($row as $value): ?>
					<td><?= CHtml::encode($value) ?></td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<p>Empty</p>
<?php endif; ?>
