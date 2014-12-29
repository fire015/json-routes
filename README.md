json-routes
===========

[![Total Downloads](https://img.shields.io/packagist/dm/fire015/json-routes.svg)](https://packagist.org/packages/fire015/json-routes)
[![Build Status](https://travis-ci.org/fire015/json-routes.svg?branch=master)](https://travis-ci.org/fire015/json-routes)

Define your routes in Laravel using JSON files.

## Installation

[PHP](https://php.net) 5.4+, [Laravel](http://laravel.com) 4.2+, and [Composer](https://getcomposer.org) are required.

To get the latest version of JSON Routes, simply add the following line to the require block of your `composer.json` file:

```
"fire015/json-routes": "~1.0"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Once JSON Routes is installed, you need to register the service provider. Open up `app/config/app.php` and add the following to the `providers` key.

`'Fire015\JsonRoutes\JsonRoutesServiceProvider'`

## Configuration

To get started, first publish the package config file:

```bash
$ php artisan config:publish fire015/json-routes
```

This will create a config file which allows you to define the path to the JSON files (by default this is a folder within `app/config` called `routes`).

## Usage

Presuming we have created the `app/config/routes` folder as specified above, create a file in that folder called `routes.json` where we can define our routes. Here is an example of that file:

```
{
	"GET": {
		"/": {
			"uses": "HomeController@showIndex"
		},
		"about": {
			"uses": "AboutController@showIndex"
		}
	},
	"POST": {
		"user/{id}": {
			"uses": "UserController@storeUser"
		}
	}
}
```

You simply define the route URI as the key under each method and the usual route options as if it were an array in the `Route::(get|post|put|patch|delete|options)` static methods.

You can also split your routes up into sub-files and folders. For example you can define `user/account` in `app/config/routes/user.json` or `app/config/routes/user/routes.json` or `app/config/routes/user/account/routes.json` (no limit on recursion).
