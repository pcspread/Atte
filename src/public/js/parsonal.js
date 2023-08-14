// 「休憩時間」のホバー時の処理
function restHover() {
    const restCaption = document.querySelector('.rest-caption');
    const captionContent = document.querySelector('.caption-content');
    const restTime = document.querySelectorAll('.parsonal-row__content.rest-time');

    // 「説明」を表示
    restCaption.addEventListener('mouseover', function () {
        this.style.cursor = 'pointer';
        captionContent.style.display = 'block';
    });

    // 「説明」を非表示
    restCaption.addEventListener('mouseleave', function () {
        captionContent.style.display = 'none';
    });
}
restHover();

// 各レコードのホバー時の処理
function hoverRec() {
    const tableRows = document.querySelectorAll('.parsonal-row');

    tableRows.forEach(content => {
        // 該当レコードを変色
        content.addEventListener('mouseover', function () {
            this.style.cursor = 'pointer';
            this.style.backgroundColor = '#60CCAA';
            if (this.firstElementChild.textContent !== '日付') {
                this.firstElementChild.style.backgroundColor = '#60CCAA';
            }
        });
        content.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#EEE';
            this.firstElementChild.style.backgroundColor = '#BBBBFF';
        });
    });
}
hoverRec();

// 各レコードの「休憩詳細」を表示
function detailDisp() {
    const restTime = document.querySelectorAll('.rest-time');

    restTime.forEach(item => {
        // 「休憩詳細」を表示
        item.addEventListener('mouseover', function () {
            this.lastElementChild.style.display = 'block';
        });

        // 「休憩詳細」を非表示
        item.addEventListener('mouseleave', function () {
            this.lastElementChild.style.display = 'none';
        });
    });
}
detailDisp();