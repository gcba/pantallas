<?php

App::uses('Email', 'Email');

class UpdateDataShell extends AppShell
{

	public $uses  = array('Origin', 'User');
	public $tasks = array('Clima', 'Twitter');


	/*
	 * main
	 */
	public function main()
	{
		// Defino la variable de mail
			$email = new Email();

		// Traigo todos los origenes que usan CRON
			$origins = $this->Origin->find('all', array(
				'conditions' => array(
					'usa_cron' => true
				)
			));

		// Comienzo a procesar
			$this->out('********************************************');
			$this->out('<comment>Actualización de ORÍGENES</comment>');
			$this->out('<comment>Comienzo: ' . date('Y-m-d h:i:s') . '</comment>');
			$this->out('<comment>Cantidad total: ' . count($origins) . '</comment>');
			$this->out('');

			// Recorro todos los orígenes y los proceso uno por uno
				foreach ($origins as $origin)
				{
					try
					{
						$slug = $origin['Origin']['slug'];

						// Si dicho slug está en la lista de tareas
							if( in_array($slug, $this->tasks) )
							{
								$this->out('--------------------------------------------');
								$this->out('Procesando <warning>' . $slug . '</warning>');
								$this->$slug->setOrigin($origin['Origin']);
								$this->$slug->setContents($origin['Content']);
								$this->$slug->execute();

								$this->out('<warning>Listo!</warning>');
							}
						// Sino, no lo procesa
							else {
								$this->out('No existe tarea para ' . $slug);
							}
					}
					catch (Exception $e)
					{
						$this->out('<error>ERROR:</error> ' . $e->getMessage());
						$this->out('Enviando reporte..');
						
						if( $email->sendTaskReport($slug, $e->getMessage()) ) {
							$this->out('Reporte enviado!');
						}
						else {
							$this->out('El reporte no fue enviado!');
						}
					}

					$this->out('--------------------------------------------');
					$this->out('');
				}

			$this->out('<comment>Fin: ' . date('Y-m-d h:i:s') . '</comment>');
			$this->out('********************************************');
	}
}