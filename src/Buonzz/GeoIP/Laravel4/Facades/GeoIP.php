<?php namespace Buonzz\GeoIP\Laravel4\Facades;

use Illuminate\Support\Facades\Facade;

/**
*  Facade class for the GeoIP.
*
*  Use this to provide a facade for Laravel Application
*
*  @author Darwin Biler <buonzz@gmail.com>
*/
class GeoIP extends Facade{
   /**
   *  method to be called to return the "real" class, since facade is just a syntax sugar.
   *  Note that the geoip is lowercase, since that is what we had registered in the ServiceProvider
   *
   *  @return mixed the class name we had registered in the serviceprovider
   */
   protected static function getFacadeAccessor(){ return 'geoip';}
}