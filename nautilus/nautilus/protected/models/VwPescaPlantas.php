<?php

/**
 * This is the model class for table "vw_pesca_plantas".
 *
 * The followings are the available columns in table 'vw_pesca_plantas':
 * @property string $desplanta
 * @property string $fecha
 * @property string $declarada
 * @property double $descargada
 * @property string $fd
 */
class VwPescaPlantas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwPescaPlantas the static model class
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
		return 'vw_pesca_plantas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descargada', 'numerical'),
			array('desplanta', 'length', 'max'=>25),
			array('fecha, declarada, fd', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('desplanta, fecha, declarada, descargada, fd', 'safe', 'on'=>'search'),
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
			'desplanta' => 'Desplanta',
			'fecha' => 'Fecha',
			'declarada' => 'Declarada',
			'descargada' => 'Descargada',
			'fd' => 'Fd',
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

		$criteria->compare('desplanta',$this->desplanta,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('declarada',$this->declarada,true);
		$criteria->compare('descargada',$this->descargada);
		$criteria->compare('fd',$this->fd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function search_dia($fecha)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('desplanta',$this->desplanta,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('declarada',$this->declarada,true);
		$criteria->compare('descargada',$this->descargada);
		$criteria->compare('fd',$this->fd,true);
		$criteria->addCondition("fecha = '".$fecha."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
}