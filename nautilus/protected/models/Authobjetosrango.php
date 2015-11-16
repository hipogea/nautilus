<?php

/**
 * This is the model class for table "{{authobjetosrango}}".
 *
 * The followings are the available columns in table '{{authobjetosrango}}':
 * @property string $id
 * @property integer $hidobjeto
 * @property string $valor1
 * @property string $valor2
 * @property integer $signo
 *
 * The followings are the available model relations:
 * @property Authobjetos $hidobjeto0
 */
class Authobjetosrango extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{authobjetosrango}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidobjeto, valor1, valor2, signo', 'required'),
			array('hidobjeto, signo', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>20),
			array('valor1, valor2', 'length', 'max'=>60),
			array('valor1, valor2,signo,iduser,hidobjeto', 'safe', 'on'=>'centros'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidobjeto, valor1, valor2, signo', 'safe', 'on'=>'search'),
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
			'valor1' => 'Valor1',
			'valor2' => 'Valor2',
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
		$criteria->compare('valor1',$this->valor1,true);
		$criteria->compare('valor2',$this->valor2,true);
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
	 * @return Authobjetosrango the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
