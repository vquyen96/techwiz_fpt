$(document).ready(function () {
    $("#form_category").validate({
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