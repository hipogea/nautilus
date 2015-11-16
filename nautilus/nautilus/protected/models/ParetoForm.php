<?php

/**
 * L
 * Para colectar datos para efectuar el pareto
 *
 */
class ParetoForm extends CFormModel
{
	public $almacen;
	public $centro;
	public $rangoa;
	public $rangob;
	public $rangoc;
	public $codtipo;





	public function rules()
	{
		return array(
			// username and password are required
			array('almacen, centro', 'required'),
			// rememberMe needs to be a boolean
			array('centro', 'validarcentroalmacen'),
			array('almacen', 'validarcentroalmacen'),
			array('rangoa,rangob, rangoc', 'required'),
			array('rangoa,rangob, rangoc', 'numerical'),
			array('rangoa,rangob, rangoc', 'validarporcentajes'),

		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'almacen'=>'Almacen',
			'centro'=>'Centro',
			'rangoa'=>'Rango A %',
			'rangob'=>'Rango B %',
			'rangoc'=>'Rango C %',
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
