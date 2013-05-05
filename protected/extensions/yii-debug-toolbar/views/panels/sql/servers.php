<div id="yii-debug-toolbar-sql-servers" class="tabscontent">
<?php if ($connections) : foreach($connections as $id=>$connection): ?>
<h4><?php echo Yii::t('yii-debug-toolbar','Connection ID')?>: <?php echo $id ?> (<?php echo get_class($connection)?>)</h4>
<?php $serverInfo = $this->getServerInfo($id); $c=1;?>
    <table>
        <tbody>
        <?php if(is_array($serverInfo)): ?>
            <?php foreach($serverInfo as $param=>$value){ ++$c;?>
            <tr class="<?php echo ($c%2?'odd':'even') ?>">
                <th><?php echo CHtml::encode($param)?></th>
                <td><?php echo CHtml::encode($value)?></td>
            </tr>
            <?php } ?>
        <?php else: ?>
            <tr class="<?php echo ($c%2?'odd':'even') ?>">
                <th>Used DB driver doesn't provide info.</th>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
<?php endforeach; ?>
<?php else : ?>
No SQL Servers used during this request.
<?php endif;?>
</div>