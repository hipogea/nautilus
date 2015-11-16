<?php

/**
 * This is the model class for table "ums".
 *
 * The followings are the available columns in table 'ums':
 * @property string $um
 * @property string $desum
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 */
class Ums extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ums the static model class
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
        return Yii::app()->params['prefijo'].'ums';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('um', 'required'),
			array('um', 'length', 'max'=>3),
			//array('codtipofac', 'length', 'max'=>2),
			array('um', 'length', 'min'=>3),
			//array('codtipofac', 'required'),
			array('um', 'unique'),
			//array('um', 'match', 'pattern'=>Yii::app()->params['mascaradocs'],'message'=>'El codigo  no es el correcto, El c debe comenzar por 2 DIGITOS  > 0 y los caracteres deben ser numericos'),

			//array('desum, creadoel, modificadopor', 'length', 'max'=>20),
			array('desum', 'required'),
			array('desum', 'length', 'max'=>25),
			array('um', 'unique', 'attributeName'=> 'um','message'=>'Esta unidad de medida ya esta registrado'),
			array('creadopor, modificadoel', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('um, desum, creadopor, creadoel, modificadopor, modificadoel', 'safe', 'on'=>'search'),
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
			'um' => 'Um',
			'desum' => 'Desum',
			
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

		$criteria->compare('um',$this->um,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}