(function ($) {

    'use strict';

    $(function () {
        $('.table').DataTable({
            deferRender: true,
            paging: false,
            info: false,
            searching: false,
            columnDefs: [
                { 'targets': [4], 'searchable': false, 'orderable': false, 'visible': true },
            ],
            order: [
                [3, 'desc']
            ]
        });
    });

})(jQuery);