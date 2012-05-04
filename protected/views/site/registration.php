<?php
    $this->breadcrumbs = array(
        'Регистрация',
    );
?>

<h1>Регистрация нового пользователя</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>