<?php

/**
 * This is the model class for table "{{authobjetoslista}}".
 *
 * The followings are the available columns in table '{{authobjetoslista}}':
 * @property string $id
 * @property integer $hidobjeto
 * @property integer $iduser
 * @property string $valorobjeto
 * @property integer $signo
 *
 * The followings are the available model relations:
 * @property Authobjetos $hidobjeto0
 */
class Authobjetoslista extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{authobjetoslista}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidobjeto, iduser, valorobjeto, signo', 'required'),
			array('hidobjeto, iduser, signo', 'numerical', 'integerOnly'=>true),
			array('valorobjeto', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidobjeto, iduser, valorobjeto, signo', 'safe', 'on'=>'search'),
			array('valorobjeto,hidobjeto, iduser', 'safe', 'on'=>'centros'),
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
			'hidobjeto0' => array(self::BELONGS_TO, 'Authobjetos', 'hidobjeto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidobjeto' => 'Hidobjeto',
			'iduser' => 'Iduser',
			'valorobjeto' => 'Valorobjeto',
			'signo' => 'Signo',
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
	public function search($idobjeto,$iduser)
	{
		$idobjeto=(int)$idobjeto;
		$iduser=(int)$iduser;

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidobjeto',$this->hidobjeto);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('valorobjeto',$this->valorobjeto,true);
		$criteria->compare('signo',$this->signo);
		$criteria->addcondition('iduser='.$iduser);
		$criteria->addcondition('hidobjeto='.$idobjeto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Authobjetoslista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
