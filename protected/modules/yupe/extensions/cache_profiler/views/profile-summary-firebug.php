<?php list($queryCount, $queryTime) = $app->db->getStats() ?>
<script type="text/javascript">
/*<![CDATA[*/
if(typeof(console)=='object')
{
	console.group("DB Profiling Summary Report (Query count: <?php echo $queryCount?>, Total query time: <?php echo sprintf('%0.5f',$queryTime)?>s)");
	console.log(" count   total   average    min      max   ");
<?php
foreach($data as $index=>$entry)
{
	$proc=CJavaScript::quote($entry[0]);
	$count=sprintf('%5d',$entry[1]);
	$min=sprintf('%0.5f',$entry[2]);
	$max=sprintf('%0.5f',$entry[3]);
	$total=sprintf('%0.5f',$entry[4]);
	$average=sprintf('%0.5f',$entry[4]/$entry[1]);
	echo "\tconsole.log(\" $count  $total  $average  $min  $max    {$proc}\");\n";
}
?>
	console.groupEnd();
}
/*]]>*/
</script>
