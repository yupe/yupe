<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 *
 * @category YupeGiiTemplate
 * @package  yupe
 * @author   Yupe Team <support@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 */
?>
<?=  "<?php\n"; ?>
/**
* Класс <?=  $this->controllerClass; ?>:
*
*   @category Yupe<?=  $this->baseControllerClass . "\n"; ?>
*   @package  yupe
*   @author   Yupe Team <support@yupe.ru>
*   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
*   @link     https://yupe.ru
**/
class <?=  $this->controllerClass; ?> extends <?=  $this->baseControllerClass . "\n"; ?>
{
    /**
    * Отображает <?=  $this->vin; ?> по указанному идентификатору
    *
    * @param integer $id Идинтификатор <?=  $this->vin; ?> для отображения
    *
    * @return void
    */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }
    
    /**
    * Создает новую модель <?=  $this->rod; ?>.
    * Если создание прошло успешно - перенаправляет на просмотр.
    *
    * @return void
    */
    public function actionCreate()
    {
        $model = new <?=  $this->modelClass; ?>;

        if (Yii::app()->getRequest()->getPost('<?=  $this->modelClass; ?>') !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('<?=  $this->modelClass; ?>'));
        
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('<?=  $this->getModuleTranslate(); ?>', 'Запись добавлена!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model-><?=  $this->tableSchema->primaryKey."\n"; ?>
                        ]
                    )
                );
            }
        }
        $this->render('create', ['model' => $model]);
    }
    
    /**
    * Редактирование <?=  $this->rod; ?>.
    *
    * @param integer $id Идинтификатор <?=  $this->vin; ?> для редактирования
    *
    * @return void
    */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->getRequest()->getPost('<?=  $this->modelClass; ?>') !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('<?=  $this->modelClass; ?>'));

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('<?=  $this->getModuleTranslate(); ?>', 'Запись обновлена!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model-><?=  $this->tableSchema->primaryKey."\n"; ?>
                        ]
                    )
                );
            }
        }
        $this->render('update', ['model' => $model]);
    }
    
    /**
    * Удаляет модель <?=  $this->rod; ?> из базы.
    * Если удаление прошло успешно - возвращется в index
    *
    * @param integer $id идентификатор <?=  $this->rod; ?>, который нужно удалить
    *
    * @return void
    */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('<?=  $this->getModuleTranslate(); ?>', 'Запись удалена!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(Yii::app()->getRequest()->getPost('returnUrl', ['index']));
            }
        } else
            throw new CHttpException(400, Yii::t('<?=  $this->getModuleTranslate(); ?>', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }
    
    /**
    * Управление <?=  $this->mtvor; ?>.
    *
    * @return void
    */
    public function actionIndex()
    {
        $model = new <?=  $this->modelClass; ?>('search');
        $model->unsetAttributes(); // clear any default values
        if (Yii::app()->getRequest()->getParam('<?=  $this->modelClass; ?>') !== null)
            $model->setAttributes(Yii::app()->getRequest()->getParam('<?=  $this->modelClass; ?>'));
        $this->render('index', ['model' => $model]);
    }
    
    /**
    * Возвращает модель по указанному идентификатору
    * Если модель не будет найдена - возникнет HTTP-исключение.
    *
    * @param integer идентификатор нужной модели
    *
    * @return void
    */
    public function loadModel($id)
    {
        $model = <?=  $this->modelClass; ?>::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('<?=  $this->getModuleTranslate(); ?>', 'Запрошенная страница не найдена.'));

        return $model;
    }
}
