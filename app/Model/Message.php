<?php

App::uses('AppModel', 'Model');

/**
 * Message Model
 *
 */
class Message extends AppModel
{
	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'mensaje';

	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'mensaje_id';

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
		'mensaje_id' => array(
			'numeric' => array(
				'rule' 		=> array('numeric'),
			),
		),
		'titulo' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'unique' => array(
				'rule' 		=> array('isUnique'),
				'message' 	=> 'Ya existe un contenido con este nombre!',
			),
			'length' => array(
				'rule' 		=> array('between', 3, 45),
				'message' 	=> 'El nombre debe tener entre 3 y 45 caracteres!',
			),
		),
		'mensaje' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
		),
	);
}
