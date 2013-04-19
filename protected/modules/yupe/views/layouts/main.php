<?php
/**
 * Отображение для layouts/main:
 * 
 *   @category YupeLayout
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
Yii::app()->clientScript->registerScript(
    'yupeToken', 'var actionToken = ' . json_encode(
        array(
            'token'      => Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
            'url'        => $this->createAbsoluteUrl('backend/modulestatus'),
            'message'    => Yii::t('YupeModule.yupe', 'Подождите, идёт обработка вашего запроса'),
            'error'      => Yii::t('YupeModule.yupe', 'Во время обработки вашего запроса произошла неизвестная ошибка'),
            'loadingimg' => CHtml::image(
                '/web/booster-install/assets/img/progressbar.gif', '', array(
                    'style' => 'width: 100%; height: 20px;',
                )
            ),
            'buttons'    => array(
                'yes'    => Yii::t('YupeModule.yupe', 'Да'),
                'no'     => Yii::t('YupeModule.yupe', 'Отмена'),
            ),
            'messages'   => array(
                'confirm_deactivate'       => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите отключить модуль?'),
                'confirm_activate'         => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите включить модуль?'),
                'confirm_uninstall'        => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить модуль?') . '<br />' . Yii::t('YupeModule.yupe', 'Все данные модуля буду удалены.'),
                'confirm_install'          => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите установить модуль?') . '<br />' . Yii::t('YupeModule.yupe', 'Будут добавлены новые данные для работы модуля.'),
                'confirm_cacheFlush'       => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить весь кеш?'),
                'confirm_assetsFlush'      => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить все ресурсы (assets)?'),
                'confirm_cacheAssetsFlush' => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить весь кеш и все ресурсы (assets)?') . '<br />' . Yii::t('YupeModule.yupe', 'Стоит учесть, что это трудоёмкий процесс и может занять некоторое время!'),
                'unknown'                  => Yii::t('YupeModule.yupe', 'Выбрано неизвестное действие.'),
            )
        )
    ), CClientScript::POS_BEGIN
); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo Yii::app()->baseUrl;?>/web/images/favicon.png" />
    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    $mainAssets = Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('application.modules.yupe.views.assets')
    );
    Yii::app()->clientScript->registerCssFile($mainAssets . '/css/styles.css');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/main.js');
    if (($langs = $this->yupe->languageSelectorArray) != array())
        Yii::app()->clientScript->registerCssFile($mainAssets. '/css/flags.css');
    ?>
</head>

<body>
    <div id="overall-wrap">
        <!-- mainmenu -->
        <?php
        $brandTitle = Yii::t('YupeModule.yupe', 'Перейти на главную панели управления');

        $this->widget(
            'bootstrap.widgets.TbNavbar', array(
                'htmlOptions' => array('class' => 'navbar-inverse'),
                'fluid'       => true,
                'brand'       => CHtml::image(
                    $this->yupe->themeBaseUrl . "/web/images/logo.png", $brandTitle, array(
                        'width'  => '38',
                        'height' => '38',
                        'title'  => $brandTitle,
                    )
                ),
                'brandUrl'    => CHtml::normalizeUrl(array("/yupe/backend/index")),
                'items'       => array(
                    array(
                        'class' => 'bootstrap.widgets.TbMenu',
                        'items' => $this->yupe->getModules(true),
                    ),
                    array(
                        'class'       => 'bootstrap.widgets.TbMenu',
                        'htmlOptions' => array('class' => 'pull-right'),
                        'encodeLabel' => false,
                        'items'       => array_merge(
                            array(
                                array(
                                    'icon'  => 'question-sign white',
                                    'label' => Yii::t('YupeModule.yupe', 'Помощь'),
                                    'url'   => CHtml::normalizeUrl(array('/yupe/backend/help')),
                                ),
                                array(
                                    'icon'        => 'home white',
                                    'label'       => Yii::t('YupeModule.yupe', 'На сайт'),
                                    'linkOptions' => array('target' => '_blank'),
                                    'url'         => array('/' . Yii::app()->defaultController . '/index/'),
                                ),
                                array(
                                    'label'       => '
                                        <div style="float: left; line-height: 16px; text-align: center; margin-top: -10px;">
                                            <small style="font-size: 80%;">' . Yii::t('YupeModule.yupe', 'Администратор') . '</small><br />
                                            <span class="label">' . Yii::app()->user->nick_name . '</span>
                                        </div>',
                                    'encodeLabel' => false,
                                    'items'       => array(
                                        array(
                                            'icon'  => 'user',
                                            'label' => Yii::t('YupeModule.yupe', 'Профиль'),
                                            'url'   => CHtml::normalizeUrl((array('/user/default/update', 'id' => Yii::app()->user->id))),
                                        ),
                                        array(
                                            'icon'  => 'off',
                                            'label' => Yii::t('YupeModule.yupe', 'Выйти'),
                                            'url'   => CHtml::normalizeUrl(array('/user/account/logout')),
                                        ),
                                    ),
                                ),
                            ), $this->yupe->languageSelectorArray
                        ),
                    ),
                ),
            )
        );
        ?>
        <div class="container-fluid" id="page"><?php echo $content; ?></div>
        <div id="footer-guard"><!-- --></div>
    </div>
    <footer>
        Copyright &copy; 2009-<?php echo date('Y'); ?>
        <a href='<?php echo $this->yupe->brandUrl; ?>'>
            <?php echo CHtml::encode(Yii::app()->name); ?>
        </a> 
        <small class="label label-info"><?php echo $this->yupe->getVersion(); ?></small>
        <br/>
        <a href="http://yupe.ru/feedback/index?from=engine">
            <?php echo Yii::t('YupeModule.yupe', 'Разработка и поддержка'); ?></a> - <a href="mailto:team@yupe.ru">yupe team
        </a>
        <br/>
        <?php echo Yii::powered(); ?>
        <?php $this->widget('YPerformanceStatistic'); ?>
    </footer>
</body>
</html>