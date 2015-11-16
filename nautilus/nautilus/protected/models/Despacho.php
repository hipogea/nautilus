<?php

/**
 * This is the model class for table "{{despacho}}".
 *
 * The followings are the available columns in table '{{despacho}}':
 * @property string $id
 * @property integer $hidpunto
 * @property string $hidkardex
 * @property string $fechacreac
 * @property string $fechaprog
 * @property string $descripcion
 * @property string $responsable
 * @property integer $iduser
 *
 * The followings are the available model relations:
 * @property Trabajadores $responsable0
 * @property Alkardex $hidkardex0
 * @property Puntodespacho $hidpunto0
 */
class Despacho extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Despacho the static model class
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
		return '{{despacho}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidpunto, hidkardex, fechacreac', 'required'),
			array('hidpunto, iduser', 'numerical', 'integerOnly'=>true),
			array('hidkardex', 'length', 'max'=>20),
			array('descripcion', 'length', 'max'=>60),
			array('responsable', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidpunto, hidkardex, fechacreac, fechaprog, descripcion, responsable, iduser', 'safe', 'on'=>'search'),
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
			'responsable' => array(self::BELONGS_TO, 'Trabajadores', 'responsable'),
			'kardex' => array(self::BELONGS_TO, 'Alkardex', 'hidkardex'),
			'punto' => array(self::BELONGS_TO, 'Puntodespacho', 'hidpunto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidpunto' => 'Hidpunto',
			'hidkardex' => 'Hidkardex',
			'fechacreac' => 'Fechacreac',
			'fechaprog' => 'Fechaprog',
			'descripcion' => 'Descripcion',
			'responsable' => 'Responsable',
			'iduser' => 'Iduser',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidpunto',$this->hidpunto);
		$criteria->compare('hidkardex',$this->hidkardex,true);
		$criteria->compare('fechacreac',$this->fechacreac,true);
		$criteria->compare('fechaprog',$this->fechaprog,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->compare('iduser',$this->iduser);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}