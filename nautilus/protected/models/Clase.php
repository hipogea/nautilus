<?php

/**
 * This is the model class for table "clasesmaestro".
 *
 * The followings are the available columns in table 'clasesmaestro':
 * @property string $codclasema
 * @property string $nomclase
 * @property string $creadopor
 * @property string $modificadopor
 * @property string $creadoel
 * @property string $modificadoel
 */
class Clase extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Clase the static model class
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
		return 'clasesmaestro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomclase', 'required'),
			array('codclasema', 'length', 'max'=>4),
			array('nomclase', 'length', 'max'=>35),
			array('creadoel, modificadoel', 'length', 'max'=>30),
			array('creadopor, modificadopor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codclasema, nomclase, creadopor, modificadopor, creadoel, modificadoel', 'safe', 'on'=>'search'),
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
			'codclasema' => 'Codclasema',
			'nomclase' => 'Nomclase',
			'creadopor' => 'Creadopor',
			'modificadopor' => 'Modificadopor',
			'creadoel' => 'Creadoel',
			'modificadoel' => 'Modificadoel',
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

		$criteria->compare('codclasema',$this->codclasema,true);
		$criteria->compare('nomclase',$this->nomclase,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}