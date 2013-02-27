<?php $this->widget('gallery.extensions.fancybox.FancyBox', array(
    'target' => '.fancybox',
    'config' => array(
        'helpers' => array('title' => array('type' => 'inside'))
    ),
)); ?>


<?php $this->widget('zii.widgets.CListView', array(
	'id' => 'gallery',
    'dataProvider' => $dataProvider,
    'itemView'     => '_image',
    'afterAjaxUpdate' => "function(id, data) { masonry('#gallery .items'); }",
)); ?>


<script type="text/javascript">
    function masonry(selector) {
        var $container = $(selector);
        $container.imagesLoaded(function(){
            this.isotope({
                masonry: { itemSelector : '.image', columnWidth : $container.width() / 19 }
            });
        });
    };
    
    masonry('#gallery .items');
</script>
