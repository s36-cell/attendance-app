■ アプリ概要


本アプリは、一般ユーザーが勤怠を記録し、修正申請を行い、

管理者がその申請を承認することができる勤怠管理システムです。

■ 主な機能


▼ 一般ユーザー
会員登録 / ログイン

勤怠登録（出勤・退勤）

勤怠一覧表示（月別）

勤怠詳細表示

勤怠修正申請

修正申請一覧（承認待ち / 承認済み）



▼ 管理者
管理者ログイン

勤怠一覧（全ユーザー）

スタッフ一覧

スタッフ別勤怠一覧

修正申請一覧

修正申請承認

◽️URL一覧
▼一般ユーザー
機能/URL
ログイン
/login
会員登録
/register
勤怠登録
/attendance
勤怠一覧
/attendance/list
勤怠詳細
/attendance/detail/{id}
申請一覧
/stamp_correction_request/list

▼管理者
機能/URL
ログイン
/admin/login
勤怠一覧
/admin/attendance/list
スタッフ一覧
/admin/staff/list
スタッフ別勤怠
/admin/attendance/staff/{id}
申請一覧
/admin/stamp_correction_request/list
◽️使用技術
・Laravel 10
・PHP
・MySQL
・Docker
・Blade
・CSS

◽️環境構築
①リポジトリをクローン
        git clone git@github.com:s36-cell/attendance-app.git
        cd attendance-app
②Docker起動
        docker compose up -d --build
③コンテナに入る
        docker compose exec php bash
④Laravel初期設定
composer install
cp .env.example .env
php artisan key:generate
⑤DB設定
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
⑥マイグレーション
php artisan migrate
⑦アクセス
http://localhost
