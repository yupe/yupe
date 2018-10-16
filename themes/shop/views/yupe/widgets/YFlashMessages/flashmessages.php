<?php foreach(Yii::app()->user->getFlashes() as $type => $message): ?>
    <div class="alert alert-<?= $type ?>"><?= $message ?></div>
<?php endforeach; ?>