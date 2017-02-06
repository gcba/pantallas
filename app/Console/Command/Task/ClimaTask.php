<?php

require_once('AppTask.php');

class ClimaTask extends AppTask
{
	public $api 		= 'http://api.openweathermap.org/data/2.5/';
	public $cityCode 	= '3433955';
	public $appId 		= 'f60fc23ef41c1b030138d43861eeaafe';
	public $lang 		= 'es';
	public $unit 		= 'metric';

	/*
	 * Retrieves Data from the OpenWeatherMap API
	 * https://openweathermap.org/api
	 */
		public function retrieveData( $cityCode = '' )
		{
			try {
				
				$this->cityCode = (trim($cityCode) != '') ? $cityCode : $this->cityCode;

				// URLs de la API
					$currentUrl  = $this->api . 'weather?id=' . $this->cityCode . '&appid=' . $this->appId . '&lang=' . $this->lang . '&units=' . $this->unit;
					$forecastUrl = $this->api . 'forecast?id=' . $this->cityCode . '&appid=' . $this->appId . '&lang=' . $this->lang . '&units=' . $this->unit;
					$dailyUrl 	 = $this->api . 'forecast/daily?id=' . $this->cityCode . '&appid=' . $this->appId . '&lang=' . $this->lang . '&units=' . $this->unit;

				// Parseo los obj
					$currentObj  = json_decode(file_get_contents($currentUrl),  true);
					$forecastObj = json_decode(file_get_contents($forecastUrl), true);
					$dailyObj    = json_decode(file_get_contents($dailyUrl),    true);

				// Si alguno de los objetos me devuelve vacío
					if( !(is_array($currentObj) && is_array($forecastObj) && is_array($dailyObj) ) ) { 
						throw new Exception('Error en el CRON de OpenWeatherMap.');
					}

				// Reemplazo las variables del temp_min y temp_max del "actual" con el del "dia".
					$currentObj['main']['temp_min'] = number_format($dailyObj['list'][0]['temp']['min'], 1);
					$currentObj['main']['temp_max'] = number_format($dailyObj['list'][0]['temp']['max'], 1);

				// Agarro los primeros 3 elementos de la lista
					$forecastObj['list'] = array_slice($forecastObj['list'], 0, 3);

				// Recorro cada elemento de la lista
					foreach ($forecastObj['list'] as $key => $value)
					{
						$date = explode(' ', $value['dt_txt']);
						$date = explode(':', $date[1]);

						$forecastObj['list'][$key]['time_txt'] 	= $date[0] . ':' . $date[1];
						$forecastObj['list'][$key]['index'] 	= $key;
					}

					return '{ "current" : ' . json_encode($currentObj) . ', ' . ' "forecast" : ' . json_encode($forecastObj) . ', "daily" : ' . json_encode($dailyObj) . '}';

			}
			catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

}