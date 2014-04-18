<?php namespace Buonzz\GeoIP\Laravel4\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Buonzz\GeoIP\GeoIP as GeoIP;

/**
*  The Laravel4 Service provider to bing your class to the IoC container
*
*  This makes it possible for Laravel to find your classes in the App object
*  like App::make('YourClass');
*  
*/
class GeoIPServiceProvider extends ServiceProvider{
	/**
	* Bind the class to IoC container
	*  @return GeoIP;
	*/
	public function register(){
		$this->app->bind('geoip', function(){
			return new GeoIP;
		});
	}
}