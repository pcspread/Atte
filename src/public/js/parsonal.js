// 「休憩詳細」表示の説明
function restCaption() {
    const restCaption = document.querySelector('.rest-caption');
    const captionContent = document.querySelector('.caption-content');

    restCaption.addEventListener('mouseover', function () {
        this.style.cursor = 'pointer';
        captionContent.style.display = 'block';
    });

    restCaption.addEventListener('mouseleave', function () {
        captionContent.style.display = 'none';
    });
}
restCaption();

// 「休憩詳細」の表示処理
function detailDisp() {
    const restTime = document.querySelectorAll('.rest-time');

    restTime.forEach(item => {
        // 「休憩時間」をマウスオーバー時
        item.addEventListener('mouseover', function () {
            this.style.cursor = 'pointer';
            this.style.backgroundColor = '#60FFAA';
            this.lastElementChild.style.display = 'block';
        });
        // 「休憩時間」からマウスリーブ時
        item.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#EEE';
            this.lastElementChild.style.display = 'none';
        });
    });
}
detailDisp();