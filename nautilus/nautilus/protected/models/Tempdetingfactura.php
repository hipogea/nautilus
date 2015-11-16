<?php

/**
 * This is the model class for table "{{tempdetingfactura}}".
 *
 * The followings are the available columns in table '{{tempdetingfactura}}':
 * @property string $hidfactura
 * @property string $item
 * @property string $hidkardex
 * @property integer $iduser
 * @property string $fechacrea
 * @property string $idtemp
 * @property integer $idusertemp
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Alkardex $hidkardex0
 * @property Ingfactura $hidfactura0
 */
class Tempdetingfactura extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tempdetingfactura}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('hidfactura, item, hidkardex, iduser, fechacrea, idusertemp, id', 'required'),
			array('iduser, idusertemp, id', 'numerical', 'integerOnly'=>true),
			//array('hidfactura, hidkardex', 'length', 'max'=>20),
			//array('item', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hidfactura, hidalentrega, item, iduser, fechacrea, idtemp, idusertemp, id', 'safe', 'on'=>'search'),
			array('hidfactura, hidalentrega,idusertemp,idstatus','safe','on'=>'basico'),
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
			'entregas' => array(self::BELONGS_TO, 'Alentregas', 'hidalentrega'),
			'recepcion' => array(self::BELONGS_TO, 'Ingfactura', 'hidfactura'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hidfactura' => 'Hidfactura',
			'item' => 'Item',
			'hidkardex' => 'Hidkardex',
			'iduser' => 'Iduser',
			'fechacrea' => 'Fechacrea',
			'idtemp' => 'Idtemp',
			'idusertemp' => 'Idusertemp',
			'id' => 'ID',
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

		$criteria->compare('hidfactura',$this->hidfactura,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('hidkardex',$this->hidkardex,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('idtemp',$this->idtemp,true);
		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_cabecera($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('hidfactura',$this->hidfactura,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('hidkardex',$this->hidkardex,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('idtemp',$this->idtemp,true);
		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('id',$this->id);
		$criteria->addCondition("hidfactura=:identidad");
		$criteria->params=array(":identidad"=>(int)$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,












		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tempdetingfactura the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
