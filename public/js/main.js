document.addEventListener('DOMContentLoaded', function () {
    const burgerMenu = document.querySelector('.burger-toggler');
    const navbar = document.querySelector('.navbar');

    burgerMenu.addEventListener('click', function () {
        navbar.classList.toggle('active');
    });
});