/**
 * 「社員名」をクリックした時の処理
 */
function listAppend() {
    const name = document.querySelector('.information-name__main');
    const list = document.querySelector('.information-name__list');

    // 社員名リスト表示
    name.addEventListener('click', function () {
        this.classList.toggle('transparent');
        list.classList.toggle('append');
    });
}
listAppend();


/**
 * 「休憩時間※」をマウスオーバーした時の処理
 */
function restHover() {
    const restCaption = document.querySelector('.rest-caption');
    const captionContent = document.querySelector('.caption-content');
    const restTime = document.querySelectorAll('.personal-row__content.rest-time');

    // 「説明」を表示
    restCaption.addEventListener('mouseover', function () {
        this.style.cursor = 'help';
        captionContent.style.display = 'block';
    });

    // 「説明」を非表示
    restCaption.addEventListener('mouseleave', function () {
        captionContent.style.display = 'none';
    });
}
restHover();


/**
 * 各レコードをマウスオーバーした時の処理
 */
function hoverRec() {
    const tableRows = document.querySelectorAll('.personal-row');
    const restTime = document.querySelectorAll('.personal-row__content rest-time');

    tableRows.forEach(content => {
        // マウスオーバーされたレコードを変色
        content.addEventListener('mouseover', function () {
            this.style.backgroundColor = '#60CCAA';
            if (this.firstElementChild.textContent !== '日付') {
                this.firstElementChild.style.backgroundColor = '#60CCAA';
            }
        });

        // マウスリーブされたレコードの色を戻す
        content.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#EEE';
            this.firstElementChild.style.backgroundColor = '#BBBBFF';
        });
    });
}
hoverRec();


/**
 * 各レコードの「休憩時間」をマウスオーバーした時の処理
 */
function detailDisp() {
    const restTime = document.querySelectorAll('.rest-time');

    restTime.forEach(item => {
        // 「休憩詳細」を表示
        item.addEventListener('mouseover', function () {
            this.style.cursor = 'help';
            this.style.color = '#FFF';
            this.lastElementChild.style.display = 'block';
        });

        // 「休憩詳細」を非表示
        item.addEventListener('mouseleave', function () {
            this.style.color = '#000';
            this.lastElementChild.style.display = 'none';
        });
    });
}
detailDisp();


/**
 * 土日の行を変色する
 */
function colorHoliday() {
    const days = document.querySelectorAll('#day');

    // let date = new Date();
    // let week = date.getDay();
    // let weekStr = ['日', '月', '火', '水', '木', '金', '土'];

    const pattern1 = /^['土']$/;
    const pattern2 = /^['日']$/;
    days.forEach(day => {
        if (this.textContent.match(pattern1) || this.textContent.match(pattern2)) {
            day.style.color = "#FF0000";
        }
    });
}
colorHoliday();