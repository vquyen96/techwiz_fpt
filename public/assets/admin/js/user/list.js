(function ($) {

    'use strict';

    $(function () {
        $('#user-table').DataTable({
            deferRender: true,
            paging: false,
            info: false,
            searching: false,
            columnDefs: [
                { 'targets': [6], 'searchable': false, 'orderable': false, 'visible': true },
            ],
            order: [
                [3, 'desc']
            ]
        });
    });

})(jQuery);
