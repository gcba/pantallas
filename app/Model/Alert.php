<?php

App::uses('AppModel', 'Model');

/**
 * Alert Model
 *
 */
class Alert extends AppModel
{
	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'alerta';
	
	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'alerta_id';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'titulo';

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
		'alerta_id' => array(
			'numeric' => array(
				'rule' 		=> array('numeric'),
			),
		),
		'titulo' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'length' => array(
				'rule' 		=> array('between', 3, 50),
				'message' 	=> 'El titulo debe tener entre 3 y 50 caracteres!',
			),
		),
		'icono' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'length' => array(
				'rule' 		=> array('maxLength', 45),
				'message' 	=> 'El ícono puede tener hasta 45 caracteres máximo!',
			),
		),
		'color' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'length' => array(
				'rule' 		=> array('maxLength', 45),
				'message' 	=> 'El color puede tener hasta 45 caracteres máximo!',
			),
		),
	);


	/**
	 * afterSave method
	 *
	 * @return boolean
	 */
	// public function afterSave( $options = array() )
	// {
	// 	// Llama al beforeSave nativo
	// 	parent::beforeSave();

	// 	// Carga el modelo de Pantalla
	// 	Controller::loadModel('Display');

	// 	// Obtiene la base de datos, la hora actual y lo parsea a String para evitar problemas
	// 	$db = $this->getDataSource();
	// 	$now = date('Y-n-j H:i:s');
	// 	$value = $db->value($now, 'string');

	// 	$this->Display->updateAll( array('Display.fecha_ultima_modificacion' => $value) );

	//     return true;
	// }

}
