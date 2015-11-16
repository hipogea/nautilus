<?php

class Clipro extends ModeloGeneral
{



	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Clipro the static model class
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
		return '{{clipro}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('codpro', 'required'),
			// array('codpro', 'length', 'max'=>6),
			array('codpro,despro,codestado, codocu, direcciontemp,nombrecomercial,telpro, rucpro,socio', 'safe', 'on'=>'insert,update'),
			array('despro,rucpro,socio', 'safe', 'on'=>'BATCH_INS,BATCH_UPD'),
			array('despro', 'required', 'message'=>'Coloca el nombre del cliente','on'=>'BATCH_INS,BATCH_UPD,insert,update'),
			array('direcciontemp', 'required', 'message'=>'Coloca la direccion','on'=>'insert'),
			array('nombrecomercial', 'required', 'message'=>'Coloca la el nombre comercial','on'=>'insert,update'),
			array('despro', 'length', 'min'=>5 ,'message'=>'El nombre es demasiado corto','on'=>'BATCH_INS,BATCH_UPD,insert,update'),
			array('direcciontemp', 'length', 'min'=>5 ,'message'=>'La direccion temporal es demasiada corta','on'=>'insert,update'),
			array('despro', 'length', 'max'=>50 ,'message'=>'El nombre es demasiado largo','on'=>'BATCH_INS,BATCH_UPD,insert,update'),

			array('rucpro',  'match', 'pattern'=> '/[0-9]{11}/', 'message'=>'Es un valor incorrecto de RUC','on'=>'BATCH_INS,BATCH_UPD,insert,update'),
			array('rucpro', 'required', 'message'=>'Llena el RUC','on'=>'BATCH_INS,BATCH_UPD,insert,update'),
			// array('socio', 'required', 'message'=>'Debes de indicar'),
			array('rucpro', 'unique', 'attributeName'=> 'rucpro', 'caseSensitive' => 'false','message'=>'Este RUC ya ha sido registrado','on'=>'BATCH_INS,BATCH_UPD,insert,update'),
			array('telpro', 'mivalidacion','on'=>'insert,update'),
			//array('emailpro', 'email','required','message'=>'Debes de llenar el correo'),
			//array('emailpro', 'email','message'=>'Correo electronico invalido'),
			array('tipo', 'length', 'max'=>1,'on'=>'insert,update'),

			//array('creadopor, modificadopor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codpro, despro, rucpro,socio', 'safe', 'on'=>'search'),
		);
	}



	public function mivalidacion ($attribute,$params) {
		if ( $this->telpro == "12345" ) {
			$this->adderror('telpro','Es una serie');
		}

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'contactoses' => array(self::HAS_MANY, 'Contactos', 'c_hcod'),
			'direcciones' => array(self::HAS_MANY, 'Direcciones', 'c_hcod'),
			'objetos' => array(self::HAS_MANY, 'Objetos', 'codpro'),
			'nobjetos' => array(self::STAT, 'ObjetosCliente', 'codpro'),
			'ndirecciones' => array(self::HAS_MANY, 'Direcciones', 'c_hcod'),
			'guias' => array(self::HAS_MANY, 'Guia', 'c_codtra'),
			'autorizacionPersonals' => array(self::HAS_MANY, 'AutorizacionPersonal', 'codpro'),
			'personalExternos' => array(self::HAS_MANY, 'PersonalExterno', 'codpro'),
		);
	}




	public $maximovalor;
	public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones
	public function beforeSave() {
		if ($this->isNewRecord) {

			$this->creadopor=Yii::app()->user->name;
			// $this->creadoel=Yii::app()->user->name;
			$this->prefijo='97';
			$this->codocu='360';
			$this->codestado='10'; //creado
			$gg=new Numeromaximo;
			$this->codpro=$gg->numero($this,'correlativo','maximovalor',4,'prefijo');
			//  $this->codpro='97'.Numeromaximo::numero($this,'correlativo','maximovalor',4);
			// $this->codpro='97'.Numeromaximo::numero($this->model(),'codpro','maximovalor',4);
			//$this->cod_estado='01';
			//$this->c_salida='1';
		} else
		{

			//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
		}
		return parent::beforeSave();
	}





	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codpro' => 'Codigo',
			'despro' => 'Nombre',
			'rucpro' => 'R.U.C.',
			'socio'=>'Es socio',
			'telpro' => 'Telefono',
			'emailpro' => 'E-mail',
			'tipo' => 'Tipo',
			'creadopor' => 'Creadopor',
			'modificadopor' => 'Modificadopor',
			'creadoel' => 'Creadoel',
			'modificadoel' => 'Modificadoel',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('rucpro',$this->rucpro,true);
		$criteria->compare('telpro',$this->telpro,true);
		$criteria->compare('emailpro',$this->emailpro,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('direcciontemp',$this->direcciontemp,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('rucpro',$this->rucpro,true);
		$criteria->compare('telpro',$this->telpro,true);
		$criteria->compare('emailpro',$this->emailpro,true);
		$criteria->compare('tipo',$this->tipo,true);

		/*return new CActiveDataProvider($this, array(
             'criteria'=>$criteria,
          ));*/


		return new  CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 1000,
			),
		));





	}
}

