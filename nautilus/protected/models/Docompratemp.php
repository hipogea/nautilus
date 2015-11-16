<?php
CONST ESTADO_PREVIO='99';
const DOCUMENTO='220';
class Docompratemp extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{docompratemp}}';
	}

	/*Importa un regisro de detalle solpe
	para trarareloe n la orden de compra*/
	public function importadesolpe($iddesolpe,$idcompra){
		$modelore=Desolpe::model()->findByPk($iddesolpe);
		if(!is_null($modelore)){
			$this->setAttributes(
				array(
					'hidguia'=>$idcompra,
					'codart'=>$modelore->codart,
					'cant'=>$modelore->cant,
					'um'=>$modelore->um,
					'descri'=>$modelore->txtmaterial,
					'iddesolpe'=>$modelore->id, //muy importante
					'cant'=>$modelore->cant,
					'tipoimputacion'=>$modelore->tipimputacion,//importante
					'ceco'=>$modelore->imputacion,//importante
					'codentro'=>$modelore->centro,//importante
					'codigoalma'=>$modelore->codal,//importante
					'tipoitem'=>$modelore->tipsolpe,
					'idusertemp'=>yii::app()->user->id,
					'coddocu'=>'220',
					'punit'=>0,
					'punitdes'=>0,
					'disp'=>'12',
					'stock'=>0,
					'estadodetalle'=>'10',

				),true
			);
			$this->setScenario('ingresodesolpe');
			return($this->save());

		}else{
			return false;
		}

	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('hidguia,codart,idusertemp,tipoimputacion,ceco,coddocu,punit,punitdes,disp,stock,estado detalle,iddesolpe,codentro,codigoalma,descri,tipoitem,cant,um','safe','on'=> 'ingresodesolpe'),
			array('cant','verificaconsistencia','on'=>'ingresodesolpe'),







			array('estadodetalle', 'safe','on'=>'cambiaestado'),


			array('codart,  cant, punit, item, descri, tipoitem, estadodetalle, coddocu, um', 'required','on'=>'insert,update'),
			array('iduser, idusertemp, idstatus, id', 'numerical', 'integerOnly'=>true),
			array('cant, punit, stock, punitdes', 'numerical'),
			array('creadoel, modificadoel, hidguia, iddesolpe', 'length', 'max'=>20),
			array('codart', 'length', 'max'=>8),
			array('disp, estadodetalle', 'length', 'max'=>2),
			array('item, coddocu, um, codigoalma', 'length', 'max'=>3),
			array('descri', 'length', 'max'=>40),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('tipoitem, tipoimputacion', 'length', 'max'=>1),
			array('codservicio', 'length', 'max'=>6),
			array('ceco, orden', 'length', 'max'=>12),
			array('codentro', 'length', 'max'=>4),
			array('punit,cant, punitdes', 'safe','on'=>'descuento'),
			array('detalle,iddesolpe,cant,codentro,codigoalma,punit,codart,descri,um, hidguia,tipoimputacion,orden', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codart, disp, cant, punit, item, descri, creadopor, creadoel, modificadopor, modificadoel, stock, detalle, tipoitem, estadodetalle, coddocu, um, hidguia, codservicio, tipoimputacion, ceco, orden, codentro, codigoalma, punitdes, iddesolpe, iduser, idusertemp, idstatus, id', 'safe', 'on'=>'search'),
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
			//'disp0' => array(self::BELONGS_TO, 'Disponiblidad', 'disp'),
			'ums'=>array(self::BELONGS_TO, 'Ums', 'um'),
			'codservicio0' => array(self::BELONGS_TO, 'TServicios', 'codservicio'),
			'dcotmaterialesDs' => array(self::HAS_MANY, 'DcotmaterialesD', 'hid'),
			'materiales' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			//'numeroentregas'=>array(self::STAT, 'Alentregas', 'iddetcompra'),//el campo foraneo
			//'numerosolpes'=>array(self::STAT, 'Desolpecompra', 'iddocompra',),//el campo foraneo
			//'cantsolpes'=>array(self::STAT, 'Desolpecompra', 'iddocompra','select'=>'sum(t.cant)'),//el campo foraneo
			//'cantidadentregada'=>array(self::STAT, 'Alentregas', 'iddetcompra','select'=>'sum(t.cant)','condition'=>"estado <> '30' "),//el subtotal
			//'cantidadfacturada'=>array(self::STAT, 'Dfacrecibida', 'hiddocompra','select'=>'sum(t.cant)','condition'=>"estado <> '30' "),//el subtotal
			'numeroentregas'=>array(self::STAT, 'Alentregas', 'iddetcompra','condition'=>"estadoentrega <> '30' "),//el campo foraneo
			'cantidadentregada'=>array(self::STAT, 'Alentregas', 'iddetcompra','select'=>'sum(t.cant)'),//el subtotal
			'numerosolpes'=>array(self::STAT, 'Desolpecompra', 'iddocompra','condition'=>"codestado <> '30'"),//el campo foraneo
			'cantsolpes'=>array(self::STAT, 'Desolpecompra', 'iddocompra','select'=>'sum(t.cant)','condition'=>"codestado <> '30'"),//el campo foraneo
			'puentesolpe'=>array(self::HAS_MANY, 'Desolpecompra', 'iddocompra'),
			//'numeroreservas'=>array(self::STAT, 'Alreserva', 'hidesolpe','condition'=>"estadoreserva <> '30' "),//el campo foraneo
			'docompra_alentregas'=>array(self::HAS_MANY, 'Alentregas', 'id'),
			'docompra_estado'=>array(self::BELONGS_TO,'Estado',array('estadodetalle'=>'codestado','coddocu'=>'codocu')),
			'docompra_alinventario'=>array(self::BELONGS_TO,'Alinventario',array('codigoalma'=>'codalm','codentro'=>'codcen','codart'=>'codart')),
			'ocompra'=>array(self::BELONGS_TO,'Ocompra','hidguia'),
			//'subtotal'=>array(self::STAT, 'Docompra', 'hidguia','select'=>'sum(t.punit*t.cant)'),//el subtotal
		);

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idtemp' => 'Idtemp',
			'codart' => 'Codart',
			'disp' => 'Disp',
			'cant' => 'Cant',
			'punit' => 'Punit',
			'item' => 'Item',
			'descri' => 'Descri',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'stock' => 'Stock',
			'detalle' => 'Detalle',
			'tipoitem' => 'Tipoitem',
			'estadodetalle' => 'Estadodetalle',
			'coddocu' => 'Coddocu',
			'um' => 'Um',
			'hidguia' => 'Hidguia',
			'codservicio' => 'Codservicio',
			'tipoimputacion' => 'Tipoimputacion',
			'ceco' => 'Ceco',
			'orden' => 'Orden',
			'codentro' => 'Codentro',
			'codigoalma' => 'Codigoalma',
			'punitdes' => 'Punitdes',
			'iddesolpe' => 'Iddesolpe',
			'iduser' => 'Iduser',
			'idusertemp' => 'Idusertemp',
			'idstatus' => 'Idstatus',
			'id' => 'ID',
		);
	}


	public function verificaconsistencia($attribute,$params) {
		//Verificar si esta iddesolpe, ya se pido anteriormente en el mismo documento
		if($this->isNewRecord and count(self::model()->find('iddesolpe=:viddesolpe ',array(':viddesolpe'=>$this->iddesolpe)))>0)
			$this->adderror('cant','Esta solicitud ya esta registrada en este documento, verifique ');
		///verificar la consistencia de la cantidad
		$registrosolpe=Desolpe::model()->findByPk($this->iddesolpe);
		     if(!is_null($registrosolpe)){
				$cantidadefectivaNew=$this->cant*Alconversiones::convierte($this->codart,$this->um,$registrosolpe->um);
				 $cantidadefectivaOLD=$this->oldVal('cant')*Alconversiones::convierte($this->codart,$this->um,$registrosolpe->um);
				  $cantidadefectiva=$cantidadefectivaNew- $cantidadefectivaOLD;

				 $hayerror=true;
				 if($this->id > 0 ){ //Si es un registro que ya ha sido confirmado
					 $hayerror=($registrosolpe->cuantofaltacomprar() < $cantidadefectiva)?true:false;
				 }else{ //Si es nuevo , solo verifica que si se agrega la cantidad excede
					 $hayerror=($registrosolpe->cuantofaltacomprar() < $cantidadefectivaNew)?true:false;
				 }

				     if( $hayerror ){
					  //obteniendo las referencias de los pedidos de compra que lo han tomado anteriormente
					  $registros=Desolpecompra::model()->findAll("iddesolpe=:viddesolpe",array(":viddesolpe"=>$this->iddesolpe));
					    $mensaje=" ";
					  foreach($registros as $fila){
							$mensaje.=" Pedido de compra : ".$fila->docompra->ocompra->numcot." Item : ".$fila->docompra->item." <br>";
						}
					  $this->adderror('cant','cant efectiva :'.$cantidadefectiva.' ,  cuanto falta :  '.$registrosolpe->cuantofaltacomprar().' ,     Usted esta comprando mas de lo que han solicitado, este item de solicitud ya se trato con  '.$mensaje);
				  }

			 }

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

		$criteria->compare('idtemp',$this->idtemp,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('disp',$this->disp,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('tipoitem',$this->tipoitem,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('hidguia',$this->hidguia,true);
		$criteria->compare('codservicio',$this->codservicio,true);
		$criteria->compare('tipoimputacion',$this->tipoimputacion,true);
		$criteria->compare('ceco',$this->ceco,true);
		$criteria->compare('orden',$this->orden,true);
		$criteria->compare('codentro',$this->codentro,true);
		$criteria->compare('codigoalma',$this->codigoalma,true);
		$criteria->compare('punitdes',$this->punitdes);
		$criteria->compare('iddesolpe',$this->iddesolpe,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('idstatus',$this->idstatus);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_compra($idcabeza)
	{
		$criteria=new CDbCriteria;
		$idcabeza=(integer)$idcabeza;

		if(!isset($idcabeza) or is_null($idcabeza))
			$idcabeza=0;

		$criteria->addcondition("hidguia=".$idcabeza);
		$criteria->addcondition("idusertemp=".Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getTotal($provider)
	{
		$totalbruto=0;
		$totaldescuento=0;
		$total=0;
		foreach($provider->data as $data)
		{
			$totalbruto+=$data->cant*$data->punit;
			$totaldescuento+=$data->cant*($data->punit-$data->punitdes);
			$total+=$data->cant*$data->punitdes;
		}
		return array('bruto'=>$totalbruto,'descuento'=>$totaldescuento,'total'=>$total);
	}


	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->idusertemp=Yii::app()->user->id;
			$this->item=str_pad($this->ocompra->itemmaximo+1,3,"0",STR_PAD_LEFT);

			//$this->hidguia=$this->ocompra->idguia;
				//$this->ocompra->itemmaximo;
			if(is_null($this->coddocu))
				$this->coddocu=DOCUMENTO;

			$this->estadodetalle=empty($this->estadodetalle)?ESTADO_PREVIO:$this->estadodetalle;

		} else
		{

			//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
		}
		///$this->colocaimpuestositem(); //aqui no esto debe de hacerlo el modelo original no el tempral

		return parent::beforeSave();
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Docompratemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
