<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model
{

	/** @var array set the behaviour to `Containable` */
	public $actsAs = array('Containable');

	public function currentUser()
	{
		$testAuth = class_exists("AuthComponent");

		$id 	= null;
		$mail 	= 'GUEST';

		if ($testAuth != null)
		{
			if (AuthComponent::user('user_id') != null)
			{
				$id 	= AuthComponent::user('user_id');
				$mail 	= AuthComponent::user('mail');
			}
		}

	    return array(
	    	'id' 	=> $id,
	    	'mail' 	=> $mail
	    );
	}

	/**
	* copy the HABTM post value in the data validation scope
	* from data[distantModel][distantModel] to data[model][distantModel]
	* @return bool true
	*/
	public function beforeValidate( $options = array() )
	{
		foreach( array_keys($this->hasAndBelongsToMany) as $model )
		{
			if( isset($this->data[$model][$model]) )
			{
				$this->data[$this->name][$model] = $this->data[$model][$model];
			}
		}

		return true;
	}

	/**
	* delete the HABTM value of the data validation scope (undo beforeValidate())
	* and add the error returned by main model in the distant HABTM model scope
	* @return bool true
	*/
	public function afterValidate( $options = array() )
	{
		foreach( array_keys($this->hasAndBelongsToMany) as $model )
		{
			unset($this->data[$this->name][$model]);
			
			if( isset($this->validationErrors[$model]) )
			{
				$this->$model->validationErrors[$model] = $this->validationErrors[$model];
			}
		}

		return true;
	}

}
