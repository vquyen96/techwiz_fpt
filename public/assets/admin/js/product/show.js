(function ($) {

    'use strict';

    $(document).on('click', '[data-lightbox]', lity);

})(jQuery);
$('input, textarea').keyup(function () {
    $(':button[type="submit"]').prop('disabled', false);
})

$(document).ready(function () {
    $("#form_edit_product").validate({
        rules: {
            "title": {
                required: true,
            },
            "buy_now_price": {
                required: true,
            },
            "description": {
                required: true,
            }
        }
    });
});