<?php
/**
 * Класс модуля документации:
 *
 * @category YupeModule
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
class DocsModule extends YWebModule
{

    public $categorySort    = 9999;
    public $docFolder       = 'application.modules.docs.guide';
    public $moduleDocFolder = 'application.modules.{module}.guide';
    public $notFoundOn      = 1;

    /**
     * Кеширование страниц на уровне фильтрации:
     */
    public $cachePages   = 0;

    /**
     *  Добавлено пустое значение на тот случай,
     *  если файл не имеет расширения. Для этого
     *  файла мы будем использовать преобразование
     *  как для обычного md-файла
     */
    public $fileExtMD   = 'md,txt';
    public $fileExtHTML = 'html,htm';

    /**
     * Статические файлы для рендеринга:
     */
    public $staticFiles = 'README.md,README_EN.md,LICENSE,UPGRADE,CHANGELOG,TEAM.md,install_ru.txt';

    /**
     * Категория модуля:
     * 
     * @return string category
     */
    public function getCategory()
    {
        return Yii::t('DocsModule.docs', 'Юпи!');
    }

    /**
     * Лейблы для редактируемых параметров:
     * 
     * @return array edit params labels
     */
    public function getParamsLabels()
    {
        return array(
            'docFolder'       => Yii::t('DocsModule.docs', 'Расположение файлов документации'),
            'moduleDocFolder' => Yii::t('DocsModule.docs', 'Расположение файлов документации модулей ({module} вместо него подставляется название модуля)'),
            'notFoundOn'      => Yii::t('DocsModule.docs', 'Показывать страницу ошибки, если файл документации на данном языке не найден?'),
            'fileExtMD'       => Yii::t('DocsModule.docs', 'Расширения для файлов MarkDown'),
            'fileExtHTML'     => Yii::t('DocsModule.docs', 'Расширения для файлов HTML'),
            'cachePages'      => Yii::t('DocsModule.docs', 'Кеширование страниц на уровне фильтрации'),
            'staticFiles'     => Yii::t('DocsModule.docs', 'Файлы, которые необходимо показать в админ панели'),
        );
    }

    /**
     * Редактируемые параметры:
     * 
     * @return array editable params
     */
    public function getEditableParams()
    {
        return array(
            'docFolder',
            'moduleDocFolder',
            'notFoundOn' => $this->notFoundTypes,
            'fileExtMD',
            'fileExtHTML',
            'cachePages' => array(
                Yii::t('DocsModule.docs', 'Выключить'),
                Yii::t('DocsModule.docs', 'Включить'),
            ),
            'staticFiles'
        );
    }

    /**
     * Массив групп параметров:
     * 
     *  @return array массив групп параметров модуля, для группировки параметров на странице настроек
     */
    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
                'label' => Yii::t('DocsModule.docs', 'Основные настройки модуля'),
            ),
            'files' => array(
                'label' => Yii::t('DocsModule.docs', 'Настройки файлов'),
                'items' => array(
                    'fileExtMD',
                    'fileExtHTML',
                    'staticFiles',
                )
            )
        );
    }

    /**
     * Варианты для параметра notFoundOn
     *
     * @return array types for variable notFoundOn
     **/
    public function getNotFoundTypes()
    {
        return array(
            0 => Yii::t('DocsModule.docs', 'Отображать страницу из языка поумолчанию'),
            1  => Yii::t('DocsModule.docs', 'Отображать ошибку'),
        );
    }

    /**
     * Название модуля:
     * 
     * @return string module name
     */
    public function getName()
    {
        return Yii::t('DocsModule.docs', 'Документация');
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('ContentBlockModule.contentblock', 'Просмотр локальных файлов'), 'url' => array('/backend/docs')),
            array('icon' => 'icon-globe', 'label' => Yii::t('ContentBlockModule.contentblock', 'Официальная документация'), 'url' => 'http://yupe.ru/docs/index.html?from=help','linkOptions' => array('target' => '_blank')),
        );
    }

    /**
     * Описание модуля:
     * 
     * @return string module description
     */
    public function getDescription()
    {
        return Yii::t('DocsModule.docs', 'Модуль для просмотра и редактирования файлов документации (HTML и Markdown)');
    }

    /**
     * Автор модуля:
     * 
     * @return string module author
     */
    public function getAuthor()
    {
        return Yii::t('DocsModule.docs', 'YupeTeam');
    }

    /**
     * E-mail адрес автора модуля:
     * 
     * @return string module author email
     */
    public function getAuthorEmail()
    {
        return Yii::t('DocsModule.docs', 'team@yupe.ru');
    }

    /**
     * Домашняя страница модуля:
     * 
     * @return string module homepage
     */
    public function getUrl()
    {
        return Yii::t('DocsModule.docs', 'http://yupe.ru');
    }

    /**
     * Иконка модуля:
     * 
     * @return string module icon
     */
    public function getIcon()
    {
        return "book";
    }

    /**
     * Версия модуля:
     * 
     * @return string module version
     */
    public function getVersion()
    {
        return Yii::t('DocsModule.docs', '0.2');
    }

    /**
     * Получаем список файлов из каталога документации:
     *
     * @param string $curDocFolder - путь к каталогу
     *                               документации текущего языка
     *
     * @return desctription of returned
     **/
    public function fileList($curDocFolder = null)
    {
        if ($curDocFolder === null)
            return null;

        /**
         * Берём из кеша список файлов, иначе получаем его снова:
         */
        if (($files = Yii::app()->cache->get('files_' . $curDocFolder)) === false) {
            
            /**
             * Получаем список файлов для построения
             * бокового или верхнего меню:
             */
            $files = glob(
                $curDocFolder
                . DIRECTORY_SEPARATOR
                . '*.'
                . '{'
                . $this->fileExtMD
                . $this->fileExtHTML 
                . '}', GLOB_BRACE
            );

            /**
             * Пишем в кеш и установаливаем зависимость для него
             * на любые изменения в каталоге:
             */
            $chain = new CChainedCacheDependency();
            
            foreach (glob($curDocFolder, GLOB_ONLYDIR) as $item)
                $chain->dependencies->add(new CDirectoryCacheDependency($item));

            Yii::app()->cache->set('files_' . $curDocFolder, $files, 0, $chain);
        }

        return $files;
    }

    /**
     * Меню для "верхушки" (возможно с чайлдами)
     *
     * @return array меню для "верхушки"
     **/
    public function getTopMenu()
    {
        return array(
            array(
                'label' => Yii::t('DocsModule.docs', 'Документация'),
                'url'   => array('/docs/show/index', 'file' => 'index'),
                'icon'  => 'home white',
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'О Юпи!'),
                'icon'  => 'info-sign white',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Возможности'),
                        'url'   => array('/docs/show/index', 'file' => 'capability', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Помощь проекту'),
                        'url'   => array('/docs/show/index', 'file' => 'assistance.project', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Команда'),
                        'url'   => array('/docs/show/index', 'file' => 'team', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                ),
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'Разработчику'),
                'icon'  => 'th-large white',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Написание документации'),
                        'url'   => array('/docs/show/index', 'file' => 'doc.files'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Оптимальные настройки APC'),
                        'url'   => array('/docs/show/index', 'file' => 'apc.options', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'IDE/Редакторы'),
                        'icon'  => 'th-large white',
                        'items' => array(
                            array(
                                'label' => Yii::t('DocsModule.docs', 'Работа с eclipse'),
                                'url'   => array('/docs/show/index', 'file' => 'editors.eclipse'),
                                'icon'  => 'file',
                            ),
                        )
                    )
                )
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'Компоненты'),
                'icon'  => 'th-large white',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Генерация Feed-ленты'),
                        'url'   => array('/docs/show/index', 'file' => 'atomfeed', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Обертка над Curl'),
                        'url'   => array('/docs/show/index', 'file' => 'curl.wrapper', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Мигратор'),
                        'url'   => array('/docs/show/index', 'file' => 'migrator.index', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                        'items' =>array(
                             array(
                                'label' => Yii::t('DocsModule.docs', 'Описание методов'),
                                'url'   => array('/docs/show/index', 'file' => 'migrator.methods', 'moduleID' => 'yupe'),
                                'icon'  => 'file'
                             ),
                        ),
                    ),
                ),
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'Модули'),
                'icon'  => 'th-large white',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Блоги'),
                        'url'   => array('/docs/show/index', 'file' => 'index','moduleID' => 'blog' ),
                        'icon'  => 'file',
                    ),
                )
            ),
        );
    }

    /**
     * Меню для сайдбара
     *
     * @return array меню для сайдбара
     **/
    public function getLeftMenu()
    {
        return $this->getTopMenu();
    }


    /**
     * Получение меню статей:
     *
     * @param bool $topMenu - для верхнего меню (возможны вложения)
     *
     * @return array меню статей
     **/
    public function getArticles($topMenu = true)
    {
        return $topMenu === true
                ? $this->topMenu
                : $this->leftMenu;
    }

    /**
     * Метод отрисовки и кеширования документации:
     *
     * @param string $fileName - файл к отрисовке
     *
     * @return возвращаем отрисованный контент
     **/
    public function renderMarkdown($fileName = null)
    {
        /**
         * нет смысла обрабатывать несушествующий файл:
         */
        if ($fileName == null || !file_exists($fileName))
            return null;

        /**
         * Получаем контент из кеша, если файл не изменился и не пуст
         * или рендерим:
         */
        if (($content = Yii::app()->cache->get('docs_content_' . $fileName)) === false || empty($content)) {
            $md = new CMarkdown;
            $content = $md->transform(file_get_contents($fileName));

            Yii::app()->cache->set('docs_content_' . $fileName, $content, 0, new CFileCacheDependency($fileName));
        }

        return $content;
    }

    /**
     *  Получаем заголовок из контента:
     *
     * @param string &$content - если передан контент, обрабатываем его
     *
     * @return string title для страниц
     */
    public function getDocTitle(&$content = null)
    {
        /**
         * незачем обрабатывать пустой контент:
         */
        if ($content === null)
            return null;

        /**
         * Если в контенте будет найден тег <h1>
         * мы из него получим заголовок для страницы
         * или же попросту вернём пустой:
         */
        if (preg_match("/<h1[^>]*>(.*?)<\\/h1>/si", $content, $match))
            return $match[1];
        else
            return null;
    }

    /**
     * Получаем абсолютный путь к файлу:
     *
     * @param string $file - запрошенный файл
     *
     * @return string абсолютный путь к файлу
     **/
    public function absoluteFilePath($file = null, $moduleDocFolder = null)
    {
        /**
         * Незачем работать, если вместо файла передан null:
         */
        if ($file === null)
            return null;

        /**
         * Получаем список подходящих файлов,
         * в случае если их массив пуст - возвращаем
         * null
         */
        if ($moduleDocFolder !== null
            && (($matches = glob(Yii::getPathOfAlias($moduleDocFolder . '.' . Yii::app()->language) . DIRECTORY_SEPARATOR . $file . '*')) === false
            || count($matches) < 1)
        ) {
            unset($matches);
            unset($moduleDocFolder);
        }

        if (!isset($matches) && ($matches = glob(Yii::getPathOfAlias($this->docFolder . '.' . Yii::app()->language) . DIRECTORY_SEPARATOR . $file . '*')) === false
            || count($matches) < 1
        ){
            return null;
        }

        /**
         * Сортируем полученный массив так,
         * чтобы md-файлы были впереди, а
         * также доп.сортировка по длине:
         */
        usort(
            $matches, function ($a, $b) {
                return (strlen(pathinfo($a, PATHINFO_EXTENSION)) < strlen(pathinfo($b, PATHINFO_EXTENSION))
                        ? -1
                        : 1)
                    + (strlen(pathinfo($a, PATHINFO_BASENAME)) < strlen(pathinfo($b, PATHINFO_BASENAME))
                        ? -1
                        : 1);
            }
        );

        /**
         * Получаем имя файла с расширением:
         */
        $file = pathinfo($matches[0], PATHINFO_BASENAME);

        if (!empty($moduleDocFolder))
            $docFolder = $moduleDocFolder;
        else
            $docFolder = $this->docFolder;

        $path = Yii::getPathOfAlias($docFolder . '.' . Yii::app()->language) . DIRECTORY_SEPARATOR . $file;
        return !file_exists($path)
                  && $this->notFoundOn == 0
                    ? Yii::getPathOfAlias($docFolder . '.' . Yii::app()->sourceLanguage) . DIRECTORY_SEPARATOR . $file
                    : $path;
    }

    /**
     * Сайдбар для админ-контроллера
     *
     * @return array отрисованые файлы проекта
     **/
    public function renderProjectDocs()
    {
        $items = array();

        foreach (explode(',', $this->staticFiles) as $key) {

            if (($file = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $key) && !file_exists($file))
                continue;

            $content = $this->renderMarkdown($file);

            $title   = $this->getDocTitle($content);

            if ($title === null)
                $title = $key;

            array_push(
                $items, array(
                    'label' => $title,
                    'url'   => array('/docs/default/show', 'file' => $key),
                    'icon'  => 'file',
                )
            );
        }
        return $items;
    }
}