<?php

/**
 * This is the model class for table "{{disponiblidad}}".
 *
 * The followings are the available columns in table '{{disponiblidad}}':
 * @property string $codisp
 * @property string $dedispo
 */
class Disponibilidad extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Disponibilidad the static model class
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
		return '{{disponiblidad}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codisp', 'required'),
			array('codisp', 'length', 'max'=>2),
			array('dedispo', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codisp, dedispo', 'safe', 'on'=>'search'),
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
			'codisp' => 'Codisp',
			'dedispo' => 'Dedispo',
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

		$criteria->compare('codisp',$this->codisp,true);
		$criteria->compare('dedispo',$this->dedispo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}