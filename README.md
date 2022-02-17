# ResidentInsure
[![php-8.0](https://img.shields.io/badge/php->=8.0-blue)](https://www.php.net/ChangeLog-8.php#8.0.0)
[![composer-2.2.6](https://img.shields.io/badge/composer->=2.2.6-pink)](https://github.com/composer/composer/releases/tag/2.2.6)
[![slim-4.9](https://img.shields.io/badge/slim-4.9-purple)](https://github.com/slimphp/Slim/tree/4.9.0)

A sample application to use slim framework with bref/serverless as microservice

## Local Development Steps to follow

- PHP: Make sure your system supports PHP>=8.0

[**Laravel Homestead**](https://laravel.com/docs/9.x/homestead#installation-and-setup) have built all releases in PHP 8.1 - 7.0

- Install the dependecies
```bash
composer install
```

- Serverless: Install serverless as standalone binary
```bash
curl -o- -L https://slss.io/install | bash
```

- Start the server
```bash
./sandbox/bref-dev-server -g172.28.128.14 -p3000
```

- Install DynamoDB locally

[**AWS Document**](https://docs.aws.amazon.com/amazondynamodb/latest/developerguide/DynamoDBLocal.DownloadingAndRunning.html) for complete installation and execution

## Access the URL on postman
# POST
```bash
http://172.28.128.14:3000/quote/date
http://172.28.128.14:3000/quote/time
http://172.28.128.14:3000/quote/all
```
# GET
```bash
http://172.28.128.14:3000/quote/search
```
