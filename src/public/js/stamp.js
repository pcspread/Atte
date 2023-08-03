// 「勤務状況」のボタンを押した時の処理
function attendance() {
    // DOM要素の取得
    const startBtn = document.querySelector('.stamp-item__start');
    const breakBtn = document.querySelector('.stamp-item__break');
    const restartBtn = document.querySelector('.stamp-item__restart');
    const endBtn = document.querySelector('.stamp-item__end');

    // 「勤務開始」のtype属性について
    if (startBtn.getAttribute('type') === 'button') {
        // buttonの場合
        startBtn.style.color = '#DDD';
        startBtn.style.pointerEvents = 'none';
        restartBtn.style.pointerEvents = 'none';
        endBtn.setAttribute('type', 'submit');
    } else {
        // submitの場合：初期状態(初回アクセス時)
        endBtn.style.pointerEvents = 'none';
        breakBtn.style.pointerEvents = 'none';
        restartBtn.style.pointerEvents = 'none';
    }

    // 「休憩開始」のtype属性がbuttonだった時
    if (breakBtn.getAttribute('type') === 'button') {
        breakBtn.style.color = '#DDD';
        breakBtn.style.pointerEvents = 'none';
        endBtn.style.pointerEvents = 'none';
        restartBtn.style.pointerEvents = 'auto';
    }
}
attendance();
