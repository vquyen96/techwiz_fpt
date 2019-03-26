$('.table').DataTable({
    deferRender: true,
    paging: false,
    info: false,
    searching: false,
    columnDefs: [
        { 'targets': [3], 'searchable': false, 'orderable': false, 'visible': true },
    ],
    order: [
        [2, 'desc']
    ]
});