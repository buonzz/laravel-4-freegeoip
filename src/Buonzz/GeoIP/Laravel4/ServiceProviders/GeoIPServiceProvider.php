<?php namespace Buonzz\GeoIP\Laravel4\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Buonzz\GeoIP\GeoIP as GeoIP;

/**
*  Binds the GeoIP class to the IoC container.
*
*  This makes it possible for Laravel to find the GeoIP in the App object
*  like App::make('GeoIP');
*  the same binding is also used by facade to resolve the class
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