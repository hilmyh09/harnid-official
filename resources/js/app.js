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

// Menu samping (drawer).
const drawer = document.querySelector('[data-drawer]');
if (drawer) {
    const openButtons = document.querySelectorAll('[data-drawer-open]');
    const setOpen = (open) => {
        drawer.hidden = !open;
        drawer.classList.toggle('hidden', !open);
        document.body.classList.toggle('overflow-hidden', open);
        openButtons.forEach((b) => b.setAttribute('aria-expanded', String(open)));
        if (open) drawer.querySelector('[data-drawer-close]')?.focus();
    };
    openButtons.forEach((b) => b.addEventListener('click', () => setOpen(true)));
    drawer.querySelectorAll('[data-drawer-close]').forEach((el) => el.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !drawer.hidden) setOpen(false); });
}
