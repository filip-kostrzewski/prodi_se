document.querySelectorAll('[data-mobile-menu]').forEach((menu) => {
    menu.addEventListener('click', (event) => {
        if (event.target.closest('a')) {
            menu.open = false;
        }
    });

    menu.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu.open) {
            menu.open = false;
            menu.querySelector('summary').focus();
        }
    });
});
