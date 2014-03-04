<?php
/**
 * DocsModule основной класс модуля docs
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.docs
 * @since 0.1
 *
 */
class DocsModule extends yupe\components\WebModule
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
    public $staticFiles = 'README.md,README_EN.md,LICENSE,UPGRADE.md,CHANGELOG.md,TEAM.md,install.md';

    /**
     * Категория модуля:
     * 
     * @return string category
     */
    public function getCategory()
    {
        return Yii::t('DocsModule.docs', 'Yupe!');
    }

    /**
     * Лейблы для редактируемых параметров:
     * 
     * @return array edit params labels
     */
    public function getParamsLabels()
    {
        return array(
            'docFolder'       => Yii::t('DocsModule.docs', 'Docs files destination'),
            'moduleDocFolder' => Yii::t('DocsModule.docs', 'Modules docs files destination ({module} replaced by module title)'),
            'notFoundOn'      => Yii::t('DocsModule.docs', 'Show error page if doc file in current language was not found?'),
            'fileExtMD'       => Yii::t('DocsModule.docs', 'Extensions for MarkDown files'),
            'fileExtHTML'     => Yii::t('DocsModule.docs', 'Extensions for HTML files'),
            'cachePages'      => Yii::t('DocsModule.docs', 'Pages caching on filtration level'),
            'staticFiles'     => Yii::t('DocsModule.docs', 'Files need display in control panel'),
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
                Yii::t('DocsModule.docs', 'Disable'),
                Yii::t('DocsModule.docs', 'Enable'),
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
                'label' => Yii::t('DocsModule.docs', 'General module settings'),
            ),
            'files' => array(
                'label' => Yii::t('DocsModule.docs', 'Files settings'),
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
            0 => Yii::t('DocsModule.docs', 'Show page for language by default'),
            1  => Yii::t('DocsModule.docs', 'Show error'),
        );
    }

    /**
     * Название модуля:
     * 
     * @return string module name
     */
    public function getName()
    {
        return Yii::t('DocsModule.docs', 'Documentation');
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('DocsModule.docs', 'Show local files'), 'url' => array('/docs/docsBackend/index')),
            array('icon' => 'list-alt', 'label' => Yii::t('DocsModule.docs', 'Local docs'), 'url' => array('/docs/show/index')),
            array('icon' => 'icon-globe', 'label' => Yii::t('DocsModule.docs', 'Online docs'), 'url' => 'http://yupe.ru/docs/index.html?from=help','linkOptions' => array('target' => '_blank')),
        );
    }

    /**
     * Описание модуля:
     * 
     * @return string module description
     */
    public function getDescription()
    {
        return Yii::t('DocsModule.docs', 'Module for view and edit docs files (HTML and Markdown)');
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
        return Yii::t('DocsModule.docs', '0.6');
    }

    /**
     * Получаем список файлов из каталога документации:
     *
     * @param string $curDocFolder - путь к каталогу документации текущего языка
     *
     * @return array список файлов каталога
     **/
    public function fileList($curDocFolder = null)
    {
        if ($curDocFolder === null) {
            return null;
        }

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
            
            foreach (glob($curDocFolder, GLOB_ONLYDIR) as $item) {
                $chain->dependencies->add(new CDirectoryCacheDependency($item));
            }

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
                'label' => Yii::t('DocsModule.docs', 'Documentation'),
                'url'   => array('/docs/show/index', 'file' => 'index'),
                'icon'  => 'home',
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'About Yupe!'),
                'icon'  => 'info-sign',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Install'),
                        'url'   => array('/docs/show/index', 'file' => 'install', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Abilities'),
                        'url'   => array('/docs/show/index', 'file' => 'capability', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Help project'),
                        'url'   => array('/docs/show/index', 'file' => 'assistance.project', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Team'),
                        'url'   => array('/docs/show/index', 'file' => 'team', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                ),
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'For developers'),
                'icon'  => 'th-large',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs','Creating module'),
                        'url'   => array('/docs/show/index', 'file' => 'module.create'),
                        'icon'  => 'file'
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Set testing environment'),
                        'url'   => array('/docs/show/index', 'file' => 'testing'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Writing docs'),
                        'url'   => array('/docs/show/index', 'file' => 'doc.files'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Problems of CWebUser and Gii module'),
                        'url'   => array('/docs/show/index', 'file' => 'cwebuser.issues'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Optimal APC settings'),
                        'url'   => array('/docs/show/index', 'file' => 'apc.options', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Memcached configuration'),
                        'url'   => array('/docs/show/index', 'file' => 'memcached'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Using userspace settings'),
                        'url'   => array('/docs/show/index', 'file' => 'userspace.config', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'ConfigManager component'),
                        'url'   => array('/docs/show/index', 'file' => 'config.manager', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'IDE/Editors'),
                        'icon'  => 'th-large',
                        'items' => array(
                            array(
                                'label' => Yii::t('DocsModule.docs', 'Working in eclipse'),
                                'url'   => array('/docs/show/index', 'file' => 'editors.eclipse'),
                                'icon'  => 'file',
                            ),
                        )
                    )
                )
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'Components'),
                'icon'  => 'th-large',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs', 'RSS feed generation'),
                        'url'   => array('/docs/show/index', 'file' => 'atomfeed', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                    ),                 
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Migrator'),
                        'url'   => array('/docs/show/index', 'file' => 'migrator.index', 'moduleID' => 'yupe'),
                        'icon'  => 'file',
                        'items' =>array(
                             array(
                                'label' => Yii::t('DocsModule.docs', 'Methods description'),
                                'url'   => array('/docs/show/index', 'file' => 'migrator.methods', 'moduleID' => 'yupe'),
                                'icon'  => 'file'
                             ),
                        ),
                    ),
                ),
            ),
            array(
                'label' => Yii::t('DocsModule.docs', 'Modules'),
                'icon'  => 'th-large',
                'items' => array(
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Blogs'),
                        'url'   => array('/docs/show/index', 'file' => 'index','moduleID' => 'blog' ),
                        'icon'  => 'file',
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'Comment'),
                        'url'   => array('/docs/show/index', 'file' => 'index','moduleID' => 'comment' ),
                        'icon'  => 'file',
                        'items' => array(
                            array(
                                'label' => Yii::t('DocsModule.docs', 'NestedSets'),
                                'url' =>  array('/docs/show/index', 'file' => 'nsmigrate','moduleID' => 'comment' )
                            )
                        )
                    ),
                    array(
                        'label' => Yii::t('DocsModule.docs', 'ZendSearch'),
                        'url'   => array('/docs/show/index', 'file' => 'index','moduleID' => 'zendsearch' ),
                        'icon'  => 'search',
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
                ? $this->getTopMenu()
                : $this->getLeftMenu();
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
        if ($fileName == null || !file_exists($fileName)) {
            return null;
        }

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
        if ($content === null) {
            return null;
        }

        /**
         * Если в контенте будет найден тег <h1>
         * мы из него получим заголовок для страницы
         * или же попросту вернём пустой:
         */
        if (preg_match("/<h1[^>]*>(.*?)<\\/h1>/si", $content, $match)) {
            return $match[1];
        }
        else {
            return null;
        }
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
        if ($file === null) {
            return null;
        }

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

        if (!empty($moduleDocFolder)) {
            $docFolder = $moduleDocFolder;
        }
        else {
            $docFolder = $this->docFolder;
        }

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

            if (($file = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $key) && !file_exists($file))
                continue;

            $content = $this->renderMarkdown($file);

            $title   = $this->getDocTitle($content);

            if ($title === null) {
                $title = $key;
            }

            array_push(
                $items, array(
                    'label' => $title,
                    'url'   => array('/docs/docsBackend/show', 'file' => $key),
                    'icon'  => 'file',
                )
            );
        }
        return $items;
    }

    public function getAdminPageLink()
    {
        return '/docs/docsBackend/index';
    }
}