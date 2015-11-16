<?php

/**
 * This is the model class for table "tenores".
 *
 * The followings are the available columns in table 'tenores':
 * @property string $coddocu
 * @property string $mensaje
 * @property string $posicion
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $creadopor
 * @property string $activo
 * @property string $logo
 * @property integer $id
 */
class Tenores extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tenores the static model class
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
		return Yii::app()->params['prefijo'].'tenores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('coddocu, sociedad,posicion', 'required'),
			array('coddocu', 'length', 'max'=>3),
			array('posicion, activo', 'length', 'max'=>1),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('modificadopor, creadopor', 'length', 'max'=>25),
			array('logo', 'length', 'max'=>360),
			array('mensaje,coddocu, sociedad,posicion', 'safe'),
			array('coddocu+posicion+sociedad', 'application.extensions.uniqueMultiColumnValidator','on'=>'insert,update'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('coddocu, mensaje, posicion, creadoel, modificadopor, modificadoel, creadopor, activo, logo, id', 'safe', 'on'=>'search'),
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
			'coddocu' => 'Coddocu',
			'mensaje' => 'Mensaje',
			'posicion' => 'Posicion',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'creadopor' => 'Creadopor',
			'activo' => 'Activo',
			'logo' => 'Logo',
			'id' => 'ID',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search_por_docu($docu)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('id',$this->id);
        $criteria->addcondition("coddocu='".$docu."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('posicion',$this->posicion,true);

		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('activo',$this->activo,true);

		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}