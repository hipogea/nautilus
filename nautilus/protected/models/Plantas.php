<?php

/**
 * This is the model class for table "plantas".
 *
 * The followings are the available columns in table 'plantas':
 * @property string $codplanta
 * @property string $desplanta
 * @property integer $id
 * @property string $codigozona
 * @property integer $capacidad
 * @property double $factor
 */
 
class Plantas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Plantas the static model class
	 */
	 
	  public $maximovalor;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'plantas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id', 'required'),
			array('id, capacidad', 'numerical', 'integerOnly'=>true),
			array('desplanta,centrito','required'),
			array('factor', 'numerical'),
			array('codplanta', 'length', 'max'=>2),
			array('desplanta', 'length', 'max'=>25),
			array('codigozona', 'length', 'max'=>3),
			array('centrito', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codplanta, centrito,desplanta, id, codigozona, capacidad, factor', 'safe', 'on'=>'search'),
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

	
	
	
	public function beforeSave() {
							if ($this->isNewRecord) {
									//$this->created = new CDbExpression('NOW()');
									// $nuevovalor=new CDbExpression('SELEC MAX(NUMERO)');
										//$this->numero=new CDbExpression('SELECt MAX(NUMERO) from mot_materiales');
									//$this->modified = new CDbExpression('NOW()');
									 $this->codplanta=Numeromaximo::numero($this,'codplanta','maximovalor',2);
									//$this->codtraba='0001';
									//$this->creadorpor='0001';

									}
									return parent::beforeSave();
				}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codplanta' => 'Codigo',
			'desplanta' => 'Nombre',
			'id' => 'ID',
			'codigozona' => 'Codigozona',
			'capacidad' => 'Capacidad (TN)',
			'factor' => 'Factor',
			'centrito'=>'Local',
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

		$criteria->compare('codplanta',$this->codplanta,true);
		$criteria->compare('desplanta',$this->desplanta,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codigozona',$this->codigozona,true);
		$criteria->compare('capacidad',$this->capacidad);
		$criteria->compare('factor',$this->factor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}