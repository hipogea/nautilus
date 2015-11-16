<?php

/**
 * This is the model class for table "{{alkardextraslado}}".
 *
 * The followings are the available columns in table '{{alkardextraslado}}':
 * @property string $id
 * @property string $hidkardexemi
 * @property double $cant
 * @property string $hidkardexdes
 * @property string $codestado
 *
 * The followings are the available model relations:
 * @property Alinventario $hidkardexdes0
 * @property Alinventario $hidkardexemi0
 */
class Alkardextraslado extends CActiveRecord
{

	const ESTADO_CREADO='10';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{alkardextraslado}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidkardexemi, cant, codestado', 'required'),
			array('cant', 'numerical'),
			array('hidkardexemi, hidkardexdes', 'length', 'max'=>20),
			array('codestado', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidkardexemi, cant, hidkardexdes, codestado', 'safe', 'on'=>'search'),
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
			'hidkardexdes0' => array(self::BELONGS_TO, 'Alinventario', 'hidkardexdes'),
			'hidkardexemi0' => array(self::BELONGS_TO, 'Alinventario', 'hidkardexemi'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidkardexemi' => 'Hidkardexemi',
			'cant' => 'Cant',
			'hidkardexdes' => 'Hidkardexdes',
			'codestado' => 'Codestado',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidkardexemi',$this->hidkardexemi,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('hidkardexdes',$this->hidkardexdes,true);
		$criteria->compare('codestado',$this->codestado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alkardextraslado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
