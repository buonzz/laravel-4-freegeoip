FreeGeoIP for Laravel 4 
=======================

[![Build Status](https://travis-ci.org/buonzz/laravel-4-freegeoip.svg?branch=master)](https://travis-ci.org/buonzz/laravel-4-freegeoip)
[![Latest Stable Version](https://poser.pugx.org/buonzz/laravel-4-freegeoip/v/stable.svg)](https://packagist.org/packages/buonzz/laravel-4-freegeoip) [![Total Downloads](https://poser.pugx.org/buonzz/laravel-4-freegeoip/downloads.svg)](https://packagist.org/packages/buonzz/laravel-4-freegeoip)
[![Latest Unstable Version](https://poser.pugx.org/buonzz/laravel-4-freegeoip/v/unstable.svg)](https://packagist.org/packages/buonzz/laravel-4-freegeoip) [![License](https://poser.pugx.org/buonzz/laravel-4-freegeoip/license.svg)](https://packagist.org/packages/buonzz/laravel-4-freegeoip)

Laravel 4 Library for calling http://freegeoip.net/ API.

In contrary to all other packages wherein it requires that you have the geoip database in your filesystem, this library calls a free service
So you dont really have to worry about downloading and maintaining geoip data from Maxmind in your own server.

Just install the package, add the config and it is ready to use!


Requirements
============

* PHP >= 5.3.7
* cURL Extension

Installation
============

    composer require buonzz/laravel-4-freegeoip:dev-master

Add the service provider and facade in your config/app.php

Service Provider

    Buonzz\GeoIP\Laravel4\ServiceProviders\GeoIPServiceProvider

Facade

    'GeoIP'            => 'Buonzz\GeoIP\Laravel4\Facades\GeoIP',

Configuration
============

This library supports optional configuration.

To get started, first publish the package config file:

```bash
$ php artisan config:publish buonzz/laravel-4-freegeoip
```

- `freegeopipURL`: defines the URL of the FreeGeoIP API. Use HTTPS or not. Default to `http://www.freegeoip.net/json/`.
- `timeout`: defines the timeout when calling the FreeGeoIP API (in seconds). Default to 30.


Usage
=====


Get country of the visitor

    GeoIP::getCountry();  // returns "United States"
    
Get country code of the visitor

    GeoIP::getCountryCode();  // returns "US"

Get region of the visitor

    GeoIP::getRegion();  // returns "New York"

Get region code of the visitor

    GeoIP::getRegionCode();  // returns "NY"

Get city of the visitor

    GeoIP::getCity();  // returns "Buffalo"

Get zip code of the visitor

    GeoIP::getZipCode();  // returns "14221"
    
Get latitude of the visitor

    GeoIP::getLatitude();  // returns "42.9864"

Get longitude of the visitor

    GeoIP::getLongitude();  // returns "-78.7279"

Get metro code of the visitor

    GeoIP::getMetroCode();  // returns "514"

Get area code of the visitor

    GeoIP::getAreaCode();  // returns "716"


Credits
=======

* Alexandre Fiori for the awesome http://freegeoip.net web api
* MaxMind for the data



