## アプリケーション情報
■ アプリケーション名<br />
・Atte

■ 概要<br />
・社員の勤怠管理を行うシステム<br />
&emsp;(社員の出勤状況と休憩状況を管理する)

■ トップ画像
![Alt text](image.png)


## 作成した目的
・仮企業の人事評価のため


## アプリケーションURL
ローカル環境で作成しています。<br />
[アプリ]<br />
&emsp;localhost/<br />
[phpMyAdmin]<br />
&emsp;localhost:8080<br />
[MailHog]<br />
&emsp;localhost:8025<br />


## 他のリポジトリ


## 機能一覧
・新規登録<br />
・メール認証<br />
・ログイン<br />
・勤務時間(勤務開始～勤務登録)<br />
・勤務時間内の休憩時間(休憩開始～休憩終了)の登録<br />
・日付別勤怠情報の取得<br />
・社員一覧情報の取得<br />
・社員別勤怠情報の取得<br />
・ログアウト


## 使用技術(実行環境)
■ 使用言語<br />
・HTML<br />
・CSS<br />
・JavaScript<br />
・PHP 8.2.7

■ 使用フレームワーク<br />
・Laravel Framework 8.83.27

■ 使用認証方法<br />
・Fortify

■ メール認証<br />
・MailHog


## テーブル設計
![Alt text](image-3.png)


## ER図
![Alt text](image-6.png)


## 画面遷移図
![Alt text](image-4.png)


## 環境構築
■ 開発環境<br />
・土台<br />
&emsp;Docker<br />
&emsp;LinuxOS<br />
・操作<br />
&emsp;ubuntu<br />
&emsp;VSCode<br />
・サーバー<br />
&emsp;nginx<br />
・データベース<br />
&emsp;mysql<br />
&emsp;phpMyAdmin<br />
・管理<br />
  Git<br />
&emsp;GitHub


■ ディレクトリ構成<br />
![Alt text](image-5.png)


## その他
■ ダミーデータ<br />
下記の内容で、seederファイルを登録しています。<br />
[内容]<br />
・名前　　　　　　：テスト一郎～テスト十郎<br />
・メールアドレス　：test1@example.com～test10@example.com<br />
・パスワード　　  　：test7777<br />
[件数]<br />
・ユーザーデータ　　　　　：10件<br />
・出勤データ、休憩データ　：各550件<br />

作成の際に(1)が必要です。(※のため)<br />
※attendancesレコード作成時に、user_idに固定数(1～10)を代入<br />
※restsレコード作成時に、attendance_idに固定数(1～550)を代入<br />
(1)php artisan migrate:fresh<br />
(2)php artisan db:seed

■ メール認証<br />
新規登録時には、メール認証を行っています。<br />
ローカル環境の為、MailHogを使用しています。<br />
新規登録で「メール送信済ページ」に遷移した際には、下記でメール確認をお願いします。<br />
http://localhost:8025<br />
※「社員情報の登録」を押して、メインページへ画面遷移します。

■ テスト実施<br />
・基本的なテスト(値のチェック)<br />
・アクセステスト(正しくアクセスできるかチェック)<br />
・データベーステスト(データベースへの値の挿入、データ存在チェック)<br />
