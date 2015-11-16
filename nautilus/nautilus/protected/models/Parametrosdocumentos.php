<?php

/**
 * This is the model class for table "parametrosdocumentos".
 *
 * The followings are the available columns in table 'parametrosdocumentos':
 * @property string $codpara
 * @property string $desparam
 * @property string $codigodoc
 * @property string $nivel
 */
class Parametrosdocumentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Parametrosdocumentos the static model class
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
		return 'parametrosdocumentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpara', 'required'),
			array('codpara', 'length', 'max'=>5),
			array('desparam', 'length', 'max'=>25),
			array('codigodoc', 'length', 'max'=>3),
			array('nivel', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codpara, desparam, codigodoc, nivel', 'safe', 'on'=>'search'),
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
			'codpara' => 'Codpara',
			'desparam' => 'Desparam',
			'codigodoc' => 'Codigodoc',
			'nivel' => 'Nivel',
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

		$criteria->compare('codpara',$this->codpara,true);
		$criteria->compare('desparam',$this->desparam,true);
		$criteria->compare('codigodoc',$this->codigodoc,true);
		$criteria->compare('nivel',$this->nivel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}