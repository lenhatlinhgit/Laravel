function toggleMenu() {
        const menu = document.querySelector('.nav__main');
        menu.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    }

    document.querySelectorAll('.dropdown-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.parentElement.classList.toggle('active');
        });
    });