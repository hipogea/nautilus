<?php

class VwAtencionessolpe extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_atencionessolpe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numreserva, cant, hidreserva, hidkardex, estadoatencion, txtmaterial', 'required'),
			array('numreserva', 'numerical', 'integerOnly'=>true),
			array('cantdesolpe, cantreserva, cant, preciounit, monto', 'numerical'),
			array('iddesolpe, idsolpe, id, hidreserva, hidkardex, desum', 'length', 'max'=>20),
			array('umsolpe, codocu, um', 'length', 'max'=>3),
			array('estadoreserva, estadoatencion, codmov', 'length', 'max'=>2),
			array('numkardex', 'length', 'max'=>14),
			array('usuario', 'length', 'max'=>25),
			array('codart', 'length', 'max'=>10),
			array('fecha', 'length', 'max'=>19),
			array('ceco', 'length', 'max'=>12),
			array('txtmaterial', 'length', 'max'=>40),
			array('movimiento', 'length', 'max'=>35),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iddesolpe, cantdesolpe, idsolpe, umsolpe, cantreserva, codocu, numreserva, estadoreserva, id, cant, hidreserva, hidkardex, estadoatencion, codmov, um, numkardex, usuario, codart, preciounit, fecha, monto, ceco, txtmaterial, desum, movimiento', 'safe', 'on'=>'search'),
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


	public static function getTotal($provider)
	{
		$totalreal=0;

		foreach($provider->data as $data)
		{

				$r = $data->monto;
				$totalreal+= $r;


		}
		return $totalreal;
	}






	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iddesolpe' => 'Iddesolpe',
			'cantdesolpe' => 'Cant Orig',
			'idsolpe' => 'Idsolpe',
			'umsolpe' => 'Umsolpe',
			'desumsolpe'=>'UM solic',
			'cantreserva' => 'Cantreserva',
			'codocu' => 'Codocu',
			'numreserva' => 'Numreserva',
			'estadoreserva' => 'Estadoreserva',
			'id' => 'ID',
			'numvale' => 'N. Vale',
			'cant' => 'Cant',
			'hidreserva' => 'Hidreserva',
			'hidkardex' => 'Hidkardex',
			'estadoatencion' => 'Estadoatencion',
			'codmov' => 'Codmov',
			'um' => 'Um',
			'numkardex' => 'Documento',
			'usuario' => 'Usuario',
			'codart' => 'Codigo',
			'preciounit' => 'P Unit',
			'fecha' => 'Fecha',
			'monto' => 'Monto',
			'ceco' => 'C Costo',
			'txtmaterial' => 'Concepto',
			'desumkardex' => 'Um movida',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('iddesolpe',$this->iddesolpe,true);
		$criteria->compare('cantdesolpe',$this->cantdesolpe);
		$criteria->compare('idsolpe',$this->idsolpe,true);
		$criteria->compare('umsolpe',$this->umsolpe,true);
		$criteria->compare('cantreserva',$this->cantreserva);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('numreserva',$this->numreserva);
		$criteria->compare('estadoreserva',$this->estadoreserva,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('hidreserva',$this->hidreserva,true);
		$criteria->compare('hidkardex',$this->hidkardex,true);
		$criteria->compare('estadoatencion',$this->estadoatencion,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('numkardex',$this->numkardex,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('preciounit',$this->preciounit);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('ceco',$this->ceco,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('movimiento',$this->movimiento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}





	public function search_por_solpe($id)
	{
		$criteria=new CDbCriteria;

		$criteria->addcondition("idsolpe=:vidsolpe");
		$criteria->params=array(":vidsolpe"=>$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_reserva($hidreserva)
	{
		$criteria=new CDbCriteria;

		$criteria->addcondition("hidreserva=:vidsolpe");
		$criteria->params=array(":vidsolpe"=>$hidreserva);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwAtencionessolpe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
