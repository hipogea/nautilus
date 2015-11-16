<?php

/**
 * This is the model class for table "lugares".
 *
 * The followings are the available columns in table 'lugares':
 * @property string $codlugar
 * @property string $deslugar
 * @property string $provincia
 * @property string $claselugar
 * @property string $codpro
 * @property integer $n_direc
 */
class Lugares extends ModeloGeneral
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lugares the static model class
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
		return '{{lugares}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deslugar, codpro,n_direc', 'required'),
			array('deslugar, codpro,n_direc','safe'),
			array('n_direc', 'numerical', 'integerOnly'=>true),
			array('codpro', 'length', 'max'=>6),
			array('deslugar', 'length', 'max'=>50),
			array('provincia', 'length', 'max'=>30),
			array('claselugar', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codlugar, deslugar, provincia, claselugar, codpro, n_direc', 'safe', 'on'=>'search'),
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
		'empresa'=>array(self::BELONGS_TO, 'Clipro', 'codpro'),
		'direcciones'=>array(self::BELONGS_TO, 'Direcciones', 'n_direc'),
		//'centro'=>array(self::BELONGS_TO, 'Clipro', 'codcen'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codlugar' => 'Codigo',
			'deslugar' => 'Nombre del lugar',
			'provincia' => 'Provincia',
			'claselugar' => 'Claselugar',
			'codpro' => 'Organizacion',
			'n_direc' => 'Direcciones',
		);
	}

	
	
	
	
	public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									    //$this->creadopor=Yii::app()->user->name;
										// $this->creadoel=Yii::app()->user->name;
										//$this->codlugar='000001';
									    $this->codlugar=Numeromaximo::numero($this->model(),'codlugar','maximovalor',6);
										//$this->cod_estado='01';
											//$this->c_salida='1';
									} else
									{
										
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
									}
									return parent::beforeSave();
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

		$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('deslugar',$this->deslugar,true);
		$criteria->compare('provincia',$this->provincia,true);
		$criteria->compare('claselugar',$this->claselugar,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('n_direc',$this->n_direc);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}