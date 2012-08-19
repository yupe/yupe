<?php
/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

class YupeCode extendS CrudCode
{

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


    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('im, rod, dat, vin, tvor, pre, mim, mrod, mtvor, mid', 'filter', 'filter' => 'trim'),
            array('im, rod, dat, vin, tvor, pre, mim, mrod, mtvor, mid', 'required'),
        ));
    }

    public function generateActiveRow($modelClass, $column)
    {
        if ($column->type === 'boolean')
            return "\$form->checkBoxRow(\$model, '{$column->name}')";
        else if (stripos($column->dbType, 'text') !== false)
            return "\$form->textAreaRow(\$model, '{$column->name}', array('rows' => 6, 'cols' => 50, 'class' => 'span8'))";
        else
        {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
                $inputField = 'passwordFieldRow';
            else
                $inputField = 'textFieldRow';

            if ($column->type !== 'string' || $column->size === null)
                return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'span5', 'size' => 60, 'maxlength' => 60))";
            else
                return "\$form->{$inputField}(\$model, '{$column->name}', array('class' => 'span5', 'maxlength' => $column->size, 'size' => 60))";
        }
    }

    public function mb_ucfirst($word)
    {
        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'), 1, mb_strlen($word), 'UTF-8');
    }
}
