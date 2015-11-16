<?php

/**
 * This is the model class for table "{{contactosadicio}}".
 *
 * The followings are the available columns in table '{{contactosadicio}}':
 * @property integer $id
 * @property integer $hidcontacto
 * @property string $mail
 * @property integer $activo
 * @property string $codocu
 * @property integer $idevento
 */
class Contactosadicio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contactosadicio the static model class
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
		return '{{contactosadicio}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//	array('hidcontacto, mail, activo, codocu, idevento', 'required'),
			//array('hidcontacto, activo, idevento', 'numerical', 'integerOnly'=>true),

			array('mail', 'length', 'max'=>120),
			array('mail,hidcontacto,codocu,activo', 'safe', 'on'=>'insert,update'),
			//array('codocu', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidcontacto, mail, activo, codocu, idevento', 'safe', 'on'=>'search'),
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
			'documentos'=>array(self::BELONGS_TO, 'Documentos', 'codocu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidcontacto' => 'Hidcontacto',
			'mail' => 'Mail',
			'activo' => 'Activo',
			'codocu' => 'Codocu',
			'idevento' => 'Idevento',
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
		$criteria->compare('hidcontacto',$this->hidcontacto);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('activo',$this->activo);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('idevento',$this->idevento);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_contacto($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('activo',$this->activo);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->addcondition('hidcontacto='.$id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}