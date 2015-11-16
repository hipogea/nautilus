<?php

/**
 * This is the model class for table "vw_solpeatencion".
 *
 * The followings are the available columns in table 'vw_solpeatencion':
 * @property string $txtmaterial
 * @property string $numero
 * @property string $tipimputacion
 * @property string $centro
 * @property string $codal
 * @property string $grupocompras
 * @property string $usuario
 * @property string $fechacrea
 * @property string $fechaent
 * @property string $fechalib
 * @property string $imputacion
 * @property string $hidsolpe
 * @property integer $id
 * @property string $codocu
 * @property string $um
 * @property double $cant
 * @property string $item
 * @property string $codart
 * @property double $cantaten
 * @property double $cantlibre
 * @property double $cantres
 * @property double $canttran
 * @property double $atencion
 */
class VwSolpeatencion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwSolpeatencion the static model class
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
		return 'vw_solpeatencion';
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
			array('cant, cantaten, cantlibre, cantres, canttran', 'numerical'),
			array('txtmaterial', 'length', 'max'=>40),
			array('numero', 'length', 'max'=>10),
		//	array('tipimputacion', 'length', 'max'=>1),
			array('centro', 'length', 'max'=>4),
			array('codal, codocu, item', 'length', 'max'=>3),
			array('usuario', 'length', 'max'=>30),
			array('imputacion', 'length', 'max'=>12),
			array('codart', 'length', 'max'=>8),
			array('fechacrea, fechaent,  hidsolpe', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('txtmaterial, numero,  centro, codal,usuario, fechacrea, fechaent, imputacion, hidsolpe, id, codocu,  cant, item, codart, cantaten, cantlibre, cantres, canttran', 'safe', 'on'=>'search'),
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
			'txtmaterial' => 'Material',
			'numero' => 'Numero',
			//'tipimputacion' => 'Tipimputacion',
			'centro' => 'Centro',
			'codal' => 'Alm.',
			//'grupocompras' => 'Grupocompras',
			'usuario' => 'Usuario',
			'fechacrea' => 'Fechacrea',
			'fechaent' => 'Fechaent',
			//'fechalib' => 'Fechalib',
			'imputacion' => 'Imputacion',
			'hidsolpe' => 'Hidsolpe',
			'id' => 'ID',
			'codocu' => 'Codocu',
			'umbase' => 'Um Base',
			'cant' => 'Solicitado',
			'item' => 'Item',
			'codart' => 'Codigo',
			'cantaten' => 'Cantaten',
			'cantlibre' => 'Libre',
			'cantres' => 'Reservado',
			'canttran' => 'Transito',
			//'atencion' => 'Atencion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($idsolpe)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('numero',$this->numero,true);
		//$criteria->compare('tipimputacion',$this->tipimputacion,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('codal',$this->codal,true);
		//$criteria->compare('grupocompras',$this->grupocompras,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		//$criteria->compare('fechalib',$this->fechalib,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('hidsolpe',$this->hidsolpe,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('umbase',$this->umbase,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('codart',$this->codart,true);
		//$criteria->compare('cantaten',$this->cantaten);
		$criteria->compare('cantlibre',$this->cantlibre);
		$criteria->compare('cantres',$this->cantres);
		$criteria->compare('canttran',$this->canttran);
		//$criteria->compare('atencion',$this->atencion);
		$criteria->addcondition('hidsolpe='.$idsolpe);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}