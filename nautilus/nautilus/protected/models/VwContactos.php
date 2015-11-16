<?php

/**
 * This is the model class for table "vw_contactos".
 *
 * The followings are the available columns in table 'vw_contactos':
 * @property integer $id
 * @property string $c_nombre
 * @property string $correlativo
 * @property string $c_hcod
 * @property string $despro
 * @property string $c_cargo
 * @property string $c_mail
 * @property string $c_tel
 */
class VwContactos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwContactos the static model class
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
		return 'vw_contactos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('c_nombre, c_cargo, c_mail, c_tel', 'length', 'max'=>30),
			array('correlativo', 'length', 'max'=>5),
			array('c_hcod', 'length', 'max'=>6),
			array('despro', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, c_nombre, correlativo, c_hcod, despro, c_cargo, c_mail, c_tel', 'safe', 'on'=>'search'),
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
			'c_nombre' => 'C Nombre',
			'correlativo' => 'Correlativo',
			'c_hcod' => 'C Hcod',
			'despro' => 'Despro',
			'c_cargo' => 'C Cargo',
			'c_mail' => 'C Mail',
			'c_tel' => 'C Tel',
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
		$criteria->compare('c_nombre',$this->c_nombre,true);
		$criteria->compare('correlativo',$this->correlativo,true);
		$criteria->compare('c_hcod',$this->c_hcod,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('c_cargo',$this->c_cargo,true);
		$criteria->compare('c_mail',$this->c_mail,true);
		$criteria->compare('c_tel',$this->c_tel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}