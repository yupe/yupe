/*! Bootstrap Editable - v1.1.4 
* In-place editing with Bootstrap Form and Popover
* https://github.com/vitalets/bootstrap-editable
* Copyright (c) 2012 Vitaliy Potapov; Licensed MIT, GPL */

(function ($) {

    //Editable object
    var Editable = function (element, options) {
        var type, typeDefaults, doAutotext = false, valueSetByText = false;
        this.$element = $(element);

        //if exists 'placement' or 'title' options, copy them to data attributes to aplly for popover
        if (options && options.placement && !this.$element.data('placement')) {
            this.$element.attr('data-placement', options.placement);
        }
        if (options && options.title && !this.$element.data('original-title')) {
            this.$element.attr('data-original-title', options.title);
        }

        //detect type
        type = (this.$element.data().type || (options && options.type) || $.fn.editable.defaults.type);
        typeDefaults = ($.fn.editable.types[type]) ? $.fn.editable.types[type] : {};

        //apply options
        this.settings = $.extend({}, $.fn.editable.defaults, $.fn.editable.types.defaults, typeDefaults, options, this.$element.data());

        //apply type's specific init()
        this.settings.init.call(this, options);
        
        //store name
        this.name = this.settings.name || this.$element.attr('id');
        if (!this.name) {
            $.error('You should define name (or id) for Editable element');
        }

        //if validate is map take only needed function
        if (typeof this.settings.validate === 'object' && this.name in this.settings.validate) {
            this.settings.validate = this.settings.validate[this.name];
        }

        //set value from settings or by element text
        if (this.settings.value === undefined || this.settings.value === null) {
            this.settings.setValueByText.call(this);
            valueSetByText = true;
        } else {
            this.value = this.settings.value;
            valueSetByText = false;
        }

        //also storing last saved value (initially equals to value)
        this.lastSavedValue = this.value;

        //set toggle element
        if (this.settings.toggle) {
            this.$toggle = $(this.settings.toggle);
            //insert in DOM if needed
            if (!this.$toggle.parent().length) {
                this.$element.after(this.$toggle);
            }
            //prevent tabstop on element
            this.$element.attr('tabindex', -1);
        } else {
            this.$toggle = this.$element;

            //add editable class
            this.$element.addClass('editable');
        }

        //bind click event on toggle
        this.$toggle.on('click', $.proxy(this.click, this));
        
        //blocking click event when going from inside popover. all other clicks will close it
        $('body').on('click.editable', '.editable-popover', function (e) { e.stopPropagation(); });

        //autotext
        if(!valueSetByText && this.value !== null && this.value !== undefined) {
            switch(this.settings.autotext) {
              case 'always':
                doAutotext = true; 
              break;
              
              case 'never':
                doAutotext = false; 
              break;
              
              case 'auto':
                if(this.$element.html().length) {
                   doAutotext = false; 
                } else {
                   //for SELECT do not use autotext when source is url and autotext = 'auto' (to prevent extra request)
                   if (type === 'select') {
                       this.settings.source = tryParseJson(this.settings.source, true);
                       if (this.settings.source && typeof this.settings.source === 'object') {
                           doAutotext = true; 
                       }
                   } else {
                      doAutotext = true; 
                   }                   
                }
              break;
            }
        }
        
        function finalize() {
            //show emptytext if visible text is empty
            this.handleEmpty();

            //trigger 'init' event: DEPRECATED
            this.$element.trigger('init', this);

            //trigger 'render' event with property isInit = true
            var event = jQuery.Event("render");
            event.isInit = true;
            this.$element.trigger(event, this);
        }           
                     
        if(doAutotext) {
           $.when(this.settings.setTextByValue.call(this)).then($.proxy(finalize, this));
        } else {
           finalize.call(this); 
        }
        
             
    };

    Editable.prototype = {
        constructor: Editable,

        click: function (e) {
            e.stopPropagation();
            e.preventDefault();

            var popover = this.$element.data('popover');
            if (popover && popover.tip().is(':visible')) {
                this.hide();
            } else {
                this.show();
            }
        },

        show: function () {
            //hide all other popovers if shown
            $('.popover').find('form').find('button.editable-cancel').click();

            //for the first time create popover
            if (!this.$element.data('popover')) {
                this.$element.popover({
                    trigger  :'manual',
                    placement:'top',
                    content  :this.settings.loading
                });

                this.$element.data('popover').tip().addClass('editable-popover');
            }

            //show popover
            this.$element.popover('show');
            
            //movepopover to correct position. Refers to bug in bootstrap 2.1.x with popover positioning
            this.setPosition();
            
            this.$element.addClass('editable-open');
            this.errorOnRender = false;

            //use deffered approach to load data asynchroniously
            $.when(this.settings.renderInput.call(this))
            .then($.proxy(function () {
                var $tip = this.$element.data('popover').tip();

                //render content & input
                this.$content = $(this.settings.formTemplate);
                this.$content.find('div.control-group').prepend(this.$input);

                //invoke form into popover content
                $tip.find('.popover-content p').append(this.$content);
                
                //set position once more. It is required to pre-move popover when it is close to screen edge.
                this.setPosition();

                //check for error during render input
                if (this.errorOnRender) {
                    this.$input.attr('disabled', true);
                    $tip.find('button.btn-primary').attr('disabled', true);
                    $tip.find('form').submit(function () {
                        return false;
                    });
                    //show error
                    this.enableContent(this.errorOnRender);
                } else {
                    this.$input.removeAttr('disabled');
                    $tip.find('button.btn-primary').removeAttr('disabled');
                    //bind form submit
                    $tip.find('form').submit($.proxy(this.submit, this));
                    //show input (and hide loading)
                    this.enableContent();
                    //set input value
                    this.settings.setInputValue.call(this);
                }

                //bind popover hide on button
                $tip.find('button.editable-cancel').click($.proxy(this.hide, this));

                //bind popover hide on escape
                $(document).on('keyup.editable', $.proxy(function (e) {
                    if (e.which === 27) {
                        e.stopPropagation();
                        this.hide();
                    }
                }, this));
               
                //hide popover on external click
                $(document).on('click.editable', $.proxy(this.hide, this));
                
                //trigger 'shown' event
                this.$element.trigger('shown', this);
            }, this));
        },

        submit: function (e) {
            e.stopPropagation();
            e.preventDefault();

            var error,
                value = this.settings.getInputValue.call(this);

            //validation
            if (error = this.validate(value)) {
                this.enableContent(error);
                return;
            }

            /*jslint eqeqeq: false*/
            if (value == this.value) {
            /*jslint eqeqeq: true*/
                //if value not changed --> do nothing, simply hide popover
                this.hide();
            } else {
                //saving new value
                this.save(value);
            }
        },

        save: function(value) {
            $.when(this.send(value))
            .done($.proxy(function (data) {
                var error, isAjax = (typeof data !== 'undefined');

                //check and run custom success handler
                if (isAjax && typeof this.settings.success === 'function' && (error = this.settings.success.apply(this, arguments))) {
                    //show form with error message
                    this.enableContent(error);
                    return;
                }

                //set new value and text
                this.value = value;
                this.settings.setTextByValue.call(this);

                //to show that value modified but not saved
                if (isAjax) {
                    this.markAsSaved();
                } else {
                    this.markAsUnsaved();
                }

                this.handleEmpty();
                this.hide();

                //trigger 'update' event. DEPRECATED! Use 'render' instead.
                this.$element.trigger('update', this);

                //trigger 'render' event with property isInit = false
                var event = jQuery.Event("render");
                event.isInit = false;
                this.$element.trigger(event, this);
            }, this))
            .fail($.proxy(function(xhr) {
                var msg = (typeof this.settings.error === 'function') ? this.settings.error.apply(this, arguments) : null;
                this.enableContent(msg || xhr.responseText || xhr.statusText);
            }, this));
        },

        send: function(value) {
            var send, pk, params;

            //getting primary key
            if (typeof this.settings.pk === 'function') {
                pk = this.settings.pk.call(this.$element);
            } else if (typeof this.settings.pk === 'string' && $(this.settings.pk).length === 1 && $(this.settings.pk).parent().length) { //pk is ID of existing element
                pk = $(this.settings.pk).text();
            } else {
                pk = this.settings.pk;
            }

            send = (this.settings.url !== undefined) && ((this.settings.send === 'always') || (this.settings.send === 'auto' && pk) || (this.settings.send === 'ifpk' /* deprecated */ && pk));

            if (send) { //send to server
                //hide form, show loading
                this.enableLoading();

                //try parse json in single quotes
                this.settings.params = tryParseJson(this.settings.params, true);

                //creating params
                params = (typeof this.settings.params === 'string') ? {params:this.settings.params} : $.extend({}, this.settings.params);
                params.name = this.name;
                params.value = value;
                if (pk) {
                    params.pk = pk;
                }

                //send ajax to server and return deferred object
                return $.ajax({
                    url     : (typeof this.settings.url === 'function') ? this.settings.url.call(this) : this.settings.url,
                    data    : params,
                    type    : 'post',
                    dataType: 'json'
                });
            }
        },

        hide: function () {
            this.$element.popover('hide');
            this.$element.removeClass('editable-open');
            $(document).off('keyup.editable');
            $(document).off('click.editable');
            
            //returning focus on toggle element
            if (this.settings.enablefocus || this.$element.get(0) !== this.$toggle.get(0)) {
                this.$toggle.focus();
            }
            
            //trigger 'hidden' event
            this.$element.trigger('hidden', this);
        },

        /**
         * show input inside popover
         */
        enableContent:function (error) {
            if (error !== undefined && error.length > 0) {
                this.$content.find('div.control-group').addClass('error').find('span.help-block').text(error);
            } else {
                this.$content.find('div.control-group').removeClass('error').find('span.help-block').text('');
            }
            this.$content.show();
            //hide loading
            this.$element.data('popover').tip().find('.editable-loading').hide();

            //move popover to final correct position
            this.setPosition();

            //TODO: find elegant way to exclude hardcode of types here
            if (this.settings.type === 'text' || this.settings.type === 'textarea') {
                this.$input.focus();
            }
        },

        /**
         * move popover to new position. This function mainly copied from bootstrap-popover.
         */
        setPosition: function () {
            var p = this.$element.data('popover'), $tip = p.tip(), inside = false, placement, pos, actualWidth, actualHeight, tp;

            placement = typeof p.options.placement === 'function' ? p.options.placement.call(p, $tip[0], p.$element[0]) : p.options.placement;

            pos = p.getPosition(inside);

            actualWidth = $tip[0].offsetWidth;
            actualHeight = $tip[0].offsetHeight;


            switch (inside ? placement.split(' ')[1] : placement) {
                case 'bottom':
                    tp = {top:pos.top + pos.height, left:pos.left + pos.width / 2 - actualWidth / 2};
                    break;
                case 'top':
                    /* For Bootstrap 2.1.x: 10 pixels needed to correct popover position. See https://github.com/twitter/bootstrap/issues/4665 */
                    if($tip.find('.arrow').get(0).offsetHeight === 10) {actualHeight += 10;}
                    tp = {top:pos.top - actualHeight, left:pos.left + pos.width / 2 - actualWidth / 2};
                    break;
                case 'left':
                    /* For Bootstrap 2.1.x: 10 pixels needed to correct popover position. See https://github.com/twitter/bootstrap/issues/4665 */
                    if($tip.find('.arrow').get(0).offsetWidth === 10) {actualWidth  += 10;}
                    tp = {top:pos.top + pos.height / 2 - actualHeight / 2, left:pos.left - actualWidth};
                    break;
                case 'right':
                    tp = {top:pos.top + pos.height / 2 - actualHeight / 2, left:pos.left + pos.width};
                    break;
            }

            $tip.css(tp).addClass(placement).addClass('in');
        },

        /**
         * show loader inside popover
         */
        enableLoading:function () {
            //enlage loading to whole area of popover
            var $tip = this.$element.data('popover').$tip;
            $tip.find('.editable-loading').css({height:this.$content[0].offsetHeight, width:this.$content[0].offsetWidth});

            this.$content.hide();
            this.$element.data('popover').tip().find('.editable-loading').show();
        },

        handleEmpty:function () {
            //don't have editalbe class --> it's not link --> toggled by another element --> no need to set emptytext
            if (!this.$element.hasClass('editable')) {
                return;
            }

            if ($.trim(this.$element.text()) === '') {
                this.$element.addClass('editable-empty').text(this.settings.emptytext);
            } else {
                this.$element.removeClass('editable-empty');
            }
        },

        validate:function (value) {
            if (value === undefined) {
                value = this.value;
            }
            if (typeof this.settings.validate === 'function') {
                return this.settings.validate.call(this, value);
            }
        },

        markAsUnsaved:function () {
            if (this.value !== this.lastSavedValue) {
                this.$element.addClass('editable-changed');
            } else {
                this.$element.removeClass('editable-changed');
            }
        },

        markAsSaved:function () {
            this.lastSavedValue = this.value;
            this.$element.removeClass('editable-changed');
        }
    };


    /* EDITABLE PLUGIN DEFINITION
     * ======================= */

    $.fn.editable = function (option) {
        //special methods returning non-jquery object
        var result = {}, args = arguments;
        switch (option) {
            case 'validate':
                this.each(function () {
                    var $this = $(this), data = $this.data('editable'), error;
                    if (data && (error = data.validate())) {
                        result[data.name] = error;
                    }
                });
                return result;

            case 'getValue':
                this.each(function () {
                    var $this = $(this), data = $this.data('editable');
                    if (data && data.value !== undefined && data.value !== null) {
                        result[data.name] = data.value;
                    }
                });
                return result;
                
            case 'submit':  //collects value, validate and submit to server for creating new record
                var config = arguments[1] || {},
                    $elems = this,
                    errors = this.editable('validate'),
                    values;
                
                if(typeof config.error !== 'function') {
                    config.error = function() {};
                } 

                if($.isEmptyObject(errors)) {
                    values = this.editable('getValue'); 
                    if(config.data) {
                        $.extend(values, config.data);
                    }
                    $.ajax({
                        type: 'POST',
                        url: config.url, 
                        data: values, 
                        dataType: 'json'
                    }).success(function(response) {
                        if(typeof response === 'object' && response.id) {
                            $elems.editable('option', 'pk', response.id); 
                            $elems.editable('markAsSaved');
                            if(typeof config.success === 'function') {
                                config.success.apply($elems, arguments);
                            } 
                        } else { //server-side validation error
                            config.error.apply($elems, arguments);
                        }
                    }).error(function(){  //ajax error
                        config.error.apply($elems, arguments);
                    });
                } else { //client-side validation error
                    config.error.call($elems, {errors: errors});
                }
                
                return this;
        }

        //return jquery object
        return this.each(function () {
            var $this = $(this), data = $this.data('editable'), options = typeof option === 'object' && option;
            if (!data) {
                $this.data('editable', (data = new Editable(this, options)));
            }
            
            if(option === 'option') {
                 if(args.length === 2 && typeof args[1] === 'object') {
                     $.extend(data.settings, args[1]); //set options by object
                 } else if(args.length === 3 && typeof args[1] === 'string') {
                    data.settings[args[1]] = args[2]; //set one option
                 } 
            } else if (typeof option === 'string') {
                data[option]();
            }
        });
    };

    $.fn.editable.Constructor = Editable;

    //default settings
    $.fn.editable.defaults = {
        url:null, //url for submit
        type:'text', //input type
        name:null, //field name
        pk:null, //primary key or record
        value:null, //real value, not shown. Especially usefull for select
        emptytext:'Empty', //text shown on empty element
        params:null, //additional params to submit
        send:'auto', // strategy for sending data on server: 'always', 'never', 'auto' (default). 'auto' = 'ifpk' (deprecated)
        autotext:'auto', //can be auto|never|always. Useful for select element: if 'auto' -> element text will be automatically set by provided value and source (in case source is object so no extra request will be performed).
        enablefocus:false, //wether to return focus on link after popover is closed. It's more functional, but focused links may look not pretty
        formTemplate:'<form class="form-inline" autocomplete="off">' + 
                       '<div class="control-group">' + 
                       '&nbsp;<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i></button>&nbsp;<button type="button" class="btn editable-cancel"><i class="icon-ban-circle"></i></button>' + 
                       '<span class="help-block" style="clear: both"></span>' + 
                       '</div>' + 
                       '</form>',
        loading:'<div class="editable-loading"></div>',

        validate:function (value) {
        }, //client-side validation. If returns msg - data will not be sent
        success:function (data) {
        }, //after send callback
        error:function (xhr) {
        }  //error wnen submitting data
    };

    //input types
    $.fn.editable.types = {
        //for all types
        defaults:{
            inputclass:'span2',
            placeholder:null,
            init:function (options) {},
            // this function called every time popover shown. Should set value of this.$input
            renderInput:function () {
                this.$input = $(this.settings.template);
                this.$input.addClass(this.settings.inputclass);
                if (this.settings.placeholder) {
                    this.$input.attr('placeholder', this.settings.placeholder);
                }
            },
            setInputValue:function () {
                this.$input.val(this.value);
                this.$input.focus();
            },
            //getter for value from input
            getInputValue:function () {
                return this.$input.val();
            },

            //setting text of element (init)
            setTextByValue:function () {
                this.$element.text(this.value);
            },

            //setting value by element text (init)
            setValueByText:function () {
                this.value = $.trim(this.$element.text());
            }
        },

        //text
        text:{
            template:'<input type="text">',
            setInputValue:function () {
                this.$input.val(this.value);
                setCursorPosition.call(this.$input, this.$input.val().length);
                this.$input.focus();
            }
        },

        //select
        select:{
            template:'<select></select>',
            source:null,
            prepend:false,
            onSourceReady:function (success, error) {
                // try parse json in single quotes (for double quotes jquery does automatically)
                try {
                    this.settings.source = tryParseJson(this.settings.source, false);
                } catch (e) {
                    error.call(this);
                    return;
                }

                if (typeof this.settings.source === 'string') {
                    var cacheID = this.settings.source + '-' + this.name, cache;

                    if (!$(document).data(cacheID)) {
                        $(document).data(cacheID, {});
                    }
                    cache = $(document).data(cacheID);

                    //check for cached data
                    if (cache.loading === false && cache.source && typeof cache.source === 'object') { //take source from cache
                        this.settings.source = cache.source;
                        success.call(this);
                        return;
                    } else if (cache.loading === true) { //cache is loading, put callback in stack to be called later
                        cache.callbacks.push($.proxy(function () {
                            this.settings.source = cache.source;
                            success.call(this);
                        }, this));

                        //also collecting error callbacks
                        cache.err_callbacks.push($.proxy(error, this));
                        return;
                    } else { //no cache yet, activate it
                        cache.loading = true;
                        cache.callbacks = [];
                        cache.err_callbacks = [];
                    }

                    //options loading from server
                    $.ajax({
                        url:this.settings.source,
                        type:'get',
                        data:{name:this.name},
                        dataType:'json',
                        success:$.proxy(function (data) {
                            this.settings.source = this.settings.doPrepend.call(this, data);
                            cache.loading = false;
                            cache.source = this.settings.source;
                            success.call(this);
                            $.each(cache.callbacks, function () {
                                this.call();
                            }); //run callbacks for other fields
                        }, this),
                        error:$.proxy(function () {
                            cache.loading = false;
                            error.call(this);
                            $.each(cache.err_callbacks, function () {
                                this.call();
                            }); //run callbacks for other fields
                        }, this)
                    });
                } else { //options as json/array

                    //convert regular array to object
                    if ($.isArray(this.settings.source)) {
                        var arr = this.settings.source, obj = {};
                        for (var i = 0; i < arr.length; i++) {
                            if (arr[i] !== undefined) {
                                obj[i] = arr[i];
                            }
                        }
                        this.settings.source = obj;
                    }

                    this.settings.source = this.settings.doPrepend.call(this, this.settings.source);
                    success.call(this);
                }
            },

            doPrepend:function (data) {
                this.settings.prepend = tryParseJson(this.settings.prepend, true);

                if (typeof this.settings.prepend === 'string') {
                    return $.extend({}, {'':this.settings.prepend}, data);
                } else if (typeof this.settings.prepend === 'object') {
                    return $.extend({}, this.settings.prepend, data);
                } else {
                    return data;
                }
            },

            renderInput:function () {
                var deferred = $.Deferred();
                this.$input = $(this.settings.template);
                this.$input.addClass(this.settings.inputclass);
                this.settings.onSourceReady.call(this, function () {
                        if (typeof this.settings.source === 'object' && this.settings.source != null) {
                            $.each(this.settings.source, $.proxy(function (key, value) {
                                this.$input.append($('<option>', { value:key }).text(value));
                            }, this));
                        }
                        deferred.resolve();
                    }, function () {
                        this.errorOnRender = 'Error when loading options';
                        deferred.resolve();
                    });

                return deferred.promise();
            },

            setValueByText:function () {
                this.value = null; //it's not good to set value by select text. better set NULL
            },

            setTextByValue:function () {
                var deferred = $.Deferred();
                this.settings.onSourceReady.call(this, function () {
                        if (typeof this.settings.source === 'object' && this.value in this.settings.source) {
                            this.$element.text(this.settings.source[this.value]);
                        } else {
                            //set empty string when key not found in source
                            this.$element.text('');
                        }
                        deferred.resolve();
                    }, function () {
                        this.$element.text('Error!');
                        deferred.resolve();
                    });

                return deferred.promise();
            }
        },

        //textarea
        textarea:{
            template:'<textarea rows="8"></textarea>',
            inputclass:'span3',
            renderInput:function () {
                this.$input = $(this.settings.template);
                this.$input.addClass(this.settings.inputclass);
                if (this.settings.placeholder) {
                    this.$input.attr('placeholder', this.settings.placeholder);
                }

                //ctrl + enter
                this.$input.keydown(function (e) {
                    if (e.ctrlKey && e.which === 13) {
                        $(this).closest('form').submit();
                    }
                });
            },
            setInputValue:function () {
                this.$input.val(this.value);
                setCursorPosition.apply(this.$input, [this.$input.val().length]);
                this.$input.focus();
            },
            setValueByText:function () {
                var lines = this.$element.html().split(/<br\s*\/?>/i);
                for (var i = 0; i < lines.length; i++) {
                    lines[i] = $('<div>').html(lines[i]).text();
                }
                this.value = lines.join("\n");
            },
            setTextByValue:function () {
                var lines = this.value.split("\n");
                for (var i = 0; i < lines.length; i++) {
                    lines[i] = $('<div>').text(lines[i]).html();
                }
                var text = lines.join('<br>');
                this.$element.html(text);
            }
        },

        /*
         date
         based on fork: https://github.com/vitalets/bootstrap-datepicker
         */
        date:{
            template:'<div style="float: left; padding: 0; margin: 0" class="well"></div>',
            format:'yyyy-mm-dd', //format used for datepicker and sending to server
            viewformat: null,  //used only for showing date
            datepicker:{
                autoclose:false,
                keyboardNavigation:false
            },
            init:function (options) {
                //set popular options directly from settings or data-* attributes
                var directOptions = mergeKeys({}, this.settings, ['format', 'weekStart', 'startView']);
                
                //overriding datepicker config (as by default jQuery merge is not recursive)
                this.settings.datepicker = $.extend({}, $.fn.editable.types.date.datepicker, directOptions, options.datepicker);
                
                //by default viewformat equals to format
                if(!this.settings.viewformat) {
                    this.settings.viewformat = this.settings.datepicker.format;
                }                
            },
            renderInput:function () {
                this.$input = $(this.settings.template);
                this.$input.datepicker(this.settings.datepicker);
            },
            setInputValue:function () {
                this.$input.datepicker('update', this.value);
            },
            getInputValue:function () {
                var dp = this.$input.data('datepicker');
                return dp.getFormattedDate();
            },
            setTextByValue:function () {
                var text = this.settings.converFormat.call(this, this.value, this.settings.format, this.settings.viewformat);    
                this.$element.text(text);
            },
            setValueByText:function () {
                var text = $.trim(this.$element.text());
                if(!text.length) {
                    return;
                }
                this.value = this.settings.converFormat.call(this, text, this.settings.viewformat, this.settings.format);    
            },
            //helper function to convert date between two formats
            converFormat: function(dateStr, formatFrom, formatTo) {
                if(formatFrom === formatTo) {
                    return dateStr; 
                }
                var dpg = $.fn.datepicker.DPGlobal, 
                    dateObj,
                    lang = (this.settings.datepicker && this.settings.datepicker.language) || 'en';
                formatFrom = dpg.parseFormat(formatFrom);
                formatTo = dpg.parseFormat(formatTo);
                dateObj = dpg.parseDate($.trim(dateStr), formatFrom, lang);
                return dpg.formatDate(dateObj, formatTo, lang);
            }           
        }
    };

    /*
    * ========================== FUNCTIONS ========================
    */
    
    /**
     * set caret position in input
     * see http://stackoverflow.com/questions/499126/jquery-set-cursor-position-in-text-area
     */
    function setCursorPosition(pos) {
        this.each(function (index, elem) {
            if (elem.setSelectionRange) {
                elem.setSelectionRange(pos, pos);
            } else if (elem.createTextRange) {
                var range = elem.createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
        });
        return this;
    }

    /**
     * function to parse JSON in *single* quotes. (jquery automatically parse only double quotes)
     * That allows such code as: <a data-source="{'a': 'b', 'c': 'd'}">
     * safe = true --> means no exception will be thrown
     * for details see http://stackoverflow.com/questions/7410348/how-to-set-json-format-to-html5-data-attributes-in-the-jquery
     */
    function tryParseJson(s, safe) {
        if (typeof s === 'string' && s.length && s.match(/^\{.*\}$/)) {
            if (safe) {
                try {
                    /*jslint evil: true*/
                    s = (new Function('return ' + s))();
                    /*jslint evil: false*/
                } catch (e) {} finally {
                    return s;
                }
            } else {
                /*jslint evil: true*/
                s = (new Function('return ' + s))();
                /*jslint evil: false*/
            }
        }

        return s;
    }

    /**
     * function merges only specified keys
     */
    function mergeKeys(objTo, objFrom, keys) {
        var key, keyLower;
        if (!$.isArray(keys)) {
            return objTo;
        }
        for (var i = 0; i < keys.length; i++) {
            key = keys[i];
            if (key in objFrom) {
                objTo[key] = objFrom[key];
                continue;
            }
            //note, that when getting data-* attributes via $.data() it's converted it to lowercase.
            //details: http://stackoverflow.com/questions/7602565/using-data-attributes-with-jquery
            //workaround is code below.
            keyLower = key.toLowerCase();
            if (keyLower in objFrom) {
                objTo[key] = objFrom[keyLower];
            }
        }
        return objTo;
    }

}(window.jQuery));
!function( $ ) {

	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}

	// Picker object

	var Datepicker = function(element, options) {
		var that = this;

		this.element = $(element);
		this.language = options.language||this.element.data('date-language')||"en";
		this.language = this.language in dates ? this.language : "en";
		this.format = DPGlobal.parseFormat(options.format||this.element.data('date-format')||'mm/dd/yyyy');
                this.isInline = false;
		this.isInput = this.element.is('input');
		this.component = this.element.is('.date') ? this.element.find('.add-on') : false;
		this.hasInput = this.component && this.element.find('input').length;
		if(this.component && this.component.length === 0)
			this.component = false;

       if (this.isInput) {   //single input
            this.element.on({
                focus: $.proxy(this.show, this),
                keyup: $.proxy(this.update, this),
                keydown: $.proxy(this.keydown, this)
            });
        } else if(this.component && this.hasInput) {  //component: input + button
                // For components that are not readonly, allow keyboard nav
                this.element.find('input').on({
                    focus: $.proxy(this.show, this),
                    keyup: $.proxy(this.update, this),
                    keydown: $.proxy(this.keydown, this)
                });

                this.component.on('click', $.proxy(this.show, this));
        } else if(this.element.is('div')) {  //inline datepicker
            this.isInline = true;
        } else {
            this.element.on('click', $.proxy(this.show, this));
        }

        this.picker = $(DPGlobal.template)
                            .appendTo(this.isInline ? this.element : 'body')
                            .on({
                                click: $.proxy(this.click, this),
                                mousedown: $.proxy(this.mousedown, this)
                            });

        if(this.isInline) {
            this.picker.addClass('datepicker-inline');
        } else {
            this.picker.addClass('dropdown-menu');
        }

		$(document).on('mousedown', function (e) {
			// Clicked outside the datepicker, hide it
			if ($(e.target).closest('.edatepicker').length == 0) {
				that.hide();
			}
		});

		this.autoclose = false;
		if ('autoclose' in options) {
			this.autoclose = options.autoclose;
		} else if ('dateAutoclose' in this.element.data()) {
			this.autoclose = this.element.data('date-autoclose');
		}

		this.keyboardNavigation = true;
		if ('keyboardNavigation' in options) {
			this.keyboardNavigation = options.keyboardNavigation;
		} else if ('dateKeyboardNavigation' in this.element.data()) {
			this.keyboardNavigation = this.element.data('date-keyboard-navigation');
		}

		switch(options.startView || this.element.data('date-start-view')){
			case 2:
			case 'decade':
				this.viewMode = this.startViewMode = 2;
				break;
			case 1:
			case 'year':
				this.viewMode = this.startViewMode = 1;
				break;
			case 0:
			case 'month':
			default:
				this.viewMode = this.startViewMode = 0;
				break;
		}

		this.weekStart = ((options.weekStart||this.element.data('date-weekstart')||dates[this.language].weekStart||0) % 7);
		this.weekEnd = ((this.weekStart + 6) % 7);
		this.startDate = -Infinity;
		this.endDate = Infinity;
		this.setStartDate(options.startDate||this.element.data('date-startdate'));
		this.setEndDate(options.endDate||this.element.data('date-enddate'));
		this.fillDow();
		this.fillMonths();
		this.update();
		this.showMode();

        if(this.isInline) {
            this.show();
        }
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		show: function(e) {
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			this.update();
			this.place();
			$(window).on('resize', $.proxy(this.place, this));
			if (e ) {
				e.stopPropagation();
				e.preventDefault();
			}
			this.element.trigger({
				type: 'show',
				date: this.date
			});
		},

		hide: function(e){
            if(this.isInline) return;
			this.picker.hide();
			$(window).off('resize', this.place);
			this.viewMode = this.startViewMode;
			this.showMode();
			if (!this.isInput) {
				$(document).off('mousedown', this.hide);
			}
			if (e && e.currentTarget.value)
				this.setValue();
			this.element.trigger({
				type: 'hide',
				date: this.date
			});
		},

		setValue: function() {
			var formatted = this.getFormattedDate();
			if (!this.isInput) {
				if (this.component){
					this.element.find('input').prop('value', formatted);
				}
				this.element.data('date', formatted);
			} else {
				this.element.prop('value', formatted);
			}
		},

        getFormattedDate: function(format) {
            if(format == undefined) format = this.format;
            return DPGlobal.formatDate(this.date, format, this.language);
        },

		setStartDate: function(startDate){
			this.startDate = startDate||-Infinity;
			if (this.startDate !== -Infinity) {
				this.startDate = DPGlobal.parseDate(this.startDate, this.format, this.language);
			}
			this.update();
			this.updateNavArrows();
		},

		setEndDate: function(endDate){
			this.endDate = endDate||Infinity;
			if (this.endDate !== Infinity) {
				this.endDate = DPGlobal.parseDate(this.endDate, this.format, this.language);
			}
			this.update();
			this.updateNavArrows();
		},

		place: function(){
                        if(this.isInline) return;
			var zIndex = parseInt(this.element.parents().filter(function() {
							return $(this).css('z-index') != 'auto';
						}).first().css('z-index'))+10;
			var offset = this.component ? this.component.offset() : this.element.offset();
			this.picker.css({
				top: offset.top + this.height,
				left: offset.left,
				zIndex: zIndex
			});
		},

		update: function(){
            var date, fromArgs = false;
            if(arguments && arguments.length && (typeof arguments[0] === 'string' || arguments[0] instanceof Date)) {
                date = arguments[0];
                fromArgs = true;
            } else {
                date = this.isInput ? this.element.prop('value') : this.element.data('date') || this.element.find('input').prop('value');
            }

			this.date = DPGlobal.parseDate(date, this.format, this.language);

            if(fromArgs) this.setValue();

			if (this.date < this.startDate) {
				this.viewDate = new Date(this.startDate);
			} else if (this.date > this.endDate) {
				this.viewDate = new Date(this.endDate);
			} else {
				this.viewDate = new Date(this.date);
			}
			this.fill();
		},

		fillDow: function(){
			var dowCnt = this.weekStart;
			var html = '<tr>';
			while (dowCnt < this.weekStart + 7) {
				html += '<th class="dow">'+dates[this.language].daysMin[(dowCnt++)%7]+'</th>';
			}
			html += '</tr>';
			this.picker.find('.datepicker-days thead').append(html);
		},

		fillMonths: function(){
			var html = '';
			var i = 0
			while (i < 12) {
				html += '<span class="month">'+dates[this.language].monthsShort[i++]+'</span>';
			}
			this.picker.find('.datepicker-months td').html(html);
		},

		fill: function() {
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				startYear = this.startDate !== -Infinity ? this.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.startDate !== -Infinity ? this.startDate.getUTCMonth() : -Infinity,
				endYear = this.endDate !== Infinity ? this.endDate.getUTCFullYear() : Infinity,
				endMonth = this.endDate !== Infinity ? this.endDate.getUTCMonth() : Infinity,
				currentDate = this.date.valueOf();
			this.picker.find('.datepicker-days th:eq(1)')
						.text(dates[this.language].months[month]+' '+year);
			this.updateNavArrows();
			this.fillMonths();
			var prevMonth = UTCDate(year, month-1, 28,0,0,0,0),
				day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
			prevMonth.setUTCDate(day);
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.weekStart + 7)%7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var clsName;
			while(prevMonth.valueOf() < nextMonth) {
				if (prevMonth.getUTCDay() == this.weekStart) {
					html.push('<tr>');
				}
				clsName = '';
				if (prevMonth.getUTCFullYear() < year || (prevMonth.getUTCFullYear() == year && prevMonth.getUTCMonth() < month)) {
					clsName += ' old';
				} else if (prevMonth.getUTCFullYear() > year || (prevMonth.getUTCFullYear() == year && prevMonth.getUTCMonth() > month)) {
					clsName += ' new';
				}
				if (prevMonth.valueOf() == currentDate) {
					clsName += ' active';
				}
				if (prevMonth.valueOf() < this.startDate || prevMonth.valueOf() > this.endDate) {
					clsName += ' disabled';
				}
				html.push('<td class="day'+clsName+'">'+prevMonth.getUTCDate() + '</td>');
				if (prevMonth.getUTCDay() == this.weekEnd) {
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate()+1);
			}
			this.picker.find('.datepicker-days tbody').empty().append(html.join(''));
			var currentYear = this.date.getUTCFullYear();

			var months = this.picker.find('.datepicker-months')
						.find('th:eq(1)')
							.text(year)
							.end()
						.find('span').removeClass('active');
			if (currentYear == year) {
				months.eq(this.date.getUTCMonth()).addClass('active');
			}
			if (year < startYear || year > endYear) {
				months.addClass('disabled');
			}
			if (year == startYear) {
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year == endYear) {
				months.slice(endMonth+1).addClass('disabled');
			}

			html = '';
			year = parseInt(year/10, 10) * 10;
			var yearCont = this.picker.find('.datepicker-years')
								.find('th:eq(1)')
									.text(year + '-' + (year + 9))
									.end()
								.find('td');
			year -= 1;
			for (var i = -1; i < 11; i++) {
				html += '<span class="year'+(i == -1 || i == 10 ? ' old' : '')+(currentYear == year ? ' active' : '')+(year < startYear || year > endYear ? ' disabled' : '')+'">'+year+'</span>';
				year += 1;
			}
			yearCont.html(html);
		},

		updateNavArrows: function() {
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth();
			switch (this.viewMode) {
				case 0:
					if (this.startDate !== -Infinity && year <= this.startDate.getUTCFullYear() && month <= this.startDate.getUTCMonth()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.endDate !== Infinity && year >= this.endDate.getUTCFullYear() && month >= this.endDate.getUTCMonth()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 1:
				case 2:
					if (this.startDate !== -Infinity && year <= this.startDate.getUTCFullYear()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.endDate !== Infinity && year >= this.endDate.getUTCFullYear()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
			}
		},

		click: function(e) {
			e.stopPropagation();
			e.preventDefault();
			var target = $(e.target).closest('span, td, th');
			if (target.length == 1) {
				switch(target[0].nodeName.toLowerCase()) {
					case 'th':
						switch(target[0].className) {
							case 'switch':
								this.showMode(1);
								break;
							case 'prev':
							case 'next':
								var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className == 'prev' ? -1 : 1);
								switch(this.viewMode){
									case 0:
										this.viewDate = this.moveMonth(this.viewDate, dir);
										break;
									case 1:
									case 2:
										this.viewDate = this.moveYear(this.viewDate, dir);
										break;
								}
								this.fill();
								break;
						}
						break;
					case 'span':
						if (!target.is('.disabled')) {
							this.viewDate.setUTCDate(1);
							if (target.is('.month')) {
								var month = target.parent().find('span').index(target);
								this.viewDate.setUTCMonth(month);
								this.element.trigger({
									type: 'changeMonth',
									date: this.viewDate
								});
							} else {
								var year = parseInt(target.text(), 10)||0;
								this.viewDate.setUTCFullYear(year);
								this.element.trigger({
									type: 'changeYear',
									date: this.viewDate
								});
							}
							this.showMode(-1);
							this.fill();
						}
						break;
					case 'td':
						if (target.is('.day') && !target.is('.disabled')){
							var day = parseInt(target.text(), 10)||1;
							var year = this.viewDate.getUTCFullYear(),
								month = this.viewDate.getUTCMonth();
							if (target.is('.old')) {
								if (month == 0) {
									month = 11;
									year -= 1;
								} else {
									month -= 1;
								}
							} else if (target.is('.new')) {
								if (month == 11) {
									month = 0;
									year += 1;
								} else {
									month += 1;
								}
							}
							this.date = UTCDate(year, month, day,0,0,0,0);
							this.viewDate = UTCDate(year, month, day,0,0,0,0);
							this.fill();
							this.setValue();
							this.element.trigger({
								type: 'changeDate',
								date: this.date
							});
							var element;
							if (this.isInput) {
								element = this.element;
							} else if (this.component){
								element = this.element.find('input');
							}
							if (element) {
								element.change();
								if (this.autoclose) {
									this.hide();
								}
							}
						}
						break;
				}
			}
		},

		moveMonth: function(date, dir){
			if (!dir) return date;
			var new_date = new Date(date.valueOf()),
				day = new_date.getUTCDate(),
				month = new_date.getUTCMonth(),
				mag = Math.abs(dir),
				new_month, test;
			dir = dir > 0 ? 1 : -1;
			if (mag == 1){
				test = dir == -1
					// If going back one month, make sure month is not current month
					// (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
					? function(){ return new_date.getUTCMonth() == month; }
					// If going forward one month, make sure month is as expected
					// (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
					: function(){ return new_date.getUTCMonth() != new_month; };
				new_month = month + dir;
				new_date.setUTCMonth(new_month);
				// Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
				if (new_month < 0 || new_month > 11)
					new_month = (new_month + 12) % 12;
			} else {
				// For magnitudes >1, move one month at a time...
				for (var i=0; i<mag; i++)
					// ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
					new_date = this.moveMonth(new_date, dir);
				// ...then reset the day, keeping it in the new month
				new_month = new_date.getUTCMonth();
				new_date.setUTCDate(day);
				test = function(){ return new_month != new_date.getUTCMonth(); };
			}
			// Common date-resetting loop -- if date is beyond end of month, make it
			// end of month
			while (test()){
				new_date.setUTCDate(--day);
				new_date.setUTCMonth(new_month);
			}
			return new_date;
		},

		moveYear: function(date, dir){
			return this.moveMonth(date, dir*12);
		},

		dateWithinRange: function(date){
			return date >= this.startDate && date <= this.endDate;
		},

		keydown: function(e){
			if (this.picker.is(':not(:visible)')){
				if (e.keyCode == 27) // allow escape to hide and re-show picker
					this.show();
				return;
			}
			var dateChanged = false,
				dir, day, month,
				newDate, newViewDate;
			switch(e.keyCode){
				case 27: // escape
					this.hide();
					e.preventDefault();
					break;
				case 37: // left
				case 39: // right
					if (!this.keyboardNavigation) break;
					dir = e.keyCode == 37 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.date, dir);
						newViewDate = this.moveYear(this.viewDate, dir);
					} else if (e.shiftKey){
						newDate = this.moveMonth(this.date, dir);
						newViewDate = this.moveMonth(this.viewDate, dir);
					} else {
						newDate = new Date(this.date);
						newDate.setUTCDate(this.date.getUTCDate() + dir);
						newViewDate = new Date(this.viewDate);
						newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir);
					}
					if (this.dateWithinRange(newDate)){
						this.date = newDate;
						this.viewDate = newViewDate;
						this.setValue();
						this.update();
						e.preventDefault();
						dateChanged = true;
					}
					break;
				case 38: // up
				case 40: // down
					if (!this.keyboardNavigation) break;
					dir = e.keyCode == 38 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.date, dir);
						newViewDate = this.moveYear(this.viewDate, dir);
					} else if (e.shiftKey){
						newDate = this.moveMonth(this.date, dir);
						newViewDate = this.moveMonth(this.viewDate, dir);
					} else {
						newDate = new Date(this.date);
						newDate.setUTCDate(this.date.getUTCDate() + dir * 7);
						newViewDate = new Date(this.viewDate);
						newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir * 7);
					}
					if (this.dateWithinRange(newDate)){
						this.date = newDate;
						this.viewDate = newViewDate;
						this.setValue();
						this.update();
						e.preventDefault();
						dateChanged = true;
					}
					break;
				case 13: // enter
					this.hide();
					e.preventDefault();
					break;
				case 9: // tab
					this.hide();
					break;
			}
			if (dateChanged){
				this.element.trigger({
					type: 'changeDate',
					date: this.date
				});
				var element;
				if (this.isInput) {
					element = this.element;
				} else if (this.component){
					element = this.element.find('input');
				}
				if (element) {
					element.change();
				}
			}
		},

		showMode: function(dir) {
			if (dir) {
				this.viewMode = Math.max(0, Math.min(2, this.viewMode + dir));
			}
			this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).show();
			this.updateNavArrows();
		}
	};

	$.fn.datepicker = function ( option ) {
		var args = Array.apply(null, arguments);
		args.shift();
		return this.each(function () {
			var $this = $(this),
				data = $this.data('datepicker'),
				options = typeof option == 'object' && option;
			if (!data) {
				$this.data('datepicker', (data = new Datepicker(this, $.extend({}, $.fn.datepicker.defaults,options))));
			}
			if (typeof option == 'string' && typeof data[option] == 'function') {
				data[option].apply(data, args);
			}
		});
	};

	$.fn.datepicker.defaults = {
	};
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		}
	}

	var DPGlobal = {
		modes: [
			{
				clsName: 'days',
				navFnc: 'Month',
				navStep: 1
			},
			{
				clsName: 'months',
				navFnc: 'FullYear',
				navStep: 1
			},
			{
				clsName: 'years',
				navFnc: 'FullYear',
				navStep: 10
		}],
		isLeapYear: function (year) {
			return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0))
		},
		getDaysInMonth: function (year, month) {
			return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month]
		},
		validParts: /dd?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\[-`{-~\t\n\r]+/g,
		parseFormat: function(format){
			// IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
				parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length == 0){
				throw new Error("Invalid date format.");
			}
			return {separators: separators, parts: parts};
		},
		parseDate: function(date, format, language) {
			if (date instanceof Date) return date;
			if (/^[-+]\d+[dmwy]([\s,]+[-+]\d+[dmwy])*$/.test(date)) {
				var part_re = /([-+]\d+)([dmwy])/,
					parts = date.match(/([-+]\d+)([dmwy])/g),
					part, dir;
				date = new Date();
				for (var i=0; i<parts.length; i++) {
					part = part_re.exec(parts[i]);
					dir = parseInt(part[1]);
					switch(part[2]){
						case 'd':
							date.setUTCDate(date.getUTCDate() + dir);
							break;
						case 'm':
							date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
							break;
						case 'w':
							date.setUTCDate(date.getUTCDate() + dir * 7);
							break;
						case 'y':
							date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
							break;
					}
				}
				return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
			}
			var parts = date && date.match(this.nonpunctuation) || [],
				date = new Date(),
				parsed = {},
				setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
				setters_map = {
					yyyy: function(d,v){ return d.setUTCFullYear(v); },
					yy: function(d,v){ return d.setUTCFullYear(2000+v); },
					m: function(d,v){
						v -= 1;
						while (v<0) v += 12;
						v %= 12;
						d.setUTCMonth(v);
						while (d.getUTCMonth() != v)
							d.setUTCDate(d.getUTCDate()-1);
						return d;
					},
					d: function(d,v){ return d.setUTCDate(v); }
				},
				val, filtered, part;
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
			if (parts.length == format.parts.length) {
				for (var i=0, cnt = format.parts.length; i < cnt; i++) {
					val = parseInt(parts[i], 10);
					part = format.parts[i];
					if (isNaN(val)) {
						switch(part) {
							case 'MM':
								filtered = $(dates[language].months).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				for (var i=0, s; i<setters_order.length; i++){
					s = setters_order[i];
					if (s in parsed)
						setters_map[s](date, parsed[s])
				}
			}
			return date;
		},
		formatDate: function(date, format, language){
			var val = {
				d: date.getUTCDate(),
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			var date = [],
				seps = $.extend([], format.separators);
			for (var i=0, cnt = format.parts.length; i < cnt; i++) {
				if (seps.length)
					date.push(seps.shift())
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>'+
							'<tr>'+
								'<th class="prev"><i class="icon-arrow-left"/></th>'+
								'<th colspan="5" class="switch"></th>'+
								'<th class="next"><i class="icon-arrow-right"/></th>'+
							'</tr>'+
						'</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>'
	};
	DPGlobal.template = '<div class="edatepicker">'+
							'<div class="datepicker-days">'+
								'<table class=" table-condensed">'+
									DPGlobal.headTemplate+
									'<tbody></tbody>'+
								'</table>'+
							'</div>'+
							'<div class="datepicker-months">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-years">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
								'</table>'+
							'</div>'+
						'</div>';
                        
    $.fn.datepicker.DPGlobal = DPGlobal;
    
}( window.jQuery );
