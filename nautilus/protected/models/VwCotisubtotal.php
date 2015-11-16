<?php

/**
 * This is the model class for table "vw_cotisubtotal".
 *
 * The followings are the available columns in table 'vw_cotisubtotal':
 * @property double $nigv
 * @property integer $descuento
 * @property double $subtotal
 * @property double $destotal
 * @property double $impuesto
 */
class VwCotisubtotal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwCotisubtotal the static model class
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
		return 'vw_cotisubtotal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descuento','hidguia', 'numerical', 'integerOnly'=>true),
			array('nigv, subtotal, destotal, impuesto', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,total,subtotaldes,nigv,hidguia, descuento, subtotal, destotal, impuesto', 'safe', 'on'=>'search'),
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
			'nigv' => 'Nigv',
			'descuento' => 'Descuento',
			'subtotal' => 'Subtotal',
			'destotal' => 'Destotal',
			'impuesto' => 'Impuesto',
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

		$criteria->compare('nigv',$this->nigv);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('subtotaldes',$this->descuento);
		$criteria->compare('subtotal',$this->subtotal);
		$criteria->compare('destotal',$this->destotal);
		$criteria->compare('impuesto',$this->impuesto);
		$criteria->addcondition('hidguia='.$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}