<?php list($queryCount, $queryTime) = $app->db->getStats() ?>
<!-- start profiling summary -->
<table class="yiiLog" width="100%" cellpadding="2" style="border-spacing:1px;font:11px Verdana, Arial, Helvetica, sans-serif;background:#EEEEEE;color:#666666;">
	<tr>
		<th style="background:black;color:white;" colspan="6">
			DB Profiling Summary Report
			(Query count: <?php echo $queryCount?>, Total query time: <?php echo sprintf('%0.5f',$queryTime)?>s)
		</th>
	</tr>
	<tr style="background-color: #ccc;">
	    <th>Procedure</th>
		<th>Count</th>
		<th>Total (s)</th>
		<th>Avg. (s)</th>
		<th>Min. (s)</th>
		<th>Max. (s)</th>
	</tr>
<?php
foreach($data as $index=>$entry)
{
	$color=($index%2)?'#F5F5F5':'#FFFFFF';
	$proc=CHtml::encode($entry[0]);
	$min=sprintf('%0.5f',$entry[2]);
	$max=sprintf('%0.5f',$entry[3]);
	$total=sprintf('%0.5f',$entry[4]);
	$average=sprintf('%0.5f',$entry[4]/$entry[1]);

	if($max>$slowQueryMin || $entry[1]>$countLimit)
	{
		$color = '#FFEEEE';
	}

	echo <<<EOD
	<tr style="background:{$color}">
		<td style="background:{$color}">{$proc}</td>
		<td style="background:{$color}; text-align: right">{$entry[1]}</td>
		<td style="background:{$color}; text-align: right">{$total}</td>
		<td style="background:{$color}; text-align: right">{$average}</td>
		<td style="background:{$color}; text-align: right">{$min}</td>
		<td style="background:{$color}; text-align: right">{$max}</td>
	</tr>
EOD;
}
?>
</table>
<!-- end of profiling summary -->