# 测试驱动开发（TDD）学习项目
## 目的
用来学习 TDD
## 参考
- [TDD构建 Laravel 论坛笔记](https://learnku.com/docs/forum-in-laravel-tdd/1-initialization-database/1633)
## 安装
### 配置 .env 文件
```angular2html
APP_NAME=tdd
.
.
APP_URL=http://tdd.test
.
.
DB_DATABASE=tdd
```
运行命令
```
 $ composer install
 $ php artisan key:generate
 $ php artisan migrate --seed
```
 
