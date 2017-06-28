# Broadsoft package
Broadsoft package for laravel  5.4

## To install this  package use:
```bash
composer require jvleeuwen/broadsoft:"dev-master"
```
\* This installs the latest development release and is not ready for production usage !

Add the serviceProvider to your config/app.php
```php
jvleeuwen\broadsoft\BroadsoftServiceProvider::class,
```

Add this line to webpack.mix.js in the root folder just below the first .js entry
```
.js('resources/assets/js/broadsoft.js', 'public/js')
```

## README.md
This file will continue to grow with features developt and implemented.