<?php
class ClientController extends FrontController
{
    public function filters()
    {
        return array(
            array('application.modules.user.filters.YXssFilter'),
            'AccessControl'
        );
    }

    public function filterAccessControl($filterChain)
    {
        if (!Yii::app()->user->isAuthorized()) {
            $this->redirect(Yii::app()->baseUrl . '/index.php/user/account/login');
        }

        $filterChain->run();
    }


    public function actionIndex()
    {
        $user = User::model()->with('profile')->findByPk(Yii::app()->user->getId());

        $this->render('index', array('user' => $user));
    }


    public function actionDelete()
    {
        $orderId = (int)Yii::app()->request->getQuery('id');

        if (!$orderId) {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

        $order = Order::model()->my()->find('id = :id AND status = :status', array(
            ':status' => Order::STATUS_NEW,
            ':id' => $orderId,
        ));

        if (is_null($order)) {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }

        // удалить заказ и все его фотки
        $order->deleteWithFotos();
    }

    public function actionDeleteFoto()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $fotoId = (int)Yii::app()->request->getParam('id');

            if (!$fotoId) {
                print json_encode(array('status' => 0, 'message' => 'Уппс! Произошла ошибка!'));
                exit;
            }

            $model = Foto::model()->with('order')->findByPk($fotoId);

            if (!$model || $model->order->userId != Yii::app()->user->getId() || $model->order->status != Order::STATUS_NEW) {
                print json_encode(array('status' => 0, 'message' => 'Уппс! Произошла ошибка!'));
                exit;
            }

            // удаление фотографии
            if ($model->deleteFotoFile()) {
                print json_encode(array('status' => 1, 'message' => 'Фотография удалена!'));
                exit;
            }

            print json_encode(array('status' => 0, 'message' => 'Уппс! Произошла ошибка!'));
            exit;

        }

        throw new CHttpException(404, 'Page not Found!!!');
    }


    public function actionAddOrder()
    {
        $model = new Order();

        $points = Point::model()->getPointsList();

        if (Yii::app()->request->isPostRequest && isset($_POST['Order'])) {
            $model->setAttributes($_POST['Order']);

            if ($model->save()) {
                Yii::app()->user->setFlash('notice', 'Ваш заказ сохранен! Пожалуйста, добавьте фотографии!');
                $this->redirect(array('/foto/client/addFoto', 'id' => $model->id));
            }
        }

        $user = User::model()->with('profile')->findByPk(Yii::app()->user->getId());

        $this->render('addOrder', array('model' => $model, 'points' => $points, 'user' => $user));
    }


    public function actionUpdate()
    {
        $id = (int)Yii::app()->request->getQuery('id');

        if (!$id) {
            throw new CHttpException(404, 'Запрашиваемая страница не найдена!');
        }

        $model = Order::model()->my()->findByPk($id);

        if (is_null($model) || $model->userId != Yii::app()->user->getId()) {
            throw new CHttpException(404, 'Запрашиваемая страница не найдена!');
        }

        if ($model->status != Order::STATUS_NEW) {
            Yii::app()->user->setFlash('notice', 'Данный заказ уже отправлен! Редактирование невозможно!');
            $this->redirect(array('/foto/client/view', 'id' => $model->id));
        }

        // найдем фото по этому заказу
        $fotos = Foto::model()->findAll('orderId = :orderId', array(':orderId' => $model->id));

        $points = Point::model()->getPointsList();

        $form = new Foto();

        $form->orderid = $model->id;

        // отправка заказа
        if (Yii::app()->request->isPostRequest && isset($_POST['sendOrder'])) {
            $orderId = (int)Yii::app()->request->getParam('orderIdSend');

            if (!$orderId) {
                Yii::app()->user->setFlash('error', 'При отправке заказа произошла ошибка!');
                Yii::log('Ошибка при отправке заказа...Нет orderId!', CLogger::LEVEL_ERROR);
                $this->redirect(array('/foto/client/orderList'));
            }

            $model = Order::model()->my()->with('fotos')->find('t.id = :id AND t.status = :status', array(
                ':id' => $orderId,
                ':status' => Order::STATUS_NEW
            ));

            if (!$model) {
                Yii::app()->user->setFlash('error', 'При отправке заказа произошла ошибка!');
                Yii::log("Ошибка при отправке заказа...Нет заказа с $orderId!", CLogger::LEVEL_ERROR);
                $this->redirect(array('/foto/client/orderList'));
            }

            if (!count($model->fotos)) {
                Yii::app()->user->setFlash('notice', 'Нельзя отправить заказ без фотографий!');
                Yii::log("Нельзя отправить заказ без фотографий! Заказ: $orderId!", CLogger::LEVEL_ERROR);
                $this->redirect(array('/foto/client/update', 'id' => $model->id));
            } else {
                $model->status = Order::STATUS_SENDED;
                $model->sendDate = new CDbExpression('NOW()');

                if ($model->save()) {
                    // отправить email менеджеру
                    $emailBody = $this->renderPartial('orderSendedEmail', array('order' => $model), true);
                    Yii::app()->mail->send(Yii::app()->getModule('feedback')->notifyEmailFrom, Yii::app()->getModule('feedback')->notifyEmailFrom, 'Отправлен новый заказ!', $emailBody);

                    Yii::app()->user->setFlash('notice', 'Ваш заказ отправлен на печать!<br>Благодарим Вас за пользование услугой "Online фотопечать"');
                    Yii::log("Заказ № {$model->id} отправлен на печать!", CLogger::LEVEL_INFO);
                    $this->redirect(array('/foto/client/view', 'id' => $model->id));
                } else {
                    Yii::app()->user->setFlash('error', 'При отправке заказа произошла ошибка!');
                    Yii::log("Ошибка при отправке заказа...!" . print_r($model->getErrors(), true), CLogger::LEVEL_ERROR);
                    $this->redirect(array('/foto/client/update', 'id' => $model->id));
                }
            }
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['Order'])) {
            if ($model->userId != Yii::app()->user->getId()) {
                throw new CHttpException(404, 'Запрашиваемая страница не найдена!');
            }

            $model->setAttributes($_POST['Order']);

            if ($model->save()) {
                Yii::app()->user->setFlash('notice', 'Данные заказа изменены!');
                $this->redirect(array('/foto/client/update', 'id' => $model->id));
            }
        }

        $user = User::model()->with('profile')->findByPk(Yii::app()->user->getId());

        $this->render('changeOrder', array('user' => $user, 'fotoModel' => null, 'fotoForm' => $form, 'fotos' => $fotos, 'model' => $model, 'points' => $points));
    }


    public function actionOrderList()
    {
        $model = new Order('search');
        $model->unsetAttributes();
        // отобразить только мои заказы
        $model->userId = (int)Yii::app()->user->getId();
        if (isset($_GET['Order']))
            $model->attributes = $_GET['Order'];
        $this->render('orderList', array('model' => $model));
    }


    public function actionView()
    {
        $id = (int)Yii::app()->request->getQuery('id');

        if (!$id) {
            throw new CHttpException(404, 'Запрашиваемая страница не найдена!');
        }

        $model = Order::model()->my()->with('fotos')->findByPk($id);

        if (is_null($model) || $model->userId != Yii::app()->user->getId()) {
            throw new CHttpException(404, 'Запрашиваемая страница не найдена!');
        }

        $this->render('view', array(
            'model' => $model,
            'fotos' => $model->fotos
        ));
    }


    public function actionShowImage()
    {
        $image = (int)Yii::app()->request->getQuery('image');

        if (!$image) {
            die('No Image!');
        }

        $model = Foto::model()->with('order')->find('t.id = :id', array(':id' => $image));

        // если пользователь не админ
        // только свои картинки отдаем
        if (!Yii::app()->user->isAdminUser()) {
            if ($model->order->userId != Yii::app()->user->getId()) {
                die('No Image!');
            }
        }

        $file = Yii::app()->controller->module->rootDir . $model->file;

        $preview = $model->generatePreviewFileName($file);

        // если нет превьюхи - сгенерим ее

        if (!file_exists($preview)) {
            $model->genaratePreview($file);
        }

        if ($model && file_exists($preview)) {
            header('Content-Type: image/jpeg');
            print readfile($preview);
            exit;
        }

        die('No image!');
    }


    public function actionAddFoto()
    {
        $orderId = (int)Yii::app()->request->getQuery('id');

        if (!$orderId) {
            Yii::log("Ошибка добавления фото orderId => $orderId", CLogger::LEVEL_ERROR);
            throw new CHttpException(404, 'Page not found!');
        }

        $order = Order::model()->my()->findByPk($orderId);

        if (is_null($order)) {
            Yii::log("Ошибка добавления фото orderId => $orderId user => " . Yii::app()->user->getId(), CLogger::LEVEL_ERROR);
            throw new CHttpException(404, 'Страница на найдена!');
        }


        // найдем фото по этому заказу
        $fotos = Foto::model()->findAll('orderId = :orderId', array(':orderId' => $order->id));

        $points = Point::model()->getPointsList();

        $form = new Foto();

        $form->orderid = $order->id;

        // если добавляем фотки к заказу
        if (Yii::app()->request->isPostRequest && isset($_POST['Foto'])) {
            $error = array();

            foreach (range(1, 3, 1) as $i) {
                if (isset($_POST['Foto'][$i]) && $_FILES['Foto']['size'][$i]['file'] > 0) {
                    $fotoModel = new Foto();
                    $fotoModel->setAttributes($_POST['Foto'][$i]);
                    $fotoModel->orderid = (int)$orderId;
                    $fotoModel->file = CUploadedFile::getInstance($fotoModel, "[$i]file");

                    // проверить на максимальное разрешение
                    $imageSize = getimagesize($fotoModel->file->getTempName());

                    if (($imageSize[1] > 5000 || $imageSize[0] > 5000)) {
                        $error[$fotoModel->file->getName()] = 'Разрешение файла должно быть от 1024х768 до 5000х5000';
                        continue;
                    }

                    if (($imageSize[0] < 768 || $imageSize[1] < 1024)) {
                        $error[$fotoModel->file->getName()] = 'Загружаемый файл имеет слишком низкое разрешение, что отрицательно отразится на качестве печати';
                        continue;
                    }

                    if ($fotoModel->validate() && $fotoModel->save()) {

                        // проверим наличие директории для заказа
                        $orderDir = Yii::app()->controller->module->rootDir . Yii::app()->controller->module->uploadDir . $order->generateFolderName();

                        if (!file_exists($orderDir) || !is_dir($orderDir)) {
                            if (!mkdir($orderDir)) {
                                Yii::log('Ошибка создания директории для заказа ' . $orderDir, CLogger::LEVEL_ERROR);
                                Yii::app()->user->setFlash('error', 'При добавлении заказа произошла ошибка! Му уже вкурсе и работаем над этим!');
                                $this->redirect(array('/foto/client/update', 'id' => $fotoModel->sorderid));
                            }
                        }
                        $ext = substr($fotoModel->file->getName(), -3);
                        $generatedFileName = $fotoModel->generateFileName();
                        $fileWebPath = Yii::app()->controller->module->uploadDir . $order->generateFolderName() . DIRECTORY_SEPARATOR . $generatedFileName . ".$ext";
                        // тут генерируется имя файла в зависимости от параметров заказа
                        $fileName = $orderDir . DIRECTORY_SEPARATOR . $generatedFileName . ".$ext";

                        if (!$fotoModel->file->saveAs($fileName)) {
                            Yii::log('Ошибка сохранения файла фотографии ' . $generatedFileName, CLogger::LEVEL_ERROR);
                            Yii::app()->user->setFlash('error', 'При добавлении заказа произошла ошибка! Му уже вкурсе и работаем над этим!');
                            $this->redirect(array('/foto/client/update', 'id' => $fotoModel->sorderid));
                        } else {
                            // переписать имя файла
                            // сгенерировать превью
                            $fotoModel->genaratePreview($fileName);
                            $fotoModel->file = $fileWebPath;
                            $fotoModel->update(array('file'));
                        }
                    } else {
                        Yii::log('Ошибка добавления фото!' . print_r($fotoModel->getErrors(), true), CLogger::LEVEL_ERROR);
                        Yii::app()->user->setFlash('error', 'При добавлении заказа произошла ошибка! Му уже вкурсе и работаем над этим!');
                        $this->render('addFoto', array('fotoModel' => $fotoModel, 'fotoForm' => $form, 'fotos' => $fotos, 'model' => $order, 'points' => $points));
                        return false;
                    }

                    continue;
                } else {
                    continue;
                }

                Yii::app()->user->setFlash('notice', 'Фотографии успешно добавлены к заказу!');
                $this->redirect(array('/foto/client/addFoto', 'id' => $order->id));
            }

            $notify = '';

            if (count($error) > 0) {
                $notify .= CHtml::image(Yii::app()->baseUrl . '/images/cancel.png', 'Ошибка!') . '<br>';

                foreach ($error as $k => $v) {
                    $notify .= "При загрузке файла '$k' произошла ошибка: $v <br>";
                }

                $notify = $notify ? $notify . '<br>Пожалуйста, загружайте файлы следующих разрешений:<br>Минимальное: 1024x786<br>Максимальное: 5000х5000' : 'Фотографий не обнаружено!';

                Yii::app()->user->setFlash('error', $notify);

                $this->redirect(array('/foto/client/addFoto', 'id' => $order->id));
            }

            Yii::app()->user->setFlash('notice', 'Фотографии добавлены к заказу!');

            $this->redirect(array('/foto/client/addFoto', 'id' => $order->id));
        }


        $this->render('addFoto', array(
            'model' => $order,
            'fotos' => $fotos,
            'fotoForm' => new Foto(),
            'fotoModel' => null
        ));
    }


    public function actionAddFotoMass()
    {
        $orderId = (int)Yii::app()->request->getPost('id');

        if (!$orderId) {
            Yii::log("Ошибка добавления фото orderId => $orderId", CLogger::LEVEL_ERROR);
            throw new CHttpException(404, 'Page not found!');
        }

        $order = Order::model()->findByPk($orderId);

        if (!$order) {
            Yii::log("Ошибка добавления фото orderId => $orderId", CLogger::LEVEL_ERROR);
            throw new CHttpException(404, 'Page not found!');
        }


        // если добавляем фотки к заказу
        if (Yii::app()->request->isPostRequest && !empty($_FILES['Foto'])) {

            $error = array();

            if ($_FILES['Foto']['size']['file'] > 0) {
                $fotoModel = new Foto;
                $fotoModel->orderid = (int)$orderId;
                $fotoModel->file = CUploadedFile::getInstance($fotoModel, "file");
                // проверить на максимальное разрешение
                $imageSize = getimagesize($fotoModel->file->getTempName());

                if (($imageSize[1] > 5000 || $imageSize[0] > 5000)) {
                    $error[] = 'Разрешение файла должно быть от 1024х768 до 5000х5000';
                }

                if (($imageSize[0] < 768 || $imageSize[1] < 1024)) {
                    $error[] = 'Загружаемый файл имеет слишком низкое разрешение, что отрицательно отразится на качестве печати';
                }

                if (empty($error) && $fotoModel->validate() && $fotoModel->save()) {
                    // проверим наличие директории для заказа
                    $orderDir = Yii::app()->controller->module->rootDir . Yii::app()->controller->module->uploadDir . $order->generateFolderName();
                    if (!file_exists($orderDir) || !is_dir($orderDir)) {
                        if (!mkdir($orderDir)) {
                            Yii::log('Ошибка создания директории для заказа ' . $orderDir, CLogger::LEVEL_ERROR);
                            Yii::app()->user->setFlash('error', 'При добавлении заказа произошла ошибка! Му уже вкурсе и работаем над этим!');
                            $error[] = 'При добавлении заказа произошла ошибка! Му уже вкурсе и работаем над этим!';
                        }
                    }

                    $ext = substr($fotoModel->file->getName(), -3);
                    $generatedFileName = $fotoModel->generateFileName();
                    $fileWebPath = Yii::app()->controller->module->uploadDir . $order->generateFolderName() . DIRECTORY_SEPARATOR . $generatedFileName . ".$ext";
                    // тут генерируется имя файла в зависимости от параметров заказа
                    $fileName = $orderDir . DIRECTORY_SEPARATOR . $generatedFileName . ".$ext";

                    if (!$fotoModel->file->saveAs($fileName)) {
                        Yii::log('Ошибка сохранения файла фотографии ' . $generatedFileName, CLogger::LEVEL_ERROR);
                        Yii::app()->user->setFlash('error', 'При добавлении заказа произошла ошибка! Му уже вкурсе и работаем над этим!');
                        $error[] = 'При добавлении заказа произошла ошибка! Му уже вкурсе и работаем над этим!';
                    } else {
                        // переписать имя файла
                        // сгенерировать превью
                        $fotoModel->genaratePreview($fileName);
                        $fotoModel->file = $fileWebPath;
                        $fotoModel->update(array('file'));
                    }
                } else {
                    $error[] = implode(', ', $fotoModel->getErrors());
                }
            }

            $data = array();

            if (!empty($error)) {
                $data['files'] = array('error' => implode(', ',$error));
            } else {
                $data['files'] = array(
                   array(
                        'name' => $_FILES['Foto']['type']['name'],
                        'type' => $_FILES['Foto']['type']['file'],
                        'size' => $_FILES['Foto']['size']['file'],
                        'url'           => Yii::app()->baseUrl.'/index.php/foto/client/showImage/image/'.$fotoModel->id,
                        'thumbnail_url' => Yii::app()->baseUrl.'/index.php/foto/client/showImage/image/'.$fotoModel->id,
                   )
                );
            }

            echo json_encode($data);

            Yii::app()->end();
        }
    }


    public function actionProfile()
    {

        $userId = (int)Yii::app()->user->getId();

        if (!$userId) {
            throw new CHttpException(500, 'Ошибка приложения!');
        }

        $form = new ProfileForm();

        $user = User::model()->with('profile')->findByPk($userId);

        $form->phone = substr($user->profile->phone, -7);

        $form->prefix = substr($user->profile->phone, 0, 3);

        if (Yii::app()->request->isPostRequest && isset($_POST['ProfileForm'])) {
            $form->setAttributes($_POST['ProfileForm']);

            if ($form->validate()) {
                if (!$user->profile) {
                    $user->profile = new Profile;

                    $user->profile->userId = $user->id;

                    $user->profile->save();
                }

                $user->profile->setAttributes(array(
                    'phone' => $form->prefix . $form->phone
                ));

                if ($user->profile->save()) {
                    Yii::app()->user->setFlash('notice', 'Ваш профиль обновлен!');
                    $this->redirect(array('/foto/client/profile'));
                }
            }

        }

        $this->render('profile', array('model' => $form));
    }
}