<?php

/**
 * This is the model class for table "vw_alreservas".
 *
 * The followings are the available columns in table 'vw_alreservas':
 * @property string $codart
 * @property string $desum
 * @property string $um
 * @property double $cant
 * @property integer $numreserva
 * @property string $fechares
 * @property string $estado
 * @property string $atendido
 * @property string $usuario
 */
class VwAlreservas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_alreservas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('um, numreserva', 'required'),
			array('numreserva', 'numerical', 'integerOnly'=>true),
			array('cant', 'numerical'),
			array('codart', 'length', 'max'=>8),
			array('desum', 'length', 'max'=>20),
			array('um', 'length', 'max'=>3),
			array('fechares, atendido', 'length', 'max'=>19),
			array('estado, usuario', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codart, desum, um, cant, numreserva, fechares, estado, atendido, usuario', 'safe', 'on'=>'search'),
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
			'codart' => 'Codigo',
			'desum' => 'UM',
			'um' => 'Um',
			'cant' => 'Cant',
			'numreserva' => 'Numreserva',
			'fechares' => 'Fecha ',
			'estado' => 'Estado',
			'atendido' => 'Atendido',
			'usuario' => 'Usuario',
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

		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('numreserva',$this->numreserva);
		$criteria->compare('fechares',$this->fechares,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('atendido',$this->atendido,true);
		$criteria->compare('usuario',$this->usuario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function search_por_codigo($codigo,$centro,$almacen)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

       // $criteria->compare('codart',$this->codart,true);
        $criteria->compare('desum',$this->desum,true);
        $criteria->compare('um',$this->um,true);
        $criteria->compare('cant',$this->cant);
        $criteria->compare('numreserva',$this->numreserva);
        $criteria->compare('fechares',$this->fechares,true);
        $criteria->compare('estado',$this->estado,true);
        $criteria->compare('atendido',$this->atendido,true);
        $criteria->compare('usuario',$this->usuario,true);
        $criteria->addcondition("codart='".trim($codigo)."' AND estadoreserva='10' ");
      /*  if(!is_null($centro))
             $criteria->addcondition("centro='".trim($centro)."' ");
        if(!is_null($almacen))
            $criteria->addcondition("almacen='".trim($almacen)."'");
           */

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }


	public function search_por_iddesolpe($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		// $criteria->compare('codart',$this->codart,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('numreserva',$this->numreserva);
		$criteria->compare('fechares',$this->fechares,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('atendido',$this->atendido,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->addcondition("hidesolpe=".$id." AND estadoreserva<>'30' ");
		/*  if(!is_null($centro))
				 $criteria->addcondition("centro='".trim($centro)."' ");
			if(!is_null($almacen))
				$criteria->addcondition("almacen='".trim($almacen)."'");
			   */

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_otros($id,$codigo)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		// $criteria->compare('codart',$this->codart,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('numreserva',$this->numreserva);
		$criteria->compare('fechares',$this->fechares,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('atendido',$this->atendido,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->addcondition("hidesolpe <> ".$id."  ");
		$criteria->addcondition("codart='".trim($codigo)."' AND estadoreserva<>'30'");
		/*  if(!is_null($centro))
				 $criteria->addcondition("centro='".trim($centro)."' ");
			if(!is_null($almacen))
				$criteria->addcondition("almacen='".trim($almacen)."'");
			   */

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwAlreservas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
