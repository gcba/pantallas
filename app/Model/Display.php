<?php

App::uses('AppModel', 'Model');

/**
 * Display Model
 *
 * @property Content $Content
 */
class Display extends AppModel
{

	public $actsAs = array(
		'AuditLog.Auditable' => array(
			'ignore' => array(),
			'habtm'  => array('Content')
		)
	);

	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'pantalla';

	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'pantalla_id';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';

	/**
	 * Virtual field
	 *
	 * @var string
	 */
	// public $virtualFields = array(
	// 	'nombreDire' => "CONCAT(Display.nombre, ' - ', Display.direccion)"
	// );

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		// 'example' => array(
		// 	'ruleName' => array(
		// 		'rule' => array(),
		// 		'message' => 'Your custom message here',
		// 		'allowEmpty' => false,
		// 		'required' => false,
		// 		'last' => false, // Stop validation after this rule
		// 		'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// ),
		'pantalla_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'nombre' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'length' => array(
				'rule' 		=> array('between', 3, 45),
				'message' 	=> 'El nombre debe tener entre 3 y 45 caracteres!',
			),
			'unique' => array(
				'rule' 		=> array('isUnique'),
				'message' 	=> 'Ya existe una pantalla con este nombre!',
			),
		),	
		'direccion' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'length' => array(
				'rule' 		=> array('maxLength', 255),
				'message' 	=> 'La dirección es inválida!',
			),
		),
		'lat' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
		),
		'lng' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
		),
		'comuna' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
		),
		'barrio' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
		),
		'orientacion' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'inlist' => array(
				'rule' 		=> array('inList', array('VERTICAL', 'HORIZONTAL')),
				'message' 	=> 'La orientación es inválida!',
			),
		),
		'Content' => array(
			'multiple' => array(
				'rule' 		=> array('multiple', array('min' => 1)),
				// 'required'  => true,
				'message' 	=> 'La pantalla necesita al menos 1 contenido para funcionar!',
			),
		),
		'Tag' => array(
			'multiple' => array(
				'rule' 		=> array('multiple', array('min' => 1)),
				// 'required'  => true,
				'message' 	=> 'Por favor, selecciona al menos 1 tag!',
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Content' => array(
			'className' 			=> 'Content',
			'joinTable' 			=> 'contenido_pantalla',
			'foreignKey' 			=> 'pantalla_id',
			'associationForeignKey' => 'contenido_id',
			'unique' 				=> 'keepExisting',
			'conditions' 			=> '',
			'fields' 				=> '',
			'order' 				=> '',
			'limit' 				=> '',
			'offset' 				=> '',
			'finderQuery' 			=> '',
			'deleteQuery' 			=> '',
			'insertQuery' 			=> ''
		),
		'Tag' => array(
			'className' 			=> 'Tag',
			'joinTable' 			=> 'tag_pantalla',
			'foreignKey' 			=> 'pantalla_id',
			'associationForeignKey' => 'tag_id',
			'unique' 				=> 'keepExisting',
			'conditions' 			=> '',
			'fields' 				=> '',
			'order' 				=> '',
			'limit' 				=> '',
			'offset' 				=> '',
			'finderQuery' 			=> '',
			'deleteQuery' 			=> '',
			'insertQuery' 			=> ''
		)
	);


	/**
	 * beforeSave method
	 *
	 * @return boolean
	 */
	public function beforeSave( $options = array() )
	{
		// parent::beforeSave();


		// Obtengo los datos viejos
		$this->old = $this->find('first', array(
			$this->primaryKey => $this->id
		));

		// Si existen
		if( $this->old )
		{
			$fecha_ultima_modificacion = date('Y-n-j H:i:s.u');

			// Si ya existe una fecha de ultima modificación vieja, la seteo en la variable
			if( isset($this->old[$this->alias]['fecha_ultima_modificacion']) ) {
				$fecha_ultima_modificacion = $this->old[$this->alias]['fecha_ultima_modificacion'];
			}
			
			// Si está seteada la fecha de última consulta en ambos, tanto en el que se guarda como el anterior
			if( isset($this->data[$this->alias]['fecha_ultima_consulta']) && isset($this->old[$this->alias]['fecha_ultima_consulta']) )
			{
				// Si son iguales las fechas de consulta significa que hubo una modificación, entonces actualizo la hora
				if( $this->old[$this->alias]['fecha_ultima_consulta'] == $this->data[$this->alias]['fecha_ultima_consulta'] ) {
					$fecha_ultima_modificacion = date('Y-n-j H:i:s.u');
				}
			}
			// Si directamente no está seteada la fecha de última consulta significa que hubo una modificación también
			else {
				$fecha_ultima_modificacion = date('Y-n-j H:i:s.u');
			}

			// Seteo la fecha de última modificación
			$this->data[$this->alias]['fecha_ultima_modificacion'] = $fecha_ultima_modificacion;
		}

		return true;
	}


	/**
	 * Overridden paginate method
	 */
	public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array())
	{
		// Devuelvo todos los resultados
		return $this->getAvailableDisplays( $conditions, $fields, $order, $limit, $page, $recursive, $extra );
	}


	/**
	 * Overridden paginateCount method
	 */
	public function paginateCount($conditions = null, $recursive = 0, $extra = array())
	{
		// Devuelvo la cantidad de resultados
		return count( $this->getAvailableDisplays( $conditions, null, null, null, null, $recursive, $extra ) );
	}


	/*
	 * Devuelve los IDs de las pantallas a las que puede acceder
	 */
	public function getAvailableDisplays( $conditions = null, $fields = null, $order = null, $limit = null, $page = null, $recursive = null, $extra = array() )
	{
		$display_ids = array();


		// Obtengo los tags del usuario
			$tags = User::getTagsIds();

		
		// Obtengo las pantallas según los tags del usuario, si es ROOT no uso los filtro
			$query = '';

			if( User::isRoot() ) {
				$query = "SELECT Display.* FROM pantalla as Display";
			}
			else
			{
				if( count($tags) > 0 )
				{
					$query = "SELECT Display.pantalla_id " .
								" FROM tag_pantalla a  " .
								" JOIN pantalla Display on a.pantalla_id = Display.pantalla_id " .
								" WHERE a.tag_id in " . '(' . implode(',', $tags) . ') ';
				}
				else
				{
					return array();
				}
			}

			$db 	 = $this->getDataSource();
			$results = $db->fetchAll($query);

		// Obtengo los id de las pantallas que voy a mostrar de los resultados
			foreach ($results as $key => $value) {
				$display_ids[] = $value['Display']['pantalla_id'];
			}


		// Seteo las condiciones
			$conditions = array( 'pantalla_id' => $display_ids );
			$group  	= array( 'Display.pantalla_id' );


		// Obtengo los resultados
			$results = $this->find( 'all', compact('conditions', 'fields', 'order', 'limit', 'page', 'recursive', 'group') );


		// Devuelvo la cantidad de resultados
		return $results;
	}

}