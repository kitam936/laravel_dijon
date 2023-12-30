## laravel dijon

##　ダウンロード方法

    git clone

    git clone https://github.com/kitam936/laravel_dijon.git

    git clone ブランチを指定してダウンロードする場合
    git clone -b ブランチ名 https://github.com/kitam936/laravel_dijon.git

    もしくはzipファイルでダウンロードしてください
 

    cd lalavel_dijon
    composer install
    npm install
    npm run dev

    .env.exampleをコピーして.envファイルを作成

    .envファイルの中の下記をご利用の環境に合わせて変更してください

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_dijon
    DB_USERNAME=root
    DB_PASSWORD=N*5csb7nn-yZx735

    XAMPP/MAMPまたは他の開発環境でDBを起動した後に

    php artisan migrate:fresh --seed

    と実行してください。

    データベーステーブルとダミーデータが追加されればOK

    最後に

    php artisan key:genarate

    と入力してキーを生成後

    php artisan serveで簡易サーバーを立ち上げ表示確認してください。
    


##　インストール後の実施事項

画像のダミーデータは
public/imagesフォルダに
sample1.jpg ～　sample6.jpg として
保存しています。

php artisan storage:link で
storageフォルダにリンク後
storage/app/public/products フォルダに保存すると
表示されます。
（productsフォルダがない場合は作成してください）

ショップの画像も表示する場合は
storage/app/public/shops フォルダを作成し
画像を保存してください。




##  section8の補足
メールのテストしてmailtrapを利用しています。
必要な場合は.envにmailtrapの情報を追記してください。

メール処理に時間がっかるのでキューを使用しています。

必要な場合はphp artisan queue:workで
ワーカーを立ち上げて動作確認してください。
