<?php

/**
 * This is the model class for table "temporadas".
 *
 * The followings are the available columns in table 'temporadas':
 * @property integer $id
 * @property string $destemporada
 * @property string $inicio
 * @property string $termino
 *
 * The followings are the available model relations:
 * @property Reportepesca[] $reportepescas
 */
class Temporadas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Temporadas the static model class
	 */
	 
	public $idespecie ;
	public $fechadehoy;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'temporadas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('destemporada', 'length', 'max'=>60),
		//REGLAS PARA EL ESCENARIO DE CREAR PARTE   "escenarioparte"
			//array('idespecie','required','message'=>'...!UPS...Por favor, llena la especie'.gettype($this->fechadehoy),'on'=>'escenarioparte'),	
			//array('fechadehoy','required','message'=>'Escribe la fecha','on'=>'escenarioparte'),
			//array('fechadehoy','checkfechahoy','on'=>'escenarioparte'),
			//array('id,destemporada, inicio, termino,fechadehoy,idespecie', 'safe', 'on'=>'escenarioparte'),
			
			array('destemporada','required','message'=>'Llena la descripcion'),
			array('inicio','required','message'=>'Llena la fecha de inicio'),
			array('zonalitoral','required','message'=>'Llena la zona : CEN-->CENTRO NORTE      SUR --> SUR'),
			array('termino','required','message'=>'Llena la fecha de fin'),
			array('idespecie','required','message'=>'...!UPS...Por favor, llena la especie'.gettype($this->fechadehoy)),	
			array('fechadehoy','required','message'=>'Escribe la fecha'),
			array('fechadehoy','checkfechahoy'),
			array('cuota_anchoveta','required','message'=>'Indica la cuota asignada a la empresa'),
			array('cuota_global_anchoveta','required','message'=>'Indica la cuota global'),			
				
				array('inicio','checkfecha'),
				array('termino','checkfecha'),
			
			//array('idespecie,fechadehoy,id,cuota_global_anchoveta, cuota_anchoveta,destemporada, inicio, termino', 'safe','on'=>'insert'),
			array('idespecie,fechadehoy,cuota_global_anchoveta, cuota_anchoveta,destemporada, inicio,zonalitoral, termino', 'safe','on'=>'insert,update'),
			array('idespecie,fechadehoy,id,cuota_global_anchoveta, cuota_anchoveta,destemporada, inicio,zonalitoral, termino', 'safe','on'=>'search'),
		);
	}

	
		public function checkfecha($attribute,$params) 	{  
 
					$fechainicio =  strtotime($this->inicio);	
					$fechafin=strtotime($this->termino);	//$tiempoarribo =  $this->fechaarribo;
					if ($fechainicio>=$fechafin){ 
					 $this->adderror('inicio','Esta fecha es mayor que la fecha de termino');
					 $this->adderror('termino','Esta fecha es menor que la fecha de inicio');
					 }	
					// if(!empty($fechadehoy)) {  
					  
						//}									
					
									
													}
	
	
	
		public function checkfechahoy($attribute,$params) 	{  
 
					$fechainicio =  strtotime($this->inicio);	
					$fechafin=strtotime($this->termino);	//$tiempoarribo =  $this->fechaarribo;
					
					// if(!empty($fechadehoy)) {  
							if ((strtotime($this->fechadehoy) < $fechainicio)  or (strtotime($this->fechadehoy) > $fechafin)  ) {  
											$this->adderror('fechadehoy','Esta fecha esta fuera del rango de fechas de la temporada   ');
								}												//}
									    
													}
	
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'reportepescas' => array(self::HAS_MANY, 'Reportepesca', 'idtemporada'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'destemporada' => 'Nombre de temporada',
			'inicio' => 'Fecha de inicio',
			'termino' => 'Fecha de termino',
			'idespecie'=> 'Especie a capturar',
			'fechadehoy'=> 'Fecha del parte de pesca(TN)',
			'cuota_anchoveta'=>'Cuota asignada (Tn)',
			'zonalitoral'=>'Zona de pesca',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('destemporada',$this->destemporada,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('termino',$this->termino,true);
        $criteria->compare('destemporada',$this->destemporada,true);
		$criteria->compare('cuota_anchoveta',$this->cuota_anchoveta,true);
		$criteria->compare('cuota-global_anchoveta',$this->cuota_global_anchoveta,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}