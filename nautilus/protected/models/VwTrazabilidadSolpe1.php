<?php

/**
 * This is the model class for table "vw_trazabilidad_solpe_1".
 *
 * The followings are the available columns in table 'vw_trazabilidad_solpe_1':
 * @property string $numero
 * @property string $centro
 * @property string $codal
 * @property string $codart
 * @property string $txtmaterial
 * @property string $fechaent
 * @property double $cant
 * @property string $item
 * @property string $um
 * @property string $desum
 * @property string $iddesolpe
 * @property string $iddocompra
 * @property double $cantaten
 * @property string $featencion
 * @property string $user
 * @property double $cantcompras
 * @property string $itemcompra
 * @property string $numcot
 * @property string $fecha
 * @property string $codmov
 * @property string $numvale
 * @property string $movimiento
 */
class VwTrazabilidadSolpe1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_trazabilidad_solpe_1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('centro, codal, codart, txtmaterial, cantcompras, itemcompra', 'required'),
			array('cant, cantaten, cantcompras', 'numerical'),
			array('numero, codart', 'length', 'max'=>10),
			array('centro', 'length', 'max'=>4),
			array('codal, item, um, itemcompra', 'length', 'max'=>3),
			array('txtmaterial', 'length', 'max'=>40),
			array('desum, iddesolpe, iddocompra', 'length', 'max'=>20),
			array('featencion, fecha', 'length', 'max'=>19),
			array('user', 'length', 'max'=>25),
			array('numcot', 'length', 'max'=>8),
			array('codmov', 'length', 'max'=>2),
			array('numvale', 'length', 'max'=>12),
			array('movimiento', 'length', 'max'=>35),
			array('fechaent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numero, centro, codal, codart, txtmaterial, fechaent, cant, item, um, desum, iddesolpe, iddocompra, cantaten, featencion, user, cantcompras, itemcompra, numcot, fecha, codmov, numvale, movimiento', 'safe', 'on'=>'search'),
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
			'centro' => 'Centro',
			'codal' => 'Codal',
			'codart' => 'Codart',
			'txtmaterial' => 'Txtmaterial',
			'fechaent' => 'Fechaent',
			'cant' => 'Cant',
			'item' => 'Item',
			'um' => 'Um',
			'desum' => 'Desum',
			'iddesolpe' => 'Iddesolpe',
			'iddocompra' => 'Iddocompra',
			'cantaten' => 'Cantaten',
			'featencion' => 'Featencion',
			'user' => 'User',
			'cantcompras' => 'Cantcompras',
			'itemcompra' => 'Itemcompra',
			'numcot' => 'Numcot',
			'fecha' => 'Fecha',
			'codmov' => 'Codmov',
			'numvale' => 'Numvale',
			'movimiento' => 'Movimiento',
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

	public function search_por_idsolpe($id)
	{

		$criteria=new CDbCriteria;
		$criteria->addcondition("iddesolpe=".(int)$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}




	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('iddesolpe',$this->iddesolpe,true);
		$criteria->compare('iddocompra',$this->iddocompra,true);
		$criteria->compare('cantaten',$this->cantaten);
		$criteria->compare('featencion',$this->featencion,true);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('cantcompras',$this->cantcompras);
		$criteria->compare('itemcompra',$this->itemcompra,true);
		$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('numvale',$this->numvale,true);
		$criteria->compare('movimiento',$this->movimiento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwTrazabilidadSolpe1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
