<?php
$this->pageTitle = 'Поиск по запросу: ' . CHtml::encode($term);
$this->breadcrumbs = array(
    'Поиск по запросу: ' . CHtml::encode($term),
);
?>
<h1>Поиск по запросу: "<?php echo CHtml::encode($term); ?>"</h1>

<?php echo CHtml::beginForm(array('/zendsearch/search/search'), 'get'); ?>
    <?php echo CHtml::textField('q',CHtml::encode($term), array('placeholder' => 'Поиск...', 'class' => ''));?>
    <?php echo CHtml::submitButton('Искать!', array('class' => 'btn'));?>
<?php echo CHtml::endForm();?>


<?php if (!empty($results)): ?>
    <h3>Результаты:</h3>
    <?php foreach ($results as $result):?>
        <?php
        $resultLink = '/';
        $paramsArray = array();

        $linkArray = explode('?', $result->link);
        if (isset($linkArray[0])) {
            $resultLink = $linkArray[0];
        } else {
            $resultLink = $result->link;
        }

        if (isset($linkArray[1])) {
            foreach (explode('&', $linkArray[1]) as $param) {
                $paramArray = explode('=', $param);
                $paramsArray[$paramArray[0]] = $paramArray[1];
            }
        }
        ?>

        <h3>
            <?php echo $query->highlightMatches(CHtml::link(CHtml::encode($result->title), CController::CreateUrl($resultLink, $paramsArray)), 'UTF-8');?>
        </h3>
        <p><?php echo $query->highlightMatches($result->description, 'UTF-8'); ?></p>
        <hr/>
    <?php endforeach; ?>

<?php else: ?>
    <p class="error">Поиск не дал результатов.</p>
<?php endif; ?>
