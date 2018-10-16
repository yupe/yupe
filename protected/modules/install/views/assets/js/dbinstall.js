jQuery(document).ready(function ($) {

    var dbType = $('#InstallForm_dbType').val();
    var dbTypeName = dbTypes[dbType].toLocaleLowerCase();

    /**
     * Проходим по списку необходимых к отключаению полей:
     */
    $.map($('.' + dbTypeName + '-disable'), function (item) {
        $(item).hide();
    });

    /**
     * Проходим по списку необходимых к включению полей:
     */
    $.map($('.' + dbTypeName + '-enable'), function (item) {
        $(item).show();
    });

    $(document).on('change', '#InstallForm_dbType', function () {
        var dbType = $(this).val();
        var dbTypeName = dbTypes[dbType].toLocaleLowerCase();

        /**
         * Проходим по списку необходимых к отключаению полей:
         */
        $.map($('.' + dbTypeName + '-disable'), function (item) {
            $(item).hide();
        });

        /**
         * Проходим по списку необходимых к включению полей:
         */
        $.map($('.' + dbTypeName + '-enable'), function (item) {
            $(item).show();
        });

        /**
         * Проходим по списку и устанавливаем нужные значения:
         */
        $.map(defaultAttr[dbTypeName], function (val, key) {
            $('#InstallForm_' + key).val(val);
        });
    });
});