<h4 class="collapsible"><?php echo YiiDebug::t('Application Properties')?></h4>
<table>
    <thead>
        <tr>
            <th width="180"><?php echo YiiDebug::t('Property')?></th>
            <th><?php echo YiiDebug::t('Value')?></th>
        </tr>
    </thead>
    <tbody>
        <?php $c=0; foreach ($application as $key=>$value) : ?>
        <tr class="<?php echo ($c%2?'odd':'even') ?>">
            <th><?php echo $key; ?></th>
            <td><?php echo $this->dump($value); ?></td>
        </tr>
        <?php ++$c; endforeach;?>
    </tbody>
</table>

<h4 class="collapsible"><?php echo YiiDebug::t('Modules')?></h4>
<table>
    <thead>
        <tr>
            <th width="180"><?php echo YiiDebug::t('Module ID')?></th>
            <th><?php echo YiiDebug::t('Configuration')?></th>
        </tr>
    </thead>
    <tbody>
        <?php $c=0; foreach ($modules as $key=>$value) : ?>
        <tr class="<?php echo ($c%2?'odd':'even') ?>">
            <th><?php echo $key; ?></th>
            <td><?php echo $this->dump($value); ?></td>
        </tr>
        <?php ++$c; endforeach;?>
    </tbody>
</table>

<h4 class="collapsible"><?php echo YiiDebug::t('Application Params')?></h4>
<table>
    <thead>
        <tr>
            <th width="180"><?php echo YiiDebug::t('Name')?></th>
            <th><?php echo YiiDebug::t('Value')?></th>
        </tr>
    </thead>
    <tbody>
        <?php $c=0; foreach ($params as $key=>$value) : ?>
        <tr class="<?php echo ($c%2?'odd':'even') ?>">
            <th><?php echo $key; ?></th>
            <td><?php echo $this->dump($value); ?></td>
        </tr>
        <?php ++$c; endforeach;?>
    </tbody>
</table>

<h4 class="collapsible"><?php echo YiiDebug::t('Components')?></h4>
<table>
    <thead>
        <tr>
            <th width="180"><?php echo YiiDebug::t('Component ID')?></th>
            <th><?php echo YiiDebug::t('Configuration')?></th>
        </tr>
    </thead>
    <tbody>
        <?php $c=0; foreach ($components as $key=>$value) : ?>
        <tr class="<?php echo ($c%2?'odd':'even') ?>">
            <th><?php echo $key; ?></th>
            <td><?php echo $this->dump($value); ?></td>
        </tr>
        <?php ++$c; endforeach;?>
    </tbody>
</table>
