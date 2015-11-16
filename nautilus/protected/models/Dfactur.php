<?php

/**
 * This is the model class for table "{{dfactur}}".
 *
 * The followings are the available columns in table '{{dfactur}}':
 * @property string $id
 * @property string $hidfactu
 * @property string $item
 * @property string $codart
 * @property double $cant
 * @property double $punit
 * @property string $um
 * @property string $descripcion
 * @property double $pventa
 * @property double $igv
 * @property double $igv_monto
 * @property string $igv_tipoafecta
 * @property string $igv_codtributo
 * @property string $igv_codinternac
 * @property double $isc
 * @property double $isc_montoitem
 * @property double $isc_montolinea
 * @property string $isc_codsistema
 * @property string $isc_codtributo
 * @property string $isc_codinternac
 * @property double $valorventa
 * @property double $valor_op_no_onerosas
 * @property double $descuento
 * @property integer $idtemp
 * @property integer $idstatus
 * @property integer $iduser
 * @property string $texto
 * @property string $idref
 * @property integer $idusertemp
 * @property string $codocu
 * @property string $codestado
 *
 * The followings are the available model relations:
 * @property Factur $hidfactu0
 */
class Dfactur extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dfactur the static model class
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
		return '{{dfactur}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidfactu, item, codart, cant, punit, um, descripcion, pventa, igv, igv_monto, igv_tipoafecta, igv_codtributo, igv_codinternac, isc, isc_montoitem, isc_montolinea, isc_codsistema, isc_codtributo, isc_codinternac, valorventa, valor_op_no_onerosas, descuento, idtemp, idstatus, iduser, texto, idref, idusertemp, codocu, codestado', 'required'),
			array('idtemp, idstatus, iduser, idusertemp', 'numerical', 'integerOnly'=>true),
			array('cant, punit, pventa, igv, igv_monto, isc, isc_montoitem, isc_montolinea, valorventa, valor_op_no_onerosas, descuento', 'numerical'),
			array('hidfactu, idref', 'length', 'max'=>20),
			array('item, um, igv_codinternac, isc_codinternac, codocu', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>10),
			array('descripcion', 'length', 'max'=>60),
			array('igv_tipoafecta, isc_codsistema, codestado', 'length', 'max'=>2),
			array('igv_codtributo, isc_codtributo', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidfactu, item, codart, cant, punit, um, descripcion, pventa, igv, igv_monto, igv_tipoafecta, igv_codtributo, igv_codinternac, isc, isc_montoitem, isc_montolinea, isc_codsistema, isc_codtributo, isc_codinternac, valorventa, valor_op_no_onerosas, descuento, idtemp, idstatus, iduser, texto, idref, idusertemp, codocu, codestado', 'safe', 'on'=>'search'),
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
			'hidfactu0' => array(self::BELONGS_TO, 'Factur', 'hidfactu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidfactu' => 'Hidfactu',
			'item' => 'Item',
			'codart' => 'Codart',
			'cant' => 'Cant',
			'punit' => 'Punit',
			'um' => 'Um',
			'descripcion' => 'Descripcion',
			'pventa' => 'Pventa',
			'igv' => 'Igv',
			'igv_monto' => 'Igv Monto',
			'igv_tipoafecta' => 'Igv Tipoafecta',
			'igv_codtributo' => 'Igv Codtributo',
			'igv_codinternac' => 'Igv Codinternac',
			'isc' => 'Isc',
			'isc_montoitem' => 'Isc Montoitem',
			'isc_montolinea' => 'Isc Montolinea',
			'isc_codsistema' => 'Isc Codsistema',
			'isc_codtributo' => 'Isc Codtributo',
			'isc_codinternac' => 'Isc Codinternac',
			'valorventa' => 'Valorventa',
			'valor_op_no_onerosas' => 'Valor Op No Onerosas',
			'descuento' => 'Descuento',
			'idtemp' => 'Idtemp',
			'idstatus' => 'Idstatus',
			'iduser' => 'Iduser',
			'texto' => 'Texto',
			'idref' => 'Idref',
			'idusertemp' => 'Idusertemp',
			'codocu' => 'Codocu',
			'codestado' => 'Codestado',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidfactu',$this->hidfactu,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('pventa',$this->pventa);
		$criteria->compare('igv',$this->igv);
		$criteria->compare('igv_monto',$this->igv_monto);
		$criteria->compare('igv_tipoafecta',$this->igv_tipoafecta,true);
		$criteria->compare('igv_codtributo',$this->igv_codtributo,true);
		$criteria->compare('igv_codinternac',$this->igv_codinternac,true);
		$criteria->compare('isc',$this->isc);
		$criteria->compare('isc_montoitem',$this->isc_montoitem);
		$criteria->compare('isc_montolinea',$this->isc_montolinea);
		$criteria->compare('isc_codsistema',$this->isc_codsistema,true);
		$criteria->compare('isc_codtributo',$this->isc_codtributo,true);
		$criteria->compare('isc_codinternac',$this->isc_codinternac,true);
		$criteria->compare('valorventa',$this->valorventa);
		$criteria->compare('valor_op_no_onerosas',$this->valor_op_no_onerosas);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('idtemp',$this->idtemp);
		$criteria->compare('idstatus',$this->idstatus);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('idref',$this->idref,true);
		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('codestado',$this->codestado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}