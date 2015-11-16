<?php
CONST ESTADO_DESOLPECOMPRA_NUEVO='10'; //eL ESTADO DEL REGISTRO DESOLPECOMPRA
CONST ESTADO_DESOLPE_ANULADO='40'; //eL ESTADO DEL REGISTRO DESOLPECOMPRA

class Docompra extends ModeloGeneral
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dcotmateriales the static model class
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
		return Yii::app()->params['prefijo'].'docompra';
	}

	public function init() {

		$this->campoprecio='punit';
		$this->isdocParent=false;
		$this->documento='220';
	}



	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cant, punit,  descri, tipoitem, tipoimputacion, um', 'required'),
			array('cant, punit, stock', 'numerical'),
			//array('numcot', 'length', 'max'=>7),
			array('codart', 'length', 'max'=>8),
			array('disp, estadodetalle', 'length', 'max'=>2),
			array('item, coddocu, um', 'length', 'max'=>3),
			array('descri', 'length', 'max'=>40),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('tipoitem', 'length', 'max'=>1),
			array('codservicio', 'length', 'max'=>6),
			array('detalle,iddesolpe,cant,codentro,codigoalma,punit,codart,descri,um, hidguia,tipoimputacion,orden', 'safe'),
			array('cant,punit,punitdes', 'safe'),


			/****************ESCENARIO INGRESO COMPRA*******
            /*********************************************/
              array('cant', 'safe','on'=>'ingresacompra'),

            /****************ESCENARIO CAMBIO DE ESTADO ANULACION *******
            /*********************************************/
            array('estadodetalle', 'safe','on'=>'anulaitemcompra'),

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
			'disp0' => array(self::BELONGS_TO, 'Disponiblidad', 'disp'),
             'docompra_ums'=>array(self::BELONGS_TO, 'Ums', 'um'),
			'ocompra'=>array(self::BELONGS_TO, 'Ocompra', 'hidguia'),
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
			'docompra_ocompra'=>array(self::BELONGS_TO,'Ocompra','hidguia'),
			//'subtotal'=>array(self::STAT, 'Docompra', 'hidguia','select'=>'sum(t.punit*t.cant)'),//el subtotal
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			//'numcot' => 'Numcot',
			'codart' => 'Codigo',
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
			'tipoitem' => 'Tipo item',
			'estadodetalle' => 'Estado',
			'coddocu' => 'Coddocu',
			'um' => 'Um',
			'hidguia' => 'Hidguia',
			'codservicio' => 'Codservicio',
			'codentro'=>'Centro',
			'codigoalma'=>'Almacen',
		);
	}

	public function behaviors()
	{
		return array(
			// Classname => path to Class
			'ActiveRecordLogableBehavior'=>
				'application.behaviors.ActiveRecordLogableBehavior',
		);
	}



	public function colocapuentesolpe(){

	if($this->iddesolpe > 0 )	 {
	//Siempre y cuando sea una compra conectada  a la solpe
		//y ademas se haya modificado  la cantidad
		//$umoriginal=Desolpe::model()->findByPk($this->iddesolpe)->um;

		///que pasa si lo estan compradno en um diferente, prevalece la UM de la SOLPE
    $umoriginal=Desolpe::model()->findByPk($this->iddesolpe)->um;
    if($umoriginal<> $this->um){
		$cantidad=Alconversiones::convierte($this->codart,$this->um,$umoriginal);
	} else {
		$cantidad=$this->cant;
	}
		$criterio=New CDbcriteria;
		$criterio->addcondition("iddocompra=:vidocompra");
		$criterio->params=array(":vidocompra"=>$this->id);
		$modelino=Desolpecompra::model()->find($criterio);
		if(is_null($modelino)){
			IF(!in_array($this->estadodetalle,array(ESTADO_DESOLPE_ANULADO))){
				$modelino=New Desolpecompra();
				$modelino->setScenario('insert');
				$modelino->setAttributes(array('iduser'=>yii::app()->user->id,'codestado'=>ESTADO_DESOLPECOMPRA_NUEVO,'iddocompra'=>$this->id,'iddesolpe'=>$this->iddesolpe,'cant'=>$cantidad,'fecha'=>date("Y-m-d H:i:s")),true);
				$modelino->save();
			}

		}else{
			IF(in_array($this->estadodetalle,array(ESTADO_DESOLPE_ANULADO))){
				$modelino->delete();
			}else{
				if(($this->oldVal('cant')<>$this->cant)  or($this->oldVal('um')<>$this->um) ) {
					$modelino->setScenario('update');
					$modelino->setAttributes(array('iduser'=>yii::app()->user->id,'cant'=>$cantidad,'fecha'=>date("Y-m-d H:i:s")),true);
					$modelino->save();
				}
			}


			}

	}


	}


			public function beforeSave() {
							if ($this->isNewRecord) {									
									//$this->estadodetalle='99';
									//$this->coddocu='022';
                                   // $this->punitdes=$this->punit*($this->docompra_ocompra->descuento);
									
													}

				//$this->colocaimpuestositem();
				return parent::beforeSave();
											}


	public function afterSave() {


		$this->colocapuentesolpe();  ///actualiza la tabla puente de la SOLPE
		$this->colocaimpuestositem();
		return parent::afterSave();
	}

	public function valorespordefecto(){ 
						//Vamos a cargar los valores por defecto
						$matriz=VwOpcionesdocumentos::Model()->search_d('220')->getData();
						//recorreindo la matriz
						
						 $i=0;
					
							 for ($i=0; $i <= count($matriz)-1;$i++) {								
											     if ($matriz[$i]['tipodato']=="N" ) {
												$this->{$matriz[$i]['campo']}=!empty($matriz[$i]['valor'])?$matriz[$i]['valor']+0:'';
											     }ELSE {
												 $this->{$matriz[$i]['campo']}=!empty($matriz[$i]['valor'])?$matriz[$i]['valor']:'';
											   
											     }
												
												}		
					return 1;						
											
											
										
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

		$criteria->compare('id',$this->id,true);
		//$criteria->compare('numcot',$this->numcot,true);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public function search_($idcoti)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		//$criteria->compare('numcot',$this->numcot,true);
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
		$criteria->addcondition("hidguia=".$idcoti);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_compra($idcabeza)
	{
		$idcabeza=(integer)$idcabeza;
		$criteria=new CDbCriteria;


		if(!isset($idcabeza) or is_null($idcabeza))
			$idcabeza=0;

		$criteria->addcondition("hidguia=".$idcabeza);
		//$criteria->addcondition("iduser=".Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



}