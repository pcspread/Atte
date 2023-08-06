// ページネーションをクリック時に変色させる
function changeColor() {
    // 表示されているページリンク要素を取得
    const nation = document.querySelector('.page-item.active .page-link');

    // スタイルの変更
    nation.style.backgroundColor = '#289ADC';
    nation.style.color = '#FFF';
}
changeColor();