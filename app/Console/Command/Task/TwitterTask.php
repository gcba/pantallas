<?php

require_once('AppTask.php');
require_once(APP . 'Vendor' . DS . 'codebird' . DS . 'src' . DS . 'codebird.php');

class TwitterTask extends AppTask
{

	/*
	 * Retrieves Data from the OpenWeatherMap API
	 * https://openweathermap.org/api
	 */
		public function retrieveData( $user = '' )
		{
			try {

				$config 			= Configure::read('Twitter.keys');
				$consumerKey 		= $config['consumer'];
				$consumerSecret 	= $config['consumer-secret'];
				$accessToken 		= $config['access-token'];
				$accessTokenSecret 	= $config['access-token-secret'];


				// Seteo las credenciales
					\Codebird\Codebird::setConsumerKey($consumerKey, $consumerSecret);
					$codebird = \Codebird\Codebird::getInstance();
					$codebird->setToken($accessToken, $accessTokenSecret);


				// Seteo el BearerToken
					$reply 		 = $codebird->oauth2_token();
					$bearerToken = $reply->access_token;
					\Codebird\Codebird::setBearerToken($bearerToken);
				

				// Seteo los parámetros
					$params = array(
						'screen_name' 		=> $user,
						'count'				=> 10,
						'include_rts' 		=> false,
						'exclude_replies' 	=> true
					);


				// REST call
					// $reply = (array) $codebird->statuses_homeTimeline($params);
					$reply = (array) $codebird->statuses_userTimeline($params);
					// $reply = (array) $codebird->search_tweets($params);
					// $reply = $codebird->statuses_userTimeline('screen_name=' . $user . '&count=10&include_rts=false&exclude_replies=true');

					$data['user'] 	= false;
					$data['tweets'] = array();

					foreach ($reply as $key => $tweet)
					{
						// Compruebo que la Key sea un int (ya que estos son los twwets)
						if( is_int($key) )
						{
							// Si la data del usuario está vacía (es falsa)
								if( !$data['user'] )
								{
									// Obtengo el usuario
										$data['user'] = $tweet->user;
									// Obtengo la imagen de perfil
										$data['user']->profile_image_url = str_replace('normal', 'reasonably_small', $data['user']->profile_image_url);
									// Obtengo la imagen de portada si es que esta existe
										if(isset($data['user']->profile_banner_url))
										{
											$data['user']->profile_banner_url = str_replace('https', 'http', $data['user']->profile_banner_url) . '/ipad_retina';
										}
								}

							// Y siempre remuevo el campo usuario del array del tweet
								unset($tweet->user);
							
							// Obtengo los tweets
								$data['tweets'][] = $tweet; 
						}
					}


				// Devuelvo la data en un JSON
					return json_encode($data);

			}
			catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

}