<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class cargainForm extends CFormModel
{
	public $centro;
	public $almacen;
	//public $rememberMe;

	//private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('centro, almacen','required','message'=>'Datos incompletos'),
			// rememberMe needs to be a boolean
			//array('rememberMe', 'boolean'),
			// password needs to be authenticated
			//array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			//'rememberMe'=>'Recordar estos datos',
			//'username'=>'Usuario Motorista',
			//'password'=>'Contrasena',
		);
	}

	
}
