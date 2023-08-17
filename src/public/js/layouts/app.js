/**
 * ハンバーガーメニューの設定
 */
function burger() {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-list');

    // ハンバーガーメニューとナビリストの開閉
    burger.addEventListener('click', function () {
        this.classList.toggle('rotate');
        nav.classList.toggle('toggle');
    });
}
burger();


/**
 * ナビの「ログアウトボタン」をマウスオーバーした時の処理
 */
function logoutColor() {
    const nav = document.querySelectorAll('.nav-item');
    const logout = document.querySelector('.nav-link__button')

    // 「ログアウトボタン」の色を変色
    nav[3].addEventListener('mouseover', function () {
        if (innerWidth < 599) {
            logout.style.backgroundColor = '#DDD';
        }
    });

    // 「ログアウトボタン」の色を戻す
    nav[3].addEventListener('mouseleave', function () {
        if (innerWidth < 599) {
            logout.style.backgroundColor = '#FFF';
        }
    });
}
logoutColor();


/**
 * 画面をスクロールした時の処理
 */
function upper() {
    const upper = document.querySelector('.upper');

    // アッパー(上方移動)ボタンを出現させる
    window.addEventListener('scroll', function () {
        if (window.scrollY > 0) {
            upper.style.display = 'block';
        } else {
            upper.style.display = 'none';
        }
    });
}
upper();