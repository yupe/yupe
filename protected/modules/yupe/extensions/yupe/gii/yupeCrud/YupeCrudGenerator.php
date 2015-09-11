<?php
/**
 * BootstrapGenerator class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudGenerator');

class YupeCrudGenerator extends CrudGenerator
{
    public $codeModel = 'application.modules.yupe.extensions.yupe.gii.yupeCrud.YupeCrudCode';
}
