<?php
/**
 * Отображение для layouts/withsidebar:
 * 
 *   @category YupeLayout
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->beginContent("docs.views.layouts.docs");
?>
  <div class="row-fluid">
    <div class="span9">
        <!-- breadcrumbs -->
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs, 'homeLink' => false)); ?>
        <!-- /breadcrumbs -->
        <?php $this->widget('YFlashMessages');?>
        <div id="content">
            <?php echo $content; ?>
        </div>

        <br/>

        <div class="alert alert-warning">
            Документация не полная? Устарела ? Вы нашли ошибку ? Хотите добавить свою статью ?
            <a href="https://github.com/yupe/yupe">Помогите нам !</a>
        </div>

        <br/>

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

        <!-- content -->
        <div id="footer-guard"><!-- --></div>
    </div>
    <div class="span3">
        <div class="well" style="padding: 8px 0;">
            <?php
            $this->widget(
                'bootstrap.widgets.TbMenu', array(
                    'type'=>'list',
                    'items' => $this->module->getArticles(false)
                )
            ); ?>
        </div>
        <div class="well" style="padding: 8px;"><?php $this->widget('YModuleInfo'); ?></div>
    </div>
  </div>
<?php $this->endContent(); ?>