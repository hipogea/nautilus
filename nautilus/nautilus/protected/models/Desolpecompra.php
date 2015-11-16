<?php

/**
 * This is the model class for table "desolpecompra".
 *
 * The followings are the available columns in table 'desolpecompra':
 * @property integer $id
 * @property string $iddesolpe
 * @property string $iddocompra
 * @property double $cant
 * @property string $fecha
 * @property string $user
 *
 * The followings are the available model relations:
 * @property Docompra $iddocompra0
 * @property Desolpe $iddesolpe0
 */
class Desolpecompra extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Desolpecompra the static model class
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
		return Yii::app()->params['prefijo'].'desolpecompra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cant', 'numerical'),
			array('user', 'length', 'max'=>25),
			array('iddesolpe,iduser, codestado, iddocompra, fecha', 'safe'),
			array('codestado', 'safe','on'=>'cambiaestado'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, iddesolpe, iddocompra, cant, fecha, user', 'safe', 'on'=>'search'),
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
			'docompra' => array(self::BELONGS_TO, 'Docompra', 'iddocompra'),
			'docompratemp' => array(self::BELONGS_TO, 'Docompratemp', 'iddocompra'),
			'desolpe' => array(self::BELONGS_TO, 'Desolpe', 'iddesolpe'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'iddesolpe' => 'Iddesolpe',
			'iddocompra' => 'Iddocompra',
			'cant' => 'Cant',
			'fecha' => 'Fecha',
			'user' => 'User',
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
		$criteria->compare('iddesolpe',$this->iddesolpe,true);
		$criteria->compare('iddocompra',$this->iddocompra,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('user',$this->user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}