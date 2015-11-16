<?php

/**
 * This is the model class for table "vw_resumenguia".
 *
 * The followings are the available columns in table 'vw_resumenguia':
 * @property integer $id
 * @property string $c_serie
 * @property string $c_numgui
 * @property string $ptopartida
 * @property string $ptollegada
 * @property string $razondestinatario
 * @property string $cod_cen
 * @property string $c_texto
 * @property string $items
 */
class VwResumenguia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwResumenguia the static model class
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
		return 'vw_resumenguia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('c_serie', 'length', 'max'=>3),
			array('c_numgui', 'length', 'max'=>8),
			array('ptopartida, ptollegada', 'length', 'max'=>60),
			array('razondestinatario', 'length', 'max'=>50),
			array('cod_cen', 'length', 'max'=>4),
			array('c_texto, items', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, c_serie, c_numgui, ptopartida, ptollegada, razondestinatario, cod_cen, c_texto, items', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'c_serie' => 'C Serie',
			'c_numgui' => 'C Numgui',
			'ptopartida' => 'Ptopartida',
			'ptollegada' => 'Ptollegada',
			'razondestinatario' => 'Razondestinatario',
			'cod_cen' => 'Cod Cen',
			'c_texto' => 'C Texto',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('c_serie',$this->c_serie,true);
		$criteria->compare('c_numgui',$this->c_numgui,true);
		$criteria->compare('ptopartida',$this->ptopartida,true);
		$criteria->compare('ptollegada',$this->ptollegada,true);
		$criteria->compare('razondestinatario',$this->razondestinatario,true);
		$criteria->compare('cod_cen',$this->cod_cen,true);
		$criteria->compare('c_texto',$this->c_texto,true);
		$criteria->compare('items',$this->items,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


public function search_()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('c_serie',$this->c_serie,true);
		$criteria->compare('c_numgui',$this->c_numgui,true);
		$criteria->compare('ptopartida',$this->ptopartida,true);
		$criteria->compare('ptollegada',$this->ptollegada,true);
		$criteria->compare('razondestinatario',$this->razondestinatario,true);
		$criteria->compare('cod_cen',$this->cod_cen,true);
		$criteria->compare('c_texto',$this->c_texto,true);
		$criteria->compare('items',$this->items,true);
		$criteria->addCondition("c_estgui='01'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}