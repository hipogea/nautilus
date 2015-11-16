<?php

/**
 * This is the model class for table "maestro_atributos".
 *
 * The followings are the available columns in table 'maestro_atributos':
 * @property integer $id
 * @property string $nombreat
 * @property string $hid
 * @property string $abreviatura
 * @property string $padre
 * @property integer $jerarquia
 * @property string $respaldo
 * @property string $respaldo2
 * @property string $respaldo3
 * @property string $texto
 * @property string $tieneum
 */
class MaestroAtributos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaestroAtributos the static model class
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
		return 'maestro_atributos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hid', 'required'),
			array('jerarquia', 'numerical', 'integerOnly'=>true),
			array('nombreat', 'length', 'max'=>20),
			array('abreviatura', 'length', 'max'=>4),
			array('respaldo, respaldo2, respaldo3', 'length', 'max'=>60),
			array('tieneum', 'length', 'max'=>1),
			array('hid, padre, texto', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombreat, hid, abreviatura, padre, jerarquia, respaldo, respaldo2, respaldo3, texto, tieneum', 'safe', 'on'=>'search'),
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
			
			'grupo'=>array(self::BELONGS_TO, 'MaestroGrupos', 'hid'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombreat' => 'Nombreat',
			'hid' => 'Hid',
			'abreviatura' => 'Abreviatura',
			'padre' => 'Padre',
			'jerarquia' => 'Jerarquia',
			'respaldo' => 'Respaldo',
			'respaldo2' => 'Respaldo2',
			'respaldo3' => 'Respaldo3',
			'texto' => 'Texto',
			'tieneum' => 'Tieneum',
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
		$criteria->compare('nombreat',$this->nombreat,true);
		$criteria->compare('hid',$this->hid,true);
		$criteria->compare('abreviatura',$this->abreviatura,true);
		$criteria->compare('padre',$this->padre,true);
		$criteria->compare('jerarquia',$this->jerarquia);
		$criteria->compare('respaldo',$this->respaldo,true);
		$criteria->compare('respaldo2',$this->respaldo2,true);
		$criteria->compare('respaldo3',$this->respaldo3,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('tieneum',$this->tieneum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}