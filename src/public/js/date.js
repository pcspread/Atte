// 各レコードのホバー時の処理
function hoverRec() {
    const records = document.querySelectorAll('.date-row');

    records.forEach(record => {
        // 該当レコードを変色
        record.addEventListener('mouseover', function () {
            if (this !== records[0]) {
                this.style.backgroundColor = '#CCC';
            }
        });

        record.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#EEE';
        });
    });
}
hoverRec();