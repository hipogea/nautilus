<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Configuraciongeneral extends CFormModel
{

	/*****general****/
	public $general_monedadef;
	public $general_rutatemaimagenes;
	public $general_horaspasadastipocambio;


	/*****documentos***/
	public $documentos_numeromaxbloqueos;
	public $documentos_docmascara;
	public $documentos_selloagua;
	public $documentos_archivo_sello_agua=null;
	public $documentos_controlrecepcion=null;
public $documentos_tolerecepfacturaendias=null;

	/*****transporte***/
	public $transporte_tiempopermitidohastaentrega;
	public $transporte_trancheck;


	/*****inventario***/
	public $inventario_periodocontrol;
	//public $adminnoticias;

	/*****compras***/
	public $compras_restringircantidades;

	/*****Activo fijo***/
	public $af_afmascara;
	public $af_rutafotosinventario;


	/*****Colectores***/
	public $colectores_ccmascara;

	/*****Materiales***/
	public $materiales_rutaimagenesmateriales;
	public $materiales_codigoservicio;

	/*****correo***/
	public $email_adminemail;
	public $email_usamaildeusuario;
	public $email_rutaficherosdeplantillas;
	public $email_tiempodeespera;
	public $email_smtpdebug; //=2
	public $email_servemail; ///mail.neotegnia.com
	public $email_smtpauth;  //=true
	public $email_cuentahost;//jramirez@neotegnia.com
	public $email_passwordhost;//pawd







	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(

			array('general_monedadef,
				   general_rutatemaimagenes,
				   general_horaspasadastipocambio,
					documentos_numeromaxbloqueos,
					documentos_docmascara,
					documentos_archivo_sello_agua,
					documentos_tolerecepfacturaendias,
					transporte_tiempopermitidohastaentrega,
					transporte_trancheck,
					,inventario_periodocontrol,
					compras_restringircantidades,
					af_afmascara,
					af_rutafotosinventario,
					colectores_ccmascara,
					materiales_rutaimagenesmateriales,
					materiales_codigoservicio,
					email_adminemail,
					email_usamaildeusuario,
					email_rutaficherosdeplantillas,
					email_tiempodeespera,

					email_smtpdebug,
					email_servemail,
					email_cuentahost',
				'required','message'=>'Este dato es obligatorio'
			),
			array('documentos_selloagua,documentos_controlrecepcion','safe'),
			array(
				// array('transporte_tiempopermitidohastaentrega','numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>100),
				'transporte_tiempopermitidohastaentrega', 'numerical', 'integerOnly'=>true,
			),


			//array(
			array('inventario_periodocontrol','numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>30),
			//),
			array(
				'af_rutafotosinventario,general_rutatemaimagenes,	materiales_rutaimagenesmateriales,email_rutaficherosdeplantillas','chkdirectorio',
			),


		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(


			'general_monedadef'=>'Moneda base',
	'documentos_numeromaxbloqueos'=>'Cant Max Documentos abiertos por usuario',
			'documentos_selloagua'=>'Sello de agua',
			'documentos_archivo_sello_agua'=>'Archivo sello agua',
			'documentos_tolerecepfacturaendias'=>'Tolerancia recep facturas (dias)',
	'transporte_tiempopermitidohastaentrega'=>'Dias permitidos para anular despacho ',
	'transporte_trancheck'=>'Restringir Mov Af por lugar',
	'inventario_periodocontrol'=>'Periodo Dias control de inventario',
	//public $adminnoticias;
	'compras_restringircantidades'=>'Restringir cant en compras',
	'af_afmascara'=>'Mascara cod AF',
	'documentos_docmascara'=>'Mascara Doc',
	'colectores_ccmascara'=>'Mascara Ceco',
	'af_rutafotosinventario'=>'Direc Fotos AF',
	'general_rutatemaimagenes'=>'Direc imagenes del tema actual',
	'materiales_rutaimagenesmateriales'=>'Direc imagenes materiales',
			'materiales_codigoservicio'=>'Codigo servicio',
	'email_adminemail'=>'Email del webmaster',
	'email_usamaildeusuario'=>'Usar mail de usuario al enviar',
	'email_rutaficherosdeplantillas'=>'Directorio plantillas mensajes',
	'email_tiempodeespera'=>'Tiempo (s) antes de enviar mensaje',
			'email_smtpdebug'=>'Modo depuracion SMTP',
			'email_servemail'=>'Servidor de correo',
			'email_cuentahost'=>'Cuenta de correo motor',
			'email_passwordhost'=>'Password de la cuenta',



		);
	}



	public function chkdirectorio($attribute,$params) {
	///	$ruta=yii::app()->basePath : /home/neologys/public_html/recurso/protected;


		if (!is_dir(Yii::getPathOfAlias('webroot').$this->af_rutafotosinventario));
		$this->adderror('af_rutafotosinventario','El directorio de la ruta fotos inventario no existe');
		if (!is_dir(Yii::getPathOfAlias('webroot').$this->general_rutatemaimagenes));
		$this->adderror('general_rutatemaimagenes','El directorio de la ruta imagenes del tema no existe');
		if (is_dir(Yii::getPathOfAlias('webroot').$this->materiales_rutaimagenesmateriales));
		$this->adderror('materiales_rutaimagenesmateriales','El directorio de la ruta fotos de materiales no existe');
		if (!is_dir(Yii::getPathOfAlias('webroot').$this->email_rutaficherosdeplantillas));
		$this->adderror('email_rutaficherosdeplantillas','El directorio de la ruta de ficheros de plantillas no existe');
		//if (!is_file(Yii::getPathOfAlias('webroot').$this->documentos_archivo_sello_agua));
		//$this->adderror('documentos_archivo_sello_agua','El directorio de la ruta de ficheros de plantillas no existe');

	}


}
