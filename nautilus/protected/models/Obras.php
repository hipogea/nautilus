<?php

/**
 * This is the model class for table "obras".
 *
 * The followings are the available columns in table 'obras':
 * @property string $descriobra
 * @property string $oi
 * @property string $idinventario
 * @property string $fechasol
 * @property string $codep
 * @property string $fechacierre
 * @property string $cc
 * @property string $estado
 * @property string $om
 * @property string $obs
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $centro
 * @property string $numero
 * @property string $prefijo
 * @property integer $idobra
 */
class Obras extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Obras the static model class
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
		return 'obras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descriobra', 'length', 'max'=>35),
			array('oi', 'length', 'max'=>12),
			array('codep', 'length', 'max'=>3),
			array('cc', 'length', 'max'=>6),
			array('estado', 'length', 'max'=>1),
			array('om', 'length', 'max'=>8),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('centro, numero, prefijo', 'length', 'max'=>4),
			array('idinventario, fechasol, fechacierre, obs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('descriobra, oi, idinventario, fechasol, codep, fechacierre, cc, estado, om, obs, creadopor, creadoel, modificadopor, modificadoel, centro, numero, prefijo, idobra', 'safe', 'on'=>'search'),
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
			'descriobra' => 'Descripcion',
			'oi' => 'Orden interna',
			'idinventario' => 'Idinventario',
			'fechasol' => 'Fecha solicitud',
			'codep' => 'Embarcacion',
			'fechacierre' => 'Fecha de Culminacion',
			'cc' => 'Cemtro de costo',
			'estado' => 'Estado',
			'om' => 'Om',
			'obs' => 'Observaciones',			
			'centro' => 'Centro',
			'numero' => 'Numero',
			'prefijo' => 'Prefijo',
			'idobra' => 'Idobra',
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

		$criteria->compare('descriobra',$this->descriobra,true);
		$criteria->compare('oi',$this->oi,true);
		$criteria->compare('idinventario',$this->idinventario,true);
		$criteria->compare('fechasol',$this->fechasol,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('fechacierre',$this->fechacierre,true);
		$criteria->compare('cc',$this->cc,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('om',$this->om,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('prefijo',$this->prefijo,true);
		$criteria->compare('idobra',$this->idobra);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}