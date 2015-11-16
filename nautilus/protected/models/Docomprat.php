<?php

/**
 * This is the model class for table "docompra_t".
 *
 * The followings are the available columns in table 'docompra_t':
 * @property integer $id
 * @property string $codart
 * @property string $disp
 * @property double $cant
 * @property double $punit
 * @property string $item
 * @property string $descri
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property double $stock
 * @property string $detalle
 * @property string $tipoitem
 * @property string $estadodetalle
 * @property string $coddocu
 * @property string $um
 * @property string $hidguia
 * @property string $codservicio
 * @property string $tipoimputacion
 * @property string $ceco
 * @property string $orden
 * @property string $codentro
 * @property string $codigoalma
 *
 * The followings are the available model relations:
 * @property Alinventario $codigoalma0
 * @property Alinventario $codentro0
 * @property Estado $estadodetalle0
 * @property Estado $coddocu0
 * @property Alinventario $codart0
 */
class Docomprat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Docomprat the static model class
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
		return Yii::app()->params['prefijo'].'docompra_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('codart, disp, cant, punit, item, descri, tipoitem, estadodetalle, coddocu, um', 'required'),
			array('cant','required','message'=>'Llene la cantidad','on'=>'search,update,insert,puentesolpe'),
			array('cant','numerical','message'=>'Solo valores numericos','on'=>'search,update,insert,puentesolpe'),
            array('cant','checkcantidad','on'=>'puentesolpe' ),
			array('punit','required','message'=>'Llene el precio Unitario','on'=>'search,update,insert,puentesolpe'),
			array('codentro','numerical','message'=>'Ingrese el centro','on'=>'search,update,insert,puentesolpe'),
			array('codigoalma','required','message'=>'Ingrese el almacen','on'=>'search,update,insert,puentesolpe'),
			array('punit','numerical','message'=>'Solo valores numericos','on'=>'search,update,insert,puentesolpe'),
			array('tipoitem','required','message'=>'Indique el tipo','on'=>'search,update,insert,puentesolpe'),
			array('tipoimputacion','required','message'=>'Indique la imputacion','on'=>'search,update,insert,puentesolpe'),
			array('cant, punit, stock', 'numerical','on'=>'search,update,insert,puentesolpe'),
			array('codart', 'length', 'max'=>8,'on'=>'search,update,insert,puentesolpe'),
			array('disp, estadodetalle', 'length', 'max'=>2,'on'=>'search,update,insert,puentesolpe'),
			array('item, coddocu, um, codigoalma', 'length', 'max'=>3,'on'=>'search,update,insert,puentesolpe'),
			array('descri', 'length', 'max'=>40,'on'=>'search,update,insert,puentesolpe'),
			array('creadopor, modificadopor', 'length', 'max'=>25,'on'=>'search,update,insert,puentesolpe'),
			array('creadoel, modificadoel', 'length', 'max'=>20,'on'=>'search,update,insert,puentesolpe'),
			array('tipoitem, tipoimputacion', 'length', 'max'=>1,'on'=>'search,update,insert,puentesolpe'),
			array('codservicio', 'length', 'max'=>6,'on'=>'search,update,insert,puentesolpe'),
			array('ceco, orden', 'length', 'max'=>12,'on'=>'search,update,insert,puentesolpe'),
			array('codentro', 'length', 'max'=>4,'on'=>'search,update,insert,puentesolpe'),
			array('detalle,iddesolpe, hidguia,iddocompra', 'safe','on'=>'search,update,insert,puentesolpe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codart,iddocompra, disp, cant, punit, item, iddesolpe, descri,punitdes, creadopor, creadoel, modificadopor, modificadoel, stock, detalle, tipoitem, estadodetalle, coddocu, um, hidguia, codservicio, tipoimputacion, ceco, orden, codentro, codigoalma', 'safe', 'on'=>'search,update,insert'),
		
		//escenariopara clonar solpes 
		     array('hidguia,iddocompra,tipoimputacion,centro,codigoalma,disp,estadodetalle,descri,detalle,ceco,um,tipoitem,cant,codart','safe','on'=>'clonasolpe'),

         //escenario  para agregar item RELACIONADO A SOLPE  VALIDA PUENTE SOLPE
            array('hidguia,iddocompra,tipoimputacion,centro,codigoalma,disp,estadodetalle,descri,detalle,ceco,um,tipoitem,cant,codart','safe','on'=>'puentesolpe'),

           // array('hidguia,iddocompra,tipoimputacion,centro,codigoalma,disp,estadodetalle,descri,detalle,ceco,um,tipoitem,cant,codart','safe','on'=>'clonasolpe'),



        );
	}



    public function checkcantidad($attribute,$params) {
       //verificando en este escenario las cantidades y la solpes

        ///veriifcar primero si esta
       $detallecompra=Docompra::Model()->findByPk($this->iddocompra);
        $detallesolpe=Desolpe::Model()->findByPk($this->iddesolpe);
        $cantidadcomprada=$detallesolpe->cantcompras;
        $cantidadsolicitada=$detallesolpe->cant;
        $diferencia=$cantidadsolicitada-$cantidadcomprada;
         if($diferencia > 0) { //Tiene sentido comprar , porque falta

           //  $this->adderror('cant','Ya no puede comprar mas , la Solicitud '.$detallesolpe->desolpe_solpe->numero.' - '.$detallesolpe->item.'  Ya se ha tomado  ');

         } else {  //ya no tiene sentido comprar ,o la solpe esta completa o ya se excedio
             $this->adderror('cant','Ya no puede comprar mas , la Solicitud '.$detallesolpe->desolpe_solpe->numero.' - '.$detallesolpe->item.'  Ya se ha tomado  ');
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
			'disp0' => array(self::BELONGS_TO, 'Disponiblidad', 'disp'),
			'codservicio0' => array(self::BELONGS_TO, 'TServicios', 'codservicio'),
			'dcotmaterialesDs' => array(self::HAS_MANY, 'DcotmaterialesD', 'hid'),
			'materiales' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'numeroentregas'=>array(self::STAT, 'Alentregas', 'iddetcompra','condition'=>"estadoentrega <> '30' "),//el campo foraneo
			'cantidadentregada'=>array(self::STAT, 'Alentregas', 'iddetcompra','select'=>'sum(t.cant)','condition'=>"estadoentrega <> '30' "),//el subtotal
			'numerosolpes'=>array(self::STAT, 'Desolpecompra', 'iddocompra','condition'=>"codestado <> '30'"),//el campo foraneo
			'cantsolpes'=>array(self::STAT, 'Desolpecompra', 'iddocompra','select'=>'sum(t.cant)','condition'=>"codestado <> '30'"),//el campo foraneo



			'docompra_alentregas'=>array(self::HAS_MANY, 'Alentregas', 'id'),
			'docompra_almacenes'=>array(self::BELONGS_TO,'Almacenes',array('codigoalma'=>'codalm','codentro'=>'codcen')),
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
		);
	}

		
	public function checkvalores($attribute,$params) {

					$modelomaterial=Maestrocompo::model()->find("codigo=:codigox",array(":codigox"=>TRIM($this->codart)));
											
						/*******************************************
						+		Debe de exigir el tipo de solpe 
						+		la combinacion de valores del tipo de solpe-material
						***********************************************/
										if ($this->tipoitem=='M')		{
											if ($this->codart=='10000000')
												 $this->adderror('codart','Este es un servicio, usted esta solicitando un material' );


											if (is_null($modelomaterial)) {
												 $this->adderror('codart','Este material no existe' );
												} else {

													if($this->docompra_alinventario===null)
														$this->adderror('codart','Este material tiene que ser ampliado al centro '.$this->centro.' y almacen '.$this->codal.' ' );
												}
											
										}	else { //Si es un servicio
											if (is_null($modelomaterial)) {
												      if (!empty($this->codart)) {
														 $this->adderror('codart','Este material no existe' );	
														    }else {
														    	// $this->adderror('codart','Este material no existe' );	
														    }
															
													}else {
															if ($this->codart <> '10000000' )
												 			$this->adderror('tipoitem','Este es un servicio, usted esta solicitando un material' );


													}
									
													} 

						}

		public function checkcanti($attribute,$params) {
		
					
						}


						
public function checkal($attribute,$params) {
						if($this->docompra_almacenes->codcen <> $this->codentro)										
											  	 $this->adderror('codal','No se permite un almacen que no este en el centro' );
											}



public function checkvalores1($attribute,$params) {					
						/*******************************************
						+		Debe de exigir el tipo de solpe 
						+		la combinacion de valores del tipo de timputacion-imputacion
						***********************************************/
										if ($this->tipoimputacion=='K')		{ //ESTA IMPOUTADA A UN CECO
											$modeloceco=Cc::model()->find("codc=:codigo",array(":codigo"=>trim($this->tipoimputacion)));
											if (is_null($modeloceco))
												 $this->adderror('tipoimputacion','Este ceco no existe' );

										}	else { // SI ES LIBRE 
													//Luego si son de otro tipo ,  no debe de haber material en el campo
											  if(!is_null($this->tipoimputacion))
											  	 $this->adderror('tipoimputacion','No se permite especificar el ceco en este tipo de solicitud' );
										}		

													} 
	
	
	
	
	
	
	
		public function beforeSave() {
							if ($this->isNewRecord) {									
									$this->estadodetalle=(empty($this->estadodetalle))?'99':$this->estadodetalle;
									$this->coddocu='220';
									$this->iddocompra=(empty($this->iddocompra))?-1:$this->iddocompra; //valor negativo para saber si es un registro agregado 
									$this->idsesion=Yii::app()->user->getId();
                                     $this->punitdes=$this->punit*(1-$this->docompra_ocompra->descuento/100);


                            }
						
							
													
										return parent::beforeSave();	
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

		$criteria->compare('id',$this->id);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
	public function search_()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
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
		$criteria->addCondition("idsesion=".Yii::app()->user->getId());

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
}