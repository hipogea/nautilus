<?php

/**
 * This is the model class for table "{{monedas}}".
 *
 * The followings are the available columns in table '{{monedas}}':
 * @property string $codmoneda
 * @property string $desmon
 * @property string $simbolo
 */
class Monedas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Monedas the static model class
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
		return '{{monedas}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codmoneda, desmon, simbolo', 'required'),
			array('codmoneda', 'length', 'max'=>3),
			array('desmon', 'length', 'max'=>60),
			array('simbolo', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codmoneda, desmon, simbolo', 'safe', 'on'=>'search'),
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
			'codmoneda' => 'Codmoneda',
			'desmon' => 'Desmon',
			'simbolo' => 'Simbolo',
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

		$criteria->compare('codmoneda',$this->codmoneda,true);
		$criteria->compare('desmon',$this->desmon,true);
		$criteria->compare('simbolo',$this->simbolo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}