<?php
Yii::import('image.widgets.ImageWrapper');

/*
 * Виджет для вывода аватарки
 */
class AvatarWidget extends ImageWrapper
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
        $this->imageSrc = $this->user->getAvatar($this->size); 
        $this->imageAlt = $this->user->nick_name;
        $this->width = $this->size . 'px';
        $this->htmlOptions = array('class' => 'avatar avatar-' . $this->user->id);
        
        parent::run();
    }
}