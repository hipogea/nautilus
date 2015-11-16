<?php

class Peticion extends ModeloGeneral implements IColectores
{
	const  ESTADO_APROBADO='20';
	const ESTADO_ANULADO='50';
	const ESTADO_EN_COMPRA='30';
	const ESTADO_CREADO='10';
	const ESTADO_PREVIO='99';
    Const ESTADO_CERRADO='70';
	const CODIGO_DOCUMENTO='130';
	const CAMPO_DE_NUMERO='numero';  ///Es el nombre del campo que guarda el numero
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{peticion}}';
	}


	public function behaviors()
	{
		return array(
			// Classname => path to Class
			'ActiveRecordLogableBehavior'=>
				'application.behaviors.ActiveRecordLogableBehavior',
		);
	}

   public static function getClassName(){
	   return __CLASS__;
   }

	public static function getFieldLink($matriz,$nombreclasepadre,$nombreclasehija)
	{
		static $lalo=NULL;
		foreach($matriz as $key=>$value)
		{
			if (is_array($value))
			{
				self::getFieldLink($value,$nombreclasepadre,$nombreclasehija);
			}else{
				if ($nombreclasepadre::HAS_MANY==$value)
					if($matriz[1]==$nombreclasehija)
						if(!is_array($matriz[2]))
						{
							$lalo=$matriz[2];
						}

			}
		}
		//if(is_null($lalo))
			//throw new CHttpException(500,'NO se pudo encontrar campo emnlace entre los modelos padre : '.$nombreclasepadre.'  e hijo  '.$nombreclasehija.'    Revisa las  relaciones ');
		return $lalo;
	}





	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('codpro, numero, fecha, usuario, fechacreac, comentario, textocorto, idcontacto, iduser, codocu, codestado, correlativo, prefijo, codmon, descuento', 'required'),
			array('idcontacto, iduser, correlativo, prefijo', 'numerical', 'integerOnly'=>true),
			array('codpro', 'length', 'max'=>6),
			array('codpro,codproadqui', 'exist','allowEmpty'=>false,'attributeName'=>'codpro','className'=>'Clipro','message'=>'Esta empresa no existe','on'=>'insert,update'),
			array('idcontacto', 'exist','allowEmpty'=>false,'attributeName'=>'id','className'=>'Contactos','message'=>'Este contacto no existe','on'=>'update'),
			array('numero', 'length', 'max'=>12),
			array('usuario', 'length', 'max'=>25),
			array('textocorto', 'length', 'max'=>40),
			array('codocu, codmon', 'length', 'max'=>3),
			array('codestado', 'length', 'max'=>2),
			array('descuento', 'length', 'max'=>10),
			array('idtemp,id,fechacreac,orcli,fpago,codmon,socio,codproadqui,direntrega,tenorsup,tenorinf,codobjeto,validez,grupocompras,idcontacto,textocorto,comentario,fecha','safe','on'=>'insert,update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, codpro, numero, fecha, usuario, fechacreac, comentario, textocorto, idcontacto, iduser, codocu, codestado, correlativo, prefijo, codmon, descuento', 'safe', 'on'=>'search'),
		    array('codestado','safe', 'on'=>'cambiaestado'),

		);
	}

	public function estaaprobado() {
		$retorno=false;
		  if ($this->codestado==self::ESTADO_APROBADO)
			   return true;

		return $retorno;

	}



	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'peticion_contactos' => array(self::BELONGS_TO, 'Contactos', 'idcontacto'),
			'peticion_grupoventas' => array(self::BELONGS_TO, 'Grupoventas', 'grupocompras'),
			'peticion_sociedades' => array(self::BELONGS_TO, 'Sociedades', 'socio'),
			'peticion_dpeticion' => array(self::HAS_MANY, 'Dpeticion', 'hidpeticion'),
			'peticion_tempdpeticion' => array(self::HAS_MANY, 'Tempdpeticion', 'hidpeticion'),
			'peticion_clipro' => array(self::BELONGS_TO, 'Clipro', 'codpro'),
			'peticion_cliproadqui' => array(self::BELONGS_TO, 'Clipro', 'codproadqui'),
			'peticion_direcciones' => array(self::BELONGS_TO, 'Direcciones', 'direntrega'),
			'peticion_moneda' => array(self::BELONGS_TO, 'Monedas', 'codmon'),
			'peticion_documentos' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
			'peticion_tipofacturacion' => array(self::BELONGS_TO, 'Tipofacturacion', 'fpago'),
			//'peticion_mensajes' => array(self::STAT, 'Mensajes', array('hidocu','codocu')),
			'peticion_tenorsup'=>array(self::BELONGS_TO, 'Tenores', 'tenorsup'),
			'peticion_solpe'=>array(self::BELONGS_TO, 'Solpe', array('id'=>'hidref','codocu'=>'codocuref')),
			'peticion_tenorinf'=>array(self::BELONGS_TO, 'Tenores', 'tenorinf'),
			'peticion_estado' => array(self::BELONGS_TO, 'Estado', array('codestado'=>'codestado','codocu'=>'codocu')),
			//'peticion_estado' => array(self::BELONGS_TO, 'Estado', 'codestado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codpro' => 'Codpro',
			'numero' => 'Numero',
			'fecha' => 'Fecha',
			'usuario' => 'Usuario',
			'fechacreac' => 'Fechacreac',
			'comentario' => 'Comentario',
			'textocorto' => 'Textocorto',
			'idcontacto' => 'Idcontacto',
			'iduser' => 'Iduser',
			'codocu' => 'Codocu',
			'codestado' => 'Codestado',
			'correlativo' => 'Correlativo',
			'prefijo' => 'Prefijo',
			'codmon' => 'Codmon',
			'descuento' => 'Descuento',
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
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('fechacreac',$this->fechacreac,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('textocorto',$this->textocorto,true);
		$criteria->compare('idcontacto',$this->idcontacto);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('correlativo',$this->correlativo);
		$criteria->compare('prefijo',$this->prefijo);
		$criteria->compare('codmon',$this->codmon,true);
		$criteria->compare('descuento',$this->descuento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


public $maximovalor;

	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->iduser=Yii::app()->user->id;
			$this->fechacreac=date("Y-m-d H:i:s");
			//$gg=new Numeromaximo;

			//$this->codocu=self::DOCUMENTO;
			//$this->codestado=self::ESTADO_PREVIO;

			$this->numero=$this->correlativo(self::CAMPO_DE_NUMERO,null,self::CODIGO_DOCUMENTO,null);
		} else
		{

			//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
		}

		return parent::beforeSave();
	}














	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Peticion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



    public  function esvalidocolector($imputacion){
        //Primero evaluamos los estados
        $mensaje="";
        $array_puede_recibir_costes=ARRAY(self::ESTADO_APROBADO,
                                        self::ESTADO_EN_COMPRA,
                                        self::ESTADO_CERRADO
                                        );
        $registro=self::model()->find("numero=:vnumero",array(":vnumero"=>$imputacion));
//VAR_DUMP($array_puede_recibir_costes);yii::app()->end();
        if (!in_array($registro->codestado, $array_puede_recibir_costes)){
            $mensaje.=" El estado de este colector (".$registro->codestado.") no permite imputar, verifique el estado del documento <br>";
                    }


        return $mensaje;

    }
}
