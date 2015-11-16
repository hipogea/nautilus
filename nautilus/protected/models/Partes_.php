<?php

/**
 * This is the model class for table "partes".
 *
 * The followings are the available columns in table 'partes':
 * @property string $numero
 * @property string $fecha
 * @property string $puerto
 * @property string $puertodes
 * @property integer $horometro
 * @property integer $horometrodes
 * @property integer $numerodecalas
 * @property integer $id
 */
class Partes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Partes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'partes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			/*array('horometro, horometrodes, numerodecalas, id', 'numerical', 'integerOnly'=>true,'message'=>'Debes de colocar un numero'),
			array('numero', 'length', 'max'=>6),
			array('puerto, puertodes', 'length', 'max'=>2),
			array('tempagua', 'required', 'message'=>'Debes de indicar la temperatura'),
			array('fecha', 'safe'),
			array('codep','required','message'=>'Debes de indicar tu embarcacion'),
			array('numero','required','message'=>'Indica el numero de tu Parte'),
			array('puerto','required','message'=>'Indica el puerto donde Zarpaste'),
			array('puertodes','required','message'=>'Indica el puerto de arribo'),
			array('fecha','required','message'=>' ¿ y la fecha ?'),
			array('horometro','required','message'=>'Indica el horometro de zarpe'),
			
			array('horometrodes','checkHorometro'),
			array('horometrodes','required','message'=>'Indica el horometro de arribo'),
			array('numerodecalas','required','message'=>'Hermano, indica cuantas calas hizo el patron'),
			
			array('horometrodes', 'compare', 'compareAttribute'=>'horometro', 'operator'=>'>','message'=>'Hermano , El horometro de arribo debe ser mayor a la lectura de Zarpe'),
			array('numero, fecha, puerto, puertodes, horometro, horometrodes, numerodecalas, id', 'safe', 'on'=>'search'),
		  */
		);
	}

	/**
	 * @return array relational rules.
	 */
	 

	 
	 
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		'barcos'=>array(self::BELONGS_TO, 'Embarcaciones', 'codep'),
		'plantaorigen'=>array(self::BELONGS_TO, 'Plantas', 'puerto'),
		'plantadestino'=>array(self::BELONGS_TO, 'Plantas', 'puertodes')
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codep' => 'Embarcacion',
			'velocidad'=>'Velocidad de la embarcacion (Nudos)',
			'tempagua'=>'Temperatura del agua (ºC)',
			'presionaceite'=>'Presion de aceite (PSI) ',
			'causa'=>'Motivo del Zarpe',
			'numero' => 'Numero de documento',
			'fecha' => 'Fecha de registro',
			'puerto' => 'Puerto de Zarpe',
			'puertodes' => 'Puerto de Descarga o Destino',
			'horometro' => 'Horometro al zarpe',
			'horometrodes' => 'Horometro al arribo',
			'numerodecalas' => 'Numero de Calas',
			'm_rpm' => 'Velocidad del motor (RPM)',
			'm_velocidad' => 'Velocidad de la embarcacion (Nudos)',
			'm_tempagua' => 'Temperatura de agua de la maquina (Escriba en ºF o ºC)',
			'm_presionaceite' => 'Presion de aceite (PSI)',
			'm_tempaceite' => 'Temperatura del aceite',
			'm_difpaceite'=> 'Diferencial de presion en el filtro de aceite (PSI)',
			'acylu_fechaultimocambiomotor'=> 'MOTOR: Fecha del ultimo cambio',  
			'acylu_horometroultimocambio'  => 'MOTOR: Horometro en el ultimo cambio',  
			'acylu_fechaultimocambiocaja'  => 'CAJA : Fecha del ultimo cambio ',  
			'acylu_horometroultimocambiocaja'=> 'CAJA: Horometro en el ultimo cambio',  
			'm_presionpetroleo' => 'Presion de petroleo (PSI)',   
			'm_ difpfpetroleo' => 'Diferencial de presion en el filtro de petroleo (PSI)',
			'm_restfairebr' => 'Restriccion en el filtro de aire Babor (pulg H2O), si es un motor en linea colcoar aqui el unico valor', 
			'm_restfaireer' => 'Restriccion en el filtro de aire Estribor (pulg H2O)',
			'm_taireadm' => 'Temperatura de aire Admision ºF o ºC',
			'm_tgasesturbo' => 'Temperatura de gases de escape de Turbo(s)  (ºC)',  
			'm_tgases1y2' => 'Temperatura de gases de escape unidades 1 y 2  (ºC)', 
			'm_tgases3y4' => 'Temperatura de gases de escape unidades 3 y 4  (ºC)', 
			'm_tgases5y6' => 'Temperatura de gases de escape unidades 5 y 6  (ºC)', 
			'm_tgases7y8' => 'Temperatura de gases de escape unidades 7 y 8  (ºC)', 
			'm_tgases9y10' => 'Temperatura de gases de escape unidades 9 y 10  (ºC)', 
			'm_tgases11y12' => 'Temperatura de gases de escape unidades 11 y 12  (ºC)', 
			'm_tgases13y14' => 'Temperatura de gases de escape unidades 13 y 14  (ºC)', 
			'm_tgases15y16' => 'Temperatura de gases de escape unidades 15 y 16  (ºC)',
			'caja_taceite' => 'CAJA: Temperatura de aceite  (ºC o º F)',
			'caja_paceite' => 'CAJA: Presion de aceite  (PSI)',
			'observacionesfinales' => 'Otras observaciones que desees hacer ',
			'panga_rpm'=>'PANGA : Velocidad del motor (RPM)',
			'panga_taguamot'=>'PANGA: Temperatura de agua del motor (ºC o ºF)',
			'panga_paceitecaja'=>'PANGA : Presion de aceite de Caja (PSI)',
			'panga_paceitemotor'=>'PANGA : Presion de aceite del motor (PSI)',
			'acylu_consumomotor'=> 'MOTOR: Consumo de aceite (gl) ',  
			'acylu_consumocaja'  => 'CAJA: Consumo de aceite (gl)',  
			'acylu_consumohid'  => 'SISTEMA HIDRAULICO : Consumo de aceite (gl) ',  
			'acylu_consumograsa'=> 'Consumo de grasa',  
			'acylu_observaciones'=> 'Observaciones', 
			'd2_zarpe'=> 'Stock de combustible al zarpe ',  
			'd2_arribo'  => 'Stock de combustible al arribo',  
			'd2_estimadohora'=> 'Estimado comsumo por hora Gl/Hr ',  
			'd2_observaciones'  => 'Obervaciones',  		
			'id' => 'ID',
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

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('fechazarpe',$this->fechazarpe,true);
		$criteria->compare('puerto',$this->puerto,true);
		$criteria->compare('puertodes',$this->puertodes,true);
		$criteria->compare('horometro',$this->horometro);
		$criteria->compare('horometrodes',$this->horometrodes);
		$criteria->compare('numerodecalas',$this->numerodecalas);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function checkHorometro($attribute,$params) 	{  
 
					//$tiempoarribo =  strtotime($this->fechaarribo);
					$tiempoarribo =  $this->fechaarribo;
					//$tiempozarpe =   strtotime($this->fechazarpe);
					$tiempozarpe =   $this->fechazarpe;
//new DateTime(date($this->fechaarribo));
					//$tiempozarpe = new DateTime(date($this->fechazarpe));
					$horastranscurridas =( $tiempoarribo-$tiempozarpe)/(60*60);		
					$diferenciahorometro=$this->horometrodes-$this->horometro;
									if ( $horastranscurridas < $diferenciahorometro) {
															$this->adderror('horometrodes','Esta lectura no puede ser, en reloj  han pasado menos horas :'.$this->fechaarribo);
																	}
									}
	
	
						}