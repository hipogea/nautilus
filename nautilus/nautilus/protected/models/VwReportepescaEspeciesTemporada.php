<?php

/**
 * This is the model class for table "vw_reportepesca_especies_temporada".
 *
 * The followings are the available columns in table 'vw_reportepesca_especies_temporada':
 * @property string $nomespecie
 * @property integer $idespecie
 * @property integer $idtemporada
 * @property string $sum
 */
class VwReportepescaEspeciesTemporada extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwReportepescaEspeciesTemporada the static model class
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
		return 'vw_reportepesca_especies_temporada';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idespecie, idtemporada', 'numerical', 'integerOnly'=>true),
			array('nomespecie', 'length', 'max'=>50),
			array('sum', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nomespecie, idespecie, idtemporada, sum', 'safe', 'on'=>'search'),
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
			'nomespecie' => 'Nomespecie',
			'idespecie' => 'Idespecie',
			'idtemporada' => 'Idtemporada',
			'sum' => 'Sum',
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

		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sum',$this->sum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function search_por_temporada($idtemporada)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('sum',$this->sum,true);
        $criteria->addcondition("idtemporada=".$idtemporada);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
}