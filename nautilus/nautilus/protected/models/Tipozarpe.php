<?php

/**
 * This is the model class for table "tipozarpe".
 *
 * The followings are the available columns in table 'tipozarpe':
 * @property string $codtipo
 * @property string $motivozarpe
 *
 * The followings are the available model relations:
 * @property Reportepesca[] $reportepescas
 */
class Tipozarpe extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tipozarpe the static model class
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
		return 'tipozarpe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtipo', 'required'),
			array('codtipo', 'length', 'max'=>2),
			array('motivozarpe', 'length', 'max'=>40),
			array('codtipo,cuentahoras, motivozarpe', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codtipo,cuentahoras, motivozarpe', 'safe', 'on'=>'search'),
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
			'reportepescas' => array(self::HAS_MANY, 'Reportepesca', 'codzarpe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtipo' => 'Codtipo',
			'motivozarpe' => 'Motivozarpe',
			'cuentahoras'=>'Cuentahoras',
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

		$criteria->compare('codtipo',$this->codtipo,true);
		$criteria->compare('motivozarpe',$this->motivozarpe,true);
		$criteria->compare('cuentahoras',$this->motivozarpe,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}