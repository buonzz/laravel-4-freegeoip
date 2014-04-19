FreeGeoIP for Laravel 4 
===================

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



