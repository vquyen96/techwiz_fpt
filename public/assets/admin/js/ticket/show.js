
$(document).ready(function() {
    $('.changeImg').click(function () {
        $(this).prev().click();
    });
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
});

function changeImg(input)
{
    console.log(input);
    var inputFile = $(this);
    //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        //Sự kiện file đã được load vào website
        reader.onload = function(e) {
            //Thay đổi đường dẫn ảnh
            // $('#avatar').attr('src',e.target.result);
            $(input).next().attr('src',e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
