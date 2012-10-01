<?php

class YandexMetrika extends YWidget
{
    public $counter;
    public $informer = true;

    public function run()
    {
        if (!$this->counter)
            throw new CException('Укажите параметр "counter" для YandexMetrikaWidget!');

        if ($this->informer)
            echo <<<EOF
                <!-- Yandex.Metrika informer -->
                <a href="http://metrika.yandex.ru/stat/?id={$this->counter}&amp;from=informer"
                target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/{$this->counter}/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" 
                title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" 
                onclick="try{Ya.Metrika.informer({i:this,id:{$this->counter},type:0,lang:'ru'});return false}catch(e){}"/></a>
                <!-- /Yandex.Metrika informer -->
EOF;
            echo <<<EOF
                <!-- Yandex.Metrika counter -->
                <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function() {
                        try {
                            w.yaCounter{$this->counter} = new Ya.Metrika({id:{$this->counter}, enableAll: true, webvisor:true});
                        } catch(e) {}
                    });
                    var n = d.getElementsByTagName("script")[0],
                        s = d.createElement("script"),
                        f = function () { n.parentNode.insertBefore(s, n); };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f);
                    } else { f(); }
                })(document, window, "yandex_metrika_callbacks");
                </script>
                <noscript><div><img src="//mc.yandex.ru/watch/{$this->counter}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                <!-- /Yandex.Metrika counter -->
EOF;
    }
}