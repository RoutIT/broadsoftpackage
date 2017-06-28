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

## Configure laravel-mix
Add this line to webpack.mix.js in the root folder just below the first .js entry
```
.js('resources/assets/js/broadsoft.js', 'public/js')
```
## Install NPM tools required for laravel-mix
```
npm install && npm run dev
```

## Enter pusher details in the .env file
First u need to create an app on pusher.com\
After creating he app the needed credentials shown below will be available\
Dont forget to set the BROADCAST_DRIVER= to 'pusher'

```
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=app_id
PUSHER_APP_KEY=app_key
PUSHER_APP_SECRET=app_secret
```



## README.md
This file will continue to grow with features developt and implemented.