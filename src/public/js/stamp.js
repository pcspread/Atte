// 「勤務状況」のボタンを押した時の処理
function attendance() {
    // DOM要素の取得
    const startBtn = document.querySelector('.stamp-item__start');
    const endBtn = document.querySelector('.stamp-item__end');
    const breakBtn = document.querySelector('.stamp-item__break');
    const restartBtn = document.querySelector('.stamp-item__restart');


    // 「勤務開始」のtype属性について
    if (startBtn.getAttribute('type') === 'button') {
        // buttonの場合
        startBtn.style.color = '#DDD';
        startBtn.style.pointerEvents = 'none';
        restartBtn.style.pointerEvents = 'none';
        restartBtn.style.color = '#DDD';
        endBtn.setAttribute('type', 'submit');
    } else {
        // submitの場合：初期状態(初回アクセス時)
        endBtn.style.pointerEvents = 'none';
        endBtn.style.color = '#DDD';
        breakBtn.style.pointerEvents = 'none';
        breakBtn.style.color = '#DDD';
        restartBtn.style.pointerEvents = 'none';
        restartBtn.style.color = '#DDD';
    }

    // 「休憩開始」のtype属性がbuttonだった時
    if (breakBtn.getAttribute('type') === 'button') {
        breakBtn.style.color = '#DDD';
        breakBtn.style.pointerEvents = 'none';
        endBtn.style.pointerEvents = 'none';
        endBtn.style.color = '#DDD';
        restartBtn.style.pointerEvents = 'auto';
        restartBtn.style.color = '#000';
    }
}
attendance();
