<?php

/**
 * This is the model class for table "vw_ocompratotalizado".
 *
 * The followings are the available columns in table 'vw_ocompratotalizado':
 * @property string $numcot
 * @property string $codpro
 * @property string $fecdoc
 * @property string $codcon
 * @property string $codestado
 * @property string $texto
 * @property string $tipologia
 * @property string $moneda
 * @property string $orcli
 * @property string $usuario
 * @property string $coddocu
 * @property string $creado
 * @property string $codgrupoventas
 * @property string $codtipocotizacion
 * @property integer $validez
 * @property string $codcentro
 * @property string $fechanominal
 * @property integer $idguia
 * @property string $despro
 * @property string $tipofacturacion
 * @property double $nigv
 * @property integer $descuento
 * @property string $simbolo
 * @property string $subtotal
 * @property string $destotal
 * @property string $subtotaldes
 * @property string $impuesto
 * @property string $total
 */
class VwOcompratotalizado extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwOcompratotalizado the static model class
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
		return 'vw_ocompratotalizado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('validez, idguia, descuento', 'numerical', 'integerOnly'=>true),
			array('nigv', 'numerical'),
			array('numcot', 'length', 'max'=>8),
			array('codpro', 'length', 'max'=>6),
			array('codcon', 'length', 'max'=>5),
			array('codestado', 'length', 'max'=>2),
			array('texto', 'length', 'max'=>40),
			array('tipologia, codtipocotizacion', 'length', 'max'=>1),
			array('moneda, coddocu, codgrupoventas, simbolo', 'length', 'max'=>3),
			array('orcli', 'length', 'max'=>12),
			array('usuario, tipofacturacion', 'length', 'max'=>35),
			array('creado', 'length', 'max'=>20),
			array('codcentro', 'length', 'max'=>4),
			array('despro', 'length', 'max'=>50),
			array('fecdoc, fechanominal, subtotal, destotal, subtotaldes, impuesto, total', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('numcot, codpro, fecdoc, codcon, codestado, texto, tipologia, moneda, orcli, usuario, coddocu, creado, codgrupoventas, codtipocotizacion, validez, codcentro, fechanominal, idguia, despro, tipofacturacion, nigv, descuento, simbolo, subtotal, destotal, subtotaldes, impuesto, total', 'safe', 'on'=>'search'),
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
			'numcot' => 'Numcot',
			'codpro' => 'Codpro',
			'fecdoc' => 'Fecdoc',
			'codcon' => 'Codcon',
			'codestado' => 'Codestado',
			'texto' => 'Texto',
			'tipologia' => 'Tipologia',
			'moneda' => 'Moneda',
			'orcli' => 'Orcli',
			'usuario' => 'Usuario',
			'coddocu' => 'Coddocu',
			'creado' => 'Creado',
			'codgrupoventas' => 'Codgrupoventas',
			'codtipocotizacion' => 'Codtipocotizacion',
			'validez' => 'Validez',
			'codcentro' => 'Codcentro',
			'fechanominal' => 'Fechanominal',
			'idguia' => 'Idguia',
			'despro' => 'Despro',
			'tipofacturacion' => 'Tipofacturacion',
			'nigv' => 'Nigv',
			'descuento' => 'Descuento',
			'simbolo' => 'Simbolo',
			'subtotal' => 'Subtotal',
			'destotal' => 'Destotal',
			'subtotaldes' => 'Subtotaldes',
			'impuesto' => 'Impuesto',
			'total' => 'Total',
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

		$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('fecdoc',$this->fecdoc,true);
		$criteria->compare('codcon',$this->codcon,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('tipologia',$this->tipologia,true);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('orcli',$this->orcli,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('codgrupoventas',$this->codgrupoventas,true);
		$criteria->compare('codtipocotizacion',$this->codtipocotizacion,true);
		$criteria->compare('validez',$this->validez);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('fechanominal',$this->fechanominal,true);
		$criteria->compare('idguia',$this->idguia);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('tipofacturacion',$this->tipofacturacion,true);
		$criteria->compare('nigv',$this->nigv);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('simbolo',$this->simbolo,true);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('destotal',$this->destotal,true);
		$criteria->compare('subtotaldes',$this->subtotaldes,true);
		$criteria->compare('impuesto',$this->impuesto,true);
		$criteria->compare('total',$this->total,true);
		$criteria->addcondition("codestado='01'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}