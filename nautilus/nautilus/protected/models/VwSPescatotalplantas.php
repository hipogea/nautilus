<?php

/**
 * This is the model class for table "vw_s_pescatotalplantas".
 *
 * The followings are the available columns in table 'vw_s_pescatotalplantas':
 * @property string $fecha
 * @property string $tpescapropia
 * @property string $tbarcospropios
 * @property string $tpescatotal
 * @property string $tbarcostotales
 * @property string $tcapacidad
 * @property string $tfalta
 * @property string $tpescaterceros
 */
class VwSPescatotalplantas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwSPescatotalplantas the static model class
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
		return 'vw_s_pescatotalplantas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, tpescapropia, tbarcospropios, tpescatotal, tbarcostotales, tcapacidad, tfalta, tpescaterceros', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fecha, tpescapropia, tbarcospropios, tpescatotal, tbarcostotales, tcapacidad, tfalta, tpescaterceros', 'safe', 'on'=>'search'),
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
			'fecha' => 'Fecha',
			'tpescapropia' => 'Tpescapropia',
			'tbarcospropios' => 'Tbarcospropios',
			'tpescatotal' => 'Tpescatotal',
			'tbarcostotales' => 'Tbarcostotales',
			'tcapacidad' => 'Tcapacidad',
			'tfalta' => 'Tfalta',
			'tpescaterceros' => 'Tpescaterceros',
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

		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('tpescapropia',$this->tpescapropia,true);
		$criteria->compare('tbarcospropios',$this->tbarcospropios,true);
		$criteria->compare('tpescatotal',$this->tpescatotal,true);
		$criteria->compare('tbarcostotales',$this->tbarcostotales,true);
		$criteria->compare('tcapacidad',$this->tcapacidad,true);
		$criteria->compare('tfalta',$this->tfalta,true);
		$criteria->compare('tpescaterceros',$this->tpescaterceros,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_dia($fecha,$idtemporada)
	{
			$criteria=new CDbCriteria;

		$criteria=new CDbCriteria;

		//$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('tpescapropia',$this->tpescapropia,true);
		$criteria->compare('tbarcospropios',$this->tbarcospropios,true);
		$criteria->compare('tpescatotal',$this->tpescatotal,true);
		$criteria->compare('tbarcostotales',$this->tbarcostotales,true);
		$criteria->compare('tcapacidad',$this->tcapacidad,true);
		$criteria->compare('tfalta',$this->tfalta,true);
		$criteria->compare('tpescaterceros',$this->tpescaterceros,true);
		$criteria->addCondition(" fecha= '".$fecha."'");
		$criteria->addCondition(" idtemporada= ".$idtemporada."");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
										'pageSize' => 40,
												),
		));
	}
	
	
	
	
}