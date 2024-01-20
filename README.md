## laravel dijon

##　ダウンロード方法

    git clone

    git clone https://github.com/kitam936/laravel_dijon.git

    git clone ブランチを指定してダウンロードする場合
    git clone -b ブランチ名 https://github.com/kitam936/laravel_dijon.git

    もしくはSSHでpullしてください
 

    cd lalavel_dijon
    composer install
    npm install
    npm run dev

    .env.exampleをコピーして.envファイルを作成

    .envファイルの中の下記をご利用の環境に合わせて変更してください

      APP_NAME=Dijon_Web
　    APP_ENV=production　　　　
　    APP_KEY=
　    APP_DEBUG=false
　    APP_URL=https://dijon1988.net

　    DB_CONNECTION=mysql
　    DB_HOST=127.0.0.1
　    DB_PORT=3306
　    DB_DATABASE=xs877338_dijon
　    DB_USERNAME=xs877338_kitam
　    DB_PASSWORD=mito145147

　    FILESYSTEM_DISK=public

    XAMPP/MAMPまたは他の開発環境でDBを起動した後に

    php artisan migrate:fresh 

    と実行してください。

    データベーステーブルが追加されればOK

    最後に

    php artisan key:genarate

    と入力してキーを生成

    php artisan strage:link
    
    画像管理はstorage/app/public/public/reportsを設定
    


##　インストール後の実施事項

画像のダミーデータは
public/imagesフォルダに
sample1.jpg ～　sample6.jpg として
保存しています。

php artisan storage:link で
storageフォルダにリンク後
storage/app/public//public/**** フォルダに保存すると
表示されます。
（フォルダがない場合は作成してください）

レイアウトは微調整が必要になる場合があります

Viewの"Admin" を "admin"　に名前の変更をしてください





##  section8の補足
メールのテストしてmailtrapを利用しています。
必要な場合は.envにmailtrapの情報を追記してください。

メール処理に時間がっかるのでキューを使用しています。

必要な場合はphp artisan queue:workで
ワーカーを立ち上げて動作確認してください。
