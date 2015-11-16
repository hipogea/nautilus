<?php

/**
 * This is the model class for table "vw_lugares".
 *
 * The followings are the available columns in table 'vw_lugares':
 * @property string $despro
 * @property string $codlugar
 * @property string $deslugar
 * @property string $provincia
 * @property string $claselugar
 * @property string $codpro
 * @property integer $n_direc
 * @property string $c_direc
 */
class VwLugares extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwLugares the static model class
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
		return 'vw_lugares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('n_direc', 'numerical', 'integerOnly'=>true),
			array('despro, deslugar', 'length', 'max'=>50),
			array('codlugar, codpro', 'length', 'max'=>6),
			array('provincia', 'length', 'max'=>30),
			array('claselugar', 'length', 'max'=>3),
			array('c_direc', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('despro, codlugar, deslugar, provincia,distrito,departamento, claselugar, codpro, n_direc, c_direc', 'safe', 'on'=>'search'),
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
	public function findByPk($valor)
	{
		return $this->find("codlugar='".$valor."'");

	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'despro' => 'Organizacion',
			'codlugar' => 'Cod. Lugar',
			'deslugar' => 'Nombre Lugar',
			'provincia' => 'Provincia',
			'departamento' => 'Departamento',
			'distrito' => 'Distrito',
			'claselugar' => 'Claselugar',
			'codpro' => 'Codpro',
			'n_direc' => 'N Direc',
			'c_direc' => 'C Direc',
		);
	}

	
	public function search_($n_direc)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('deslugar',$this->deslugar,true);
		$criteria->compare('provincia',$this->provincia,true);
		$criteria->compare('claselugar',$this->claselugar,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('c_direc',$this->c_direc,true);
		$criteria->addCondition("n_direc= ".$n_direc." ");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('deslugar',$this->deslugar,true);
		$criteria->compare('claselugar',$this->claselugar,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('c_direc',$this->c_direc,true);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('provincia',$this->provincia);
		$criteria->compare('distrito',$this->distrito,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}