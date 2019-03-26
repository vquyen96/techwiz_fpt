(function ($) {

    'use strict';

    $(function () {
        $('.user-product-table').DataTable({
            deferRender: true,
            columnDefs: [
                { 'targets': [4], 'searchable': false, 'orderable': false, 'visible': true },
            ],
            'order': [
                [1, 'desc']
            ]
        });
    });

})(jQuery);


$(document).ready(function () {
    $('.form-horizontal').submit(function (e) {

        var name = $(this).find('input[name="name"]');
        var tel = $(this).find('input[name="tel"]');
        var description = $(this).find('textarea[name="description"]');
        var error = 0;
        $(".error").remove();

        if (name.val().length < 1) {
            name.after('<span class="error">This field is required</span>');
            error++;
        }
        if (tel.val().length < 1) {
            tel.after('<span class="error">This field is required</span>');
            error++;
        }
        if (description.text().length < 1) {
            description.after('<span class="error">This field is required</span>');
            error++;
        }

        if (error != 0) {
            e.preventDefault();
        }
    });
});
