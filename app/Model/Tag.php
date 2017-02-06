<?php

App::uses('AppModel', 'Model');

/**
 * Tag Model
 *
 * @property Display $Display
 * @property User $User
 */
class Tag extends AppModel
{

	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'tag';

	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'tag_id';

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
		'tag_id' => array(
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
				'rule' => array('between', 3, 45),
				'message' 	=> 'El nombre debe tener entre 3 y 45 caracteres!',
			),
			'unique' => array(
				'rule' 		=> array('isUnique'),
				'message' 	=> 'Ya existe un tag con este nombre!',
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
		'Display' => array(
			'className' 			=> 'Display',
			'joinTable' 			=> 'tag_pantalla',
			'foreignKey' 			=> 'tag_id',
			'associationForeignKey' => 'pantalla_id',
			'unique' 				=> 'keepExisting',
			'conditions' 			=> '',
			'fields'				=> '',
			'order' 				=> '',
			'limit' 				=> '',
			'offset' 				=> '',
			'finderQuery' 			=> '',
			'deleteQuery' 			=> '',
			'insertQuery' 			=> ''
		),
		'User' => array(
			'className' 			=> 'User',
			'joinTable' 			=> 'tag_user',
			'foreignKey' 			=> 'tag_id',
			'associationForeignKey' => 'user_id',
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


	/*
	 * Función encargada de devolver los tags en forma de lista
	 */
	public static function getIds( $tagsList = null )
	{
		$tags = array();
		
		foreach ($tagsList as $key => $value) {
			$tags[] = strval($value['tag_id']);
		}

		return $tags;
	}


	/*
	 * Función encargada de devolver los tags en forma de lista
	 */
	public static function getList( $tagsList = null )
	{
		$tags = '';

		if( $tagsList )
		{
			foreach ($tagsList as $key => $value) {
				$tags .= $value['nombre'] . ', '; 
			}

			$tags = rtrim($tags, ', ');
		}
		else {
			$tags = 'todos';
		}

		if( $tags == '' ) {
			$tags = 'no tenes permisos asignados.';
		}

		return $tags;
	}

}
