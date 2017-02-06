<?php
class AppTask extends Shell {

    public $uses = array('Content', 'Origin');
	
	public $contents;
	public $origin;


	/*
	 * setContents
	 */
		public function setContents($contents) {
			$this->contents = $contents;
		}

	/*
	 * setOrigin
	 */
		public function setOrigin($origins) {
			$this->origin = $origins;
		}

	/*
	 * execute
	 */
		public function execute() {
			$this->process();
		}


	/*
	 * process
	 */
		public function process() {

			// Por cada contenido
				foreach ($this->contents as $key => $value)
				{
					// Agarro las configuraciones
						$settings 	= ($value['settings'] != '' ? json_decode($value['settings'], true) : null);
						$filtro 	= '';

					// Si hay configuraciones
						if($settings)
						{
							switch($this->origin['slug'])
							{
								case 'Clima':
									$filtro = $settings['ciudad_id']['value'];
								break;

								case 'Twitter':
									$filtro = $settings['username']['value'];
								break;
							}

							// Llamo a la funcion retrieveData para obtener los datos
								$data = $this->retrieveData( $filtro );
							
							// Si la data no me devolvió vacía
								if($data !== FALSE)
								{
									// La asigno y guardo el contenido
										$value['local_data'] = $data;
										$this->Content->save($value);
								}
						}
				}

			// Actualizo la fecha de última actualización del origen y lo guardo
				$this->origin['fecha_ultima_actualizacion'] = date('Y-m-d h:i:s');
				$this->Origin->save($this->origin);

		}


	/*
	 * retrieveData
	 */
		public function retrieveData( $filter ) {

			// Si no existe la función retrieveData en la Task correspondiente, tira error.
				throw new Exception('Subclass responsability', 1);
				
		}

}