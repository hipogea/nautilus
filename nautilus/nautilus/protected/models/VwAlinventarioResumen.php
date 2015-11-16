<?php

/**
 * This is the model class for table "vw_alinventario_resumen".
 *
 * The followings are the available columns in table 'vw_alinventario_resumen':
 * @property double $stocklibre
 * @property double $stocktran
 * @property double $stockres
 * @property double $stocktotal
 * @property string $codalm
 * @property string $codart
 * @property string $codcen
 * @property string $ubicacion
 */
class VwAlinventarioResumen extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwAlinventarioResumen the static model class
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
		return 'vw_alinventario_resumen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stocklibre, stocktran, stockres, stocktotal', 'numerical'),
			array('codalm', 'length', 'max'=>3),
			array('codart, ubicacion', 'length', 'max'=>10),
			array('codcen', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stocklibre, stocktran, stockres, stocktotal, codalm, codart, codcen, ubicacion', 'safe', 'on'=>'search'),
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
			'stocklibre' => 'Stocklibre',
			'stocktran' => 'Stocktran',
			'stockres' => 'Stockres',
			'stocktotal' => 'Stocktotal',
			'codalm' => 'Codalm',
			'codart' => 'Codart',
			'codcen' => 'Codcen',
			'ubicacion' => 'Ubicacion',
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

		//$criteria->compare('stocklibre',$this->stocklibre);
		//$criteria->compare('stocktran',$this->stocktran);
		//$criteria->compare('stockres',$this->stockres);
		//$criteria->compare('stocktotal',$this->stocktotal);
		$criteria->compare('codalm',$this->codalm,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('ubicacion',$this->ubicacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}