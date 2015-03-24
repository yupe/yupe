<?php
/**
 * Class ActiveForm. Extend yii-booster TbActiveForm
 *
 * @since 0.9.4
 */

namespace yupe\widgets;

use Yii;
use TbActiveForm;
use CHtml;

Yii::import('bootstrap.widgets.TbActiveForm', true);

class ActiveForm extends TbActiveForm
{
    /**
     * Output slug field.
     *
     * Set up $options['sourceModel'] and $options['sourceAttribute'] or just $options['sourceName'] with field name which is the source of slug field
     *
     * @since 0.9.4
     *
     * @throws \CException
     *
     * @param \CModel $model The data model.
     * @param string $attribute The attribute.
     * @param array $options
     * @return string
     */
    public function slugFieldGroup($model, $attribute, $options = array())
    {
        $this->initOptions($options);

        if (!isset($options['sourceModel'])) {
            $options['sourceModel'] = $model;
        }

        if (!isset($options['sourceName']) && !isset($options['sourceModel'], $options['sourceAttribute'])) {
            throw new \CException('Set up source field params for slug field!');
        }

        $sourceID = isset($options['sourceName']) ? CHtml::getIdByName($options['sourceName']) : CHtml::getIdByName(CHtml::resolveName($options['sourceModel'], $options['sourceAttribute']));
        $targetID = CHtml::getIdByName(CHtml::resolveName($model, $attribute));

        $updateUrl = Yii::app()->createUrl('/yupe/backend/transliterate');

        $JS = <<<JS

        $(function () {
            var timer,
                sourceField = $('#{$sourceID}'),
                targetField = $('#{$targetID}'),
                updateUrl = "{$updateUrl}",
                editable = targetField.val().length == 0,
                value = sourceField.val();

            if (targetField.val().length !== 0) {
                $.get(updateUrl, {data: sourceField.val()}, function (r) {
                    editable = targetField.val() == r;
                });
            }

            sourceField.on('keyup blur copy paste cut start', function () {
                clearTimeout(timer);

                if (editable && value != sourceField.val()) {
                    timer = setTimeout(function () {
                        value = sourceField.val();
                        targetField.attr('disabled', 'disabled');
                        $.get(updateUrl, {data: sourceField.val()}, function (r) {
                            targetField.val(r).removeAttr('disabled');
                        });
                    }, 300);
                }
            });

            targetField.on('change', function () {
                editable = $(this).val().length == 0;
            });
        });
JS;

        Yii::app()->clientScript->registerScript($this->getId(), $JS, \CClientScript::POS_END);

        return $this->textFieldGroup($model, $attribute, $options);
    }
}