<?php

/**
 * This is the model class for table "vw_ultimashoras".
 *
 * The followings are the available columns in table 'vw_ultimashoras':
 * @property integer $id
 * @property string $codep
 * @property string $fechaarribo
 * @property integer $horometrodes
 */
class VwUltimashoras extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwUltimashoras the static model class
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
		return 'vw_ultimashoras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, idequipo', 'numerical', 'integerOnly'=>true),
			//array('fulectura', 'length', 'max'=>3),
			//array('fechaarribo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, idequipo, fulectura, horometro', 'safe', 'on'=>'search'),
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
			'codep' => 'Codep',
			'fechaarribo' => 'Fecha_de_lectura',
			'horometrodes' => 'Horometro',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($idequipo)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('idequipo',$this->idequipo,true);
		$criteria->compare('fulectura',$this->fulectura,true);
		$criteria->compare('horometro',$this->horometro);
        $criteria->addCondition("idequipo = ".$idequipo."");		
		
	//	$criteria->offset=4;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}