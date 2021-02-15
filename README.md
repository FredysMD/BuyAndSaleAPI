<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## RestFul API - BuyAndSale

BuyAndSale is a RestFul API built with Laravel version 8.x. BuyAnd is app what allow the buy and sale of products.

## Artisan CLI used

* php artisan serve (start server)
* php artisan make:controller Model (create controller)
* php artisan make:controller Model -r (create controller with default route).
* php artisan migrate:reset (reset table of database)
* php artisan migrate:refresh --seed (empty table and automatic full).
* php artisan route:list (view all routes)

## Routes

Routes of app sort by Models.

**Buyer**

* api/buyers -> (All buyers registered). (GET)
* api/buyers/{id} -> (A buyer by id) (GET)
* api/buyers/{id}/transactions -> (All transactions by buyer). (GET)
* api/buyers/{id}/products -> (All products purchased by a buyer). (GET)
* api/buyers/{id}/sellers -> (All sellers by a buyer). (GET)
* api/buyers/{id}/categories -> (All categories purchased by a buyer). (GET)

**Category**

* api/categories ->(All categories). (GET)
* api/categories/{id} -> (A category by id). (GET)
* api/categories/{id}/products -> (All products a by category).
* api/categories/{id}/sellers -> (All sellers a by category).
* api/categories/{id}/transactions-> (All transactions a by category).
* api/categories/{id}/buyers-> (All buyers a by category).


The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
