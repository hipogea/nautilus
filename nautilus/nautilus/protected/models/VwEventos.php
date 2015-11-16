<?php

class VwEventos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwEventos the static model class
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
		return 'vw_eventos';
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
			array('codocu', 'length', 'max'=>3),
			array('estadofinal, estadoinicial', 'length', 'max'=>2),
			array('descripcion', 'length', 'max'=>30),
			array('creadopor', 'length', 'max'=>20),
			array('creadoel', 'length', 'max'=>15),
			array('einicial, efinal', 'length', 'max'=>25),
			array('desdocu', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codocu, estadofinal, estadoinicial, descripcion, creadopor, creadoel, einicial, desdocu, efinal', 'safe', 'on'=>'search'),
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
			'codocu' => 'Codocu',
			'estadofinal' => 'Estadofinal',
			'estadoinicial' => 'Estadoinicial',
			'descripcion' => 'Descripcion',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'einicial' => 'Einicial',
			'desdocu' => 'Desdocu',
			'efinal' => 'Efinal',
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
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('estadofinal',$this->estadofinal,true);
		$criteria->compare('estadoinicial',$this->estadoinicial,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('einicial',$this->einicial,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('efinal',$this->efinal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_docu($documento)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('estadofinal',$this->estadofinal,true);
		$criteria->compare('estadoinicial',$this->estadoinicial,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('einicial',$this->einicial,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('efinal',$this->efinal,true);
		$criteria->addcondition(" codocu='".$documento."' ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}