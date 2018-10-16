<?php
/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

class YupeCrudCode extends CrudCode
{
    const BASE_CONTROLLER_BACKEND = '\yupe\components\controllers\BackController';
    const BASE_CONTROLLER_FRONTEND = '\yupe\components\controllers\FrontController';

    public $im;
    public $rod;
    public $dat;
    public $vin;
    public $tvor;
    public $pre;

    public $mim;
    public $mrod;
    public $mtvor;

    public $mid;
    public $mName;

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['im, rod, dat, vin, tvor, pre, mim, mrod, mtvor, mid', 'filter', 'filter' => 'trim'],
                ['im, rod, dat, vin, tvor, pre, mim, mrod, mtvor, mid', 'required'],
            ]
        );
    }

    /**
     * Меняем labels переменных
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'model'=>'Модель (название)',
            'controller'=>'Контроллер (название)',
            'baseControllerClass'=>'Базовый класс контроллера',
        ));
    }

    public function generateActiveGroup($modelClass, $column)
    {
        if ($column->type === 'boolean') {
            return "\$form->checkBoxGroup(\$model, '{$column->name}', [
            'widgetOptions' =>
            [
                'htmlOptions' => [
                    'class' => 'popover-help',
                    'data-original-title' => \$model->getAttributeLabel('{$column->name}'),
                    'data-content' => \$model->getAttributeDescription('{$column->name}')
                ]
            ]
        ])";
        } else {
            if (stripos($column->dbType, 'text') !== false) {
                return "\$form->textAreaGroup(\$model, '{$column->name}', [
            'widgetOptions' => [
                'htmlOptions' => [
                    'class' => 'popover-help',
                    'rows' => 6,
                    'cols' => 50,
                    'data-original-title' => \$model->getAttributeLabel('{$column->name}'),
                    'data-content' => \$model->getAttributeDescription('{$column->name}')
                ]
            ]])";
            } elseif ($column->dbType == 'date') {
                return "\$form->datePickerGroup(\$model,'{$column->name}', [
            'widgetOptions'=>[
                'options' => [],
                'htmlOptions' => []
            ],
            'prepend'=>'<i class=\"fa fa-calendar\"></i>'
        ])";
            } elseif ($column->dbType == 'datetime') {
                return "\$form->dateTimePickerGroup(\$model,'{$column->name}', [
            'widgetOptions' => [
                'options' => [],
                'htmlOptions'=>[]
            ],
            'prepend'=>'<i class=\"fa fa-calendar\"></i>'
        ])";
            } else {
                if ($column->isForeignKey) {
                    $relations = CActiveRecord::model($modelClass)->relations();
                    foreach ($relations as $key => $relation) {
                        if ($relation[0] == 'CBelongsToRelation' && $relation[2] == $column->name) {
                            $relationModel = CActiveRecord::model($relation[1]);
                            $suggestedName = $this->suggestName($relationModel->tableSchema->columns)->name;

                            return "\$form->dropDownListGroup(\$model, '{$relation[2]}', [
                    'widgetOptions' => [
                        'data' => CHtml::listData($relation[1]::model()->findAll(), 'id', '{$suggestedName}')
                    ]
                ])";
                        }
                    }
                } else {
                    if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                        $inputField = 'passwordFieldGroup';
                    } else {
                        $inputField = 'textFieldGroup';
                    }

                    if ($column->type !== 'string' || $column->size === null) {
                        return "\$form->{$inputField}(\$model, '{$column->name}', [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class' => 'popover-help',
                        'data-original-title' => \$model->getAttributeLabel('{$column->name}'),
                        'data-content' => \$model->getAttributeDescription('{$column->name}')
                    ]
                ]
            ])";
                    } else {
                        return "\$form->{$inputField}(\$model, '{$column->name}', [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class' => 'popover-help',
                        'data-original-title' => \$model->getAttributeLabel('{$column->name}'),
                        'data-content' => \$model->getAttributeDescription('{$column->name}')
                    ]
                ]
            ])";
                    }
                }
            }
        }
    }

    public function mb_ucfirst($word)
    {
        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(
            mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'),
            1,
            mb_strlen($word),
            'UTF-8'
        );
    }

    // Определяем первый осмысленный текстовый столбец в таблице. Как правило это что-то вроде blahblahName,
    // который можно в будущем использовать в качестве текстового значения для списков в связанных таблицах.
    public function suggestName($columns)
    {
        $j = 0;
        foreach ($columns as $column) {
            if (!$column->isForeignKey &&
                !$column->isPrimaryKey &&
                $column->type != 'INT' &&
                $column->type != 'INTEGER' &&
                $column->type != 'BOOLEAN' &&
                substr_count(strtolower($column->name), 'name') > 0
            ) {
                $num = $j;
                break;
            }
            $j++;
        }

        for ($i = 0; $i < $j; $i++) {
            next($columns);
        }

        if (is_object(current($columns))) {
            return current($columns);
        } else {
            $column = reset($columns);

            return $column;
        }
    }

    public function getControllerFile()
    {
        $id = $this->getControllerID();

        if (($pos = strrpos($id, '/')) !== false) {
            $id[$pos + 1] = strtoupper($id[$pos + 1]);
        } else {
            $id[0] = strtoupper($id[0]);
        }

        return $this->getModulePath() . '/controllers/' . $id . 'Controller.php';
    }

    /**
     * Возвращается путь к папке модуля
     * @return string
     */
    public function getModulePath()
    {
        return Yii::app()->basePath . '/modules/' . $this->mid;
    }

    /**
     * Возвращает строку категории для Yii::t()
     * @return string
     */
    public function getModuleTranslate()
    {
        return ucfirst($this->mid) . 'Module.' . $this->mid;
    }

    public function getViewPath()
    {
        return $this->getModulePath() . '/views/' . $this->getControllerID();
    }

    /**
     * Возвращаем список возможных классов-родителей для контроллера
     * @return array
     */
    public function getBbaseControllerClassList()
    {
        return [
            self::BASE_CONTROLLER_BACKEND => self::BASE_CONTROLLER_BACKEND,
            self::BASE_CONTROLLER_FRONTEND => self::BASE_CONTROLLER_FRONTEND,
        ];
    }
}
