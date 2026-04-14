# 模擬案件＿勤怠管理アプリ

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:WakitaToshiyuki/pretest3.git
2. cd pretest3
3. DockerDesktopアプリを立ち上げる
4. `docker-compose up -d --build`

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. Doctrine DBAL のインストール
``` bash
composer require doctrine/dbal
```

7. マイグレーションの実行
``` bash
php artisan migrate
```

8. シーディングの実行
``` bash
php artisan db:seed
```

9. Docker コンテナに入る
``` bash
docker exec -it <コンテナ名> bash
```

10. コンテナ内で権限を修正
``` bash
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/vendor
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache  
```

※ 開発環境で Permission denied が出る場合は以下を実行してください
docker exec -it pretest-php-1 bash
cd /var/www
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

## 使用技術(実行環境)
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

## テーブル設計
スプレッドシートに記載

## ER図
スプレッドシートに記載

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
