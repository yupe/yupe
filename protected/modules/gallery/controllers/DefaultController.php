<?php

class DefaultController extends YBackController
{
    /**
     * Отображает галерею по указанному идентификатору
     * @param integer $id Идинтификатор галерею для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель галереи.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Gallery;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Gallery']))
        {
            $model->attributes = $_POST['Gallery'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('GalleryModule.gallery', 'Запись добавлена!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование галереи.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Gallery']))
        {
            $model->attributes = $_POST['Gallery'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('GalleryModule.gallery', 'Запись обновлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаяет модель галереи из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор галереи, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('GalleryModule.gallery', 'Запись удалена!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('GalleryModule.gallery', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
     * Управление галереями.
     */
    public function actionIndex()
    {
        $model = new Gallery('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Gallery']))
            $model->attributes = $_GET['Gallery'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Отображение изображений галереи:
     *
     * @param int $id - id-галереи
     *
     * @return void
     **/
    public function actionImages($id)
    {
        if (($gallery = Gallery::model()->findByPk($id)) === null)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $image = new Image;

        if (Yii::app()->request->isPostRequest && ($imageData = Yii::app()->request->getPost('Image')) !== null) {
            $this->_addImage($image, $imageData, $gallery);
        }

        $this->render(
            'images', array(
                'image'        => $image,
                'model'        => $gallery,
                'tab'          => !($errors = $image->getErrors()) ? '_images_show' : '_image_add'
            )
        );
    }

    /**
     * Метод добавления одной фотографии:
     *
     * @param Image   $image     - инстанс изображения
     * @param mixed   $imageData - POST-массив данных
     * @param Gallery $gallery   - инстанс галереи
     *
     * @return void
     **/
    private function _addImage(Image $image, array $imageData, Gallery $gallery)
    {
        try {
            $transaction = Yii::app()->db->beginTransaction();
            $image->setAttributes($imageData);

            if ($image->save() && $gallery->addImage($image)) {
                
                $transaction->commit();

                if (Yii::app()->request->getPost('ajax') === null) {
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('GalleryModule.gallery', 'Фотография добавлена!')
                    );
                    $this->redirect(array('/gallery/default/images', 'id' => $gallery->id));
                }
            }
        } catch (Exception $e) {
            
            $transaction->rollback();
            
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }
    }

    /**
     * Ajax/Get-обёртка для удаления изображения:
     *
     * @param int    $id     - id-изображения
     * @param string $method - тип с помощью чего удаляем
     *
     * @return void
     **/
    public function actionDeleteImage($id = null, $method = null)
    {
        if (($image = Image::model()->findByPk($id)) === null || $image->canChange() === false)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $message = Yii::t(
            'GalleryModule.gallery', 'Изображение #{id} {result} удалено!', array(
                '{id}' => $id,
                '{result}' => ($result = $image->delete())
                    ? Yii::t('GalleryModule.gallery', 'успешно')
                    : Yii::t('GalleryModule.gallery', 'не')
            )
        );

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $result === true
                ? Yii::app()->ajax->success($message)
                : Yii::app()->ajax->failure($message);
        }

        Yii::app()->user->setFlash(
            $result ? YFlashMessages::NOTICE_MESSAGE : YFlashMessages::ERROR_MESSAGE,
            $message
        );

        $this->redirect(
            Yii::app()->request->urlReferer(
                $this->createAbsoluteUrl('gallery/default/images')
            )
        );
    }

    /**
     * Функция добавления группы изображений
     *
     * @param int $id - id-галереи
     *
     * @return void
     **/
    public function actionAddimages($id)
    {
        if (($gallery = Gallery::model()->findByPk($id)) === null)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $image = new Image;

        if (Yii::app()->request->isPostRequest && ($imageData = Yii::app()->request->getPost('Image')) !== null) {
            $imageData = $imageData[$_FILES['Image']['name']['file']];
            $this->_addImage($image, $imageData, $gallery);
            if ($image->hasErrors())
                $data[] = array('error' => $image->getErrors());
            else
                $data[] = array(
                    'name'          => $image->name,
                    'type'          => $_FILES['Image']['type']['file'],
                    'size'          => $_FILES['Image']['size']['file'],
                    'url'           => $image->getUrl(),
                    'thumbnail_url' => $image->getUrl(80),
                    'delete_url'    => $this->createUrl(
                        '/gallery/default/deleteImage', array(
                            'id' => $image->id,
                            'method' => 'uploader'
                        )
                    ),
                    'delete_type' => 'GET'
                );
            echo json_encode($data);
            die();
        } else
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));
    }

    /**
     * Для перезагрузки контента:
     *
     * @param int    $id   - id-галереи
     * @param string $view - необходимая вьюшка
     *
     * @return void
     **/
    public function actionReloadContent($id = null, $view = null)
    {
        if (($gallery = Gallery::model()->findByPk($id)) === null)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $this->renderPartial(
            $view, array(
                'model'        => $gallery,
            )
        );
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = Gallery::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Запрошенная страница не найдена.'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gallery-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}