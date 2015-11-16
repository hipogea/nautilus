<?php

/**
 * This is the model class for table "temporadas".
 *
 * The followings are the available columns in table 'temporadas':
 * @property integer $id
 * @property string $destemporada
 * @property string $inicio
 * @property string $termino
 * @property integer $cuota_anchoveta
 * @property integer $cuota_jurel
 * @property integer $cuota_global_anchoveta
 * @property string $zonalitoral
 */
class Temporadas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Temporadas the static model class
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
			array('cuota_anchoveta, cuota_jurel, cuota_global_anchoveta', 'numerical', 'integerOnly'=>true),
			array('destemporada', 'length', 'max'=>60),
			array('zonalitoral', 'length', 'max'=>3),
			array('inicio, termino', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, destemporada, inicio, termino, cuota_anchoveta, cuota_jurel, cuota_global_anchoveta, zonalitoral', 'safe', 'on'=>'search'),
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
			'destemporada' => 'Destemporada',
			'inicio' => 'Inicio',
			'termino' => 'Termino',
			'cuota_anchoveta' => 'Cuota Anchoveta',
			'cuota_jurel' => 'Cuota Jurel',
			'cuota_global_anchoveta' => 'Cuota Global Anchoveta',
			'zonalitoral' => 'Zonalitoral',
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
		$criteria->compare('cuota_anchoveta',$this->cuota_anchoveta);
		$criteria->compare('cuota_jurel',$this->cuota_jurel);
		$criteria->compare('cuota_global_anchoveta',$this->cuota_global_anchoveta);
		$criteria->compare('zonalitoral',$this->zonalitoral,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}