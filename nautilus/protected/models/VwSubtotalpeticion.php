<?php

/**
 * This is the model class for table "vw_subtotalpeticion".
 *
 * The followings are the available columns in table 'vw_subtotalpeticion':
 * @property double $punit
 * @property double $plista
 * @property double $igv_monto
 * @property double $pventa
 * @property double $descuento
 */
class VwSubtotalpeticion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwSubtotalpeticion the static model class
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
		return 'vw_subtotalpeticion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('punit, plista, igv_monto, pventa, descuento', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('punit, plista, igv_monto, pventa, descuento', 'safe', 'on'=>'search'),
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
			'punit' => 'Punit',
			'plista' => 'Plista',
			'igv_monto' => 'Igv Monto',
			'pventa' => 'Pventa',
			'descuento' => 'Descuento',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search_por_peticion($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('punit',$this->punit);
		$criteria->compare('plista',$this->plista);
		$criteria->compare('igv_monto',$this->igv_monto);
		$criteria->compare('pventa',$this->pventa);
		$criteria->compare('descuento',$this->descuento);
		$criteria->addcondition('hidpeticion='.$id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}