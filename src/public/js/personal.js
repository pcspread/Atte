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
        restTime.forEach(rest => {
            rest.style.color = '#300AFF';
        });
    });

    // 「説明」を非表示
    restCaption.addEventListener('mouseleave', function () {
        captionContent.style.display = 'none';
        restTime.forEach(rest => {
            rest.style.color = '#000';
        });
    });
}
restHover();


/**
 * 各レコードをマウスオーバーした時の処理
 */
function hoverRec() {
    const tableRows = document.querySelectorAll('.personal-row');

    tableRows.forEach(content => {
        // マウスオーバーされたレコードを変色
        content.addEventListener('mouseover', function () {
            this.style.backgroundColor = '#CCC';
            if (this.children[0].textContent !== '日付') {
                this.children[0].style.backgroundColor = '#CCC';
            }
        });

        // マウスリーブされたレコードの色を戻す
        content.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#EEE';
            if (this.children[0].textContent.indexOf('(土)') > -1) {
                this.children[0].style.backgroundColor = '#7777FF';
            } else if (this.children[0].textContent.indexOf('(日)') > -1) {
                this.children[0].style.backgroundColor = '#FF7777';
            } else {
                this.children[0].style.backgroundColor = '#BBBBFF';
            }
        });
    });
}
hoverRec();


/**
 * 各レコードの「休憩時間」をマウスオーバーした時の処理
 */
function detailDisp() {
    const restTime = document.querySelectorAll('.personal-row__content.rest-time');

    restTime.forEach(item => {
        // 「休憩詳細」を表示
        item.addEventListener('mouseover', function () {
            if (this.textContent !== '') {
                this.style.color = '#300AFF';
                this.lastElementChild.style.display = 'block';
                this.style.cursor = 'help';
            }
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
    const days = document.querySelectorAll('.personal-row__content.day');

    days.forEach(day => {
        if (day.textContent.indexOf('(土)') > -1) {
            day.style.backgroundColor = '#7777FF';
        }
        if (day.textContent.indexOf('(日)') > -1) {
            day.style.backgroundColor = '#FF7777';
        }
    });
}
colorHoliday();