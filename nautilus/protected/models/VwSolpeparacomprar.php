<?php
CONST ESTADO_OC_APROBADA='20';
/**
 * This is the model class for table "vw_solpeparacomprar".
 *
 * The followings are the available columns in table 'vw_solpeparacomprar':
 * @property string $numero
 * @property string $estado
 * @property string $fechaent
 * @property string $tipsolpe
 * @property string $centro
 * @property string $codal
 * @property string $codart
 * @property string $imputacion
 * @property double $cant
 * @property string $desum
 * @property string $txtmaterial
 * @property double $cantatendida
 * @property double $cant_pendiente
 */
class VwSolpeparacomprar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_solpeparacomprar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('centro, codal, codart, txtmaterial', 'required'),
			array('cant, cantatendida, cant_pendiente', 'numerical'),
			array('numero, codart', 'length', 'max'=>10),
			array('estado', 'length', 'max'=>2),
			array('tipsolpe', 'length', 'max'=>1),
			array('centro', 'length', 'max'=>4),
			array('codal', 'length', 'max'=>3),
			array('imputacion', 'length', 'max'=>12),
			array('desum', 'length', 'max'=>20),
			array('txtmaterial', 'length', 'max'=>40),
			array('txtmateriales', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numero, estado, fechaent, tipsolpe, centro, codal, codart, imputacion, cant, desum, txtmaterial, cantatendida, cant_pendiente', 'safe', 'on'=>'search'),
			//array('numero, estado, fechaent, tipsolpe, centro, codal, codart, imputacion, cant, desum, txtmaterial, cantatendida, cant_pendiente', 'safe', 'on'=>'search')
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
			'numero' => 'Numero',
			'estado' => 'Estado',
			'fechaent' => 'Fechaent',
			'tipsolpe' => 'Tipsolpe',
			'centro' => 'Centro',
			'codal' => 'Codal',
			'codart' => 'Codart',
			'imputacion' => 'Imputacion',
			'cant' => 'Cant',
			'desum' => 'Desum',
			'txtmaterial' => 'Txtmaterial',
			'cantatendida' => 'Cantatendida',
			'cant_pendiente' => 'Cant Pendiente',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('tipsolpe',$this->tipsolpe,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('cantatendida',$this->cantatendida);
		$criteria->compare('cant_pendiente',$this->cant_pendiente);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 100,
			)
		));
	}


	public function findByPk($numero){
		$registros=self::model()->findAll("numero=:vnumero",array(":vnumero"=>$numero));
		if(!is_null($registros)){
			return $registros[0];
		}else {
			return null;
		}


	}

	public function search_aprobados()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('tipsolpe',$this->tipsolpe,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('cantatendida',$this->cantatendida);
		$criteria->compare('cant_pendiente',$this->cant_pendiente);
		$criteria->addcondition("estado='".ESTADO_OC_APROBADA."'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwSolpeparacomprar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
