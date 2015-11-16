<?php

/**
 * This is the model class for table "vw_despachogeneral".
 *
 * The followings are the available columns in table 'vw_despachogeneral':
 * @property string $codcentro
 * @property string $codalmacen
 * @property string $nombrepunto
 * @property string $numvale
 * @property string $items
 */
class VwDespachogeneral extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwDespachogeneral the static model class
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
		return 'vw_despachogeneral';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombrepunto', 'required'),
			array('codcentro', 'length', 'max'=>4),
			array('codalmacen', 'length', 'max'=>3),
			array('nombrepunto', 'length', 'max'=>40),
			array('numvale', 'length', 'max'=>12),
			array('items', 'length', 'max'=>21),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codcentro, codalmacen, nombrepunto, numvale, items', 'safe', 'on'=>'search'),
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
			'codcentro' => 'Codcentro',
			'codalmacen' => 'Codalmacen',
			'nombrepunto' => 'Nombrepunto',
			'numvale' => 'Numvale',
			'items' => 'Items',
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

		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codalmacen',$this->codalmacen,true);
		$criteria->compare('nombrepunto',$this->nombrepunto,true);
		$criteria->compare('numvale',$this->numvale,true);
		$criteria->compare('items',$this->items,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}