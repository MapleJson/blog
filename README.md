# blog

### 环境要求

#### PHP环境
- PHP >= 7.1.3
- PHP OpenSSL 扩展
- PHP Event 扩展
- PHP Redis 扩展
- PHP Mbstring 扩展
- PHP Tokenizer 扩展
- PHP XML 扩展
根据不同的环境安装方法，可依据实际调试情况安装以下扩展：
- PHP MYSQL 扩展
- PHP PDO 扩展

#### Nginx环境
- nginx >= 1.0.0

#### Mysql
- MySql >= 5.7

### 安装

```

git clone https://github.com/MapleJson/blog.git

cd blog

composer install

```

### 配置

```

cp .env.example .env

vim .env {填写配置}

php artisan key:generate

```

### 迁移数据库

```

mysql> create database `demo_blog`;

mysql> use `demo_blog`;

mysql> source storage/mysql_dump/demo_blog.sql

```

### 运行

```

php artisan serve

```

[访问<http://127.0.0.1:8000>](http://127.0.0.1:8000)