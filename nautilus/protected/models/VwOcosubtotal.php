<?php

/**
 * This is the model class for table "vw_ocosubtotal".
 *
 * The followings are the available columns in table 'vw_ocosubtotal':
 * @property string $hidguia
 * @property double $nigv
 * @property integer $descuento
 * @property string $simbolo
 * @property string $subtotal
 * @property string $destotal
 * @property string $subtotaldes
 * @property string $impuesto
 * @property string $total
 */
class VwOcosubtotal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwOcosubtotal the static model class
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
		return 'vw_ocosubtotal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descuento','idguia', 'numerical', 'integerOnly'=>true),
			array('nigv', 'numerical'),
			array('simbolo', 'length', 'max'=>3),
			array('hidguia, subtotal, destotal, subtotaldes, impuesto, total', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hidguia, nigv, descuento, simbolo, subtotal, destotal, subtotaldes, impuesto, total', 'safe', 'on'=>'search'),
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
			'hidguia' => 'Hidguia',
			'idguia'=>'idguia',
			'nigv' => 'Nigv',
			'descuento' => 'Descuento',
			'simbolo' => 'Simbolo',
			'subtotal' => 'Subtotal',
			'destotal' => 'Destotal',
			'subtotaldes' => 'Subtotaldes',
			'impuesto' => 'Impuesto',
			'total' => 'Total',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('idguia',$this->idguia,true);
		$criteria->compare('hidguia',$this->hidguia,true);
		$criteria->compare('nigv',$this->nigv);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('simbolo',$this->simbolo,true);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('destotal',$this->destotal,true);
		$criteria->compare('subtotaldes',$this->subtotaldes,true);
		$criteria->compare('impuesto',$this->impuesto,true);
		$criteria->compare('total',$this->total,true);
		$criteria->addcondition('idguia='.$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}