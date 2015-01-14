<?php
/**
 * Файл отображения для show/index:
 *
 * @category YupeViews
 * @package  yupe
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
$this->breadcrumbs = [
    $this->module->name                                                              => ['index'],
    empty($module) ? Yii::t('DocsModule.docs', 'Documentation') : $module->getName() => empty($module) ? null : [
            '/docs/show/index/',
            'moduleID' => $module->getId(),
            'file'     => 'index'
        ],
    $title
];
?>

<?php echo $content; ?>

<i><?php echo Yii::t('DocsModule.docs', 'Updated {mtime}', ['{mtime}' => $mtime]); ?></i>

<br/><br/>
<?php $this->widget(
    "application.modules.contentblock.widgets.ContentBlockWidget",
    ["code" => "DISQUS_COMMENTS", "silent" => true]
); ?>
