<?php

/**
 * This is the model class for table "{{igv}}".
 *
 * The followings are the available columns in table '{{igv}}':
 * @property double $valor
 * @property integer $id
 * @property string $tipo
 * @property string $Descripcion
 * @property string $finicio
 * @property string $ffin
 * @property string $activo
 * @property string $abreviatura
 */
class Igv extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Igv the static model class
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
		return '{{igv}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valor, finicio, ffin, activo, abreviatura', 'required'),
			array('valor', 'numerical'),
			array('tipo', 'length', 'max'=>2),
			array('Descripcion', 'length', 'max'=>30),
			array('activo', 'length', 'max'=>1),
			array('abreviatura', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('valor, id, tipo, Descripcion, finicio, ffin, activo, abreviatura', 'safe', 'on'=>'search'),
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
			'valor' => 'Valor',
			'id' => 'ID',
			'tipo' => 'Tipo',
			'Descripcion' => 'Descripcion',
			'finicio' => 'Finicio',
			'ffin' => 'Ffin',
			'activo' => 'Activo',
			'abreviatura' => 'Abreviatura',
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

		$criteria->compare('valor',$this->valor);
		$criteria->compare('id',$this->id);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('finicio',$this->finicio,true);
		$criteria->compare('ffin',$this->ffin,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('abreviatura',$this->abreviatura,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}