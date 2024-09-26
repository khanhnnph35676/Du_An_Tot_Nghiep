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
