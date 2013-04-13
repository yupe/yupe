<?php
/**
 * Class ThemeController
 *
 * @author Alexander Bolshakov <a.bolshakov.coder@gmail.com>
 */
class ThemeController extends YBackController
{
    public function filters()
    {
        return array_merge(
            parent::filters(),
            array(
                'ajaxOnly + toggle'
            )
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * List all available themes.
     */
    public function actionList()
    {
        $themes     = array();
        $themeNames = $this->getThemeManager()->getThemeNames();
        foreach ($themeNames as $themeName) {
            $themes[] = $this->getThemeManager()->getTheme($themeName);
        }
        $themes = new CArrayDataProvider($themes, array('sort' => false, 'keyField' => 'name', 'pagination' => false));

        if (Yii::app()->getRequest()->isAjaxRequest) {
            $this->renderPartial('list', compact('themes'));
        } else {
            $this->render('list', compact('themes'));
        }
    }

    /**
     * Applying theme based on its name.
     *
     * @postParam $themeID Theme's name.
     *
     * @throws CHttpException If applying wasn't successful.
     *
     * @see AppearanceModule::toggleTheme()
     */
    public function actionToggle()
    {
        $themeID = Yii::app()->getRequest()->getPost('themeID', null);
        $theme   = $this->loadTheme($themeID);
        $saved   = AppearanceModule::get()->toggleTheme($theme);
        if (!$saved) {
            throw new CHttpException(500, 'Не удалось применить тему');
        } else {
            // @todo try to find better solution
            Yii::app()->cache->flush();
        }
    }


    public function actionInstall()
    {
        $this->render('install');
    }

    /**
     * Shortcut method
     *
     * @return CThemeManager
     */
    public function getThemeManager()
    {
        return Yii::app()->themeManager;
    }


    /**
     * @param string $themeID The name of theme
     *
     * @return YTheme
     * @throws CHttpException
     */
    protected function loadTheme($themeID)
    {
        $theme = $this->getThemeManager()->getTheme($themeID);
        if ($theme instanceof YTheme) {
            return $theme;
        } else {
            throw new CHttpException(404, 'Указанная тема оформления не существует.');
        }
    }
}