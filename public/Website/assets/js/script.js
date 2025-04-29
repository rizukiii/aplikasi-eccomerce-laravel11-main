
document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.zoom-thumbnail');
    const mainImage = document.getElementById('mainImage');
    const previewImage = document.getElementById('previewImage');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            mainImage.src = this.src;
        });
    });

    mainImage.addEventListener('click', function () {
        previewImage.src = this.src;
    });
});
