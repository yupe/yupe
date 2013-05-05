<?php
/**
 * application file.
 * 
 * Description of application file
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package
 * @since 1.1.7
 */


$index = 1;
?>

<?php foreach ($data as $id=>$item) : ?>
<h4><?php echo YiiDebug::t('Context')?>&nbsp;<?php echo CHtml::encode(get_class($item['context']))?></h4>
<p class="collapsible collapsed">
    <?php echo $this->getFileAlias($item['sourceFile']) ?>
</p>

<div>
    <table>
    <tbody>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Context class</th>
            <td><?php echo CHtml::encode(get_class($item['context']))?></td>
        </tr>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Inheritance</th>
            <td><?php echo $this->getInheritance($item['reflection'])?></td>
        </tr>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Defined in file</th>
            <td><?php echo $this->getFilePath($item['reflection']->getFileName()) ?></td>
        </tr>

        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Context properties</th>
            <td>
                <ul>
                    <?php if ($item['contextProperties']) : foreach($item['contextProperties'] as $key=>$value) : ?>
                    <li>
                        <label><?php YiiDebug::dump($key, 1) ?></label>
                        &nbsp;=>&nbsp;
                        <span><label><?php YiiDebug::dump($value, 0) ?></label></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <?php YiiDebug::dump(null) ?>
                <?php endif; ?>
            </td>
        </tr>

        <?php if(null!==$item['action']): ?>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Route</th>
            <td><?php echo $item['route'] ?></td>
        </tr>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Action</th>
            <td><?php echo get_class($item['action']) , '&nbsp;(' , $item['action']->getId() , ')'  ?></td>
        </tr>

        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Action params</th>
            <td>
                <ul>
                    <?php if ($item['actionParams']) : foreach($item['actionParams'] as $key=>$value) : ?>
                    <li>
                        <label><?php YiiDebug::dump($key, 1) ?></label>
                        &nbsp;=>&nbsp;
                        <span><label><?php YiiDebug::dump($value, 0) ?></label></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <?php YiiDebug::dump(null) ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endif; ?>

        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">Render method</th>
            <td><?php echo $item['backTrace']['function'] ?></td>
        </tr>

        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">View file</th>
            <td><?php echo $this->getFilePath($item['sourceFile']) ?></td>
        </tr>

        <?php if(!(1===count($item['data']) && isset($item['data']['content']))): ?>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th nowrap="nowrap">View data</th>
            <td>
                <ul>
                    <?php if ($item['data']) : foreach($item['data'] as $key=>$value) : ?>
                    <li>
                        <label><?php YiiDebug::dump($key, 1) ?></label>
                        &nbsp;=>&nbsp;
                        <span><label><?php YiiDebug::dump($value, 0) ?></label></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <?php YiiDebug::dump(null) ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endif; ?>

    </tbody>
</table>
</div>
<?php endforeach; ?>

