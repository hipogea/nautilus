<?php

/**
 * This is the model class for table "maestro_solicitudes".
 *
 * The followings are the available columns in table 'maestro_solicitudes':
 * @property integer $id
 * @property string $descripcioncorta
 * @property string $marca
 * @property string $modelo
 * @property string $numeroparte
 * @property string $descripcion
 * @property string $um
 * @property string $codclase
 * @property string $codgrupo
 * @property string $codsector
 * @property string $textolargo
 * @property string $codigoestado
 * @property string $codigodoc
 * @property string $codigocreado
 * @property string $descripcionfinal
 */
class Maestrosolicitudes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Maestrosolicitudes the static model class
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
		return 'maestro_solicitudes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('descripcioncorta,codclase,codgrupo,um', 'required'),
			array('descripcioncorta', 'length', 'max'=>20),
			array('marca', 'length', 'max'=>30),
			array('modelo, numeroparte', 'length', 'max'=>25),
			array('descripcion, descripcionfinal', 'length', 'max'=>40),
			array('um, codgrupo, codigodoc', 'length', 'max'=>3),
			array('codclase', 'length', 'max'=>4),
			array('codsector, codigoestado', 'length', 'max'=>2),
			array('codigocreado', 'length', 'max'=>12),
			array('textolargo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,hid, descripcioncorta, marca, modelo, numeroparte, descripcion, um, codclase, codgrupo, codsector, textolargo, codigoestado, codigodoc, codigocreado, descripcionfinal', 'safe', 'on'=>'search'),
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
		'clasesita' => array(self::BELONGS_TO, 'Clase', 'codclase'),
		'grupito' => array(self::BELONGS_TO, 'Maestrogrupos', 'codgrupo'),
		'centritos' => array(self::BELONGS_TO, 'Centros', 'centro'),	
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descripcioncorta' => 'Que cosa es',
			'marca' => 'Marca o Fabricante',
			'modelo' => 'Modelo',
			'numeroparte' => 'Numero de Parte',
			'descripcion' => 'Verificar si existe',
			'um' => 'Um',
			'codclase' => 'Clase',
			'codgrupo' => 'Grupo',
			//'codsector' => 'Codsector',
			'textolargo' => 'Informacion adicional',
			'codigoestado' => 'Estado',
			'codigodoc' => 'Documento',
			'codigocreado' => 'Codigocreado',
			'descripcionfinal' => 'Descripcion propuesta',
		);
	}

	
	public $maximovalor;
//	public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									    $this->creadopor=Yii::app()->user->name;
										// $this->creadoel=Yii::app()->user->name;
									    $this->correlativo=Numeromaximo::numero($this->model(),'correlativo','maximovalor',6);
										$this->codigoestado='01';
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

		$criteria->compare('id',$this->id);
		$criteria->compare('descripcioncorta',$this->descripcioncorta,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('numeroparte',$this->numeroparte,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('codclase',$this->codclase,true);
		$criteria->compare('codgrupo',$this->codgrupo,true);
		$criteria->compare('codsector',$this->codsector,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('codigoestado',$this->codigoestado,true);
		$criteria->compare('codigodoc',$this->codigodoc,true);
		$criteria->compare('codigocreado',$this->codigocreado,true);
		$criteria->compare('descripcionfinal',$this->descripcionfinal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search_($ide)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('descripcioncorta',$this->descripcioncorta,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('numeroparte',$this->numeroparte,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('codclase',$this->codclase,true);
		$criteria->compare('codgrupo',$this->codgrupo,true);
		$criteria->compare('codsector',$this->codsector,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('codigoestado',$this->codigoestado,true);
		$criteria->compare('codigodoc',$this->codigodoc,true);
		$criteria->compare('codigocreado',$this->codigocreado,true);
		$criteria->compare('descripcionfinal',$this->descripcionfinal,true);
		$criteria->addCondition("hid = ".$ide."");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}