/**
 * 各レコードをマウスオーバーした時の処理
 */
function hoverRec() {
    const records = document.querySelectorAll('.date-row');

    records.forEach(record => {
        // マウスオーバーされたレコードを変色
        record.addEventListener('mouseover', function () {
            if (this !== records[0]) {
                this.style.backgroundColor = '#CCC';
            }
        });

        // マウスリーブされたレコードの色を戻す
        record.addEventListener('mouseleave', function () {
            this.style.backgroundColor = '#EEE';
        });
    });
}
hoverRec();