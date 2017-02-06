<?php

App::uses('AppModel', 'Model');

/**
 * Content Model
 *
 * @property Display $Display
 * @property Origin $Origin
 */
class Content extends AppModel
{
	public $actsAs = array(
		'AuditLog.Auditable' => array(
			'ignore' => array('json_data'),
			'habtm'  => array('Display')
		)
	);

	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'contenido';

	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'contenido_id';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'contenido_id' => array(
			'numeric' => array(
				'rule' 		=> array('numeric'),
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
				'message' 	=> 'Ya existe un contenido con este nombre!',
			),
		),
		'origen_id' => array(
			'numeric' => array(
				'rule' 		=> array('numeric'),
				'message' 	=> 'El origen es inválido!',
			),
		)
	);


	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Origin' => array(
			'className' 	=> 'Origin',
			'foreignKey' 	=> 'origen_id',
			'conditions' 	=> '',
			'fields'		=> '',
			'order' 		=> ''
		)
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Display' => array(
			'className' 			=> 'Display',
			'joinTable' 			=> 'contenido_pantalla',
			'foreignKey' 			=> 'contenido_id',
			'associationForeignKey' => 'pantalla_id',
			'unique' 				=> 'keepExisting',
			'conditions' 			=> '',
			'fields' 				=> '',
			'order' 				=> '',
			'limit' 				=> '',
			'offset'				=> '',
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
		// Seteo la fecha de última modificación
			$this->data[$this->alias]['fecha_ultima_modificacion'] = date('Y-n-j H:i:s.u');

		return true;
	}

}
