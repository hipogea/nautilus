<?php

/**
 * This is the model class for table "carteres".
 *
 * The followings are the available columns in table 'carteres':
 * @property integer $idequipo
 * @property double $capacidad
 * @property string $tipoaceite
 * @property integer $horascambio
 * @property string $tipocarter
 * @property integer $haceite
 * @property integer $hmuestra
 * @property integer $nummuestras
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $fulectura
 * @property string $fumuestra
 * @property string $fucambio
 * @property integer $horometro
 * @property string $codigo
 * @property string $activo
 * @property integer $hucambio
 * @property integer $casco
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Inventario $idequipo0
 * @property Maestrocomponentes $tipoaceite0
 */
class Cartereshorometro extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Carterescambio the static model class
	 */
	 
	 public $vhorometro;
	public $vfulectura;
	 
	 
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'carteres';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hucambio,horometro ', 'numerical', 'integerOnly'=>true),			
			array('fucambio,  hucambio,vfucambio,vhorometro', 'safe'),
			array('fulectura', 'required', 'message'=>'Llena la fecha de lectura'),
			array('horometro', 'required', 'message'=>'Llena el horometro '),
			array('fulectura','checkdatos'),
			array('horometro','checkdatos'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,fulectura,horometro,fucambio,  hucambio', 'safe', 'on'=>'search'),
		);
	}

	
	
	
	
	
	
	
	public function checkdatos($attribute,$params)
	{
	   /*******
		Primero, verificams que la fecha de lectura no este en el futruro 
		
		********/
		if ((strtotime($this->fulectura) -strtotime(" ".date("Y-m-d")." ")) > 12*3600 ) 
		    $this->adderror('fulectura','Estas colocando : '.date("d/m/Y",strtotime($this->fulectura)).' Una fecha en el futuro');
			




	   /*******
		Esta parte del codigo valida la nueva fecha del lectura, es decir que no puedes registrar 
		una fecha anterior al ultimo cambio registrado por ejemplo si cambiaste el aceite 
		un 21-08-2012 no podrias colocar la fecha de lectura como 19-08-2012	
		********/
		if ((strtotime($this->fulectura) -strtotime($this->fucambio)) < 0 ) 
		    $this->adderror('fulectura','Estas colocando : '.date("d/m/Y",strtotime($this->fulectura)).' No puedes ser, tu ultimo cambio de aceite lo hiciste el '.date("d/m/Y",strtotime($this->fucambio)).' Estas registrando una fecha anterior');
			
		/*******
		This section code, validates the new odometer value, you can't enter a value 
		less than last odometer value, It would be ridiculuos
		********/
		if ($this->horometro  < $this->hucambio ) 
		    $this->adderror('horometro','Estas colocando : ('.$this->horometro.'),  No puedes ser, tu ultimo cambiolo hiciste cuando tenias  ('.$this->vhorometro.') Horas, esta lectura es anterior');
			
			
		 /*******
		Esta parte del codigo valida la nueva fecha del lectura, es decir que no puedes registrar 
		una fecha anterior a la ultima lectura por ejemplo registraste una lecttura
		un 21-08-2012 no podrias colocar la nueva fecha de lectura como 19-08-2012	
		********/
		if ((strtotime($this->vfulectura) -strtotime($this->fulectura)) > 0 ) 
		    $this->adderror('fulectura','Estas colocando : '.date("d/m/Y",strtotime($this->fulectura)).' No puede ser pues,  tu ultima lectura fue el '.date("d/m/Y",strtotime($this->vfulectura)).' Estas registrando una fecha anterior');
				
		
		/*******
		This section code, validates the new odometer value, you can't enter a value 
		less than last odometer value, It would be ridiculuos
		********/
		if ($this->vhorometro > $this->horometro ) 
		    $this->adderror('horometro','Estas colocando : ('.$this->horometro.')  No puedes ser, tu ultima lectura lo hiciste cuando tenias  '.$this->vhorometro.' Horas, esta lectura es anterior');
			
		
		//verifcando copnsitencia de las 24 horas diarias + 24 por supeusto para la diferncia de horas
		
		
		///Dias trabajados en calendario
		  $diascalendario= (strtotime($this->fulectura) -strtotime($this->vfulectura))/(3600*24) +1;		  
		///Dias pasados en horometro
		 $diasenhorometro=($this->horometro -$this->vhorometro)/24;		 
		 //ahora la difeerncia no puede ser mas de 24 horas por un ajuste de horas 
		if(($diasenhorometro-$diascalendario) > 0 ) 
		   $this->adderror('horometro','....UPs, en reloj han pasado solo '.strval($diascalendario*24).' horas, sin embargo segun el horometro que has colocado ('.$this->horometro.')  : '.$this->horometro.'- '.$this->vhorometro.'='.($this->horometro-$this->vhorometro).'  ');
		
		///Dias trabajados en calendario
		  $diascalendario= (strtotime($this->fulectura) -strtotime($this->fucambio))/(3600*24) +1;		  
		///Dias pasados en horometro
		 $diasenhorometro=($this->horometro -$this->hucambio)/24;		 
		 //ahora la difeerncia no puede ser mas de 24 horas por un ajuste de horas 
		if(($diasenhorometro-$diascalendario) > 0 ) 
		   $this->adderror('horometro','....UPs, Este horometro no coincide con le ultimo cambio');
		
		
		
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		
	}

	
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idequipo0' => array(self::BELONGS_TO, 'Inventario', 'idequipo'),
			'tipoaceite0' => array(self::BELONGS_TO, 'Maestrocomponentes', 'tipoaceite'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(			
			'fulectura' => 'Fulectura',			
			'fucambio' => 'Fucambio',			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		$criteria->compare('horometro',$this->horometro,true);
		
		$criteria->compare('fulectura',$this->fulectura,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}