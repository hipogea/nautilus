<?php

/**
 * This is the model class for table "log_modificaciones".
 *
 * The followings are the available columns in table 'log_modificaciones':
 * @property string $idregistro
 * @property string $nombrecampo
 * @property string $valorant
 * @property string $valoract
 * @property string $fecha
 * @property string $quien
 * @property string $modificacion
 * @property integer $id
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Log the static model class
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
		return 'log_modificaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombrecampo', 'length', 'max'=>25),
			array('valorant, valoract', 'length', 'max'=>40),
			array('quien', 'length', 'max'=>30),
			array('modificacion', 'length', 'max'=>1),
			array('idregistro, fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idregistro, nombrecampo, valorant, valoract, fecha, quien, modificacion, id', 'safe', 'on'=>'search'),
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
			'idregistro' => 'Idregistro',
			'nombrecampo' => 'Nombrecampo',
			'valorant' => 'Valorant',
			'valoract' => 'Valoract',
			'fecha' => 'Fecha',
			'quien' => 'Quien',
			'modificacion' => 'Modificacion',
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

		$criteria->compare('idregistro',$this->idregistro,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('valorant',$this->valorant,true);
		$criteria->compare('valoract',$this->valoract,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('quien',$this->quien,true);
		$criteria->compare('modificacion',$this->modificacion,true);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}