<?php
/**
* ������ ��� ������ ����
* @param name - ���������� ��� ����
* @param layout - ������ ��� ������ ����. ���� ������ ����� ���������� php � ���������� � themes/<�������� ����>/views/widgets/MenuWidget.
* ���� �������� �� ������, �� ���� ��������� ������ ��������.
* @param viewData - ������ �������������� ����������, ������� ����� ���������� � ������ �������
*/

class MenuWidget extends YWidget
{
    public $name;
    public $parent_id = 0;
	
	public $layout;
	public $viewData=array();
	
    public $id;
    public $params = array();

    public function init()
    {
        parent::init();

        $this->parent_id = (int)$this->parent_id;
    }

    public function run()
    {
		$content=$this->widget('zii.widgets.CMenu', 
						array_merge(
							$this->params, 
							array('items' => Menu::model()->getItems($this->name, $this->parent_id))),
						true
					);
		if (isset($this->layout)) {
			$this->render($this->layout, array_merge(array('content'=>$content),$this->viewData));
		} else {
			echo CHtml::openTag('div', array('id' => $this->id));
			echo $content;
			echo CHtml::closeTag('div');
		}
    }

}
