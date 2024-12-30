document.getElementById('upload-button').addEventListener('click', function () {
    const form = document.getElementById('upload-form');
    const formData = new FormData(form);
    const uploadButton = this;

    uploadButton.disabled = true;
    uploadButton.innerHTML = '<i class="bx bx-loader bx-spin"></i> Uploading...';

    const imageInput = document.getElementById('image');
    if (imageInput.files.length === 0) {
        alert('Silakan pilih gambar terlebih dahulu!');
        resetUploadButton();
        return;
    }

    fetch('/upload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);

            resetForm();
        } else {
            alert(data.message || 'Gambar gagal diupload!');
        }
    })
    .catch(error => {
        console.error("Error uploading image:", error);
        alert('Terjadi kesalahan saat mengupload gambar.');
    })
    .finally(() => {
        resetUploadButton();
    });

    function resetForm() {
        form.reset();
        
        const preview = document.getElementById('preview');
        preview.src = '';
        preview.style.display = 'none';
        
        document.querySelector('.image-area .icon').style.display = 'block';
        document.querySelector('.image-area h3').style.display = 'block';
    }

    function resetUploadButton() {
        uploadButton.disabled = false;
        uploadButton.innerHTML = '<i class="bx bx-send"></i> Submit';
    }
});

