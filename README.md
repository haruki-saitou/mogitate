# mogitate  
## 環境構築  
### Dockerビルド  
・git clone git@github.com:haruki-saitou/mogitate.git  
・docker compose up -d --build  
### laravel環境構築  
・docker compose exec php bash  
・composer install  
・cp .env.example .env 、環境変数を適宣変更  
・php artisan key:generate  
・php artisan migrate  
・php artisan db:seed  
## 開発環境  
・商品一覧画面  
・商品詳細画面  
・商品登録画面  
## 使用技術(実行環境)  
・Laravel 8.83.29  
・PHP 8.1.33  
・nginx 1.21.1  
・MySQL 8.0.44  
・jquery 3.7.1  
## ER図
![ER図](assets/er_diagram.png)
