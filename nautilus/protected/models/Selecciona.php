<?php



/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Selecciona extends CFormModel
{
	public $codigodelbarco;
	//public $password;
	//public $rememberMe;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('codigodelbarco', 'required'),
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
			'codigodelbarco'=>UserModule::t("Seleccione la embarcacion que desea ver"),
			//'username'=>UserModule::t("username or email"),
			//'password'=>UserModule::t("password"),
		);
	}

	
}

?>