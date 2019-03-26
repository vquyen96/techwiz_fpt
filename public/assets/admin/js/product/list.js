(function ($) {

    'use strict';

    $(function () {
        $('.table').DataTable({
            deferRender: true,
            paging: false,
            info: false,
            searching: false,
            columnDefs: [
                { 'targets': [0], 'searchable': false, 'orderable': false, 'visible': true },
                { 'targets': [7], 'searchable': false, 'orderable': false, 'visible': true },
                { 'targets': [5], 'searchable': false, 'orderable': false, 'visible': true }
            ],
            order: [
                [4, 'desc']
            ]
        });
    });

})(jQuery);
