$('#notification-table').DataTable({
    deferRender: true,
    paging: false,
    info: false,
    searching: false,
    columnDefs: [
        { 'targets': [0], 'searchable': false, 'orderable': false, 'visible': true },
        { 'targets': [4], 'searchable': false, 'orderable': false, 'visible': true },
    ],
    order: false
});
