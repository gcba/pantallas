<?php

App::uses('AppModel', 'Model');
App::uses('Email', 'Email');

/**
 * User Model
 *
 */
class User extends AppModel
{
	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'user';

	/**
	 * Primary key field
	 *
	 * @var string
	 */
	public $primaryKey = 'user_id';

	/**
	 * Display field
	 *
	 * @var string
	 */
	// public $displayField = 'user';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' 		=> array('numeric'),
			),
		),
		'mail' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'unique' => array(
				'rule' 		=> array('isUnique'),
				'message' 	=> 'Ya existe un usuario con este correo electrónico!',
			),
			'length' => array(
				'rule' 		=> array('maxLength', 45),
				'message' 	=> 'El email puede tener hasta 45 caracteres máximo!',
			),
		),
		'user' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'unique' => array(
				'rule' 		=> array('isUnique'),
				'message' 	=> 'Ya existe un usuario con este nombre!',
			),
			'length' => array(
				'rule' 		=> array('maxLength', 45),
				'message' 	=> 'El usuario puede tener hasta 45 caracteres máximo!',
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'on'		=> 'create',
			),
			'length' => array(
				'rule' => array('maxLength', 45),
				'message' 	=> 'La contraseña puede tener hasta 45 caracteres máximo!',
			),
		),
		'role' => array(
			'notempty' => array(
				'rule' 		=> array('notEmpty'),
				'message' 	=> 'Este campo no puede estar vacío!',
			),
			'inlist' => array(
				'rule' 		=> array('inList', array('INSTALADOR', 'EDITOR', 'ADMIN', 'SUPER-ADMIN')),
				// 'required'  => true,
				'message' 	=> 'El rol es inválido!',
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

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' 			=> 'Tag',
			'joinTable' 			=> 'tag_user',
			'foreignKey' 			=> 'user_id',
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
	 * beforeValidate method
	 *
	 * @return boolean
	 */
	public function beforeValidate( $options = array() )
	{
		// Si el usuario es ROOT, le borro todos los tags, total es ROOT no los necesita.
		if( self::isRoleRoot($this->data[$this->alias]['role']) ) {
			$this->data['Tag'] = array(
				/*'Tag' => $this->Tag->getIds()*/
			);
		}

		return true;
	}


	/**
	 * beforeDelete method
	 *
	 * @return boolean
	 */
	public function beforeDelete( $cascade = true ) {

		// Si es él mismo, no se puede borrar
			if( $this->id == AuthComponent::user('user_id') ) {
				return false;
			}

		// Si es algún administrador del sistema, tampoco se puede borrar
			$user = $this->find('first', array(
				'conditions' => array(
					'user_id' => $this->id
				)
			));

			if( in_array($user[$this->alias]['mail'], Configure::read('Environment')['root']) ) {
				return false;
			}

		// Por defecto devuelvo true
			return true;
	}


	/**
	 * beforeSave method
	 *
	 * @return boolean
	 */
	public function beforeSave( $options = array() )
	{
		// Consulta del usuario actual
		$this->old = $this->find('first', array(
			'conditions' => array(
				$this->primaryKey => $this->id
			)
		));

		// Si existe el usuario
		if ( $this->old )
		{
			// Si cambio la password
			if( $this->old[$this->alias]['password'] != $this->data[$this->alias]['password'] )
			{
				// Si tiene una password, la hashea
				if ( isset($this->data[$this->alias]['password']) )
				{
				    $this->data[$this->alias]['password'] = AuthComponent::password( $this->data[$this->alias]['password'] );
				}
			}
		}
		else
		{
			// Si tiene una password, la hashea
			if ( isset($this->data[$this->alias]['password']) )
			{
				$this->data[$this->alias]['password'] = AuthComponent::password( $this->data[$this->alias]['password'] );
			}
		}


		// Si no es un usuario ROOT
		if( AuthComponent::user('user_id') && !self::isRoot() ) {
			// Si no es un rol válido el que voy a guardar (es mayor al rol del usuario que guarda)
			if( !self::isValidRole(self::getRole(), self::getRoleNormalized($this->old[$this->alias]['role']), self::getRoleNormalized($this->data[$this->alias]['role'])) ) {
				return false;
			}
		}


		// Envío de email por alta de usuario root
			$sendEmail = false;

			// Si existe el usuario
				if ( $this->old )
				{
					// Si antes no era root y ahora si lo es
					if( !self::isRoleRoot($this->old[$this->alias]['role']) && self::isRoleRoot($this->data[$this->alias]['role']) ) {
						$sendEmail = true;
					}
				}
			// Si no existe
				else {
					// Y ahora es root
					if( self::isRoleRoot($this->data[$this->alias]['role']) ) {
						$sendEmail = true;
					}
				}

			if($sendEmail) {
				$email = new Email();
				$email->sendUserRootAddedReport($this->data);
			}

		return true;
	}


	/*
	 * Función encargada de comprobar si el usuario es ROOT
	 */
	public static function isRoot()
	{
		// Si el usuario es un super admin
		if( self::isRoleRoot( self::getRole() ) )
			return true;

		// Por defecto no lo es
		return false;
	}


	/*
	 * Función encargada de comprobar si el rol enviado por parámetro es ROOT
	 */
	public static function isRoleRoot( $role = "" )
	{
		// Si el usuario es un super admin
		if( self::getRoleNormalized($role) == self::getRoleNormalized('SUPER-ADMIN') )
			return true;

		// Por defecto no lo es
		return false;
	}


	/*
	 * Función encargada de devolver el rol
	 */
	public static function getRole()
	{
		return self::getRoleNormalized(AuthComponent::user('role'));
	}


	/*
	 * Función encargada de devolver el nombre del rol
	 */
	public static function getRoleName( $role = "" )
	{
		return self::getRoles()[$role];
	}


	/*
	 * Función encargada de devolver el rol en mayusculas (normalizado)
	 */
	public static function getRoleNormalized( $role = "" )
	{
		return strtoupper($role);
	}


	/*
	 * Función encargada de devolver los tags en forma de array
	 */
	public static function getTags()
	{
		return AuthComponent::user('Tag');
	}


	/*
	 * Función encargada de devolver los ids de los tags
	 */
	public static function getTagsIds()
	{
		return Tag::getIds( AuthComponent::user('Tag') );
	}


	/*
	 * Función encargada de devolver los tags en forma de lista
	 */
	public static function getTagsList()
	{
		return Tag::getList( AuthComponent::user('Tag') );
	}


	/*
	 * Función encargada de devolver la lista de roles asociada
	 */
	public static function getRoles()
	{
		return array(
			'INSTALADOR'	=> 'Instalador',
			'EDITOR' 		=> 'Editor',
			'ADMIN' 		=> 'Administrador',
			'SUPER-ADMIN'	=> 'Root'
		);
	}


	/*
	 * Función encargada de devolver los roles disponibles para agregar/editar
	 */
	public static function getAvailableRoles( $userRole, $oldRole )
	{
		// Compruebo sólo que el userRole sea válido ya que el oldRole sólo funciona en edit
		if( $userRole )
		{
			$roles = self::getRoles();


			// Si alguno de los 2 usuario es root
				if( self::isRoleRoot($userRole) || self::isRoleRoot($oldRole) ) {
					return $roles;
				}


			// Si el usuario no es Root
				$userRoleIndex = AppController::array_search_multiple($roles, $userRole);


				// Obtengo los roles válido en base al index
					$i = 0;
					$validRoles = array();

					foreach($roles as $key => $value)
					{
						if($i < $userRoleIndex) {
							$validRoles[$key] = $value;
						}

						$i++;
					}
		

				return $validRoles;
		}


		return array();
	}


	/*
	 * Función encargada de devolver si el rol seleccionado es válido
	 */
	public static function isValidRole( $userRole, $oldRole, $newRole )
	{
		// Chequeo que ninguno de los 3 roles sea nulo
		if($userRole && $oldRole && $newRole)
		{	
			// Obtengo los roles
				$roles = self::getRoles();


			// Obtengo el index del rol del usuario
				$userRoleIndex = AppController::array_search_multiple($roles, $userRole);

			// Obtengo el index del NUEVO rol del usuario que estoy editando
				$newRoleIndex = AppController::array_search_multiple($roles, $newRole);

			// Obtengo el index del VIEJO rol del usuario que estoy editando
				$oldRoleIndex = AppController::array_search_multiple($roles, $oldRole);


			// Si hubo una modificación en el rol
				if($newRole != $oldRole)
				{
					// Si el rol que tenía el usuario es mayor al del que edita || el nuevo rol es mayor al del que edita || el rol era root 
					if( $userRoleIndex < $oldRoleIndex || $newRoleIndex >= $userRoleIndex || self::isRoleRoot($oldRole) ) {
						return false;
					}
				}
			

			// Devuelvo true por defecto si no hubo problemas
				return true;
		}

		return false;
	}

}
