<?php

/**
 * This is the model class for table "vw_trazabilidad_reservas".
 *
 * The followings are the available columns in table 'vw_trazabilidad_reservas':
 * @property string $hidesolpe
 * @property string $id
 * @property string $fecha_reserva
 * @property string $usuario_reserva
 * @property string $desdocu_reserva
 * @property double $cantidad_reservada
 * @property double $cantidad_atendida
 * @property string $fecha_atencion_vale
 * @property string $numero_vale_atencion
 * @property string $fecha_solicitud_compra
 * @property string $solicitud_compra
 * @property string $fecha_compra
 * @property string $orden_compra
 * @property string $vale_ingreso_compra_almacen
 * @property string $fecha_vale_ingreso_almacen
 */
class VwTrazabilidadReservas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_trazabilidad_reservas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cantidad_reservada, cantidad_atendida', 'numerical'),
			array('hidesolpe, id', 'length', 'max'=>20),
			array('fecha_reserva, fecha_compra', 'length', 'max'=>19),
			array('usuario_reserva', 'length', 'max'=>25),
			array('desdocu_reserva', 'length', 'max'=>45),
			array('numero_vale_atencion, vale_ingreso_compra_almacen', 'length', 'max'=>12),
			array('solicitud_compra', 'length', 'max'=>10),
			array('orden_compra', 'length', 'max'=>8),
			array('fecha_atencion_vale, fecha_solicitud_compra, fecha_vale_ingreso_almacen', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hidesolpe, id, fecha_reserva, usuario_reserva, desdocu_reserva, cantidad_reservada, cantidad_atendida, fecha_atencion_vale, numero_vale_atencion, fecha_solicitud_compra, solicitud_compra, fecha_compra, orden_compra, vale_ingreso_compra_almacen, fecha_vale_ingreso_almacen', 'safe', 'on'=>'search'),
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
			'hidesolpe' => 'id',
			'id' => 'ID',
			'fecha_reserva' => 'F Res',
			'usuario_reserva' => 'Us',
			'desdocu_reserva' => 'Doc',
			'cantidad_reservada' => 'C Res',
			'cantidad_atendida' => 'C Aten',
			'fecha_atencion_vale' => 'F Ate',
			'numero_vale_atencion' => 'Num Vale Ate',
			'fecha_solicitud_compra' => 'F Solic Comp',
			'solicitud_compra' => 'Sol Compra',
			'fecha_compra' => 'F Comp',
			'orden_compra' => 'O Comp',
			'vale_ingreso_compra_almacen' => 'Ing Comp Al',
			'fecha_vale_ingreso_almacen' => 'Fecha',
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

		$criteria->compare('hidesolpe',$this->hidesolpe,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('fecha_reserva',$this->fecha_reserva,true);
		$criteria->compare('usuario_reserva',$this->usuario_reserva,true);
		$criteria->compare('desdocu_reserva',$this->desdocu_reserva,true);
		$criteria->compare('cantidad_reservada',$this->cantidad_reservada);
		$criteria->compare('cantidad_atendida',$this->cantidad_atendida);
		$criteria->compare('fecha_atencion_vale',$this->fecha_atencion_vale,true);
		$criteria->compare('numero_vale_atencion',$this->numero_vale_atencion,true);
		$criteria->compare('fecha_solicitud_compra',$this->fecha_solicitud_compra,true);
		$criteria->compare('solicitud_compra',$this->solicitud_compra,true);
		$criteria->compare('fecha_compra',$this->fecha_compra,true);
		$criteria->compare('orden_compra',$this->orden_compra,true);
		$criteria->compare('vale_ingreso_compra_almacen',$this->vale_ingreso_compra_almacen,true);
		$criteria->compare('fecha_vale_ingreso_almacen',$this->fecha_vale_ingreso_almacen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	public function search_por_desolpe($idsolpe)
	{
		$idsolpe=MiFactoria::cleanInput($idsolpe);
		$criteria=new CDbCriteria;
		$criteria->addCondition("hidesolpe=:vid");
		$criteria->params=array(":vid"=>(int)$idsolpe);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwTrazabilidadReservas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
