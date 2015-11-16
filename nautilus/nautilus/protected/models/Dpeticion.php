<?php

class Dpeticion extends ModeloGeneral
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
		return '{{dpeticion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('hidpeticion, um, codart, punit, cant, comentario, codestado, codcen, codal, codocu, usuario, iduser, disponibilidad', 'required'),
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('punit, cant', 'numerical'),
			array('hidpeticion', 'length', 'max'=>20),
			array('um, codal, codocu', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>10),
			array('codestado, disponibilidad', 'length', 'max'=>2),
			array('codcen', 'length', 'max'=>4),
			array('imputacion,tipo,codservicio,item,descripcion,punit,comentario,idparent,plista,igv_monto,pventa,descuento,idstatus', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidpeticion, um, codart, punit, descripcion,cant, comentario, codestado, codcen, codal, codocu, usuario, iduser, disponibilidad', 'safe', 'on'=>'search'),
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
			'dpeticion_almacenes' => array(self::BELONGS_TO, 'Almacenes', 'codal'),
			'dpeticion_ums' => array(self::BELONGS_TO, 'Ums', 'um'),
			'dpeticion_maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'dpeticion_centros' => array(self::BELONGS_TO, 'Centros', 'codcen'),
			'dpeticion_documentos' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
			'dpeticion_estado' => array(self::BELONGS_TO, 'Estado', 'codestado'),
			'numeroreservas'=>array(self::STAT, 'Alreserva', 'hidesolpe','condition'=>"estadoreserva <> '30' and codocu='310' "),//el campo foraneo
			'numero_reservascompras'=>array(self::STAT, 'Alreserva', 'hidesolpe','condition'=>"estadoreserva <> '30' and codocu='800' "),//el campo foraneo
			'dpeticion_alinventario'=> array(self::BELONGS_TO, 'Alinventario', array('codal'=>'codalm','codcen'=>'codcen','codart'=>'codart')),
			'impuestosaplicados' => array(self::HAS_MANY, 'Impuestosaplicados', array('id'=>'hidocu','codocu'=>'codocu')),

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





	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->iduser=Yii::app()->user->id;
			//$this->codestado='10';
		} else
		{

			//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
		}
		$this->colocaimpuestositem(); ///Inserta o actualiza lois impuestos asigandos al documento
		return parent::beforeSave();
	}

	public function afterSave() {
		//$this->refresh();
		$this->colocaimpuestositem(); ///Inserta o actualiza lois impuestos asigandos al documento
		return parent::afterSave();
	}







	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dpeticion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
