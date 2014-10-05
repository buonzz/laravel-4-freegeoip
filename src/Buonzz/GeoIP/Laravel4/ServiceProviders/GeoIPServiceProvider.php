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

	public function boot()
	{
		$this->package('buonzz/laravel-4-freegeoip', null, __DIR__.'/../../../..');
	}
	
	/**
	* Bind the class to IoC container
	*/
	public function register(){
		$this->app->bind('geoip', function($app) {
			
			// Inject configuration variables into the constructor
			$config = [];

			foreach (['freegeoipURL', 'timeout'] as $value)
				$config[$value] = $app['config']->get('laravel-4-freegeoip::'.$value);

			return new GeoIP($config);
		});
	}
}