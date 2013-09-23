/**
 * Фильтр таблиц с классом table-filtered
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */

;(function($)
{
    $(function()
    {
        $('table.table-filtered').each(function()
        {
            var
                table = this, value = '',
                input = $('<input type="search" placeholder="Search">');

            input.keyup(function()
            {
                if ($(this).val() === value) return;
                value = $(this).val();
                if (value) {
                    $(table).find('tbody tr:not(:Contains("' + value + '"))').hide();
                    $(table).find('tbody tr:Contains("' + value + '")').show();
                } else {
                    $(table).find('tbody tr').show();
                }
            });

            $('<div class="input-append pull-right">')
                .append(input)
                .append($('<span class="add-on"><i class="icon-search"></i></span>'))
                .insertBefore(table);
        });
    });

    $.expr[':'].Contains = function(a, i, m)
    {
        return $(a).text().toLowerCase().indexOf(m[3].toLowerCase()) >= 0;
    };
})(jQuery);
