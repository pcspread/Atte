// ハンバーガーメニューの設定
function burger() {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-list');

    burger.addEventListener('click', function () {
        this.classList.toggle('rotate');
        nav.classList.toggle('toggle');
    });
}
burger();

// navのログアウトボタンのhover時の設定
function logoutColor() {
    const nav = document.querySelectorAll('.nav-item');
    const logout = document.querySelector('.nav-item__logout-form button')

    nav[2].addEventListener('mouseover', function () {
        if (innerWidth < 480) {
            logout.style.backgroundColor = '#DDD';
        }
    });
    nav[2].addEventListener('mouseleave', function () {
        if (innerWidth < 480) {
            logout.style.backgroundColor = '#FFF';
        }
    });
}
logoutColor();