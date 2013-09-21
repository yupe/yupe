/*
 Highcharts JS v2.2.5 (2012-06-08)
 MooTools adapter

 (c) 2010-2011 Torstein H?nsi

 License: www.highcharts.com/license
*/
(function(){var e=window,i=document,f=e.MooTools.version.substring(0,3),g=f==="1.2"||f==="1.1",j=g||f==="1.3",h=e.$extend||function(){return Object.append.apply(Object,arguments)};e.HighchartsAdapter={init:function(a){var b=Fx.prototype,c=b.start,d=Fx.Morph.prototype,e=d.compute;b.start=function(b,d){var e=this.element;if(b.d)this.paths=a.init(e,e.d,this.toD);c.apply(this,arguments);return this};d.compute=function(b,c,d){var f=this.paths;if(f)this.element.attr("d",a.step(f[0],f[1],d,this.toD));else return e.apply(this,
arguments)}},adapterRun:function(a,b){return $(a).getStyle(b).toInt()},getScript:function(a,b){var c=i.getElementsByTagName("head")[0],d=i.createElement("script");d.type="text/javascript";d.src=a;d.onload=b;c.appendChild(d)},animate:function(a,b,c){var d=a.attr,f=c&&c.complete;if(d&&!a.setStyle)a.getStyle=a.attr,a.setStyle=function(){var b=arguments;a.attr.call(a,b[0],b[1][0])},a.$family=function(){return!0};e.HighchartsAdapter.stop(a);c=new Fx.Morph(d?a:$(a),h({transition:Fx.Transitions.Quad.easeInOut},
c));if(d)c.element=a;if(b.d)c.toD=b.d;f&&c.addEvent("complete",f);c.start(b);a.fx=c},each:function(a,b){return g?$each(a,b):Array.each(a,b)},map:function(a,b){return a.map(b)},grep:function(a,b){return a.filter(b)},merge:function(){var a=arguments,b=[{}],c=a.length;if(g)a=$merge.apply(null,a);else{for(;c--;)typeof a[c]!=="boolean"&&(b[c+1]=a[c]);a=Object.merge.apply(Object,b)}return a},offset:function(a){a=$(a).getOffsets();return{left:a.x,top:a.y}},extendWithEvents:function(a){a.addEvent||(a.nodeName?
$(a):h(a,new Events))},addEvent:function(a,b,c){typeof b==="string"&&(b==="unload"&&(b="beforeunload"),e.HighchartsAdapter.extendWithEvents(a),a.addEvent(b,c))},removeEvent:function(a,b,c){typeof a!=="string"&&(e.HighchartsAdapter.extendWithEvents(a),b?(b==="unload"&&(b="beforeunload"),c?a.removeEvent(b,c):a.removeEvents&&a.removeEvents(b)):a.removeEvents())},fireEvent:function(a,b,c,d){b={type:b,target:a};b=j?new Event(b):new DOMEvent(b);b=h(b,c);b.preventDefault=function(){d=null};a.fireEvent&&
a.fireEvent(b.type,b);d&&d(b)},washMouseEvent:function(a){a.pageX=a.page.x;a.pageY=a.page.y;return a},stop:function(a){a.fx&&a.fx.cancel()}}})();
