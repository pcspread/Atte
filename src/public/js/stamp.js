/**
 * 「勤務状況」のボタンを押した時の処理
 */
function attendance() {
    // DOM要素の取得
    // 「勤務開始ボタン」
    const startBtn = document.querySelector('.stamp-item__start');
    // 「勤務終了ボタン」
    const endBtn = document.querySelector('.stamp-item__end');
    // 「休憩開始ボタン」
    const breakBtn = document.querySelector('.stamp-item__break');
    // 「休憩終了ボタン」
    const restartBtn = document.querySelector('.stamp-item__restart');


    // 「勤務開始ボタン」について
    if (startBtn.getAttribute('type') === 'submit') {
        // submitの場合：初期状態(ページにアクセスした時)
        endBtn.style.pointerEvents = 'none';
        endBtn.style.color = '#DDD';
        breakBtn.style.pointerEvents = 'none';
        breakBtn.style.color = '#DDD';
        restartBtn.style.pointerEvents = 'none';
        restartBtn.style.color = '#DDD';
    } else {
        // buttonの場合：「勤務開始ボタン」を押した時
        startBtn.style.color = '#DDD';
        startBtn.style.pointerEvents = 'none';
        restartBtn.style.pointerEvents = 'none';
        restartBtn.style.color = '#DDD';
        endBtn.setAttribute('type', 'submit');
    }

    // 「休憩開始ボタン」を押した後の処理
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
