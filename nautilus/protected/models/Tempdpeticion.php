<?php


class Tempdpeticion extends ModeloGeneral
{
	const ESTADO_CREADO='10';
	const ESTADO_PREVIO='99';



	public function init() {

		$this->campoprecio='plista';
		$this->isdocParent=false;
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tempdpeticion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('um,cant,codcen,codservicio,disponibilidad,descripcion,imputacion',
				'required','message'=>'Este dato es obligatorio', 'on'=>'servicio'),

			array('um,cant,codcen,codal,codart,disponibilidad,descripcion,tipo,imputacion',
				'required','message'=>'Este dato es obligatorio', 'on'=>'insert,update'),
			array('codal,codcen','checkcentroalmacen', 'on'=>'insert,update'),
			array('um','checkum'),


			//	array('id, idusertemp, hidpeticion, um, codart, punit, cant, comentario, codestado, codcen, codal, codocu, usuario, iduser, disponibilidad', 'required'),
			array('idusertemp, iduser', 'numerical', 'integerOnly'=>true),
			array('punit, cant', 'numerical'),
			array('id, hidpeticion', 'length', 'max'=>20),
			array('um, codal, codocu', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>10),
			array('codestado, disponibilidad', 'length', 'max'=>2),
			array('codcen', 'length', 'max'=>4),

			array('imputacion,tipo,item,descripcion,punit,idparent,comentario,plista,igv_monto,pventa,descuento,idstatus', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idusertemp,descripcion, hidpeticion, um, codart, punit, cant, comentario, codestado, codcen, codal, codocu, usuario, iduser, disponibilidad', 'safe', 'on'=>'search'),
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
			'tempdpeticion_almacenes' => array(self::BELONGS_TO, 'Almacenes', 'codal'),
			'tempdpeticion_alinventario' => array(self::BELONGS_TO, 'Alinventario',array('codart'=>'codart','codal'=>'codalm', 'codcen'=>'codcen')),
			'tempdpeticion_ums' => array(self::BELONGS_TO, 'Ums', 'um'),
			//'tempdpeticion_cc' => array(self::BELONGS_TO, 'Cc', 'Imputacion'),
			'cecos'=>array(self::BELONGS_TO, 'Cc', 'imputacion'),
			'tempdpeticion_maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'servicios' => array(self::BELONGS_TO, 'Maestroservicios', 'codservicio'),
			'tempdpeticion_centros' => array(self::BELONGS_TO, 'Centros', 'codcen'),
			'tempdpeticion_documentos' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
			'tempdpeticion_estado' => array(self::BELONGS_TO, 'Estado', 'codestado'),
			'tempdpeticion_peticion' => array(self::BELONGS_TO, 'Peticion', 'hidpeticion'),
			'impuestosaplicados' => array(self::HAS_MANY, 'Impuestosaplicados', array('id'=>'hidocu','codocu'=>'codocu')),

		);
	}


	public function checkcentroalmacen($attribute,$params) {
		if(!MiFactoria::Validacentro($this->codcen,$this->codal))
			$this->adderror('codal',' No existe esta combinacion Centro Almacen');
	}

	public function checkum($attribute,$params) {
		if(!Alconversiones::validaum($this->codart,$this->um))
			$this->adderror('um',' Esta unidad de medida no corresponde a este material');
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idusertemp' => 'Idusertemp',
			'hidpeticion' => 'Hidpeticion',
			'um' => 'Um',
			'codart' => 'Codart',
			'punit' => 'Punit',
			'cant' => 'Cant',
			'comentario' => 'Comentario',
			'codestado' => 'Codestado',
			'codcen' => 'Codcen',
			'codal' => 'Codal',
			'codocu' => 'Codocu',
			'usuario' => 'Usuario',
			'iduser' => 'Iduser',
			'disponibilidad' => 'Disponibilidad',
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
		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('hidpeticion',$this->hidpeticion,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codocu',$this->codocu,true);

		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('disponibilidad',$this->disponibilidad,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_peticion($idcabeza)
	{
		$criteria=new CDbCriteria;


		if(!isset($idcabeza) or is_null($idcabeza))
			$idcabeza=0;

		$criteria->addcondition("hidpeticion=".$idcabeza);
		$criteria->addcondition("idusertemp=".Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

public function getdescuento()
{
	$valordesc=$this->tempdpeticion_peticion->descuento;
	$valordesc=(is_null($valordesc))?0:$valordesc;
	return $this->plista*$valordesc;
}

	public function getpreciostock()
	{
		return Alinventario::preciostock($this->codcen,$this->codal,$this->codart,$this->um) ;
	}


	public function beforeSave() {
		if ($this->isNewRecord) {
					$this->idusertemp=Yii::app()->user->id;

			$this->codestado=empty($this->codestado)?self::ESTADO_PREVIO:$this->codestado;

            } else
		{

			//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
		}
		///$this->colocaimpuestositem(); //aqui no esto debe de hacerlo el modelo original no el tempral
		$this->descuento=$this->getdescuento(); //el descuento
		$this->punit=$this->getpreciostock();//el valor del stock
		return parent::beforeSave();
	}




	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tempdpeticion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
