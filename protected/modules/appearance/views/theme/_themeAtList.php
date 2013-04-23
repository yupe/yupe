<?php
/** @var $data YTheme */
?>
<div class="media">
    <div class="pull-left">
        <?php if (null == $data->getScreenshot()): ?>
            <img src="<?php echo Yii::app()->baseUrl . '/web/images/main-logo.png'; ?>" class="img-polaroid">
        <?php else : ?>
            <img src="<?php echo $data->resource($data->getScreenshot()); ?>" width="250" class="img-polaroid">
        <?php endif; ?>
    </div>

    <div class="media-body">
        <h4 class="media-heading">
            <?php echo CHtml::encode($data->getTitle());?>
            <span class="label label-info"
                  title="<?php echo Yii::t('AppearanceModule.messages', 'Версия темы'); ?>">
                <?php echo CHtml::encode($data->getVersion());?>
            </span>
            <?php if ($data->getParentTheme()) : ?>
                <small title="<?php echo Yii::t('AppearanceModule.messages', 'Родительская тема'); ?>">&larr;
                    <?php echo CHtml::encode($data->getParentTheme()->getTitle());?>
                </small>
            <?php endif; ?>
        </h4>

        <div>
            <?php if ($data->getIsBackend()) : ?>
                <span class="label"><?php echo Yii::t('AppearanceModule.messages', 'Для панели управления');?></span>
            <?php else : ?>
                <span class="label label-info"><?php echo Yii::t(
                        'AppearanceModule.messages',
                        'Для клиентской части'
                    );?>
                </span>
            <?php endif; ?>
            <?php if ($data->getIsEnabled()) : ?>
                <span class="label label-success"><?php echo  Yii::t('AppearanceModule.messages', 'Включена'); ?></span>
            <?php else : ?>
                <span class="label"><?php echo Yii::t('AppearanceModule.messages', 'Выключена');?></span>
            <?php endif; ?>
        </div>
        <div>
            <?php echo Yii::t('AppearanceModule.messages', 'Автор');?>: <?php echo CHtml::encode($data->getAuthors());?>
        </div>
        <p><?php echo CHtml::decode($data->getDescription());?></p>

        <div class="theme-actions">
            <?php if (!$data->getIsEnabled()) : ?>
                <a class="btn btn-small btn-success toggleTheme" data-theme-id="<?php echo  $data->getName(); ?>">
                    <?php echo Yii::t('AppearanceModule.messages', 'Включить');?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
