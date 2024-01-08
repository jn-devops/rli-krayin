### 1. Introduction:



### 2. Requirements:
* **Bagisto**: v1.5.0 or higher.

Install Depenedance
~~~
composer require spatie/laravel-webhook-client
~~~

~~~
composer require spatie/laravel-webhook-server
~~~

### 3. Installation:

* Unzip the respective extension zip and then merge "packages" and "storage" folders into project root directory.
* Goto config/app.php file and add following line under 'providers'

~~~
Webkul\BagistoConnector\Providers\BagistoConnectorServiceProvider::class,
~~~

* Goto composer.json file and add following line under 'psr-4'

~~~
"Webkul\\BagistoConnector\\": "packages/Webkul/BagistoConnector/src"
~~~

* Run these commands below to complete the setup

~~~
composer dump-autoload
~~~

~~~
php artisan route:cache
~~~

~~~
php artisan migration
~~~

~~~
php artisan vendor:publish

-> Press 0 and then press enter to publish all assets and configurations.
~~~

## Add in .env

WEBHOOK_CLIENT_SECRET=krayin123
WEBHOOK_SERVER_URL=
WEBHOOK_SERVER_SECRET=krayin123

## Modify Product Modal

Add index into fillable property

`'api_entity_id', 'api_entity_source_type_id'`


## MOdify Product Controller in update method

add this line `Event::dispatch('bagisto.catalog.product.update.after', $product);` after this line `Event::dispatch('product.update.after', $product);`

# Webhook Docs

A webhook is a way for an app to provide information to another app about a particular event. The way the two apps communicate is with a simple HTTP request.

## Authorization Process

When setting up, it's common to generate, store, and share a secret between your app and the app that wants to receive webhooks.

~~~php
$data = 'X-Krayin-Bagisto-Signature'; 
$secret = 'krayin123';

$signature = hash_hmac('sha256', $data, $secret);
~~~

## Headers

For development purposes we are giving direct hash but in production we should compute.

~~~headers
X-Krayin-Bagisto-Signature : 83bdbbc385f0d59aa2b944305e598789d54aa8103136a657644c1e6934dde8f8
Accept            : application/json
~~~

