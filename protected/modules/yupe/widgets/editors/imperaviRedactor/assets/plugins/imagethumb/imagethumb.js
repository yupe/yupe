if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};

RedactorPlugins.imagethumb = {
    init: function () {
        this.buttonAdd('imagethumb', 'Картинка с превью', this.imagePreviewShow);
        this.buttonAwesome('imagethumb', 'fa-camera-retro');
        $.extend(this.opts,
            {
                modal_image_preview: String()
                    + '<section>'
                    + '<div id="redactor_tabs">'
                    + '<a href="#" id="redactor-tab-control-1" class="redactor_tabs_act">' + this.opts.curLang.upload + '</a>'
                    + '<a href="#" id="redactor-tab-control-2">' + this.opts.curLang.choose + '</a>'
                    + '</div>'
                    + '<div id="redactor-progress" class="redactor-progress-inline" style="display: none;"><span></span></div>'
                    + '<form id="redactorInsertImageForm" method="post" action="" enctype="multipart/form-data">'
                    + '<div id="redactor_tab1" class="redactor_tab">'
                    + '<input type="file" id="redactor_file" name="' + this.opts.imageUploadParam + '" />'
                    + '</div>'
                    + '<div id="redactor_tab2" class="redactor_tab" style="display: none;">'
                    + '<div id="redactor_image_box"></div>'
                    + '</div>'
                    + '</form>'
                    + '<div id="redactor_tab3" class="redactor_tab" style="display: none;">'
                    + '<label>' + this.opts.curLang.image_web_link + '</label>'
                    + '<input type="text" name="redactor_file_link" id="redactor_file_link" class="redactor_input"  /><br><br>'
                    + '</div>'
                    + '</section>'
                    + '<footer>'
                    + '<div style="width: 50%;"><button class="redactor_btn_modal_close">' + this.opts.curLang.cancel + '</button></div>'
                    + '<div style="width: 50%;"><button class="redactor_modal_action_btn" id="redactor_upload_btn">' + this.opts.curLang.insert + '</button></div>'
                    + '</footer>',
                modal_image_edit: String()
                    + '<section>'
                    + '<label>' + this.opts.curLang.title + '</label>'
                    + '<input id="redactor_file_alt" class="redactor_input" />'
                    + '<label>' + this.opts.curLang.link + '</label>'
                    + '<input id="redactor_file_link" class="redactor_input" />'
                    + '<label><input type="checkbox" id="redactor_link_blank"> ' + this.opts.curLang.link_new_tab + '</label>'
                    + '<label>' + this.opts.curLang.image_position + '</label>'
                    + '<select id="redactor_form_image_align">'
                    + '<option value="none">' + this.opts.curLang.none + '</option>'
                    + '<option value="left">' + this.opts.curLang.left + '</option>'
                    + '<option value="center">' + this.opts.curLang.center + '</option>'
                    + '<option value="right">' + this.opts.curLang.right + '</option>'
                    + '</select>'
                    + '<label>' + 'Класс изображения' + '</label>'
                    + '<input id="redactor_form_image_class" class="redactor_input" />'
                    + '</section>'
                    + '<footer>'
                    + '<div style="width: 33%;"><button class="redactor_modal_delete_btn" id="redactor_image_delete_btn">' + this.opts.curLang._delete + '</button></div>'
                    + '<div style="width: 33%;"><button class="redactor_btn_modal_close">' + this.opts.curLang.cancel + '</button></div>'
                    + '<div style="width: 34%;"><button class="redactor_modal_action_btn" id="redactorSaveBtn">' + this.opts.curLang.save + '</button></div>'
                    + '</footer>'
            });
    },
    imagePreviewShow: function(){
        this.selectionSave();

        var callback = $.proxy(function()
        {
            // json
            if (this.opts.imageGetJson)
            {
                $.getJSON(this.opts.imageGetJson, $.proxy(function(data)
                {
                    var folders = {}, count = 0;

                    // folders
                    $.each(data, $.proxy(function(key, val)
                    {
                        if (typeof val.folder !== 'undefined')
                        {
                            count++;
                            folders[val.folder] = count;
                        }

                    }, this));

                    var folderclass = false;
                    $.each(data, $.proxy(function(key, val)
                    {
                        // title
                        var thumbtitle = '';
                        if (typeof val.title !== 'undefined') thumbtitle = val.title;

                        var folderkey = 0;
                        if (!$.isEmptyObject(folders) && typeof val.folder !== 'undefined')
                        {
                            folderkey = folders[val.folder];
                            if (folderclass === false) folderclass = '.redactorfolder' + folderkey;
                        }

                        var img = $('<img src="' + val.thumb + '" class="redactorfolder redactorfolder' + folderkey + '" rel="' + val.image + '" title="' + thumbtitle + '" />');
                        $('#redactor_image_box').append(img);
                        $(img).click($.proxy(this.imagePreviewThumbClick, this));

                    }, this));

                    // folders
                    if (!$.isEmptyObject(folders))
                    {
                        $('.redactorfolder').hide();
                        $(folderclass).show();

                        var onchangeFunc = function(e)
                        {
                            $('.redactorfolder').hide();
                            $('.redactorfolder' + $(e.target).val()).show();
                        };

                        var select = $('<select id="redactor_image_box_select">');
                        $.each( folders, function(k, v)
                        {
                            select.append( $('<option value="' + v + '">' + k + '</option>'));
                        });

                        $('#redactor_image_box').before(select);
                        select.change(onchangeFunc);
                    }
                }, this));

            }
            else
            {
                $('#redactor-modal-tab-2').remove();
            }

            if (this.opts.imageUpload || this.opts.s3)
            {
                // dragupload
                if (!this.isMobile()  && !this.isIPad() && this.opts.s3 === false)
                {
                    if ($('#redactor_file' ).length)
                    {
                        this.draguploadInit('#redactor_file', {
                            url: this.opts.imageUpload,
                            uploadFields: this.opts.uploadFields,
                            success: $.proxy(this.imagePreviewCallback, this),
                            error: $.proxy(function(obj, json)
                            {
                                this.callback('imageUploadError', json);

                            }, this),
                            uploadParam: this.opts.imageUploadParam
                        });
                    }
                }

                if (this.opts.s3 === false)
                {
                    // ajax upload
                    this.uploadInit('redactor_file', {
                        auto: true,
                        url: this.opts.imageUpload,
                        success: $.proxy(this.imagePreviewCallback, this),
                        error: $.proxy(function(obj, json)
                        {
                            this.callback('imageUploadError', json);

                        }, this)
                    });
                }
                // s3 upload
                else
                {
                    $('#redactor_file').on('change.redactor', $.proxy(this.s3handleFileSelect, this));
                }

            }
            else
            {
                $('.redactor_tab').hide();
                if (!this.opts.imageGetJson)
                {
                    $('#redactor_tabs').remove();
                    $('#redactor_tab3').show();
                }
                else
                {
                    $('#redactor-modal-tab-1').remove();
                    $('#redactor-modal-tab-2').addClass('redactor_tabs_act');
                    $('#redactor_tab2').show();
                }
            }

            if (!this.opts.imageTabLink && (this.opts.imageUpload || this.opts.imageGetJson))
            {
                $('#redactor-tab-control-3').hide();
            }

            $('#redactor_upload_btn').click($.proxy(this.imageCallbackLink, this));

            if (!this.opts.imageUpload && !this.opts.imageGetJson)
            {
                setTimeout(function()
                {
                    $('#redactor_file_link').focus();

                }, 200);
            }

        }, this);

        this.modalInit(this.opts.curLang.image, this.opts.modal_image_preview, 610, callback);
    },
    imageEdit: function (image) {
        var $el = image;
        var parent = $el.parent().parent();

        var callback = $.proxy(function () {
            $('#redactor_file_alt').val($el.attr('alt'));
            $('#redactor_image_edit_src').attr('href', $el.attr('src'));
            $('#redactor_form_image_class').val($el.attr('class'));

            if ($el.css('display') == 'block' && $el.css('float') == 'none') {
                $('#redactor_form_image_align').val('center');
            }
            else {
                $('#redactor_form_image_align').val($el.css('float'));
            }

            if ($(parent).get(0).tagName === 'A') {
                $('#redactor_file_link').val($(parent).attr('href'));

                if ($(parent).attr('target') == '_blank') {
                    $('#redactor_link_blank').prop('checked', true);
                }
            }

            $('#redactor_image_delete_btn').click($.proxy(function () {
                this.imageRemove($el);

            }, this));

            $('#redactorSaveBtn').click($.proxy(function () {
                this.imageSave($el);

            }, this));

        }, this);

        this.modalInit(this.opts.curLang.edit, this.opts.modal_image_edit, 380, callback);

    },
    imageSave: function (el) {
        var $el = $(el);
        var parent = $el.parent();

        $el.attr('alt', $('#redactor_file_alt').val());
        $el.attr('class', $('#redactor_form_image_class').val());

        var floating = $('#redactor_form_image_align').val();
        var margin = '';

        this.imageResizeHide(false);

        if (floating === 'left') {
            margin = '0 ' + this.opts.imageFloatMargin + ' ' + this.opts.imageFloatMargin + ' 0';
            $el.css({ 'float': 'left', 'margin': margin });
        }
        else if (floating === 'right') {
            margin = '0 0 ' + this.opts.imageFloatMargin + ' ' + this.opts.imageFloatMargin + '';
            $el.css({ 'float': 'right', 'margin': margin });
        }
        else if (floating === 'center') {
            $el.css({ 'float': '', 'display': 'block', 'margin': 'auto' });
        }
        else {
            $el.css({ 'float': '', 'display': '', 'margin': '' });
        }

        // as link
        var link = $.trim($('#redactor_file_link').val());
        if (link !== '') {
            var target = false;
            if ($('#redactor_link_blank').prop('checked')) {
                target = true;
            }

            if (parent.get(0).tagName !== 'A') {
                var a = $('<a href="' + link + '">' + this.outerHtml(el) + '</a>');

                if (target) {
                    a.attr('target', '_blank');
                }

                $el.replaceWith(a);
            }
            else {
                parent.attr('href', link);
                if (target) {
                    parent.attr('target', '_blank');
                }
                else {
                    parent.removeAttr('target');
                }
            }
        }
        else {
            if (parent.get(0).tagName === 'A') {
                parent.replaceWith(this.outerHtml(el));
            }
        }

        this.modalClose();
        this.observeImages();
        this.sync();

    },
    imagePreviewCallback: function(data)
    {
        this.insertImageWithPreview(data);
    },
    imagePreviewThumbClick: function (e) {
        var img = '<img id="image-marker" src="' + $(e.target).attr('rel') + '" alt="' + $(e.target).attr('title') + '" />';

        var parent = this.getParent();
        if (this.opts.paragraphy && $(parent).closest('li').size() == 0) img = '<p>' + img + '</p>';
        this.insertImageWithPreview({thumb: $(e.target).attr('src'), filelink: $(e.target).attr('rel')});

    },
    insertImageWithPreview: function (img) {
        this.selectionRestore();

        if (img !== false) {
            var html = '';
            html = '<a class="gallery" href="' + img.filelink + '"> <img id="image-marker" src="' + img.thumb + '" /></a>';
            var parent = this.getParent();
            if (this.opts.paragraphy && $(parent).closest('li').size() == 0) {
                html = '<p>' + html + '</p>';
            }

            this.execCommand('inserthtml', html, false);

            var image = $(this.$editor.find('img#image-marker'));

            if (image.length) image.removeAttr('id');
            else image = false;

            this.sync();
        }

        this.modalClose();
        this.observeImages();
    }
};
