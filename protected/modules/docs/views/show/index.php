<?php
/**
 * Файл отображения для show/index:
 *
 * @category YupeViews
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/
$this->breadcrumbs=array(
    $this->module->name => array('index'),
    empty($module) ? Yii::t('DocsModule.docs','Документация') : $module->getName() => empty($module) ? null : array('/docs/show/index/','moduleID' => $module->getId(),'file' => 'index'),
    $title
);
?>

<?php echo $content;?>

<i><?php echo Yii::t('DocsModule.docs', 'изменено {mtime}',array('{mtime}' => $mtime));?></i>

<br/><br/>

<div>
    <script type="text/javascript">(function() {
            if(window.pluso) if(typeof window.pluso.start == "function") return;
            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
            s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
            var h=d[g]('head')[0] || d[g]('body')[0];
            h.appendChild(s);
        })();</script>
    <div class="pluso" data-options="medium,round,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print" data-background="transparent"></div>
</div>

<br/><br/>
<?php $this->widget("application.modules.contentblock.widgets.ContentBlockWidget", array("code" => "DISQUS_COMMENTS","silent" => true)); ?>