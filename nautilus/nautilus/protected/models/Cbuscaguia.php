<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Cbuscaguia extends CFormModel
{
	public $ptopartida;
	public $ptollegada;
	public $c_numgui;
	public $c_serie;
	public $d_fectra;
	public $d_fectra1;
	public $razondestinatario;
	public $estado;
	public $c_itguia;
	public $n_cangui;
	public $c_codgui;
	public $c_descri;
	public $c_codep;
	public $c_codactivo;
	//public $c_codactivo;
	public $c_codsap;


	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			//array('username, password', 'required'),
			// rememberMe needs to be a boolean
			//array('rememberMe', 'boolean'),
			// password needs to be authenticated
			//array('password', 'authenticate'),
				//array('horometro, horometrodes, numerodecalas, d2_zarpe,d2_arribo', 'numerical', 'integerOnly'=>true,'message'=>'Debes de colocar un numero'),
			//array('numero', 'length', 'max'=>6),
			//array('puerto, puertodes', 'length', 'max'=>2),
			//array('tempagua', 'required', 'message'=>'Debes de indicar la temperatura'),
			//array('m_velocidad', 'in','range'=>range(1,20),'message'=>'Esta velocidad no puede ser'),
			//array('m_rpm', 'in','range'=>range(200,3500),'message'=>'Esta velocidad no puede ser'),
			//array('m_presionaceite', 'in','range'=>range(10,100),'message'=>'Esta presion no puede ser'),
			//array('fecha', 'safe'),
			//array('codep','required','message'=>'Debes de indicar tu embarcacion'),
			//array('numero','required','message'=>'Indica el numero de tu Parte'),
			//array('puerto','required','message'=>'Indica el puerto donde Zarpaste'),
			//array('puertodes','required','message'=>'Indica el puerto de arribo'),
			//array('fecha','required','message'=>' ¿ y la fecha ?'),
			//array('fechazarpe','required','message'=>' ¿ y la fecha de zarpe?'),
			//array('fechaarribo','required','message'=>' ¿ y la fecha de arribo?'),
			//array('horometro','required','message'=>'Indica el horometro de zarpe'),
			//array('zarpo','required','message'=>'Indica si zarpo o no'),
			array('d_fectra','checkfecha'),
			array('d_fectra1','checkfecha'),
			//array('horometrodes','required','message'=>'Indica el horometro de arribo'),
			//array('numerodecalas','required','message'=>'Hermano, indica cuantas calas hizo el patron'),	
			//array('numero, fecha, puerto, puertodes, horometro, horometrodes, numerodecalas, id', 'safe', 'on'=>'search'),
		   //array('horometrodes', 'compare', 'compareAttribute'=>'horometro', 'operator'=>'>','message'=>'Hermano , El horometro de arribo debe ser mayor a la lectura de Zarpe'),
				array('d_fectra,d_fectra1,ptopartida,ptollegada,c_numgui,c_serie,razondestinatario,estado,c_itguia,n_cangui,c_codgui,c_descri,c_codactivo,c_codsap',  'safe', 'on'=>'search'),
			);
		
	}

		
	public function checkfecha($attribute,$params) 	{  
				$fechainicio=$this->d_fectra;
				$fechafinal=$this->d_fectra1;
						if (!isset($fechainicio)  OR $fechainicio=="" ) {
									if (!isset($fechafinal)  OR $fechafinal=="" ) 
								    {
									   //INICIO BLANCO   FINAL BLANCO
									   
									} else {
									  // INICIO BLANCO   FINAL LLEMO 
									  
									}
						
						} else {
								if (!isset($fechafinal)  OR $fechafinal=="" ) 
								    {
									    //INICIO LLENO FINAL BLANCO
									} else {
									   //INICIO LLENO  FINAL LLENO
									   
									   if ( $fechainicio > $fechafinal ) {
									      $this->adderror('d_fectra','Las fecha de inicio es mayor que la fecha final ');
										   $this->adderror('d_fectra1','Las fecha de inicio es mayor que la fecha final ');
									   }
									   
									} 
													
						}
						
	}	
	
	
	
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}

	
}
