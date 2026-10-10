// Galeri produk: klik thumbnail untuk mengganti gambar utama.
document.querySelectorAll('[data-gallery]').forEach((gallery) => {
    const main = gallery.querySelector('[data-gallery-main]');
    const thumbs = gallery.querySelectorAll('[data-gallery-thumb]');

    thumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            main.src = thumb.dataset.galleryThumb;
            thumbs.forEach((t) => t.classList.replace('border-noir-900', 'border-transparent'));
            thumb.classList.replace('border-transparent', 'border-noir-900');
        });
    });
});
