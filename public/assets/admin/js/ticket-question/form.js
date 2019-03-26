$(document).ready(function () {
    $("#form_ticket_question").validate({
        rules: {
            "title_en": {
                required: true,
            },
            "title_ja": {
                required: true,
            },
            "description": {
                required: true,
            }
        }
    });
});