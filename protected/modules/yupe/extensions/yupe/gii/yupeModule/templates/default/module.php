<?php echo "<?php\n"; ?>
/**
 * <?php echo $this->moduleClass; ?> основной класс модуля <?php echo $this->moduleID."\n"; ?>
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-<?= date('Y'); ?> amyLabs && Yupe! team
 * @package yupe.modules.<?php echo $this->moduleID."\n"; ?>
 * @since 0.1
 */

class <?php echo $this->moduleClass; ?>  extends yupe\components\WebModule
{
    const VERSION = '0.9.8';

    /**
     * Массив с именами модулей, от которых зависит работа данного модуля
     *
     * @return array
     */
    public function getDependencies()
    {
        return parent::getDependencies();
    }

    /**
     * Работоспособность модуля может зависеть от разных факторов: версия php, версия Yii, наличие определенных модулей и т.д.
     * В этом методе необходимо выполнить все проверки.
     *
     * @return array или false
     */
    public function checkSelf()
    {
        return parent::checkSelf();
    }

    /**
     * Каждый модуль должен принадлежать одной категории, именно по категориям делятся модули в панели управления
     *
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleCategory; ?>');
    }

    /**
     * массив лейблов для параметров (свойств) модуля. Используется на странице настроек модуля в панели управления.
     *
     * @return array
     */
    public function getParamsLabels()
    {
        return parent::getParamsLabels();
    }

    /**
     * массив параметров модуля, которые можно редактировать через панель управления (GUI)
     *
     * @return array
     */
    public function getEditableParams()
    {
        return parent::getEditableParams();
    }

    /**
     * массив групп параметров модуля, для группировки параметров на странице настроек
     *
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return parent::getEditableParamsGroups();
    }

    /**
     * если модуль должен добавить несколько ссылок в панель управления - укажите массив
     *
     * @return array
     */
    public function getNavigation()
    {
        return [
            ['label' => Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>')],
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'Index'),
                'url' => ['/<?php echo $this->moduleID; ?>/<?php echo $this->moduleID; ?>Backend/index']
            ],
        ];
    }

    /**
     * текущая версия модуля
     *
     * @return string
     */
    public function getVersion()
    {
        return Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', self::VERSION);
    }

    /**
     * веб-сайт разработчика модуля или страничка самого модуля
     *
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'http://yupe.ru');
    }

    /**
     * Возвращает название модуля
     *
     * @return string.
     */
    public function getName()
    {
        return Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', '<?php echo $this->moduleID; ?>');
    }

    /**
     * Возвращает описание модуля
     *
     * @return string.
     */
    public function getDescription()
    {
        return Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'Описание модуля "<?php echo $this->moduleID; ?>"');
    }

    /**
     * Имя автора модуля
     *
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'yupe team');
    }

    /**
     * Контактный email автора модуля
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'team@yupe.ru');
    }

    /**
     * Ссылка, которая будет отображена в панели управления
     * Как правило, ведет на страничку для администрирования модуля
     *
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/<?php echo $this->moduleID; ?>/<?php echo $this->moduleID; ?>Backend/index';
    }

    /**
     * Название иконки для меню админки, например 'user'
     *
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-<?php echo $this->moduleIcon; ?>";
    }

    /**
      * Возвращаем статус, устанавливать ли галку для установки модуля в инсталяторе по умолчанию:
      *
      * @return bool
      **/
    public function getIsInstallDefault()
    {
        return parent::getIsInstallDefault();
    }

    /**
     * Инициализация модуля, считывание настроек из базы данных и их кэширование
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                '<?php echo $this->moduleID; ?>.models.*',
                '<?php echo $this->moduleID; ?>.components.*',
            ]
        );
    }

    /**
     * Массив правил модуля
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => '<?php echo ucfirst($this->moduleID); ?>.<?php echo ucfirst($this->moduleID); ?>Manager',
                'description' => Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'Manage <?php echo $this->moduleID; ?>'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => '<?php echo ucfirst($this->moduleID); ?>.<?php echo ucfirst($this->moduleID); ?>Backend.Index',
                        'description' => Yii::t('<?php echo $this->moduleClass; ?>.<?php echo $this->moduleID; ?>', 'Index')
                    ],
                ]
            ]
        ];
    }
}
