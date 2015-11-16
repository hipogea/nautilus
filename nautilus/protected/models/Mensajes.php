<?php

/**
 * This is the model class for table "mensajes".
 *
 * The followings are the available columns in table 'mensajes':
 * @property integer $id
 * @property string $usuario
 * @property string $cuando
 * @property string $codocu
 * @property string $enviadoel
 * @property string $nombrefichero
 */
class Mensajes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mensajes the static model class
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
		return Yii::app()->params['prefijo'].'mensajes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario', 'length', 'max'=>50),
			array('codocu', 'length', 'max'=>3),
			array('nombrefichero', 'length', 'max'=>400),
			array('cuando,tipo,nombrefichero, hidocu,enviadoel', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidocu,usuario, cuando, codocu, enviadoel, nombrefichero', 'safe', 'on'=>'search'),
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
			'usuario' => 'Usuario',
			'cuando' => 'Cuando',
			'codocu' => 'Codocu',
			'enviadoel' => 'Enviadoel',
			'nombrefichero' => 'Nombrefichero',
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
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('cuando',$this->cuando,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('enviadoel',$this->enviadoel,true);
		$criteria->compare('nombrefichero',$this->nombrefichero,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_docu($documento,$identidad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('cuando',$this->cuando,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('enviadoel',$this->enviadoel,true);
		$criteria->compare('nombrefichero',$this->nombrefichero,true);
		$criteria->addcondition("codocu='".$documento."'");
		$criteria->addcondition(" hidocu=".$identidad."");

		return new CActiveDataProvider($this, array('criteria'=>$criteria,));

    }

}