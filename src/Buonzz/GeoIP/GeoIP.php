<?php namespace Buonzz\GeoIP;

/**
*  Contains all the method to retrieve data from freegeoip.net.
*
*  This contains the geoip data as well all the marshalling mechanism from 
*  the web service.
*
*  @author Darwin Biler <buonzz@gmail.com>
*/
class GeoIP{


  /**  @var mixed $geoip_data  contains the JSON object retrieved from the API */
  private $geoip_data = NULL;

  /**  @var string $ip contains the IP of the current visitor */
  private $ip;


  /**
  * constructor which initialiazes various things.
  *
  * detects if the REMOTE_ADDR is present (usually not, when running in cli or phpunit)
  * if present use that one.
  *
  * @return void
  */
  public function __construct(){
      if(isset($_SERVER['REMOTE_ADDR']))
          $this->ip = $_SERVER['REMOTE_ADDR'];
          
      // Check if an override for the current ip exists
      $overrides = \Config::get('laravel-4-freegeoip::overrides');
      if(isset($this->ip, $overrides))$this->ip = $overrides[$this->ip];
  }

  /**
  * allows the user to set the IP to be process instead of retrieving it from server.
  *
  * @return void
  */
  public function setIP($ip){
    $this->ip = $ip;
  }

  /**
  * get the descriptive name of the country.
  *
  * @return string
  */
  public function getCountry(){
			return $this->getItem('country_name');
   }

  /**
  * get the 2-letter code  of the country.
  *
  * @return string
  */
  public function getCountryCode(){
      return $this->getItem('country_code');
   }

  /**
  * get the region code.
  *
  * @return string
  */
  public function getRegionCode(){
      return $this->getItem('region_code');
   }

  /**
  * get the descriptive name of the region.
  *
  * @return string
  */
   public function getRegion(){
       return $this->getItem('region_name');
   }

  /**
  * get the descriptive name of the City.
  *
  * @return string
  */
  public function getCity(){
       return $this->getItem('city');
   }

  /**
  * get the zip code.
  *
  * @return string
  */
  public function getZipCode(){
       return $this->getItem('zip_code');
   }

  /**
  * get the latitude of the location.
  *
  * @return double
  */
  public function getLatitude(){
       return $this->getItem('latitude');
   }

  /**
  * get the longitude of the location.
  *
  * @return double
  */
  public function getLongitude(){
      return $this->getItem('longitude');
   }

  /**
  * get the metro code.
  *
  * @return string
  */
  public function getMetroCode(){
     return $this->getItem('metro_code');
   }

  
  /**
  * get the area code.
  *
  * @return string
  */
  public function getAreaCode(){
      return $this->getItem('area_code');
   }

  /**
  * generic property retriever.
  *
  * @return string
  */
  private function getItem($name){      
        
        if($this->geoip_data == NULL)
          $this->retrievefromCache();

        return $this->geoip_data->$name;
   }

  /**
  * check if the Cache class exists and use caching mechanism if there is, otherwise just call the API directly.
  *
  * @return void
  */
  private function retrievefromCache(){      
      
      if (class_exists('\\Cache'))
      {
        
        $cache_key = 'laravel-4-freegeoip-'. $this->ip;     

        if (\Cache::has($cache_key))
             $this->geoip_data = \Cache::get($cache_key);
          else
          {
              $this->geoip_data = $this->resolve($this->ip); 
              \Cache::put($cache_key, $this->geoip_data , 60*60);       
          }
      }
      else
           $this->geoip_data = $this->resolve($this->ip);
   }


  /**
  * call the freegeoip.net for data, retrieve it as JSON and convert it to stdclass.
  *
  * @todo make this thing use Guzzle instead, you novice kid!
  *
  * @return void
  */
   function resolve($ip){
      
      $url = \Config::get('laravel-4-freegeoip::freegeoipURL').$ip;
      
      $ch = curl_init();
      curl_setopt ($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, \Config::get('laravel-4-freegeoip::timeout'));
      
      $file_contents = curl_exec($ch);    
      curl_close($ch);
      
      $data = json_decode($file_contents);
      
      if($data == NULL)
          throw new \Exception("Problems in retrieving data from http://freegeoip.net");

      return $data;
    }

}
