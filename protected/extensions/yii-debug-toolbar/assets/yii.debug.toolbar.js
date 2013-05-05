(function( $ ){
    var COOKIE_NAME = 'yii-debug-toolbar';

    yiiDebugToolbar = {

        init : function(){
            
            this.registerEventListeners();

            if ($.cookie(COOKIE_NAME)) {
                $('#yii-debug-toolbar').hide();
            } else {
                $('#yii-debug-toolbar').show();
            }
            this.initTabs();
        },

        initTabs : function()
        {
            $('#yii-debug-toolbar').find('ul.yii-debug-toolbar-tabs li').bind('click', $.proxy( this.toggleTabs, this ));
            $('.tabscontent').hide();

            var panelId = $('#yii-debug-toolbar').find('ul.yii-debug-toolbar-tabs li.active').attr('type');

            if (typeof panelId !== 'undefined')
            {
                var path = panelId.split('-');
                var panelName = path.pop();
                var section = path.join('-');

                if($.cookie(section))
                {
                    $('#yii-debug-toolbar').find('ul.yii-debug-toolbar-tabs li').removeClass('active');
                    panelId = section+'-'+$.cookie(section);
                    $('#'+panelId).show();
                    $('#yii-debug-toolbar').find('ul.yii-debug-toolbar-tabs li[type='+panelId+']').addClass('active');
                }
                else
                {
                    $('#'+panelId).show();
                }
            }

            
        },

        toggleTabs : function(e) 
        {
            e.preventDefault();
            var $target = $(e.currentTarget);
            $('.tabscontent').hide();
            $('#yii-debug-toolbar').find('ul.yii-debug-toolbar-tabs li').removeClass('active');

            var panelId = $target.attr('type');
            var path = panelId.split('-');
            var panelName = path.pop();
            var section = path.join('-');

            $.cookie(section, panelName, {
                path: '/',
                expires: 10
            });

            $('#'+panelId).show();
            $target.addClass('active');

        },
        
        /**
         * Toggles the nearby panel section in context of the clicked element
         */
        toggleSection: function(toToggle, object) {
            object = $(object);
            toToggle = !toToggle ? object.next() : $(toToggle);
            toToggle.toggle();
            if(toToggle.is(':visible')) {
                object.removeClass('collapsed');
            } else {
                object.addClass('collapsed');
            }
        },

        togglePanel : function(id)
        {
            var button = $('.' + id);
            var panel = $('#' + id);
            
            if(panel.is(':visible')) {
                panel.hide();
                button.removeClass('active');
                return;
            }
            
            this.closeAllPannels();
            $('#'+id).show();
            $('.'+id).addClass('active');
        },

        buttonClicked : function(e)
        {
            this.togglePanel($(e.currentTarget).attr('class').split(' ')[1]);
        },

        closeAllPannels : function()
        {
            $('.yii-debug-toolbar-panel').hide();
            $('.yii-debug-toolbar-button').removeClass('active');
        },

        closeButtonClicked : function(e)
        {
            this.closeAllPannels();
        },

        toggleToolbar : function(e)
        {
            //this.closeButtonClicked(e);
            if($('#yii-debug-toolbar').is(":visible"))
            {
                $('#yii-debug-toolbar').hide();
                $('#yii-debug-toolbar-swither a').removeClass('close');
                $.cookie(COOKIE_NAME, 'hide', {
                    path: '/',
                    expires: 10
                });
            }
            else
            {
                $('#yii-debug-toolbar').show();
                $('#yii-debug-toolbar-swither a').addClass('close');
                $.cookie(COOKIE_NAME, null, {
                    path: '/',
                    expires: -1
                });
            }
        }, 
        
        registerEventListeners: function() {
            $('#yii-debug-toolbar-swither').bind('click',$.proxy( this.toggleToolbar, this ));
            $('.yii-debug-toolbar-button').bind('click',$.proxy( this.buttonClicked, this ));
            $('.yii-debug-toolbar-panel-close').bind('click',$.proxy( this.closeButtonClicked, this ));
            $('#yii-debug-toolbar .collapsible').bind('click', function(){ yiiDebugToolbar.toggleSection($(this).attr('rel'), this); });
            $('#yii-debug-toolbar .collapsible.collapsed').next().hide();

        },

        toggleDetails: function(selector, cell){
            $(selector).toggleClass('hidden');
        }
        
    };

    $(function(){
        $('.yii-debug-toolbar-button').live('click', function(){
            setTimeout(function(){
                $('a.yii-debug-toolbar-link').each(function(){
                    $(this).attr('href', '#'+$(this).attr('id').replace('yii-debug-toolbar-tab-',''));
                    if($(this).parents('li.yii-debug-toolbar-button').hasClass('active')){
                        $(this).attr('href', '#close');
                    }
                });
            }, 1);
        });
    });
    
})( jQuery );
