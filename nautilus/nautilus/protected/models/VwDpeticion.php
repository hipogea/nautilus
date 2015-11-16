<?php

/**
 * This is the model class for table "vw_dpeticion".
 *
 * The followings are the available columns in table 'vw_dpeticion':
 * @property string $id
 * @property string $hidpeticion
 * @property string $um
 * @property string $codart
 * @property double $punit
 * @property double $plista
 * @property double $igv_monto
 * @property double $descuento
 * @property double $pventa
 * @property double $cant
 * @property string $comentario
 * @property string $codestado
 * @property string $codcen
 * @property string $codal
 * @property string $disponibilidad
 * @property string $idtemp
 * @property string $item
 * @property integer $idusertemp
 * @property string $descripcion
 * @property integer $idstatus
 * @property string $tipo
 * @property string $imputacion
 * @property string $codocu
 * @property string $estado
 * @property string $dedispo
 */
class VwDpeticion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwDpeticion the static model class
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
		return 'vw_dpeticion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidpeticion, um, codart, punit, plista, igv_monto, descuento, pventa, cant, comentario, codestado, codcen, codal, disponibilidad, idtemp, idusertemp, descripcion, idstatus, tipo, imputacion, codocu', 'required'),
			array('idusertemp, idstatus', 'numerical', 'integerOnly'=>true),
			array('punit, plista, igv_monto, descuento, pventa, cant', 'numerical'),
			array('id, hidpeticion, idtemp', 'length', 'max'=>20),
			array('um, codal, item, codocu', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>10),
			array('codestado, disponibilidad', 'length', 'max'=>2),
			array('codcen', 'length', 'max'=>4),
			array('descripcion, dedispo', 'length', 'max'=>40),
			array('tipo', 'length', 'max'=>1),
			array('imputacion', 'length', 'max'=>12),
			array('estado', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidpeticion, um, codart, punit, plista, igv_monto, descuento, pventa, cant, comentario, codestado, codcen, codal, disponibilidad, idtemp, item, idusertemp, descripcion, idstatus, tipo, imputacion, codocu, estado, dedispo', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'hidpeticion' => 'Hidpeticion',
			'um' => 'Um',
			'codart' => 'Codart',
			'punit' => 'Punit',
			'plista' => 'Plista',
			'igv_monto' => 'Igv Monto',
			'descuento' => 'Descuento',
			'pventa' => 'Pventa',
			'cant' => 'Cant',
			'comentario' => 'Comentario',
			'codestado' => 'Codestado',
			'codcen' => 'Codcen',
			'codal' => 'Codal',
			'disponibilidad' => 'Disponibilidad',
			'idtemp' => 'Idtemp',
			'item' => 'Item',
			'idusertemp' => 'Idusertemp',
			'descripcion' => 'Descripcion',
			'idstatus' => 'Idstatus',
			'tipo' => 'Tipo',
			'imputacion' => 'Imputacion',
			'codocu' => 'Codocu',
			'estado' => 'Estado',
			'dedispo' => 'Dedispo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search_por_peticion($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
  /*
		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidpeticion',$this->hidpeticion,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('plista',$this->plista);
		$criteria->compare('igv_monto',$this->igv_monto);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('pventa',$this->pventa);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('disponibilidad',$this->disponibilidad,true);
		$criteria->compare('idtemp',$this->idtemp,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('idstatus',$this->idstatus);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('dedispo',$this->dedispo,true);*/
		$criteria->addCondition("hidpeticion=".$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}