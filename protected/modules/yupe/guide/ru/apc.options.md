Оптимальные настройки APC
=========================

В интернете можно найти множество вариантов настроек для APC, мы же хотим предложить вам те, которые используем сами. Это подборка лучших вариаций настроек из тех, что мы видели. Если у вас есть предложения, которые позволят добиться ещё большей производительности - будем рады, если вы поделитесь ими. И так, всё, что нам требуется, это применить данные настройки:
<pre><code class="bash">
; enable APC
apc.enabled=1    
; The number of shared memory segments
apc.shm_segments=1      
; The size of each shared memory segment
apc.shm_size=64    
; The number of seconds a cache entry is allowed to idle in a slot in case this
; cache entry slot is needed by another entry.
apc.ttl=7200

</code></pre>


**При возникновении проблем - [напишите нам](http://amylabs.ru/contact)!**