/*
 * jQuery liTranslit v 1.0
 * http://
 *
 * Copyright 2012, Linnik Yura
 * Free to use
 * 
 * August 2012
 */
jQuery.fn.liTranslit = function (options) {
    // настройки по умолчанию
    var o = jQuery.extend({
        elName: '.s_name',		//Класс елемента с именем
        elAlias: '.s_alias'		//Класс елемента с алиасом
    }, options);
    return this.each(function () {
        var elName = $(this).find(o.elName),
            elAlias = $(this).find(o.elAlias),
            nameVal ,
            disableLiveEdit = false;

        if (elAlias.val().length > 0)
            disableLiveEdit = true;

        elAlias.focusout(function () {
            if (elAlias.val().length > 0)
                disableLiveEdit = true;
            else
                disableLiveEdit = false;
            tr(elName);
        });

        function tr(el) {
            nameVal = el.val();
            if (!disableLiveEdit) inser_trans(get_trans(nameVal));
        };
        elName.keyup(function () {
            tr($(this));
        });
        tr(elName);
        function get_trans() {
            en_to_ru = {
                'а': 'a',
                'б': 'b',
                'в': 'v',
                'г': 'g',
                'д': 'd',
                'е': 'e',
                'ё': 'jo',
                'ж': 'zh',
                'з': 'z',
                'и': 'i',
                'й': 'j',
                'к': 'k',
                'л': 'l',
                'м': 'm',
                'н': 'n',
                'о': 'o',
                'п': 'p',
                'р': 'r',
                'с': 's',
                'т': 't',
                'у': 'u',
                'ф': 'f',
                'х': 'h',
                'ц': 'c',
                'ч': 'ch',
                'ш': 'sh',
                'щ': 'sch',
                'ъ': '#',
                'ы': 'y',
                'ь': '',
                'э': 'je',
                'ю': 'ju',
                'я': 'ja',
                ' ': '-',
                'і': 'i',
                'ї': 'i'
            };
            nameVal = nameVal.toLowerCase();
            nameVal = trim(nameVal);
            nameVal = nameVal.split("");
            var trans = new String();
            for (i = 0; i < nameVal.length; i++) {
                for (key in en_to_ru) {
                    val = en_to_ru[key];
                    if (key == nameVal[i]) {
                        trans += val;
                        break
                    } else if (key == "ї") {
                        trans += nameVal[i]
                    }
                    ;
                }
                ;
            }
            ;
            return trans;
        }

        function inser_trans(result) {
            elAlias.val(result);
        }

        function trim(string) {
            string = string.replace(/'|"|<|>|\!|\||@|#|$|%|^|&|\*|\(\)|-|\|\/|;|\+|№|,|\?|:|{|}|\[|\]/g, "");
            string = string.replace(/\./g, "_");
            string = string.replace(/(^\s+)|(\s+$)/g, "");
            return string;
        };
    });
};