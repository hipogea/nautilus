<?php

/**
 * This is the model class for table "vw_hojaentrada".
 *
 * The followings are the available columns in table 'vw_hojaentrada':
 * @property string $um
 * @property string $codart
 * @property string $codmov
 * @property double $cant
 * @property string $alemi
 * @property string $fecha
 * @property string $comentario
 * @property string $codocuref
 * @property string $numdocref
 * @property string $codcentro
 * @property double $preciounit
 * @property integer $iduser
 * @property string $fechadoc
 * @property string $numcot
 * @property string $item
 * @property double $punit
 * @property string $desum
 * @property string $despro
 * @property string $texto
 */
class VwHojaentrada extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_hojaentrada';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item, punit, texto', 'required'),
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('cant, preciounit, punit', 'numerical'),
			array('um, alemi, codocuref, item', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>10),
			array('codmov', 'length', 'max'=>2),
			array('fecha, fechadoc', 'length', 'max'=>19),
			array('comentario, texto', 'length', 'max'=>40),
			array('numdocref', 'length', 'max'=>15),
			array('codcentro', 'length', 'max'=>4),
			array('numcot', 'length', 'max'=>8),
			array('desum', 'length', 'max'=>20),
			array('despro', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('um, codart, codmov, cant, alemi, fecha, comentario, codocuref, numdocref, codcentro, preciounit, iduser, fechadoc, numcot, item, punit, desum, despro, texto', 'safe', 'on'=>'search'),
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
			'um' => 'Um',
			'codart' => 'Codart',
			'codmov' => 'Codmov',
			'cant' => 'Cant',
			'alemi' => 'Alemi',
			'fecha' => 'Fecha',
			'comentario' => 'Comentario',
			'codocuref' => 'Codocuref',
			'numdocref' => 'Numdocref',
			'codcentro' => 'Codcentro',
			'preciounit' => 'Preciounit',
			'iduser' => 'Iduser',
			'fechadoc' => 'Fechadoc',
			'numcot' => 'Numcot',
			'item' => 'Item',
			'punit' => 'Punit',
			'desum' => 'Desum',
			'despro' => 'Despro',
			'texto' => 'Texto',
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

		$criteria->compare('um',$this->um,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('alemi',$this->alemi,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codocuref',$this->codocuref,true);
		$criteria->compare('numdocref',$this->numdocref,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('preciounit',$this->preciounit);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechadoc',$this->fechadoc,true);
		$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('texto',$this->texto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwHojaentrada the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
