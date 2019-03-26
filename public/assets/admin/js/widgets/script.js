$(document).ready(function () {
    $('#change_password_form').submit(function (e) {

        var old_password = $(this).find('input[name="old_password"]');
        var password = $(this).find('input[name="password"]');
        var password_confirmation = $(this).find('input[name="password_confirmation"]');
        var error = 0;
        $(".error").remove();

        if (old_password.val().length < 1) {
            old_password.siblings('.bar').after('<span class="error">This field is required</span>');
            error++;
        }
        if (password.val().length < 1) {
            password.siblings('.bar').after('<span class="error">This field is required</span>');
            error++;
        }
        if (password_confirmation.val().length < 1) {
            password_confirmation.siblings('.bar').after('<span class="error">This field is required</span>');
            error++;
        }
        if (old_password.val().length < 8 && old_password.val().length >0 ) {
            old_password.siblings('.bar').after('<span class="error">Old Password must be at least 8 characters long</span>');
            error++;
        }
        if (password.val().length < 8 && password.val().length > 0) {
            password.siblings('.bar').after('<span class="error">Password must be at least 8 characters long</span>');
            error++;
        }
        if (password.val() != password_confirmation.val() && password_confirmation.val() > 0) {
            password_confirmation.siblings('.bar').after('<span class="error">Password confirmation not match</span>');
            error++;
        }

        if (error != 0) {
            e.preventDefault();
        }
    });
});