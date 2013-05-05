<?php
/**
 * YiiDebugToolbarPanelServer class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanelServer represents an ...
 *
 * Description of YiiDebugToolbarPanelServer
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugToolbarPanelServer extends YiiDebugToolbarPanel
{
    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        return YiiDebug::t('Server');
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSubTitle()
    {
        return YiiDebug::t('Yii {n}', array(Yii::getVersion()));
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return YiiDebug::t('Server Info');
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->render('server');
    }

    /**
     * Get content of PHPInfo.
     *
     * @return string
     */
    public function getPhpInfoContent()
    {
        ob_start();
        phpinfo(INFO_MODULES);
        $info = ob_get_clean();

        preg_match('/<body>(.*?)<\/body>/msS', $info, $matches);

        if (isset($matches[1]))
        {
            $content = preg_replace('/\s?class\="\w+"/', '', $matches[1]);
            $content = str_replace(' border="0" cellpadding="3" width="600"', ' class="phpinfo"', $content);
            $content = explode("\n", $content);
            $counter = 0;
            foreach($content as &$row)
            {
                if (0 === strpos($row, '<tr>'))
                {
                    $replace = '<tr class="'.($counter % 2 ? 'even' : 'odd') . '">';
                    $row = str_replace('<tr>', $replace, $row);
                    $counter++;
                }
                else
                {
                    $counter = 0;
                }
            }
            return implode("\n", $content);
        }

        return;
    }

}
