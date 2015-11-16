<?php

/**
 * This is the model class for table "vw_reservas_pendientes".
 *
 * The followings are the available columns in table 'vw_reservas_pendientes':
 * @property string $numero
 * @property string $idsolpe
 * @property string $item
 * @property string $desum
 * @property string $codart
 * @property string $txtmaterial
 * @property string $fechaent
 * @property string $codal
 * @property string $centro
 * @property string $hidesolpe
 * @property string $iddesolpe
 * @property string $fecha_reserva
 * @property string $usuario_reserva
 * @property string $desdocu_reserva
 * @property double $cantidad_reservada
 * @property double $cantidad_atendida
 * @property double $cantidad_pendiente
 */
class VwReservasPendientes extends CActiveRecord
{

	public $fechaent1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_reservas_pendientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codart, txtmaterial, codal, centro', 'required'),
			array('cantidad_reservada, cantidad_atendida, cantidad_pendiente', 'numerical'),
			array('numero, codart', 'length', 'max'=>10),
			array('idsolpe, desum, hidesolpe, iddesolpe', 'length', 'max'=>20),
			array('item, codal', 'length', 'max'=>3),
			array('txtmaterial', 'length', 'max'=>40),
			array('centro', 'length', 'max'=>4),
			array('fecha_reserva', 'length', 'max'=>19),
			array('usuario_reserva', 'length', 'max'=>25),
			array('desdocu_reserva', 'length', 'max'=>45),
			array('fechaent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numero, idsolpe, item, desum, codart, txtmaterial, fechaent, codal, centro, hidesolpe, iddesolpe, fecha_reserva, usuario_reserva, desdocu_reserva, cantidad_reservada, cantidad_atendida, cantidad_pendiente', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			//'hidsolpe0' => array(self::BELONGS_TO, 'Solpe', 'hidsolpe'),

			'maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'imputacion' => array(self::BELONGS_TO, 'Cc', 'imputacion'),
				// 'desolpe_alinventario'=>array(self::BELONGS_TO,'Alinventario',array('codal'=>'codalm','centro'=>'codcen','codart'=>'codart')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'numero' => 'N Sol',
			'idsolpe' => 'Idsolpe',
			'item' => 'Item',
			'desum' => 'Um',
			'codart' => 'Cod',
			'txtmaterial' => 'Material',
			'fechaent' => 'F prog',
			'codal' => 'Alm',
			'centro' => 'Cent',
			'hidesolpe' => 'Hidesolpe',
			'iddesolpe' => 'Iddesolpe',
			'fecha_reserva' => 'F Res',
			'usuario_reserva' => 'Usr Res',
			'desdocu_reserva' => 'Tipo Reserva',
			'cantidad_reservada' => 'Cant Res',
			'cantidad_atendida' => 'Cant At',
			'cantidad_pendiente' => 'Cant Pend',
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
		$criteria->compare('idsolpe',$this->idsolpe,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('hidesolpe',$this->hidesolpe,true);
		$criteria->compare('iddesolpe',$this->iddesolpe,true);
		$criteria->compare('fecha_reserva',$this->fecha_reserva,true);
		$criteria->compare('usuario_reserva',$this->usuario_reserva,true);
		$criteria->compare('desdocu_reserva',$this->desdocu_reserva,true);
		$criteria->compare('cantidad_reservada',$this->cantidad_reservada);
		$criteria->compare('cantidad_atendida',$this->cantidad_atendida);
		$criteria->compare('cantidad_pendiente',$this->cantidad_pendiente);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_pendiente()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('idsolpe',$this->idsolpe,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('desum',$this->desum,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('hidesolpe',$this->hidesolpe,true);
		$criteria->compare('iddesolpe',$this->iddesolpe,true);
		$criteria->compare('fecha_reserva',$this->fecha_reserva,true);
		$criteria->compare('usuario_reserva',$this->usuario_reserva,true);
		$criteria->compare('desdocu_reserva',$this->desdocu_reserva,true);
		$criteria->compare('cantidad_reservada',$this->cantidad_reservada);
		$criteria->compare('cantidad_atendida',$this->cantidad_atendida);
		$criteria->compare('cantidad_pendiente',$this->cantidad_pendiente);
		$criteria->addcondition('cantidad_pendiente > 0 or cantidad_pendiente IS NULL ');
		$criteria->addcondition(" estadoreserva not in ( '30','20','70') ");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}





	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VwReservasPendientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
