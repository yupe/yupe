<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 *
 * @category YupeGiiTemplate
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 */
?>
<?php echo "<?php\n"; ?>
/**
* Класс <?php echo $this->controllerClass; ?>:
*
*   @category Yupe<?php echo $this->baseControllerClass . "\n"; ?>
*   @package  yupe
*   @author   Yupe Team <team@yupe.ru>
*   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
*   @link     http://yupe.ru
**/
class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass . "\n"; ?>
{
    /**
    * Отображает <?php echo $this->vin; ?> по указанному идентификатору
    *
    * @param integer $id Идинтификатор <?php echo $this->vin; ?> для отображения
    *
    * @return void
    */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }
    
    /**
    * Создает новую модель <?php echo $this->rod; ?>.
    * Если создание прошло успешно - перенаправляет на просмотр.
    *
    * @return void
    */
    public function actionCreate()
    {
        $model = new <?php echo $this->modelClass; ?>;

        if (Yii::app()->getRequest()->getPost('<?php echo $this->modelClass; ?>') !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('<?php echo $this->modelClass; ?>'));
        
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('<?php echo $this->getModuleTranslate(); ?>', 'Запись добавлена!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model-><?php echo $this->tableSchema->primaryKey."\n"; ?>
                        ]
                    )
                );
            }
        }
        $this->render('create', ['model' => $model]);
    }
    
    /**
    * Редактирование <?php echo $this->rod; ?>.
    *
    * @param integer $id Идинтификатор <?php echo $this->vin; ?> для редактирования
    *
    * @return void
    */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->getRequest()->getPost('<?php echo $this->modelClass; ?>') !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('<?php echo $this->modelClass; ?>'));

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('<?php echo $this->getModuleTranslate(); ?>', 'Запись обновлена!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model-><?php echo $this->tableSchema->primaryKey."\n"; ?>
                        ]
                    )
                );
            }
        }
        $this->render('update', ['model' => $model]);
    }
    
    /**
    * Удаляет модель <?php echo $this->rod; ?> из базы.
    * Если удаление прошло успешно - возвращется в index
    *
    * @param integer $id идентификатор <?php echo $this->rod; ?>, который нужно удалить
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
                Yii::t('<?php echo $this->getModuleTranslate(); ?>', 'Запись удалена!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(Yii::app()->getRequest()->getPost('returnUrl', ['index']));
            }
        } else
            throw new CHttpException(400, Yii::t('<?php echo $this->getModuleTranslate(); ?>', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }
    
    /**
    * Управление <?php echo $this->mtvor; ?>.
    *
    * @return void
    */
    public function actionIndex()
    {
        $model = new <?php echo $this->modelClass; ?>('search');
        $model->unsetAttributes(); // clear any default values
        if (Yii::app()->getRequest()->getParam('<?php echo $this->modelClass; ?>') !== null)
            $model->setAttributes(Yii::app()->getRequest()->getParam('<?php echo $this->modelClass; ?>'));
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
        $model = <?php echo $this->modelClass; ?>::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('<?php echo $this->getModuleTranslate(); ?>', 'Запрошенная страница не найдена.'));

        return $model;
    }
}
