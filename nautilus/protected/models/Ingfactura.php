<?php
const CODIGO_DOC_FACTURA='190';
const ESTADO_PREVIO='99';
const ESTADO_CREADO='10';
const ESTADO_ANULADO='30';

class Ingfactura extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ingfactura}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		//Si esta activcado el control de garita
		if(yii::app()->settings->get('documentos','documentos_controlrecepcion')=='1'){
			$control=array('idgarita','required','mensaje'=>'Ingrese el registro de ingreso ');
			$control2=array('idgarita','exist','allowEmpty' => false, 'attributeName' => 'id', 'className' => 'Docingresados','message'=>'Esta factura no tiene registro de admision');
		}else{
			$control=array('idgarita','safe');
		}


		return array(


			array('codpro','exist','allowEmpty' => false, 'attributeName' => 'codpro', 'className' => 'Clipro','message'=>'Esta empresa no existe'),
			array('numocompra','exist','allowEmpty' => false, 'attributeName' => 'numcot', 'className' => 'Ocompra','message'=>'Esta Ordend de compra  no existe'),

			array('codpro, fecha, fechadoc, numerodoc, numocompra, seriedoc,  descripcion, codcentro', 'required'),
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('codpro', 'length', 'max'=>8),
			array('numerodoc', 'length', 'max'=>13),
			array('seriedoc', 'length', 'max'=>5),
			array('numrecepcion', 'length', 'max'=>10),
			array('descripcion', 'length', 'max'=>40),
			array('codcentro', 'length', 'max'=>4),
			$control,
			array('codcentro', 'length', 'max'=>4),
			array('numocompra','chkcompra'),
			array('fecha','chkfechas'),
			array('fechadoc','chkfechas'),

			//
			array('id, codpro, fecha, fechadoc, numerodoc, seriedoc, numrecepcion, descripcion, iduser, fechacrea, codcentro', 'safe', 'on'=>'search'),
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
			'detalle' => array(self::HAS_MANY, 'Detingfactura', 'hidfactura'),
			'detalletemp' => array(self::HAS_MANY, 'Tempdetingfactura', 'hidfactura'),
			'clipro' => array(self::BELONGS_TO, 'Clipro', 'codpro'),
			'estado' => array(self::BELONGS_TO, 'Estado', array('codocu'=>'codocu','codestado'=>'codestado')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
			'numocompra'=>'Orden de compra',
			'codpro' => 'Proveedor',
			'fecha' => 'Fecha Recep',
			'fechadoc' => 'Fecha Fact',
			'numerodoc' => 'Numero Fact',
			'seriedoc' => 'Serie Fact',
			'numrecepcion' => 'Num Recepcion',
			'descripcion' => 'Descripcion',
			'idgarita' => 'Control de Ingreso',
			'fechacrea' => 'F Crea',
			'codcentro' => 'Centro',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('fechadoc',$this->fechadoc,true);
		$criteria->compare('numerodoc',$this->numerodoc,true);
		$criteria->compare('seriedoc',$this->seriedoc,true);
		$criteria->compare('numrecepcion',$this->numrecepcion,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('codcentro',$this->codcentro,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ingfactura the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function beforeSave() {
		if ($this->isNewRecord) {

			$this->iduser=Yii::app()->user->id;
			// $this->creadoel=Yii::app()->user->name;
			//$this->correlativo=Numeromaximo::numero($this->model(),'correlativo','maximovalor',8);
			//$this->fechacre=date('Y-m-d H:i:s');

			//$this->c_salida='1';
		} else
		{

			//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
		}
		return parent::beforeSave();
	}

	//verifica consistencia de la compra
	public function chkcompra($attribute,$params) {
		////Primero  que LA OC pertenezca al proveedor
		$registrocompra=Ocompra::findByNumero($this->numocompra);
		if(is_null($registrocompra))
			$this->adderror('numocompra', 'Esta orden de compra no existe');

			if(!$registrocompra->codpro==$this->codpro)
				$this->adderror('numocompra', 'Esta orden de compra no corresponde al Proveedor ingresado');
			///Que la OC sea una OC procesada
			$vprocesada=false;

			foreach($registrocompra->ocompra_docompra as $filadetalle){
				if($filadetalle->cantidadentregada > 0){
					$vprocesada=true;
					break; ///Basta que pesque una ya puede facturarse ese item
				}
			}
			if(!$vprocesada)
				$this->adderror('numocompra', 'Esta orden de compra no tiene items con entregas o conformidades');






	}

		public function chkgarita($attribute,$params){

			//EL ingreso en garita debe ser el correcto
			if(yii::app()->settings->get('documentos','documentos_controlrecepcion')=='1'){
				IF(!Docingresados::model()->findByPk($this->idgarita)->codocu==CODIGO_DOC_FACTURA)
					$this->adderror('idgarita', 'El ingreso en recepcion no esta como factura');
					}
				}

	public function chkfechas($attribute,$params){
///PRIMERO QUE LA FECHA DEL INGRESO NO PUEDE SER ANTERIOR A LA FECHA DE LA OC


		///LA FECHA DE LA FACTURA fechadoc  NO PUEDE SER MAYOR QUE LA FECHA DEL INGRESO
		if(!yii::app()->periodo->verificaFechas($this->fechadoc,$this->fecha))
			$this->adderror('fechadoc','La fecha de la factura es mayor que la fecha de ingreso');

		///LA FECHA DE LA FACTURA fechadoc  NO PUEDE SER MAYOR QUE LA FECHA DE LA ORDEN DE COMPRA

		//Sacando la fecha de la OC
		$registrocompra=Ocompra::findByNumero($this->numocompra);
		if(!yii::app()->periodo->verificaFechas($registrocompra->fechanominal,$this->fechadoc))
		$this->adderror('fechadoc','La fecha de la factura es menor que la de la Orden de compra');



		///LA FECHA DE LA FACTURA fechadoc  DEBE DE ESTAR DENTRO DEL PERIODO ACTIVO
		if(!yii::app()->periodo->estadentroperiodo($this->fechadoc))
			$this->adderror('fechadoc','La fecha de la factura no esta dentro del periodo activo');

		///LA FECHA DEl INGRESO fecha  DEBE DE ESTAR DENTRO DEL PERIODO ACTIVO
		if(!yii::app()->periodo->estadentroperiodo($this->fecha))
			$this->adderror('fechadoc','La fecha de ingreso no esta dentro del periodo activo');


		//LA FECHA DE LA FACTURA  fechadoc  DEBE DE DEBE SER MAYOR QUE LA FECHA DE LA ULTIMA ENTREGA DE MERCADERIA
		/*$criterio=New CDBCriteria;
		$criterio->addcondition("hidguia=:idcompra");
		$criterio->params=array(":idcompra"=>$registrocompra->idguia);
		$idhijos=MiFactoria::arrayColumnaSQL('{{docompra}}','id',$criterio->condition,$criterio->params);
		unset($criterio);
		$criterio=New CDBCriteria;
		$criterio->addInCondition("iddetcompra",$idhijos);
		$fila=yii::app()->db->createCommand()->
		select(min('fecha'))->from('{{alentregas}}')->where($criterio->condition,$criterio->params)->queryAll();

		if(count($fila)==0){
			$this->adderror('numocompra','Esta Orden de compra no tiene entregas');
		} else{
			if(!yii::app()->periodo->verificaFechas($fila,$this->fechadoc))
				$this->adderror('fechadoc','La factura tiene una fecha anterior a la primera entrega de mercaderia o conformidad');

		}*/



//LA DIFERENCIA DE FECHAS ENTRE EL INGRESO DE LA FACTURA fechadoc  Y LA FECHA DE LA FACTURA DEBE SER MENOR QUE  < ????
		if(yii::app()->periodo->diasentre($this->fecha,$this->fechadoc) >
		yii::app()->settings->get('documentos','documentos_tolerecepfacturaendias'))
			$this->adderror('fechadoc','La diferencia de fechas entre la factura y el ingreso paso la tolerancia en dias ('.yii::app()->settings->get("documentos","documentos_tolerecepfacturaendias").')');


	}

}
