<?php
class YServerErrorException extends CException
{
    /**
     * @var integer HTTP status code, such as 403, 404, 500, etc.
     */
    public $statusCode = 500;

    /**
     * Конструктор
     * @param string $message Сообщение об ошибке
     * @param integer $code error code
     */
    public function __construct($message = null, $code = 0)
    {
        parent::__construct($message, $code);
    }
}