<?php namespace Buonzz\GeoIP;
/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author yourname
*/
class GeoIP{

  private $geoip_data = NULL;
  private $ip;

  public function __construct(){
      if(isset($_SERVER['REMOTE_ADDR']))
          $this->ip = $_SERVER['REMOTE_ADDR'];     
  }

  public function setIP($ip){
    $this->ip = $ip;
  }

   public function getCountry(){
			return $this->getItem('country_name');
   }

   public function getCountryCode(){
      return $this->getItem('country_code');
   }

   public function getRegionCode(){
      return $this->getItem('region_code');
   }

   public function getRegion(){
       return $this->getItem('region_name');
   }

   public function getCity(){
       return $this->getItem('city');
   }

   public function getZipCode(){
       return $this->getItem('zipcode');
   }

   public function getLatitude(){
       return $this->getItem('latitude');
   }

   public function getLongitude(){
      return $this->getItem('longitude');
   }

   public function getMetroCode(){
     return $this->getItem('metro_code');
   }

   public function getAreaCode(){
      return $this->getItem('area_code');
   }

   private function getItem($name){      
        
        if($this->geoip_data == NULL)
          $this->retrievefromCache();

        return $this->geoip_data->$name;
   }

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

   function resolve($ip){
      
      $url = 'https://freegeoip.net/json/'.$ip;
      $timeout = 30; // set to zero for no timeout
      
      $ch = curl_init();
      curl_setopt ($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      
      $file_contents = curl_exec($ch);    
      curl_close($ch);
      
      $data = json_decode($file_contents);
      
      if($data == NULL)
          throw new \Exception("Problems in retrieving data from http://freegeoip.net");

      return $data;
    }

}