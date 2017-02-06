<?php

App::uses('AppModel', 'Model');

/**
 * Audit Model
 *
 * @property Source $Source
 * @property AuditDelta $AuditDelta
 */
class Audit extends AppModel
{
	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'audits';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'id';

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' 	=> 'User',
			'foreignKey' 	=> 'source_id',
			'conditions' 	=> '',
			'fields' 		=> '',
			'order' 		=> ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'AuditDelta' => array(
			'className' 	=> 'AuditDelta',
			'foreignKey' 	=> 'audit_id',
			'dependent' 	=> false,
			'conditions' 	=> '',
			'fields' 		=> '',
			'order' 		=> '',
			'limit' 		=> '',
			'offset' 		=> '',
			'exclusive' 	=> '',
			'finderQuery' 	=> '',
			'counterQuery' 	=> ''
		)
	);

}
