<?php

/**
 * This is the model class for table "pescaterceros".
 *
 * The followings are the available columns in table 'pescaterceros':
 * @property integer $id
 * @property string $codplanta
 * @property integer $pesca
 * @property integer $numeroep
 * @property string $fecha
 * @property double $factor
 */
class Pescaterceros extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pescaterceros the static model class
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
		return 'pescaterceros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesca,numeroep,codplanta,factor', 'required'),
			array('pesca, numeroep', 'numerical', 'integerOnly'=>true),
			array('factor', 'numerical'),
			array('codplanta', 'length', 'max'=>2),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codplanta, pesca, numeroep, fecha, factor', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codplanta' => 'Codplanta',
			'pesca' => 'Pesca',
			'numeroep' => 'Numeroep',
			'fecha' => 'Fecha',
			'factor' => 'Factor',
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
		$criteria->compare('codplanta',$this->codplanta,true);
		$criteria->compare('pesca',$this->pesca);
		$criteria->compare('numeroep',$this->numeroep);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('factor',$this->factor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}