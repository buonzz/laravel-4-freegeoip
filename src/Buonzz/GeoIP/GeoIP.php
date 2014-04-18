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

   public function getCountry(){
			return $this->getItem('country_name');
   }

   public function getCountryCode(){
      return $this->getItem('country_code');
   }

   public function getRegionCode(){
      return $this->getItem('region_code');
   }

   public function getRegionName(){
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
            $this->geoip_data = $this->resolve($_SERVER['REMOTE_ADDR']);        

        return $this->geoip_data->$name;
   }

   function resolve($ip){
      
      $url = 'https://freegeoip.net/json/'.$ip;
      $timeout = 30; // set to zero for no timeout
      
      $ch = curl_init();
      curl_setopt ($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      //curl_setopt($ch, CURLOPT_HEADER, true);
      $file_contents = curl_exec($ch);    
      curl_close($ch);
      
      $data = json_decode($file_contents);

      return $data;
    }

}