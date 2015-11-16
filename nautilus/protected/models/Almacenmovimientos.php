<?php

/**
 * This is the model class for table "almacenmovimientos".
 *
 * The followings are the available columns in table 'almacenmovimientos':
 * @property string $codmov
 * @property string $movimiento
 * @property integer $signo
 * @property string $codigo_objeto
 * @property string $ingreso
 */
class Almacenmovimientos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Almacenmovimientos the static model class
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
		return Yii::app()->params['prefijo'].'almacenmovimientos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codmov', 'required'),
			array('idevento', 'required'),
			array('codmov', 'unique'),
			array('signo', 'numerical', 'integerOnly'=>true),
			array('codmov', 'required','message'=>'Debes de indicar el codigo de movimiento'),
			array('codmov, codigo_objeto', 'length', 'max'=>2),
			array('movimiento,signo', 'required'),
			array('movimiento', 'length', 'max'=>35),
			array('codocu','safe'),
			array('codmov,activo, movimiento,campodestino, anticodmov,actualizaprecio,signo,codocu, codigo_objeto,
			ingreso,escontable,permcodcondicion,permiteparciales,
			campoafectadoinv,verifconversionmoneda,permitereversiones,esconsumo,itemsdeterministicos,editarcantidad,borraritems','safe', 'on'=>'search,insert,update'),
		);
		}

	public function relations()
	{
		return array(
			//'codpro0' => array(self::BELONGS_TO, 'Contactos', 'codpro'),
			'documentos' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
			'eventos'=>array(self::BELONGS_TO, 'Eventos', 'idevento'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'codmov' => 'Codigo',
			'anticodmov' => 'Mov opuesto',
			'movimiento' => 'Movimiento',
			'signo' => 'Signo',
			'codigo_objeto' => 'Codigo Objeto',
			'ingreso' => 'Ingreso?',
			'actualizaprecio' => 'Afecta valor?',
			'escontable' => 'Implicancia en LM',
			'permcodcondicion' => 'Permitido evaluar estado del material',
			'permiteparciales' => 'Permite cantidades parciales',
			'campoafectadoinv' => 'Campo afectado del Inv',
			'permitereversiones' => 'Es reversible',
			'campodestino'=>'Campo Destino'
		);
	}



public $maximovalor;

	public function beforeSave() {
							if ($this->isNewRecord) {
										//$this->codmov=Numeromaximo::numero($this->model(),'codmov','maximovalor',3);
									
										} else
									{
										 
												//	$this->numcot=Numeromaximo::numero($this->model(),'numcot','maximovalor',8);
											
											}	//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
									
													return parent::beforeSave();
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

		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('movimiento',$this->movimiento,true);
		$criteria->compare('signo',$this->signo);
		$criteria->compare('codigo_objeto',$this->codigo_objeto,true);
		$criteria->compare('ingreso',$this->ingreso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}