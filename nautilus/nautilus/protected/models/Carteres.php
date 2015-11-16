<?php

/**
 * This is the model class for table "carteres".
 *
 * The followings are the available columns in table 'carteres':
 * @property integer $idequipo
 * @property double $capacidad
 * @property string $tipoaceite
 * @property integer $horascambio
 * @property string $tipocarter
 * @property integer $haceite
 * @property integer $hmuestra
 * @property integer $nummuestras
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $fulectura
 * @property string $fumuestra
 * @property string $fucambio
 * @property integer $horometro
 * @property string $codigo
 * @property string $activo
 * @property integer $hucambio
 * @property integer $casco
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Inventario $idequipo0
 * @property Maestrocomponentes $tipoaceite0
 */
class Carteres extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Carteres the static model class
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
		return 'carteres';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idequipo, horascambio, haceite, hmuestra, nummuestras, horometro, hucambio, casco', 'numerical', 'integerOnly'=>true),
			array('horascambio','required','message'=>'Cada cuantas horas se debe cambiar...?'),
			array('idequipo','required','message'=>'A quien le vas a cambiar...?'),
			array('tipoaceite','required','message'=>'Que lubricante vas a usar...?'),	
			array('capacidad','required','message'=>'Tamano del carter ...?'),	
			array('capacidad', 'numerical'),
			array('tipoaceite, codigo', 'length', 'max'=>8),
			array('tipocarter, activo', 'length', 'max'=>1),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('fulectura, fumuestra, fucambio', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idequipo, capacidad, tipoaceite, horascambio,id', 'safe', 'on'=>'search'),
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
			'idequipo0' => array(self::BELONGS_TO, 'Inventario', 'idequipo'),
			'tipoaceite0' => array(self::BELONGS_TO, 'Maestrocomponentes', 'tipoaceite'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idequipo' => 'Idequipo',
			'capacidad' => 'Capacidad',
			'tipoaceite' => 'Tipoaceite',
			'horascambio' => 'Horascambio',
			'tipocarter' => 'Tipocarter',
			'haceite' => 'Haceite',
			'hmuestra' => 'Hmuestra',
			'nummuestras' => 'Nummuestras',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'fulectura' => 'Fulectura',
			'fumuestra' => 'Fumuestra',
			'fucambio' => 'Fucambio',
			'horometro' => 'Horometro',
			'codigo' => 'Codigo',
			'activo' => 'Activo',
			'hucambio' => 'Hucambio',
			'casco' => 'Casco',
			'id' => 'ID',
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

		$criteria->compare('idequipo',$this->idequipo);
		$criteria->compare('capacidad',$this->capacidad);
		$criteria->compare('tipoaceite',$this->tipoaceite,true);
		$criteria->compare('horascambio',$this->horascambio);
		$criteria->compare('tipocarter',$this->tipocarter,true);
		$criteria->compare('haceite',$this->haceite);
		$criteria->compare('hmuestra',$this->hmuestra);
		$criteria->compare('nummuestras',$this->nummuestras);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('fulectura',$this->fulectura,true);
		$criteria->compare('fumuestra',$this->fumuestra,true);
		$criteria->compare('fucambio',$this->fucambio,true);
		$criteria->compare('horometro',$this->horometro);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('hucambio',$this->hucambio);
		$criteria->compare('casco',$this->casco);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function search2($codep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('idequipo',$this->idequipo);
		$criteria->compare('capacidad',$this->capacidad);
		$criteria->compare('tipoaceite',$this->tipoaceite,true);
		$criteria->compare('horascambio',$this->horascambio);
		$criteria->compare('tipocarter',$this->tipocarter,true);
		$criteria->compare('haceite',$this->haceite);
		$criteria->compare('hmuestra',$this->hmuestra);
		$criteria->compare('nummuestras',$this->nummuestras);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('fulectura',$this->fulectura,true);
		$criteria->compare('fumuestra',$this->fumuestra,true);
		$criteria->compare('fucambio',$this->fucambio,true);
		$criteria->compare('horometro',$this->horometro);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('hucambio',$this->hucambio);
		$criteria->compare('casco',$this->casco);
		$criteria->addCondition("codep = '".$codep."'");
		$criteria->addCondition("tienecarter = '1'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
}