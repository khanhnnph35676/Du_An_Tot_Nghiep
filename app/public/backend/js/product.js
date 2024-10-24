document.getElementById('imageUpload').onchange = function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = reader.result;
        imagePreview.style.display = 'block';

        // Hiển thị nút xóa
        document.getElementById('removeImage').style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
};

document.getElementById('removeImage').onclick = function() {
    // Xóa ảnh và ẩn nút xóa
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('imageUpload').value = '';
    document.getElementById('removeImage').style.display = 'none';
};


// css js upload anh
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.image-upload-wrap').hide();

            $('.file-upload-image').attr('src', e.target.result);
            $('.file-upload-content').show();

            $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();

    // Nếu có hình ảnh từ cơ sở dữ liệu, nó sẽ hiện lại
    if ($('.file-upload-image').attr('src') !== '#') {
        $('.file-upload-content').show();
    }
}

$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});
