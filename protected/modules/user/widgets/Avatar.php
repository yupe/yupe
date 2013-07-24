<?php
/*
 * Виджет для вывода аватарки
 */
class Avatar extends CWidget
{
    /**
     * Модель пользователя
     * @var User
     */
    public $user;
    /**
     * Размер аватарки
     * @var int Пикселей
     */
    public $size = 100;
    
    public function run() {
        $this->widget('image.widgets.ImageWrapper', array(
                'imageSrc' => $this->user->getAvatar($this->size), 
                'imageAlt' => $this->user->nick_name, 
                'width' => $this->size . 'px',
                'htmlOptions' => array('class' => 'avatar', 'id' => 'avatar-' . $this->user->id)
        ));
    }
}