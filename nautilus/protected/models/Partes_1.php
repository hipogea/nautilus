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
			//array('id', 'required'),
			array('horometro, horometrodes, numerodecalas, id', 'numerical', 'integerOnly'=>true,'message'=>'Debes de colocar un numero'),
			array('numero', 'length', 'max'=>6),
			array('puerto, puertodes', 'length', 'max'=>2),
			array('fecha', 'safe'),
			array('codep','required','message'=>'Debes de indicar tu embarcacion'),
			array('numero','required','message'=>'Indica el numero de tu Parte'),
			array('puerto','required','message'=>'Indica el puerto donde Zarpaste'),
			array('puertodes','required','message'=>'Indica el puerto de arribo'),
			array('fecha','required','message'=>' ¿ y la fecha ?'),
			array('horometro','required','message'=>'Indica el horometro de zarpe'),
			array('horometrodes','required','message'=>'Indica el horometro de arribo'),
			array('numerodecalas','required','message'=>'Hermano, indica cuantas calas hizo el patron'),
			array('horometrodes', 'compare', 'compareAttribute'=>'horometro', 'operator'=>'>','message'=>'Hermano , El horometro de arribo debe ser mayor a l alectura de Zarpe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('numero, fecha, puerto, puertodes, horometro, horometrodes, numerodecalas, id', 'safe', 'on'=>'search'),
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
			'numero' => 'Numero de documento',
			'fecha' => 'Fecha de registro',
			'puerto' => 'Puerto de Zarpe',
			'puertodes' => 'PuertoERRRR de Descarga o Destino',
			'horometro' => 'Horometro al zarpe',
			'horometrodes' => 'Horometro al arribo',
			'numerodecalas' => 'Numero de Calas',
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
		$criteria->compare('fecha',$this->fecha,true);
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
}