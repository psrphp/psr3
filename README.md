# psr3

php psr3的简单实现

## 安装

``` bash
composer require psrphp/psr3
```

## 用例

``` php
$logger = new \PsrPHP\Psr3\LocalLogger(__DIR__);
$logger->log($level, $message, $context);
$logger->log('alert', '这是一个警告');
```
