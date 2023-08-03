// ログアウト画面で、ナビバーを非表示にする
function displayNone() {
    const nav = document.querySelector('.header-nav');
    const burger = document.querySelector('.burger');

    if (location.pathname === '/logout') {
        nav.style.display = 'none';
        burger.style.display = 'none';
    }
}
displayNone();