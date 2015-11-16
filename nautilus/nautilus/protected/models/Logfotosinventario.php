<?php

/**
 * This is the model class for table "logfotosinventario".
 *
 * The followings are the available columns in table 'logfotosinventario':
 * @property integer $id
 * @property string $ip
 * @property integer $iduser
 * @property integer $hidinventario
 * @property string $operacion
 * @property string $nombrefoto
 * @property string $fecha
 */
class Logfotosinventario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Logfotosinventario the static model class
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
		return '{{logfotosinventario}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iduser, hidinventario', 'numerical', 'integerOnly'=>true),
			array('ip', 'length', 'max'=>20),
			array('operacion', 'length', 'max'=>10),
			array('nombrefoto', 'length', 'max'=>80),
			array('fecha,ip, iduser, hidinventario, operacion, nombrefoto', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip, iduser, hidinventario, operacion, nombrefoto, fecha', 'safe', 'on'=>'search'),
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
			'ip' => 'Ip',
			'iduser' => 'Iduser',
			'hidinventario' => 'Hidinventario',
			'operacion' => 'Operacion',
			'nombrefoto' => 'Nombrefoto',
			'fecha' => 'Fecha',
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
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('hidinventario',$this->hidinventario);
		$criteria->compare('operacion',$this->operacion,true);
		$criteria->compare('nombrefoto',$this->nombrefoto,true);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}