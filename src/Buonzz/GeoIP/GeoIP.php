<?php namespace Buonzz\GeoIP;

/**
*  Contains all the method to retrieve data from freegeoip.net.
*
*  This contains the geoip data as well all the marshalling mechanism from 
*  the web service.
*
*  @author Darwin Biler <buonzz@gmail.com>
*  @author Antoine Augusti <antoine.augusti@gmail.com>
*/
class GeoIP {

	/**
	 * Contains the JSON object retrieved from the API
	 * @var mixed
	 */
	private $geoip_data = null;

	/**
	 * Contains the IP of the current visitor
	 * @var string
	 */
	private $ip;

	/**
	 * The configuration array
	 * @var array
	 */
	private $config;

	/**
	* Constructor which initialiazes various things.
	*
	* Detects if the REMOTE_ADDR is present (usually not, when running in CLI or PHPUnit)
	* if present use that one.
	*
	* @return void
	*/
	public function __construct($config)
	{
		$this->config = $config;

		if (isset($_SERVER['REMOTE_ADDR']))
			$this->setIP($_SERVER['REMOTE_ADDR']);
	}

	/**
	* Allows the user to set the IP to be process instead of retrieving it from server.
	*
	* @return void
	*/
	public function setIP($ip)
	{
		$this->ip = $ip;
	}

	/**
	* Get the descriptive name of the country.
	*
	* @return string
	*/
	public function getCountry()
	{
		return $this->getItem('country_name');
	}

	/**
	* Get the 2-letter code  of the country.
	*
	* @return string
	*/
	public function getCountryCode()
	{
		return $this->getItem('country_code');
	}

	/**
	* Get the region code.
	*
	* @return string
	*/
	public function getRegionCode()
	{
		return $this->getItem('region_code');
	}

	/**
	* Get the descriptive name of the region.
	*
	* @return string
	*/
	public function getRegion()
	{
		return $this->getItem('region_name');
	}

	/**
	* Get the descriptive name of the City.
	*
	* @return string
	*/
	public function getCity()
	{
		return $this->getItem('city');
	}

	/**
	* Get the zip code.
	*
	* @return string
	*/
	public function getZipCode()
	{
		return $this->getItem('zipcode');
	}

	/**
	* Get the latitude of the location.
	*
	* @return double
	*/
	public function getLatitude()
	{
		return $this->getItem('latitude');
	}

	/**
	* Get the longitude of the location.
	*
	* @return double
	*/
	public function getLongitude()
	{
		return $this->getItem('longitude');
	}

	/**
	* Get the metro code.
	*
	* @return string
	*/
	public function getMetroCode()
	{
		return $this->getItem('metro_code');
	}

	/**
	* Get the area code.
	*
	* @return string
	*/
	public function getAreaCode()
	{
		return $this->getItem('area_code');
	}

	/**
	* Generic property retriever.
	*
	* @return string
	*/
	private function getItem($name)
	{
		if ($this->geoip_data == NULL)
			$this->retrievefromCache();

		return $this->geoip_data->$name;
	}

	/**
	* Check if the Cache class exists and use caching mechanism if there is, otherwise just call the API directly.
	*
	* @return void
	*/
	private function retrievefromCache()
	{
		if (class_exists('\\Cache'))
		{
			$cache_key = 'laravel-4-freegeoip-'. $this->ip;     

			if (\Cache::has($cache_key))
				$this->geoip_data = \Cache::get($cache_key);
			else
			{
				$this->geoip_data = $this->resolve($this->ip); 
				\Cache::put($cache_key, $this->geoip_data , 60 * 60);       
			}
		}
		else
			$this->geoip_data = $this->resolve($this->ip);
	}

	/**
	* Call the freegeoip for data, retrieve it as JSON and convert it to StdClass.
	*
	* @todo make this thing use Guzzle instead, you novice kid!
	* @throws \Exception When we have got a problem when retrieving data
	* @return void
	*/
	private function resolve($ip)
	{
		$url = $this->config['freegeoipURL'] . $ip;

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		// The number of seconds to wait while trying to connect
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $this->config['timeout']);
		// The maximum number of seconds to allow cURL functions to execute
		curl_setopt ($ch, CURLOPT_TIMEOUT, $this->config['timeout']);

		$file_contents = curl_exec($ch);    
		curl_close($ch);

		$data = json_decode($file_contents);

		if (is_null($data))
			throw new \Exception("Problems in retrieving data from " . $url);

		return $data;
	}
}