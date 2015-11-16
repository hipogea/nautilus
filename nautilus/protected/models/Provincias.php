<?php

/**
 * This is the model class for table "{{provincias}}".
 *
 * The followings are the available columns in table '{{provincias}}':
 * @property integer $id
 * @property string $codprov
 * @property string $provincia
 * @property string $coddepa
 */
class Provincias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Provincias the static model class
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
		return '{{provincias}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codprov, provincia, coddepa', 'required'),
			array('codprov, coddepa', 'length', 'max'=>2),
			array('provincia', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codprov, provincia, coddepa', 'safe', 'on'=>'search'),
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
			'codprov' => 'Codprov',
			'provincia' => 'Provincia',
			'coddepa' => 'Coddepa',
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
		$criteria->compare('codprov',$this->codprov,true);
		$criteria->compare('provincia',$this->provincia,true);
		$criteria->compare('coddepa',$this->coddepa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}