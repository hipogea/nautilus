<?php

/**
 * This is the model class for table "aceites".
 *
 * The followings are the available columns in table 'aceites':
 * @property string $nombre
 * @property string $marca
 * @property string $prop1
 * @property string $comaterial
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 */
class Aceites extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Aceites the static model class
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
		return 'aceites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comaterial', 'required'),
			array('nombre', 'length', 'max'=>50),
			array('marca, creadopor, modificadopor', 'length', 'max'=>25),
			array('prop1', 'length', 'max'=>10),
			array('comaterial', 'length', 'max'=>8),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nombre, marca, prop1, comaterial, creadopor, creadoel, modificadopor, modificadoel', 'safe', 'on'=>'search'),
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
			'nombre' => 'Nombre',
			'marca' => 'Marca',
			'prop1' => 'Prop1',
			'comaterial' => 'Comaterial',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
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

		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('prop1',$this->prop1,true);
		$criteria->compare('comaterial',$this->comaterial,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	 /** Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search2($codigoep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
			$criteria=new CDbCriteria;
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('prop1',$this->prop1,true);
		$criteria->compare('comaterial',$this->comaterial,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->addCondition("codep = '".$codigoep."'");
		$criteria->addCondition("tienecarter = '1'");
		//$criteria->params = array(':codbarco' => $codigoep);	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	
	
	
}