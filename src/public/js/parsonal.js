// 「休憩時間」ホバー時の処理
function restCaption() {
    const restCaption = document.querySelector('.rest-caption');
    const captionContent = document.querySelector('.caption-content');
    const restTime = document.querySelectorAll('.parsonal-row__content.rest-time');

    // 「説明」を表示
    restCaption.addEventListener('mouseover', function () {
        this.style.cursor = 'pointer';
        captionContent.style.display = 'block';
        restTime.forEach(item => {
            item.style.backgroundColor = '#60FFAA';
        });
    });

    // 「説明」を非表示
    restCaption.addEventListener('mouseleave', function () {
        captionContent.style.display = 'none';
        restTime.forEach(item => {
            item.style.backgroundColor = '#EEE';
        });
    });
}
restCaption();

// 各レコードの「休憩詳細」を表示
function detailDisp() {
    const restTime = document.querySelectorAll('.rest-time');

    restTime.forEach(item => {
        // 「休憩詳細」を表示
        item.addEventListener('mouseover', function () {
            this.style.cursor = 'pointer';
            this.style.backgroundColor = '#60FFAA';
            this.lastElementChild.style.display = 'block';
        });

        // 「休憩詳細」を非表示
        item.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#EEE';
            this.lastElementChild.style.display = 'none';
        });
    });
}
detailDisp();