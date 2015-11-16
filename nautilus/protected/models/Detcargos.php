<?php

/**
 * This is the model class for table "detcargos".
 *
 * The followings are the available columns in table 'detcargos':
 * @property string $hidcargo
 * @property string $coditem
 * @property string $codmaterial
 * @property string $m_detcargo
 * @property string $c_esdetcargo
 * @property string $iddetcargo
 * @property string $descrip
 * @property string $coddocudetallecargo
 * @property double $cantcargo
 * @property integer $esactivo
 * @property integer $esusado
 * @property string $umedida
 */
class Detcargos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Detcargos the static model class
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
		return 'detcargos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidcargo, coditem, c_esdetcargo, descrip, coddocudetallecargo, cantcargo, umedida', 'required'),
			array('esactivo, esusado', 'numerical', 'integerOnly'=>true),
			array('cantcargo', 'numerical'),
			array('coditem, coddocudetallecargo, umedida', 'length', 'max'=>3),
			array('codmaterial', 'length', 'max'=>8),
			array('c_esdetcargo', 'length', 'max'=>2),
			array('descrip', 'length', 'max'=>40),
			array('m_detcargo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hidcargo, coditem, codmaterial, m_detcargo, c_esdetcargo, iddetcargo, descrip, coddocudetallecargo, cantcargo, esactivo, esusado, umedida', 'safe', 'on'=>'search'),
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
			'hidcargo' => 'Hidcargo',
			'coditem' => 'Coditem',
			'codmaterial' => 'Codmaterial',
			'm_detcargo' => 'M Detcargo',
			'c_esdetcargo' => 'C Esdetcargo',
			'iddetcargo' => 'Iddetcargo',
			'descrip' => 'Descrip',
			'coddocudetallecargo' => 'Coddocudetallecargo',
			'cantcargo' => 'Cantcargo',
			'esactivo' => 'Esactivo',
			'esusado' => 'Esusado',
			'umedida' => 'Umedida',
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

		$criteria->compare('hidcargo',$this->hidcargo,true);
		$criteria->compare('coditem',$this->coditem,true);
		$criteria->compare('codmaterial',$this->codmaterial,true);
		$criteria->compare('m_detcargo',$this->m_detcargo,true);
		$criteria->compare('c_esdetcargo',$this->c_esdetcargo,true);
		$criteria->compare('iddetcargo',$this->iddetcargo,true);
		$criteria->compare('descrip',$this->descrip,true);
		$criteria->compare('coddocudetallecargo',$this->coddocudetallecargo,true);
		$criteria->compare('cantcargo',$this->cantcargo);
		$criteria->compare('esactivo',$this->esactivo);
		$criteria->compare('esusado',$this->esusado);
		$criteria->compare('umedida',$this->umedida,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}