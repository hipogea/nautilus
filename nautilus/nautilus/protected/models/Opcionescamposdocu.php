<?php

class Opcionescamposdocu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Opcionescamposdocu the static model class
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
		return Yii::app()->params['prefijo'].'opcionescamposdocu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('longitud', 'numerical', 'integerOnly'=>true),
			array('codocu', 'length', 'max'=>3),
			array('campo, nombrecampo, nombredelmodelo, primercampolista, segundocampolista', 'length', 'max'=>30),
			array('tipodato', 'length', 'max'=>1),
			array('seleccionable', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codocu, campo, nombrecampo, tipodato, longitud, nombredelmodelo, primercampolista, segundocampolista, seleccionable', 'safe', 'on'=>'search'),
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
			'opcionesdocumentos' => array(self::HAS_MANY, 'Opcionesdocumentos', 'idopdoc'),
			'cuantasopcioneshay' => array(self::STAT, 'Opcionesdocumentos', 'idopdoc'),


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
			'campo' => 'Campo',
			'nombrecampo' => 'Nombrecampo',
			'tipodato' => 'Tipodato',
			'longitud' => 'Longitud',
			'nombredelmodelo' => 'Nombredelmodelo',
			'primercampolista' => 'Primercampolista',
			'segundocampolista' => 'Segundocampolista',
			'seleccionable' => 'Seleccionable',
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
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('tipodato',$this->tipodato,true);
		$criteria->compare('longitud',$this->longitud);
		$criteria->compare('nombredelmodelo',$this->nombredelmodelo,true);
		$criteria->compare('primercampolista',$this->primercampolista,true);
		$criteria->compare('segundocampolista',$this->segundocampolista,true);
		$criteria->compare('seleccionable',$this->seleccionable,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function search_por_docu($docu)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('tipodato',$this->tipodato,true);
		$criteria->compare('longitud',$this->longitud);
		$criteria->compare('nombredelmodelo',$this->nombredelmodelo,true);
		$criteria->compare('primercampolista',$this->primercampolista,true);
		$criteria->compare('segundocampolista',$this->segundocampolista,true);
		$criteria->compare('seleccionable',$this->seleccionable,true);
		$criteria->addcondition("codocu='".$docu."'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	
}