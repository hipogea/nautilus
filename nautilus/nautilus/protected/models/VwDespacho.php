<?php

/**
 * This is the model class for table "vw_despacho".
 *
 * The followings are the available columns in table 'vw_despacho':
 * @property string $id
 * @property integer $hidpunto
 * @property string $hidkardex
 * @property string $fechacreac
 * @property string $fechaprog
 * @property string $descripcion
 * @property string $responsable
 * @property integer $iduser
 * @property string $vigente
 * @property string $codart
 * @property string $codcentro
 * @property string $nombrepunto
 * @property string $codalmacen
 * @property string $descripmaterial
 * @property double $cant
 * @property string $desum
 * @property string $idkardex
 * @property string $numdocref
 * @property string $numvale
 * @property string $movimiento
 */
class VwDespacho extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwDespacho the static model class
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
		return 'vw_despacho';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidpunto, hidkardex, fechacreac, fechaprog, descripcion, responsable, iduser, vigente, nombrepunto', 'required'),
			array('hidpunto, iduser', 'numerical', 'integerOnly'=>true),
			array('cant', 'numerical'),
			array('id, hidkardex, desum, idkardex', 'length', 'max'=>20),
			array('descripcion, descripmaterial', 'length', 'max'=>60),
			array('responsable, codcentro', 'length', 'max'=>4),
			array('vigente', 'length', 'max'=>1),
			array('codart', 'length', 'max'=>10),
			array('nombrepunto', 'length', 'max'=>40),
			array('codalmacen', 'length', 'max'=>3),
			array('numdocref', 'length', 'max'=>15),
			array('numvale', 'length', 'max'=>12),
			array('movimiento', 'length', 'max'=>35),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hidpunto, hidkardex, fechacreac, fechaprog, descripcion, responsable, iduser, vigente, codart, codcentro, nombrepunto, codalmacen, descripmaterial, cant, desum, idkardex, numdocref, numvale, movimiento', 'safe', 'on'=>'search'),
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
			'hidpunto' => 'Hidpunto',
			'hidkardex' => 'Hidkardex',
			'fechacreac' => 'Fechacreac',
			'fechaprog' => 'Fechaprog',
			'descripcion' => 'Descripcion',
			'responsable' => 'Responsable',
			'iduser' => 'Iduser',
			'vigente' => 'Vigente',
			'codart' => 'Codart',
			'codcentro' => 'Codcentro',
			'nombrepunto' => 'Nombrepunto',
			'codalmacen' => 'Codalmacen',
			'descripmaterial' => 'Descripmaterial',
			'cant' => 'Cant',
			'desum' => 'Desum',
			'idkardex' => 'Idkardex',
			'numdocref' => 'Numdocref',
			'numvale' => 'Numvale',
			'movimiento' => 'Movimiento',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search_vigente()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidpunto',$this->hidpunto);
		$criteria->compare('hidkardex',$this->hidkardex,true);
		$criteria->compare('fechacreac',$this->fechacreac,true);
		$criteria->compare('fechaprog',$this->fechaprog,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('vigente',$this->vigente,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('nombrepunto',$this->nombrepunto,true);
		$criteria->compare('codalmacen',$this->codalmacen,true);
		$criteria->compare('descripmaterial',$this->descripmaterial,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('idkardex',$this->idkardex,true);
		$criteria->compare('numdocref',$this->numdocref,true);
		$criteria->compare('numvale',$this->numvale,true);
		$criteria->compare('movimiento',$this->movimiento,true);
		$criteria->addCondition("vigente='1'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_vale($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addcondition('hidvale='.$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}