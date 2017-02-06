<?php

App::uses('Email', 'Email');

class CheckStatusShell extends AppShell
{

	public $uses = array('Display', 'User');


	/*
	* main
	*/
	public function main()
	{
		// Defino la variable de mail
			$email = new Email();

		// Obtengo todas las pantallas
			$displays = $this->Display->find('all');
		
		// Obtengo la hora actual y le resto 1 hora
			$current = strtotime(date('Y-n-j H:i:s', strtotime('-1 hours')));

		// Variables auxiliares
			$msg 				= '';
			$areOffline 		= array();
			$areOfflineIds 		= array();
			$stillOffline 		= array();
			$stillOfflineIds 	= array();

		// Comienzo a procesar
			$this->out('********************************************');
			$this->out('<comment>Actualización de PANTALLAS</comment>');
			$this->out('<comment>Comienzo: ' . date('Y-m-d h:i:s') . '</comment>');
			$this->out('<comment>Cantidad total: ' . count($displays) . '</comment>');
			$this->out('');

			// Recorro todas las pantallas
				foreach ($displays as $display)
				{
					// Si tienen una IP seteada
						if( $display['Display']['ip_actual'] )
						{
							// Obtengo la ultima consulta
								$ultima_consulta = strtotime($display['Display']['fecha_ultima_consulta']);

							// Si la última consulta es mejor a la "hora actual"
								if( $ultima_consulta < $current )
								{
									$envio_alerta = $display['Display']['envio_alerta'];

									// Si el envío de alerta está en 0, significa que la pantalla está fallando
										if( $envio_alerta == 0 ) {
											$areOffline[] 		= $display;
											$areOfflineIds[] 	= $display['Display']['pantalla_id'];
										}
									// Si el envío de alerta está en 1, significa que la pantalla sigue fallando
										else {
											$stillOffline[] 	= $display;
											$stillOfflineIds[] 	= $display['Display']['pantalla_id'];
										}
								} 
						}
				}


			// Si falla alguna pantalla nueva
				if( count($areOffline) > 0 )
				{
					$msg = 'Fallan ' . count($areOffline) . ' nuevas pantallas al ' . date('Y-n-j H:i:s') . '.';
					$this->out('<error>ERROR: ' . $msg . '</error>');

					$msg = 'IDs: ' . implode(', ', $areOfflineIds);
					$this->out($msg);
					$this->out('');

					// Les activo el envío de alerta
						foreach ($areOfflineIds as $id)
						{
							$display = $this->Display->find('first', array(
								'conditions' => array(
									'Display.' . $this->Display->primaryKey => $id
								)
							));

							$display['Display']['envio_alerta'] = 1;
							
							$this->Display->Save($display);
						}
				}
				else {
					$msg .= 'No falla ninguna pantalla nueva!';
					$this->out('<info>' . $msg . '</info>');
					$this->out('');
				}

			// Si sigue fallando alguna pantalla
				if( count($stillOffline) > 0 )
				{
					$msg = 'Siguen fallando ' . count($stillOffline) . ' pantallas al ' . date('Y-n-j H:i:s') . '.';
					$this->out('<error>ERROR:</error> ' . $msg);

					$msg = 'IDs: ' . implode(', ', $stillOfflineIds);
					$this->out($msg);
					$this->out('');
				}

			// Si al menos alguna pantalla falló o sigue fallando
				if( count($areOffline) > 0 || count($stillOffline) > 0 )
				{
					$this->out('Enviando reporte..');

					if( $email->sendOfflineDisplaysReport($areOffline, $stillOffline) ) {
						$this->out('Reporte enviado!');
						$this->out('');
					}
					else {
						$this->out('El reporte no fue enviado!');
						$this->out('');
					}
				}

			$this->out('<comment>Fin: ' . date('Y-m-d h:i:s') . '</comment>');
			$this->out('********************************************');

	}
}