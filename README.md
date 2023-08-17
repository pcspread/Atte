# アプリケーション情報
■ アプリケーション名
・Atte

■ 概要
・社員の勤怠管理を行うシステム
    (社員の出勤状況と休憩状況を管理する)

■ トップ画像
![Alt text](image.png)


## 作成した目的
・仮企業の人事評価のため


## アプリケーションURL


## 他のリポジトリ


## 機能一覧
・新規登録
・ログイン
・勤務時間(勤務開始～勤務登録)
・勤務時間内の休憩時間(休憩開始～休憩終了)の登録
・日付別勤怠情報の取得
・社員一覧情報の取得
・社員別勤怠情報の取得
・ログアウト


## 使用技術(実行環境)
■ 使用言語
・HTML
・CSS
・JavaScript
・PHP 8.2.7

■ 使用フレームワーク
・Laravel Framework 8.83.27

■ 使用認証方法
・Fortify


## テーブル設計
![Alt text](image-3.png)


## ER図
![Alt text](image-1.png)


## 環境構築
■ 開発環境
    Dockerを使用

■ ファイル構成
Atte
├── docker
│   ├── mysql
│   │   ├── data
│   │   └── my.cnf
│   ├── nginx
│   │   └── default.conf
│   └── php
│       ├── Dockerfile
│       └── php.ini
├── docker-compose.yml
├── src
└── README.md

■ ダミーデータ再作成コマンド
・下記のため、(1)が必要
※attendancesレコード作成時に、user_idに固定数(1～10)を代入
※restsレコード作成時に、attendance_idに固定数(1～550)を代入
(1)php artisan migrate:fresh
(2)php artisan db:seed


## その他
■ テストログイン用ユーザーデータ
・名前　　　　　　：test
・メールアドレス　：test@text.com
・パスワード　　  ：test1111

■ その他、下記ダミーデータを登録済
・ユーザーデータ　　　　　：10件
・出勤データ、休憩データ　：各550件
