
const sidebar = document.querySelector('.sidebar');
const btnMobileMenu = document.querySelector('#mobile-menu');
const btnCloseMenu = document.querySelector('#cerrar-menu');

if(btnMobileMenu) {
    btnMobileMenu.addEventListener('click', function () {
        sidebar.classList.add('show');     
    })
}

if(btnCloseMenu) {
    btnCloseMenu.addEventListener('click', function () {
        sidebar.classList.add('hide');
        setTimeout(() => {
            sidebar.classList.remove('show');
            sidebar.classList.remove('hide');
        }, 500); //el mismo tiempo que en el transition-duration de CSS
    })
}

//Elimnar la clase show cuando la pantalla sea mayor o igual a 768px
window.addEventListener('resize', function () {
    const widthScreen = document.body.clientWidth;
    if(widthScreen >=768) {
        sidebar.classList.remove('show');
    }
});
