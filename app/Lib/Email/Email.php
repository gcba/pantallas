<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Email Lib
 *
 * @property Email $Email
 */
class Email
{

	/**
	* sendEmail
	* Función en común para enviar los emails
	*/
	private function sendEmail( $function, $subject = '', $body = '', $mails = array(), $theme = 'Cakestrap', $template = 'default', $format = 'html', $vars = array() )
	{
		// Si el nivel de debug es 0 [PRODUCCIÓN]
			if( Configure::read('debug') == 0 )
			{
				// Variables auxiliares
					$bcc  = array_merge(Configure::read('Environment')['email']['admin'], $mails);
					$from = array(
						Configure::read('Environment')['email']['noreply'] => Configure::read('Environment')['name']
					);
        
				// Cargo las configuraciones del email
					$email = new CakeEmail( 'buenosaires' );
					$email 	->from( $from )
							->theme( $theme )
						 	->emailFormat( $format )
						 	->template( $template )
							->viewVars( $vars )
							->bcc( $bcc )
							->subject( $subject );

				// Intento enviarlo
					try {
						$email->send( $body );
						return true;
					}
				// Sino guardo un mensaje de error en el log
					catch (Exception $e) {
						$this->log('Falló el envío de email de ' . $function);
						$this->log($e);
					}
			}

		return false;
	}


	/**
	* sendUserRootAddedReport
	* Envía un email diciendo que se dió de alta un nuevo usuario Root
	*/
		public function sendUserRootAddedReport( $user = null )
		{
			if( !is_null($user) )
			{
				$subject = 'Alta de usuario ROOT';
				$body  	 = 	'<table>' .
								'<tr>' .
									'<th>NOMBRE</th>' .
									'<th>EMAIL</th>' .
								'</tr>' .
								'<tr>' .
									'<td>' . $user['User']['user'] . '</td>' .
									'<td>' . $user['User']['mail'] . '</td>' .
								'</tr>' .
							'</table>';

				if( $this->sendEmail(__FUNCTION__, $subject, $body) ){
					return true;
				}
			}

			return false;
		}


	/**
	* sendDisplayWithoutContentReport
	* Envía un email diciendo que la pantalla no tiene contenido
	*/
		public function sendDisplayWithoutContentReport( $display = null )
		{
			if( !is_null($display) )
			{
				$subject = 'Pantalla reproduciendo sin contenidos';
				$body  	 = 	'<table>' .
								'<tr>' .
									'<th>ID</th>' .
									'<th>NOMBRE</th>' .
									'<th>IP</th>' .
									'<th>ÚLTIMA CONSULTA</th>' .
									'<th>ÚLTIMA MODIFICACIÓN</th>' .
								'</tr>' .
								'<tr>' .
									'<td>' . $display['pantalla_id'] . '</td>' .
									'<td>' . $display['nombre'] . '</td>' .
									'<td>' . $display['ip_actual'] . '</td>' .
									'<td>' . $display['fecha_ultima_consulta'] . '</td>' .
									'<td>' . $display['fecha_ultima_modificacion'] . '</td>' .
								'</tr>' .
							'</table>';

				if( $this->sendEmail(__FUNCTION__, $subject, $body) ){
					return true;
				}
			}

			return false;
		}


	/**
	* sendDisplayBackOnlineReport
	* Envía un email diciendo que la pantalla está nuevamente operativa
	*/
		public function sendDisplayBackOnlineReport( $display = null )
		{
			if( !is_null($display) )
			{
				$subject = 'Pantalla nuevamente operativa';
				$body  	 = 	'<table>' .
								'<tr>' .
									'<th>ID</th>' .
									'<th>NOMBRE</th>' .
									'<th>IP</th>' .
									'<th>ÚLTIMA CONSULTA</th>' .
									'<th>ÚLTIMA MODIFICACIÓN</th>' .
								'</tr>' .
								'<tr>' .
									'<td>' . $display['pantalla_id'] . '</td>' .
									'<td>' . $display['nombre'] . '</td>' .
									'<td>' . $display['ip_actual'] . '</td>' .
									'<td>' . $display['fecha_ultima_consulta'] . '</td>' .
									'<td>' . $display['fecha_ultima_modificacion'] . '</td>' .
								'</tr>' .
							'</table>';

				if( $this->sendEmail(__FUNCTION__, $subject, $body) ){
					return true;
				}
			}

			return false;
		}


	/**
	* sendOfflineDisplaysReport
	* Envia un email con las pantallas que están caídas
	*/
		public function sendOfflineDisplaysReport( $areOffline = null, $stillOffline = null )
		{
			if( !is_null($areOffline) && !is_null($stillOffline) )
			{
				$subject = 'Pantallas fuera de servicio';

				$body  = 'Las siguientes pantallas dejaron de funcionar en la última hora: <br/>';
				$body .= '<table>
							<tr>
								<th>ID</th>
								<th>NOMBRE</th>
							</tr>';

							foreach ($areOffline as $display)
							{
								$body .= '<tr>' .
											'<td>' . $display['Display']['pantalla_id'] . '</td>' .
											'<td>' . $display['Display']['nombre'] . '</td>' .
										 '</tr>';
							}
				$body .= '</table>';

				$body  = '<br/><br/><br/>';

				$body .= 'Las siguientes pantallas que todavia no se consultan son:<br/>';
				$body .= '<table>
							<tr>
								<th>ID</th>
								<th>NOMBRE</th>
							</tr>';

							foreach ($stillOffline as $display)
							{
								$body .= '<tr>' .
											'<td>' . $display['Display']['pantalla_id'] . '</td>' .
											'<td>' . $display['Display']['nombre'] . '</td>' .
										 '</tr>';
							}
				$body .= '</table>';

				if( $this->sendEmail(__FUNCTION__, $subject, $body) ){
					return true;
				}
			}

			return false;

		}


	/**
	* sendTaskReport
	* Envía un email diciendo que una tarea falló
	*/
		public function sendTaskReport( $task, $msg )
		{
			$subject = 'Error en el cron de ' . $task;
			$body 	 = 'Tarea:' . $task . ' </br> Error:' . $msg;

			if( $this->sendEmail(__FUNCTION__, $subject, $body) ){
				return true;
			}

			return false;
		}

}