<?php
class YandexMetrika extends CWidget
{
    public $counter;

    public function run()
    {

        if (!$this->counter)
            throw new CException('Укажите параметр "counter" для YandexMetrikaWidget!');

        echo '<!-- Yandex.Metrika counter -->
                <script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
                <div style="display:none;"><script type="text/javascript">
                try { var yaCounter' . $this->counter . ' = new Ya.Metrika(' . $this->counter . ');} catch(e) { }
                </script></div>
                <noscript><img src="//mc.yandex.ru/watch/' . $this->counter . '" style="position:absolute; left:-9999px;" alt="" /></noscript>
                <!-- /Yandex.Metrika counter -->';
    }
}