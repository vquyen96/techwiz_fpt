$(document).ready(function () {
    $("#form_game").validate({
        rules: {
            "slug": {
                required: true,
            },
            "title_en": {
                required: true,
            },
            "title_ja": {
                required: true,
            },
            "description_en": {
                required: true,
            },
            "description_ja": {
                required: true,
            }
        }
    });
});