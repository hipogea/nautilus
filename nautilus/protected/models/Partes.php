<?php

/**
 
 * @property Embarcaciones $codep0
 */
 
class Partes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Partes the static model class
	 */
	 
	
 //----Agunos campos calculados interesantes -------------------
   public $consumocombustible  ;  //Guarda el consumo de petroleo
   public $consumoporhora ; ///guarda el consumo por hora  
   public $horasdeaceitemotor ; ///La cantidad de horas del aceite
   public $horasdeaceitecaja ; ///La cantidad de horas del aceite
   public $numeroauxiliar ; // Un numero aleatorio que guarda el hid  par acvtualizar los reistros hijos de las novedades 
   public $embarcaciones_nomep; ///es para pintar el campo relacionado de embarcaicones en le gris y ralizar filtros y bsiuedas 
   public $horastrabajadas;
 //-------------------------------------------------------------
  //public function init() {
	   //$this->consumocombustible=$this->d2_arribo-$this->d2_zarpe;
	
	//}
	
	//----ahora le agremosd la funcion de pintar locampos calculados 
	public  function refrescacampos()
		{
									$this->consumocombustible=$this->d2_zarpe-$this->d2_arribo;
									 if(($this->horometrodes-$this->horometro)==0 ){
											$this->consumoporhora=0;
									 } else {
									   $this->consumoporhora=round($this->consumocombustible/($this->horometrodes-$this->horometro),2);
									 }
									$this->horastrabajadas=$this->horometrodes-$this->horometro;
									//$this->horasdeaceitemotor=$this->horometrodes-$this->acylu_horometroultimocambio;
									//$this->horasdeaceitecaja=$this->horometrodes-$this->acylu_horometroultimocambiocaja;
								
				
				//return 1;					
		//return parent::model($className);
		}
   ///----interesante mis priemros pasos en YII
	 
	 
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
		    array('numeroauxiliar,numero, fecha, puerto, puertodes, horometro, horometrodes, numerodecalas, 
            codep, velocidad,tempagua, presionaceite, idusuario, zarpo, 
            causa, m_rpm, m_velocidad, m_tempagua, m_presionaceite, m_tempaceite, 
            m_difpaceite,m_presionpetroleo, m_difpfpetroleo, m_restfairebr, 
            m_restfaireer, m_taireadm, m_tgasesturbo, m_tgases1y2, m_tgases3y4, 
            m_tgases5y6, m_tgases7y8,m_tgases9y10, m_tgases11y12, m_tgases13y14, 
            m_tgases15y16, caja_taceite, caja_paceite, panga_rpm, panga_taguamot, 
            panga_paceitemotor, panga_paceitecaja, d2_zarpe, d2_arribo, d2_estimadohora, 
            d2_observaciones, acylu_consumomotor, acylu_consumocaja, acylu_consumohid, 
            acylu_consumograsa, acylu_observaciones, 
            acylu_horometroultimocambio,  acylu_horometroultimocambiocaja, 
            observacionesfinales,  fechazarpe, fechaarribo','safe'),
			array('horometro, horometrodes, numerodecalas, d2_zarpe,d2_arribo', 'numerical', 'integerOnly'=>true,'message'=>'Debes de colocar un numero'),
			array('numero', 'length', 'max'=>6),
			array('puerto, puertodes', 'length', 'max'=>2),
			//array('tempagua', 'required', 'message'=>'Debes de indicar la temperatura'),
			//array('m_velocidad', 'in','range'=>range(1.00,20.00),'message'=>'Esta velocidad de embarcacion no puede ser'),
			array('m_rpm', 'in','range'=>range(200,3500),'message'=>'Esta velocidad del motor no puede ser'),
			array('m_presionaceite', 'in','range'=>range(0,100),'message'=>'Esta presion de aceite de motor no puede ser'),
			//array('fecha', 'safe'),
			array('codep','required','message'=>'Debes de indicar tu embarcacion'),
			//array('numero','required','message'=>'Indica el numero de tu Parte'),
			array('puerto','required','message'=>'Indica el puerto donde Zarpaste'),
				array('causa','required','message'=>'No has llenado como zarpa la embarcacion'),
			array('puertodes','required','message'=>'Indica el puerto de arribo'),
			array('fecha','required','message'=>' ¿ y la fecha ?'),
			array('fechazarpe','required','message'=>' ¿ y la fecha de zarpe?'),
			array('fechaarribo','required','message'=>' ¿ y la fecha de arribo?'),
			array('horometro','required','message'=>'Indica el horometro de zarpe'),
			array('zarpo','required','message'=>'Indica si zarpo o no'),
			array('horometrodes','checkHorometro'),
			array('horometrodes','required','message'=>'Indica el horometro de arribo'),
			array('numerodecalas','required','message'=>'Hermano, indica cuantas calas hizo el patron'),
			
		
			//array('numero, fecha, puerto, puertodes, horometro, horometrodes, numerodecalas, id', 'safe', 'on'=>'search'),
		   array('horometrodes', 'compare', 'compareAttribute'=>'horometro', 'operator'=>'>','message'=>'Hermano , El horometro de arribo debe ser mayor a la lectura de Zarpe'),
				array('embarcaciones_nomep,codep',  'safe', 'on'=>'search'),
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
		'embarcaciones'=>array(self::BELONGS_TO, 'Embarcaciones', 'codep'),
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
			'horasdeaceitemotor'=> 'Horas de trabajo del aceite del motor ',
			'horasdeaceitecaja'=> 'Horas de trabajo del aceite de la caja  ',
			'consumocombustible'=>'Consumo de petroleo',
			'velocidad'=>'Velocidad de la embarcacion (Nudos)',
			'tempagua'=>'Temperatura del agua (C)',
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
			'm_tempagua' => 'Temperatura de agua de la maquina (Escriba en F o C)',
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
			'm_taireadm' => 'Temperatura de aire Admision F o C',
			'm_tgasesturbo' => 'Temp. gases de escape de Turbo(s)  (C)',  
			'm_tgases1y2' => 'Temp. gasesescape  1 y 2  (C)', 
			'm_tgases3y4' => 'Temp. gases escape  3 y 4  (C)', 
			'm_tgases5y6' => 'Temp. gases escape  5 y 6  (C)', 
			'm_tgases7y8' => 'Temp. gases escape 7 y 8  (C)', 
			'm_tgases9y10' => 'Temp. gases escape  9 y 10  (C)', 
			'm_tgases11y12' => 'Temp. gases escape  11 y 12  (C)', 
			'm_tgases13y14' => 'Temp. gases escape  13 y 14  (C)', 
			'm_tgases15y16' => 'Temp. gases escape  15 y 16  (C)',
			'caja_taceite' => 'CAJA: Temp aceite  (C o  F)',
			'caja_paceite' => 'CAJA: Presion de aceite  (PSI)',
			'observacionesfinales' => 'Otras observaciones que desees hacer ',
			'panga_rpm'=>'PANGA : Velocidad del motor (RPM)',
			'panga_taguamot'=>'PANGA: Temperatura de agua del motor (C o ºF)',
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
		//$criteria->compare('numeroauxiliar',$this->numero,true);
		//$criteria->compare('horasdeaceitemotor',$this->horasdeaceitemotor,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('puerto',$this->puerto,true);
		$criteria->compare('puertodes',$this->puertodes,true);
		$criteria->compare('horometro',$this->horometro);
		$criteria->compare('horometrodes',$this->horometrodes);
		$criteria->compare('numerodecalas',$this->numerodecalas);		
		$criteria->compare('velocidad',$this->velocidad);
		$criteria->compare('tempagua',$this->tempagua);
		$criteria->compare('presionaceite',$this->presionaceite);
		$criteria->compare('idusuario',$this->idusuario);
		$criteria->compare('zarpo',$this->zarpo,true);
		$criteria->compare('causa',$this->causa,true);
		$criteria->compare('m_rpm',$this->m_rpm);
		$criteria->compare('m_velocidad',$this->m_velocidad);
		$criteria->compare('m_tempagua',$this->m_tempagua);
		//$criteria->compare('m_presionaceite',$this->m_presionaceite);
		//$criteria->compare('m_tempaceite',$this->m_tempaceite);
		//$criteria->compare('m_difpaceite',$this->m_difpaceite);
		/*$criteria->compare('m_presionpetroleo',$this->m_presionpetroleo);
		$criteria->compare('m_difpfpetroleo',$this->m_difpfpetroleo);
		$criteria->compare('m_restfairebr',$this->m_restfairebr);
		$criteria->compare('m_restfaireer',$this->m_restfaireer);
		$criteria->compare('m_taireadm',$this->m_taireadm);
		$criteria->compare('m_tgasesturbo',$this->m_tgasesturbo);
		$criteria->compare('m_tgases1y2',$this->m_tgases1y2);
		$criteria->compare('m_tgases3y4',$this->m_tgases3y4);
		$criteria->compare('m_tgases5y6',$this->m_tgases5y6);
		$criteria->compare('m_tgases7y8',$this->m_tgases7y8);
		$criteria->compare('m_tgases9y10',$this->m_tgases9y10);
		$criteria->compare('m_tgases11y12',$this->m_tgases11y12);
		$criteria->compare('m_tgases13y14',$this->m_tgases13y14);
		$criteria->compare('m_tgases15y16',$this->m_tgases15y16);
		$criteria->compare('caja_taceite',$this->caja_taceite);
		$criteria->compare('caja_paceite',$this->caja_paceite);
		$criteria->compare('panga_rpm',$this->panga_rpm);
		$criteria->compare('panga_taguamot',$this->panga_taguamot);
		$criteria->compare('panga_paceitemotor',$this->panga_paceitemotor);
		$criteria->compare('panga_paceitecaja',$this->panga_paceitecaja);
		$criteria->compare('d2_zarpe',$this->d2_zarpe);
		$criteria->compare('d2_arribo',$this->d2_arribo);
		$criteria->compare('d2_estimadohora',$this->d2_estimadohora);
		$criteria->compare('d2_observaciones',$this->d2_observaciones,true);
		$criteria->compare('acylu_consumomotor',$this->acylu_consumomotor);
		$criteria->compare('acylu_consumocaja',$this->acylu_consumocaja);
		$criteria->compare('acylu_consumohid',$this->acylu_consumohid);
		$criteria->compare('acylu_consumograsa',$this->acylu_consumograsa);
		$criteria->compare('acylu_observaciones',$this->acylu_observaciones,true);
		$criteria->compare('acylu_fechaultimocambiomotor',$this->acylu_fechaultimocambiomotor,true);
		$criteria->compare('acylu_horometroultimocambio',$this->acylu_horometroultimocambio);
		$criteria->compare('acylu_fechaultimocambiocaja',$this->acylu_fechaultimocambiocaja,true);
		$criteria->compare('acylu_horometroultimocambiocaja',$this->acylu_horometroultimocambiocaja);
		$criteria->compare('observacionesfinales',$this->observacionesfinales,true);*/
		$criteria->compare('fechazarpe',$this->fechazarpe,true);
		$criteria->compare('fechaarribo',$this->fechaarribo,true);
		//$criteria->compare('id',$this->id);
		
		
		$criteria->compare('codep',$this->codep,true);
		$criteria->together  =  true;
		$criteria->with = array('embarcaciones');
		 if($this->embarcaciones_nomep){
				$criteria->compare('embarcaciones.nomep',$this->embarcaciones_nomep,true);
			}
	  $sort=new CSort;
    $sort->attributes=array(
      'codep',
      // For each relational attribute, create a 'virtual attribute' using the public variable name
      'embarcaciones_nomep' => array(
        'asc' => 'embarcaciones.nomep',
        'desc' => 'embarcaciones.nomep DESC',
        'label' => 'Embarcacionere',
      ),
      '*',
    );
	
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>$sort,
		));
	}
	

public function search_barco($codep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numero',$this->numero,true);
		//$criteria->compare('numeroauxiliar',$this->numero,true);
		//$criteria->compare('horasdeaceitemotor',$this->horasdeaceitemotor,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('puerto',$this->puerto,true);
		$criteria->compare('puertodes',$this->puertodes,true);
		$criteria->compare('horometro',$this->horometro);
		$criteria->compare('horometrodes',$this->horometrodes);
		$criteria->compare('numerodecalas',$this->numerodecalas);		
		$criteria->compare('velocidad',$this->velocidad);
		$criteria->compare('tempagua',$this->tempagua);
		$criteria->compare('presionaceite',$this->presionaceite);
		$criteria->compare('idusuario',$this->idusuario);
		$criteria->compare('zarpo',$this->zarpo,true);
		$criteria->compare('causa',$this->causa,true);
		$criteria->compare('m_rpm',$this->m_rpm);
		$criteria->compare('m_velocidad',$this->m_velocidad);
		$criteria->compare('m_tempagua',$this->m_tempagua);
		
		$criteria->compare('fechazarpe',$this->fechazarpe,true);
		$criteria->compare('fechaarribo',$this->fechaarribo,true);
		//$criteria->compare('id',$this->id);
			$criteria->addCondition("t.codep = '".$codep."'");	
		
		//$criteria->compare('codep',$codep,true);
		$criteria->together  =  true;
		$criteria->with = array('embarcaciones');
		 if($this->embarcaciones_nomep){
				$criteria->compare('embarcaciones.nomep',$this->embarcaciones_nomep,true);
			}
	  $sort=new CSort;
    $sort->attributes=array(
      'codep',
      // For each relational attribute, create a 'virtual attribute' using the public variable name
      'embarcaciones_nomep' => array(
        'asc' => 'embarcaciones.nomep',
        'desc' => 'embarcaciones.nomep DESC',
        'label' => 'Embarcacionere',
      ),
      '*',
    );
	
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'sort'=>$sort,
		));
	}


	
	
	public function search_horometros($codep)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('horometrodes',$this->horometrodes,true);
		$criteria->compare('fechaarribo',$this->fechaarribo,true);
		$criteria->addCondition("codep = '".$codep."'");		
		$criteria->order=" id desc";
	//	$criteria->offset=4;
	$criteria->limit=-1;
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 
		));
	}
	
	public function checkHorometro($attribute,$params) 	{  
 
					$tiempoarribo =  strtotime($this->fechaarribo);	
					$tiempoparte=strtotime($this->fecha);	//$tiempoarribo =  $this->fechaarribo;
					$tiempozarpe =   strtotime($this->fechazarpe);
					$horastranscurridas =( $tiempoarribo-$tiempozarpe)/(60*60);		
					$diferenciahorometro=$this->horometrodes-$this->horometro;
									if ( $horastranscurridas < $diferenciahorometro-2) {
															$this->adderror('horometrodes','Esta lectura no puede ser, en reloj  han pasado :'.round($horastranscurridas,1).' horas !');
																	}
									
									if ( $tiempozarpe > $tiempoparte +60*60*24+1) {
															$this->adderror('fechazarpe','Esta fecha de zarpe es mayor que la fecha del documento, revisa la fecha del documento');
																	}
									
									if ( $tiempozarpe > $tiempoarribo) {
															$this->adderror('fechaarribo','Revisa bien la fecha de zarpe esta despues del arribo, esto no puede ser ');
																	}
									
	
									if ( $this->d2_zarpe  < $this->d2_arribo) {
															$this->adderror('d2_zarpe','No puedes tener mas petroleo desde que saliste ');
																	} 
									
									
							//if ( $this->acylu_fechaultimocambiomotor  > $this->fechaarribo) {
															//$this->adderror('acylu_fechaultimocambiomotor','Esta fecha no puede ser posterior a la fecha de arribo ');
																//	}
									
								//if ( $this->acylu_fechaultimocambiocaja  > $this->fechaarribo) {
														//	$this->adderror('acylu_fechaultimocambiocaja','Esta fecha no puede ser posterior a la fecha de arribo ');
																//	}
									
								//if ( $this->acylu_horometroultimocambio  > $this->horometrodes) {
															//$this->adderror('acylu_horometroultimocambio','Este horometro no puede ser mayor al horometro del arribo ');
																//	}
									
								//if ( $this->acylu_horometroultimocambiocaja  > $this->horometrodes) {
															//$this->adderror('acylu_horometroultimocambiocaja','Este horometro no puede ser mayor al horometro del arribo ');
																								//	}														
			
									$this->refrescacampos();
	}								
	
	
	
	/*Checka el valor del horometro en la tabla carteres 
	
	**/	
	
	
	
	
}