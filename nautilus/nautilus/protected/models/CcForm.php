<?php

/**
 * L
 * Para colectar datos para efectuar el pareto
 *
 */
class CcForm extends CFormModel
{
	public $fecha1;
	public $fecha2;
	public $colector;
	public $clasecolector;
	public $vceco;

	public function rules()
	{
		return array(
			// username and password are required
			array('fecha1,fecha2, clasecolector', 'required','message'=>'Este dato es obligatorio','on'=>'resumen'),
			array('fecha1,fecha2, clasecolector', 'safe','on'=>'resumen'),
			// rememberMe needs to be a boolean

			array('fecha1,fecha2, vceco', 'required','message'=>'Este dato es obligatorio','on'=>'detalle'),
			array('fecha1,fecha2, vceco', 'safe','on'=>'detalle'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'fecha1'=>'Fecha inicio',
			'fecha2'=>'Fecha final',
			'clasecolector'=>'Clase colector',

		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function validarcentroalmacen($attribute,$params)
	{
		$centro=Centros::model()->findByPk($this->centro);
		$almacen=Almacenes::model()->findByPk($this->almacen);

		if(is_null($centro))
		 $this->adderror('centro','El centro no existe');
		if(is_null($almacen))
		$this->adderror('almacen','El almacen no existe');
		  if(!$almacen->codcen==$this->centro)
			  $this->adderror('almacen','Este almacen no correponde a este centro');




	}

	public function validarporcentajes($attribute,$params)
	{
		if($this->rangoa >=100)
			$this->adderror('rangoa','Debe ser un valor menor al total');
		if($this->rangoa <= 50 )
			$this->adderror('rangoa','Es un parametro muy extendido para el analisis de pareto; se recomienda mayores A 50%');
		if($this->rangoa+$this->rangob+$this->rangoc >100 )
			$this->adderror('rangoc','Los valores soprepasan al  100%');
		if($this->rangoa+$this->rangob+$this->rangoc < 100 )
			$this->adderror('rangoc','Los valores no llegan al  100%');
		if($this->rangob >100 )
			$this->adderror('rangob','Debe ser un valor menor al total');
		if($this->rangoc >100 )
			$this->adderror('rangoc','Debe ser un valor menor al total');



	}
}
