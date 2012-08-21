<?php
/**
 * Отвечает за отображение Юпи меню на сайте(фронт-энд)
 * Содержит ссылки на скачивание последней версии yii
 * А так же contribute ссылки
 * И твиттер ссылку
 */
class YYupeDownloadWidget  extends YWidget
{
    public function run()
    {
        $this->render('yupeDownload');
    }
}
