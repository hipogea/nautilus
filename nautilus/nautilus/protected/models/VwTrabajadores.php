<?php

/**
 * This is the model class for table "vw_trabajadores".
 *
 * The followings are the available columns in table 'vw_trabajadores':
 * @property string $codigotra
 * @property string $nombrecompleto
 * @property string $codpuesto
 * @property string $ap
 * @property string $am
 * @property string $nombres
 * @property string $dni
 * @property string $oficio
 */
class VwTrabajadores extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwTrabajadores the static model class
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
		return 'vw_trabajadores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigotra', 'length', 'max'=>4),
			array('nombrecompleto, ap', 'length', 'max'=>30),
			array('codpuesto', 'length', 'max'=>3),
			array('am', 'length', 'max'=>35),
			array('nombres', 'length', 'max'=>25),
			array('dni', 'length', 'max'=>12),
			array('oficio', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigotra, nombrecompleto, codpuesto, ap, am, nombres, dni, oficio', 'safe', 'on'=>'search'),
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
			'codigotra' => 'Codigo',
			'nombrecompleto' => 'Nombre completo',
			'codpuesto' => 'Codpuesto',
			'ap' => 'Ap',
			'am' => 'Am',
			'nombres' => 'Nombres',
			'dni' => 'Dni',
			'oficio' => 'Oficio',
		);
	}

	public function findByPk($id,$condition='',$params=array()) {

			return self::model()->find("codigotra='".$id."'");
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

		$criteria->compare('codigotra',$this->codigotra,true);
		$criteria->compare('nombrecompleto',$this->nombrecompleto,true);
		$criteria->compare('codpuesto',$this->codpuesto,true);
		$criteria->compare('ap',$this->ap,true);
		$criteria->compare('am',$this->am,true);
		$criteria->compare('nombres',$this->nombres,true);
		$criteria->compare('dni',$this->dni,true);
		$criteria->compare('oficio',$this->oficio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}