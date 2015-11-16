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
class Carterescambio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Carterescambio the static model class
	 */
	 
	 public $fucambiox;
	public $hucambiox;
	 
	 
	 
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
			array('haceite, hucambio, ', 'numerical', 'integerOnly'=>true),			
			array('fucambio,  hucambio,hucambiox,fucambiox', 'safe'),
			array('fucambio', 'required', 'message'=>'Llena la fecha de cambio'),
			array('hucambio', 'required', 'message'=>'Llena el horometro del cambio'),
			array('fucambio','checkdatos'),
				array('hucambio','checkdatos'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,fucambio,horometro,fulectura,  hucambio', 'safe', 'on'=>'search'),
		);
	}

	
	
	
	
		
	
	
	
	
	
	
	public function checkhorometroparteesmenor()
	{
	  ///verificando con las lecturas de los partes 
		$modeloinventario=Inventario::model()->findByPk($this->idequipo);		
		$datospartes=VwUltimashoras::model()->search($modeloinventario->codep); 
		$matr=$datospartes->getdata();
		
		 if(count($matr)>0) {
				
				$ultimalectura=$matr[0]['horometrodes'];
				$ultimafecha=$matr[0]['fechaarribo'];
				
				if (strtotime($ultimalectura) > strtotime($this->hucambio)) 
							{
								return false;
							}else {
							return true;
							}
				
				
		 } else
		 
		 {
		   return true;
		 }
		//ESTE MODELO YA ESTA ORDENADO DESDE EL MOTOR DE DATOS 
		//coiendo le ultimo parte de mortorista
	}
	
	
	
	
	
	
	
	
	public function checkdatos($attribute,$params)
	{
	   
  /*  si esta en le futuro aviosar */
     if ((strtotime($this->fucambio) -strtotime(" ".date("Y-m-d")." ")) > 12*3600 ) 
		    $this->adderror('fucambio','Estas colocando : '.date("d/m/Y",strtotime($this->fucambio)).' Una fecha en el futuro');



	   /*******
		Esta parte del codigo valida la nueva fecha del cambio, es decir que no puedes registrar 
		una fecha anterior al ultimo cambio registrado por ejemplo si cambiaste el aceite 
		un 21-08-2012 no podrias colocar la fecha del ultimo cambio como 19-08-2012	
		********/
		if ((strtotime($this->fucambiox) -strtotime($this->fucambio)) > 0 ) 
		    $this->adderror('fucambio','No puedes ser tu ultimo cambio lo hiciste el '.date("d/m/Y",strtotime($this->fucambiox)).' Estas registrando una fecha anterior');
			
		/*******
		This section code, validates the new odometer value, you can't enter a value 
		less than last odometer value, It would be ridiculuos
		********/
		if ($this->hucambiox > $this->hucambio ) 
		    $this->adderror('hucambio','No puedes ser tu ultimo cambiolo hiciste cuando tenias  '.$this->hucambiox.' Horas, esta lectura es anterior');
			
			
		
		//verifcando copnsitencia de las 24 horas diarias + 24 por supeusto para la diferncia de horas
		
		
		///Dias trabajados en calendario
		  $diascalendario= (strtotime($this->fucambio) -strtotime($this->fucambiox))/(3600*24) +1;
		  
		///Dias pasados en horometro
		 $diasenhorometro=($this->hucambio -$this->hucambiox)/24;
		 
		 //ahora la difeerncia no puede ser mas de 24 horas por un ajuste de horas 
		if(($diasenhorometro-$diascalendario) > 24 ) 
		   $this->adderror('hucambio','....UPs, en calendario han pasado solo '.strval($diascalendario*24).' horas, este horometro esta muy adelantado');
		
		
		
		///verificando con las lecturas de los partes 
		$modeloinventario=Inventario::model()->findByPk($this->idequipo);		
		$datospartes=VwUltimashoras::model()->search($modeloinventario->codep);  //ESTE MODELO YA ESTA ORDENADO DESDE EL MOTOR DE DATOS 
		//coiendo le ultimo parte de mortorista
		 if(isset($datospartes)) {
		        
				$matr=$datospartes->getdata();
				 if(count($matr)>0) {
						$ultimalectura=$matr[0]['horometrodes'];
							$ultimafecha=$matr[0]['fechaarribo'];
				
				 ///puede que la fecha de cambio sea mayor menor que la ultima fecha registrado en el parte
						 if ((strtotime($ultimafecha) -strtotime($this->fucambio))> 0) 
						       {		
								//Dias trabajados en calendario
									$diascalendario= (strtotime($ultimafecha) -strtotime($this->fucambio))/(3600*24) +1;
								///Dias pasados en horometro
															$diasenhorometro=($this->hucambio -$ultimalectura)/24;
																if(($diasenhorometro-$diascalendario) > 24 ) 
																		$this->adderror('hucambio',' Revisa tu parte, en calendario han pasado solo '.strval($diascalendario*24).' horas, este horometro esta muy adelantado');
								 }else{
				///si la fecha del ultimo cambio es mayor que cualquier fecha del parte 
								      $diascalendario= ( strtotime($this->fucambio)- strtotime($ultimafecha))/(3600*24) +1;
								///Dias pasados en horometro
								      $diasenhorometro=($ultimalectura-$this->hucambio )/24;
									  if(($diasenhorometro-$diascalendario) > 24 ) 
																		$this->adderror('hucambio',' Revisa tu parte, en calendario han pasado solo '.strval($diascalendario*24).' horas, este horometro esta muy adelantado');
								
								 }
						}
		   }
		
		
		
		  
		
		
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

		
		$criteria->compare('fulectura',$this->fulectura,true);
		
		$criteria->compare('fucambio',$this->fucambio,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}