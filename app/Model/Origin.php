<?php

App::uses('AppModel', 'Model');

/**
 * Origin Model
 *
 * @property Content $Content
 */
class Origin extends AppModel
{
	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'origen';

	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'origen_id';

	/**
	 * Display field
	 *
	 * @var string
	 */
	// public $displayField = 'nombre';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'origen_id' => array(
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
				'message' 	=> 'Ya existe un origen con este nombre!',
			),
		),
		'slug' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'length' => array(
				'rule' 		=> array('between', 3, 45),
				'message' 	=> 'El slug debe tener entre 3 y 45 caracteres!',
			),
			'unique' => array(
				'rule' 		=> array('isUnique'),
				'message' 	=> 'Ya existe un origen con este slug!',
			),
		),
		'descripcion' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			// 'length' => array(
			// 	'rule' 		=> array('maxLength', 100),
			// 	'message' 	=> 'La descripción puede tener hasta 100 caracteres máximo!',
			// ),
		)
	);


	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Content' => array(
			'className' 	=> 'Content',
			'foreignKey' 	=> 'origen_id'
			// 'dependent' 	=> false
		)
	);


	/**
	 * beforeSave method
	 *
	 * @return boolean
	 */
	public function beforeSave( $options = array() )
	{
		// Si el SLUG NO ES alfanumérico
			if( !ctype_alnum(trim( $this->data[$this->alias]['slug'] )) ) {
				return false;
			}

		// Seteo la fecha de última modificación
			$this->data[$this->alias]['fecha_ultima_modificacion'] = date('Y-n-j H:i:s.u');

		return true;
	}

}