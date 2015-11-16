<?php

/**
 * This is the model class for table "vw_detalle_stock_reservado".
 *
 * The followings are the available columns in table 'vw_detalle_stock_reservado':
 * @property string $numsolpe
 * @property string $item
 * @property string $tipimputacion
 * @property string $imputacion
 * @property string $desum
 * @property double $cantreservada
 * @property string $usuariodesolpe
 * @property string $fechaent
 * @property double $cantres
 * @property double $cantlibre
 */
class VwDetalleStockReservado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_detalle_stock_reservado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipimputacion', 'required'),
			array('cantreservada, cantres, cantlibre', 'numerical'),
			array('numsolpe', 'length', 'max'=>10),
			array('item', 'length', 'max'=>3),
			array('tipimputacion', 'length', 'max'=>1),
			array('imputacion', 'length', 'max'=>12),
			array('desum', 'length', 'max'=>20),
			array('usuariodesolpe', 'length', 'max'=>35),
			array('fechaent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numsolpe, item, tipimputacion, imputacion, desum, cantreservada, usuariodesolpe, fechaent, cantres, cantlibre', 'safe', 'on'=>'search'),
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
			'numsolpe' => 'Numsolpe',
			'item' => 'Item',
			'tipimputacion' => 'Tipimputacion',
			'imputacion' => 'Imputacion',
			'desum' => 'Desum',
			'cantreservada' => 'Cantreservada',
			'usuariodesolpe' => 'Usuariodesolpe',
			'fechaent' => 'Fechaent',
			'cantres' => 'Cantres',
			'cantlibre' => 'Cantlibre',
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

		$criteria->compare('numsolpe',$this->numsolpe,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('tipimputacion',$this->tipimputacion,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('cantreservada',$this->cantreservada);
		$criteria->compare('usuariodesolpe',$this->usuariodesolpe,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('cantres',$this->cantres);
		$criteria->compare('cantlibre',$this->cantlibre);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_inventario($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;


		$criteria->addCondition("id=".$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwDetalleStockReservado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
