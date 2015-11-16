<?php

/**
 * This is the model class for table "{{puntodespacho}}".
 *
 * The followings are the available columns in table '{{puntodespacho}}':
 * @property integer $id
 * @property string $hcodcanal
 * @property string $nombrepunto
 * @property string $pesaje
 * @property string $codcen
 * @property integer $maxhorasespera
 *
 * The followings are the available model relations:
 * @property Despacho[] $despachos
 * @property Canales $hcodcanal0
 */
class Puntodespacho extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puntodespacho the static model class
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
		return '{{puntodespacho}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hcodcanal, nombrepunto, pesaje, codcen, maxhorasespera', 'required'),
			array('maxhorasespera', 'numerical', 'integerOnly'=>true),
			array('hcodcanal', 'length', 'max'=>3),
			array('nombrepunto', 'length', 'max'=>40),
			array('pesaje', 'length', 'max'=>1),
			array('codcen', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hcodcanal, nombrepunto, pesaje, codcen, maxhorasespera', 'safe', 'on'=>'search'),
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
			'despachos' => array(self::HAS_MANY, 'Despacho', 'hidpunto'),
			'hcodcanal0' => array(self::BELONGS_TO, 'Canales', 'hcodcanal'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hcodcanal' => 'Hcodcanal',
			'nombrepunto' => 'Nombrepunto',
			'pesaje' => 'Pesaje',
			'codcen' => 'Codcen',
			'maxhorasespera' => 'Maxhorasespera',
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
		$criteria->compare('hcodcanal',$this->hcodcanal,true);
		$criteria->compare('nombrepunto',$this->nombrepunto,true);
		$criteria->compare('pesaje',$this->pesaje,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('maxhorasespera',$this->maxhorasespera);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}