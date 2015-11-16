<?php

CONST ESTADO_PREVIO='99';
CONST ESTADO_CREADO='10';
CONST ESTADO_ANULADO='20';
CONST ESTADO_APROBADO='30';
CONST ESTADO_ATENDIDO='40';
CONST ESTADO_ATENDIDO_PARCIAL='50';
CONST ESTADO_RESERVADO='60';
CONST ESTADO_EN_COMPRA='70';
CONST ESTADO_SOLICITADO='80';
CONST ESTADO_COMPRADO_COMPLETO='90';


class Desolpe extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Desolpe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	 public $cantidad_reservada;
      public $cantidad_compras;
	public $idenfavorito;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'public_desolpe1';
	}

	public function behaviors()
	{
		return array(
			// Classname => path to Class
			'ActiveRecordLogableBehavior'=>
				'application.behaviors.ActiveRecordLogableBehavior',
		);
	}



	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('hidsolpe', 'required'),
			//array('numero, codart', 'length', 'max'=>10),
			array('tipimputacion', 'required', 'message'=>'Debe de indicar el tipo de imputacion', 'on'=>'insert,update'),
			array('codart,id,centro,tipimputacion,codal,txtmaterial,tipsolpe,cant,um,punitplan','safe','on'=> 'ingresodesolpe'),


			array('imputacion','exist','allowEmpty' => false, 'attributeName' => 'codc', 'className' => 'VwImputaciones','message'=>'Este colector no existe', 'on'=>'insert,update'),

			array('cant', 'required', 'message'=>'Debes de indicar la cantidad', 'on'=>'insert,update'),
			array('cant', 'numerical', 'message'=>'Debes de indicar la cantidad en numeros', 'on'=>'insert,update'),
			array('um', 'required', 'message'=>'Debes de indicar la unidad de medida', 'on'=>'insert,update'),
            array('um', 'checkum', 'on'=>'insert,update'),
			array('tipimputacion','checktipimputacion', 'on'=>'insert,update'),
			array('tipsolpe', 'required', 'message'=>'Debe de indicar el tipo de solicitud', 'on'=>'insert,update'),
			array('tipsolpe','in','range'=>range('S','M'),'message'=>'No es un tipo valido, ingresa M o S', 'on'=>'insert,update'),
			array('centro', 'required', 'message'=>'Debe de indicar el centro', 'on'=>'insert,update'),
			array('codal', 'required', 'message'=>'Debe de indicar el almacen al que corresponde la solicitud', 'on'=>'insert,update'),
			//array('codal', 'required', 'message'=>'Debe de indicar el almacen al que corresponde la solicitud'),
			array('fechaent', 'required', 'message'=>'Indica para cuando lo requieres', 'on'=>'insert,update'),
				array('txtmaterial', 'required', 'message'=>'Falto indicar la descripcion', 'on'=>'insert,update'),
			array('codart', 'checkvalores', 'on'=>'insert,update'),
			array('imputacion', 'checkvalores1', 'on'=>'insert,update'),
			array('codal', 'checkal', 'on'=>'insert,update'),
			//array('c_numgui', 'checkvalores','on'=>'insert'),
			array('posicion, centro, grupocompras', 'length', 'max'=>4),
			array('tipimputacion, estadolib', 'length', 'max'=>1),
			array('codal', 'length', 'max'=>3),
			array('txtmaterial', 'length', 'max'=>40),
			array('txtmaterial', 'length', 'min'=>10),
			array('usuario, modificado', 'length', 'max'=>30),
			array('imputacion', 'length', 'max'=>12),
			array('solicitanet', 'length', 'max'=>25),
			array('creado, creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('textodetalle,est,solicitanet,item,punitplan,punitreal, hidsolpe,cant,idenfavorito,idreserva,fechacrea,tipsolpe, tipimputacion,fechaent, fechalib', 'safe','on'=>'insert,update'),
			
			
			//escenario para compras
			
			
			array('cant', 'required', 'message'=>'Debes de indicar la cantidad', 'on'=>'compra'),
			array('cant', 'numerical', 'message'=>'Debes de indicar la cantidad en numeros', 'on'=>'compra'),
			array('um', 'required', 'message'=>'Debes de indicar la unidad de medida', 'on'=>'compra'),
            array('um', 'checkum', 'on'=>'compra'),
			array('tipimputacion','in','range'=>range('N','K'),'message'=>'No es un tipo valido, ingresa K o N', 'on'=>'compra'),
			array('tipsolpe', 'required', 'message'=>'Debe de indicar el tipo de solicitud', 'on'=>'compra'),
			array('tipsolpe','in','range'=>range('S','M'),'message'=>'No es un tipo valido, ingresa M o S', 'on'=>'compra'),
			array('centro', 'required', 'message'=>'Debe de indicar el centro', 'on'=>'compra'),
			array('codal', 'required', 'message'=>'Debe de indicar el almacen al que corresponde la solicitud', 'on'=>'compra'),
			//array('codal', 'required', 'message'=>'Debe de indicar el almacen al que corresponde la solicitud'),
			array('fechaent', 'required', 'message'=>'Indica para cuando lo requieres', 'on'=>'compra'),
				array('txtmaterial', 'required', 'message'=>'Falto indicar la descripcion', 'on'=>'compra'),
			array('codart', 'checkvalores', 'on'=>'compra'),			
			array('codal', 'checkal', 'on'=>'compra'),			
			array('textodetalle,est,item, hidsolpe,cant,fechacrea,tipsolpe, tipimputacion,fechaent, fechalib', 'safe','on'=>'compra'),


			//escenario para SERVICIOS


			array('cant', 'required', 'message'=>'Debes de indicar la cantidad', 'on'=>'servicios'),
			array('codservicio', 'required', 'message'=>'El código del servicio es obligatorio', 'on'=>'servicios'),
			array('cant', 'numerical', 'message'=>'Debes de indicar la cantidad en numeros', 'on'=>'servicios'),
			array('tipimputacion','required','message'=>'El tipo de imputacion es obligatorio', 'on'=>'servicios'),
			array('tipimputacion','in','range'=>range('N','K'),'message'=>'No es un tipo valido, ingresa K o N', 'on'=>'servicios'),
			array('centro', 'required', 'message'=>'Debe de indicar el centro', 'on'=>'servicios'),
			array('codal', 'required', 'message'=>'Debe de indicar el almacen al que corresponde la solicitud', 'on'=>'servicios'),
			//array('codal', 'required', 'message'=>'Debe de indicar el almacen al que corresponde la solicitud'),
			array('fechaent', 'required', 'message'=>'Indica para cuando lo requieres', 'on'=>'servicios'),
			array('txtmaterial', 'required', 'message'=>'Falto indicar la descripcion', 'on'=>'servicios'),
			array('codal', 'checkal', 'on'=>'servicios'),
			array('textodetalle,est,item,codservicio,punitplan, solicitanet,hidsolpe,codart,um,cant,fechacrea,tipsolpe, tipimputacion,fechaent, fechalib', 'safe','on'=>'servicios'),
















			//escenario para reservar 
			array('cantidad_reservada','required','message'=>'Debes de indicar la cantidad reservada','on'=>'reservar'),
			array('cantidad_compras','required','message'=>'Debes de indicar la cantidad a comprar','on'=>'reservar'),
			array('cantidad_reservada','checkcanti','on'=>'reservar'),
			array('cantidad_reservada,est,cantidad_compras','safe','on'=>'reservar'),
			
			//escenario para actualiar estatus de reservas
			
			array('est','required','on'=>'Atencionreserva'),
			//array('est,punitreal','safe','on'=>'Atencionreserva'),
			
			
			
			
			
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('numero, posicion,cant,item, tipimputacion, centro,est, tipsolpe,codal, codart, txtmaterial, grupocompras, usuario, modificado, textodetalle, fechacrea, fechaent, fechalib, estadolib, imputacion, solicitanet, hidsolpe, creado, creadopor, creadoel, modificadopor, modificadoel, id', 'safe', 'on'=>'search'),
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
			//'hidsolpe0' => array(self::BELONGS_TO, 'Solpe', 'hidsolpe'),
			'almac' => array(self::BELONGS_TO, 'Almacenes', 'codal'),
			'servicios'=>array(self::BELONGS_TO, 'Maestroservicios', 'codservicio'),
			'maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'desolpe_um'=> array(self::BELONGS_TO, 'Ums', 'um'),
			'desolpe_alreserva'=> array(self::HAS_MANY, 'Alreserva', 'hidesolpe'),
			//'cecos'=>array(self::BELONGS_TO, 'Cc', 'imputacion'),
			//'peticiones'=>array(self::BELONGS_TO, 'Peticion', 'imputacion'),
				'imputaciones'=>array(self::BELONGS_TO, 'VwImputaciones', 'imputacion'),
			 'desolpe_solpe'=>array(self::BELONGS_TO, 'Solpe', 'hidsolpe'),
			'desolpe_alinventario'=> array(self::BELONGS_TO, 'Alinventario', array('codal'=>'codalm','centro'=>'codcen','codart'=>'codart')),
			'desolpe_estado'=>array(self::BELONGS_TO,'Estado',array('est'=>'codestado','codocu'=>'codocu')),
			  'numeroreservas'=>array(self::STAT, 'Alreserva', 'hidesolpe','condition'=>"estadoreserva <> '30' AND codocu IN ('450','800') "),//el campo foraneo
			   'numero_reservascompras'=>array(self::STAT, 'Alreserva', 'hidesolpe','condition'=>"estadoreserva <> '30' and codocu='800' "),//el campo foraneo
			'cant_reservada'=>array(self::STAT, 'Alreserva', 'hidesolpe','select'=>'sum(t.cant)','condition'=>"estadoreserva <> '30' AND codocu IN ('450') "),//el campo foraneo
			'cant_solicitada'=>array(self::STAT, 'Alreserva', 'hidesolpe','select'=>'sum(t.cant)','condition'=>"estadoreserva <> '30' AND codocu IN ('800') "),//el campo foraneo

			'numerocompras'=>array(self::STAT, 'Desolpecompra', 'iddesolpe','condition'=>"codestado <> '30'"),//el campo foraneo
				'cantcompras'=>array(self::STAT, 'Desolpecompra', 'iddesolpe','select'=>'sum(t.cant)','condition'=>"codestado <> '30'"),//el campo foraneo
			 // 'desolpe_alreserva'=>array(self::HAS_MANY, 'Alreserva', array('id'=>'hidesolpe',),//el campo foraneo
			'alkardex_gastos'=>array(self::STAT, 'Alkardex', 'idref','select'=>'sum(t.preciounit*t.cant*-1)'),//el campo foraneo
             // 'desolpe_alinventario'=>array(self::BELONGS_TO,'Alinventario',array('codal'=>'codalm','centro'=>'codcen','codart'=>'codart')),
				);
	}
 public $descentro;
 public $holas;

	public function devuelveestado()
	{
		$cantreservada = $this->cant_reservada;
		$cantsolicitada = $this->cant_solicitada;
		$estado=$this->est;
		///Si no tiene niguyamna tenciomn y no esta anulado entones esta creado
		if ( $this->est == ESTADO_ANULADO ) {

			$estado=ESTADO_ANULADO;
		} ELSE {
			//Si no tiene reservas ni solicitudes ...entonces es libre
			if ( $cantreservada == 0 AND $cantsolicitada == 0 ) {
				$estado=ESTADO_CREADO;
			} else {  /// Si tiene alguna reserva o reservas de solicitudes
				if ( $cantreservada > 0 and $cantsolicitada == 0 ) { //7se btrata de solo una reserva sin soliictudes
								return ($cantreservada >=$this->cant)?ESTADO_ATENDIDO:ESTADO_ATENDIDO_PARCIAL;


				}
				if ( $cantreservada == 0 and $cantsolicitada > 0 ) { //7se btrata de solo una solicitud
					    if($cantsolicitada >=$this->cant){ ///si esta atendida
							$estado=ESTADO_ATENDIDO;
						}else { //Aamlizando las compras

							$idreserva=yii::app()->createCommand()->select("b.id")->from("{{alreserva}} b")
								->where("b.hidesolpe=:videsolpe and codocu='800' ",array(":videsolpe"=>$this->id))->queryScalar();

							$algunacompra=yii::app()->createCommand()->select("sum(b.cant)")->from(" {{desolpe1}} a,{{desolpecompra}} b ")
								->where("a.id=b.iddesolpe and idreserva=:videreserva and b.codestado <> '30' ",array(":videreserva"=>$idreserva))->queryScalar();

							if($algunacompra!=false){
								$estado=$estado;
							}else{
								if($this->cant <= $algunacompra) {
									$estado=ESTADO_EN_COMPRA;
								} else {
									$estado=ESTADO_COMPRADO_COMPLETO;
								}

							}
						}

				}
				if ( $cantreservada > 0 and $cantsolicitada > 0 ) { //7se btrata de una reserva mixta
					 ///Se analizam las com
					$estado=ESTADO_ATENDIDO_PARCIAL;
				}
			}
		}
		return $estado;
	}




	public function sepuedeanular()  {
           return ($this->numeroreservas >0 )?false:true;
	}

public function checktipimputacion(){
///vERIFICA SI COREPSONDE EL COLECTOPR CON EL TIPO
	$registro=VwImputaciones::model()->findByPk($this->imputacion);
	if(!is_null($registro)){
		if($this->tipimputacion!=$registro->clasecolector)
			$this->adderror('imputacion', 'Este colector no corresponde al tipo de imputacion,  Verifique');
           if(!is_null($registro->validacion)){
               $modelo=$registro->validacion;
              $objetomodelo= new $modelo;
              // var_dump($objetomodelo);
              // yii::app()->end();
              $mensaje= $objetomodelo->esvalidocolector($this->imputacion); ///usa la funcion de la interfaz de colectores
               if(strlen($mensaje) > 0)
                   $this->adderror('imputacion',$mensaje);

           }


	}


}

    public function checkum($attribute,$params) {
          if((!empty($this->codart) OR !is_null($this->codart)) and $this->tipsolpe=='M') {
              $Modelomaterial=Maestrocompo::model()->findbyPk(TRIM($this->codart));
              if ($Modelomaterial===null) {
                 //  $this->adderror('codart','No.  Existe este material' );
              } else {
                 $unidad=trim($Modelomaterial->um);
                    IF ($unidad <> $this->um) {

                      //si no se encontro buscar en la tabla conversiones
                      $matriz=Alconversiones::model()->findAll("um2='".trim($this->um)."' and codart='".trim($this->codart)."'");
                      if (count($matriz)==0 ) {
                          //$matriz2=Alconversiones::model()->findAll("um1='".trim($unidad)."'");

                          $this->adderror('um','No hay conversiones para esta Um' );
                      }

                    }else {
                      //  $this->adderror('um','Esta unidad no es aplicable  '.$this->um.' -  '.$unidad );

                    }

              }



          } else {

          }

    }
	
	public function checkvalores($attribute,$params) {
		     $codigoserv=yii::app()->settings->get('materiales','materiales_codigoservicio');
					$modelomaterial=Maestrocompo::model()->find("codigo=:codigox",array(":codigox"=>TRIM($this->codart)));
											
						/*******************************************
						+		Debe de exigir el tipo de solpe 
						+		la combinacion de valores del tipo de solpe-material
						***********************************************/
										if ($this->tipsolpe=='M')		{
											if ($this->codart==$codigoserv)
												 $this->adderror('codart','Este es un servicio, usted esta solicitando un material' );


											if (is_null($modelomaterial)) {
												 $this->adderror('codart','Este material no existe ...' );
												} else {

													if($this->desolpe_alinventario===null)
														$this->adderror('codart','Este material tiene que ser ampliado al centro '.$this->centro.' y almacen '.$this->codal.' ' );
												}
											
										}	else { //Si es un servicio
											if (is_null($modelomaterial)) {
												      if (!empty($this->codart)) {
														 $this->adderror('codart','Este material no existe ->' );
														    }else {
														    	// $this->adderror('codart','Este material no existe' );
														    $this->codart=$codigoserv;
														    }
															
													}else {
															if (TRIM($this->codart) <> $codigoserv )
												 			$this->adderror('tipsolpe','Este es un servicio, usted esta solicitando un material' );


													}
									
													} 

						}

		public function checkcanti($attribute,$params) {
		///cone sta fiunciuon verificamos que la reserva sea consistente 
		
		//primero debemos de verificar qu este item nbo este reservado 
		if (!$this->est =='30')
					$this->adderror('cantidad_reservada','El status de este item no permite reservar' );
		
		//luego verifica rque las cantidades a ingrear sean consistentes
		 if( $this->cantidad_compras +$this->cantidad_reservada <> $this->cant )
		           $this->adderror('cantidad_reservada','La cantidad reservada y compras  no coincide con la solicitada' );


	    //verifica que la cantidad a reservar no supere el stock de inventario
		
		//antes asegurarse que se esta hablando de la misma unidad de medida base, emn otro caso convertir
		if( !$this->um==Maestrocompo::model()->findByPk(trim($this->codart))->um) {
				$cantidad_reservada_convertida=$this->cant*Alconversiones::model()->convierte($this->codart,$this->um);
			}else{
			  $cantidad_reservada_convertida=$this->cantidad_reservada;
			}
				  
				 $eninventario=$this->desolpe_alinventario->cantlibre;
				   //ahora si lo que se quiere reservar es mayot que lo que hay en inventario
				  if( $eninventario < $cantidad_reservada_convertida)
							$this->adderror('cantidad_reservada','La cantidad reservada es mayor de la que hay en inventario' );
		
		            if( $eninventario > 0 and  $cantidad_reservada_convertida==0 )
                        $this->adderror('cantidad_reservada','La cantidad reservada no puede ser cero, habiendo stock' );

		
					
						}



	public static function getTotal($provider)
	{
		$totalreal=0;
		$totalplan=0;
		foreach($provider->data as $data)
		{
			if($data->est <> '20'){
			$r = $data->alkardex_gastos;
			$p=$data->punitplan;
			$totalreal += $r;
			$totalplan += $p;
			}
		}
		return array('plan'=>$totalplan,'real'=>$totalreal);
	}




						
public function checkal($attribute,$params) {
						if($this->almac->codcen <> $this->centro)
							$this->adderror('codal','No se permite un almacen que no este en el centro' );
	//SI ES UN SERVICIO Y LA SOLPE NO ES COMPRA
	       if ($this->desolpe_solpe->escompra!='1' and $this->tipsolpe=='S')
			   $this->adderror('tipsolpe','La solicitud debe de tener activado el flag de compras' );

											  	 	


											}



public function checkvalores1($attribute,$params) {





									
													} 

	public function valorespordefecto(){ 
						//Vamos a cargar los valores por defecto
						$matriz=VwOpcionesdocumentos::Model()->search_d('350')->getData();
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


	public function beforeSave() {
							if ($this->isNewRecord) {
								
											//$command = Yii::app()->db->createCommand(" select nextval('sq_guias') "); 
											$this->usuario=Yii::app()->user->name;
											$this->fechacrea=date("Y-m-d H:i:s");											
											//$this->n_guia= $command->queryScalar();
												$this->codocu='350';
												//if($this->tipsolpe<>'S'){ ///Si no se trata de servicios
													$registroinventario=Alinventario::model()->encontrarregistro($this->centro,$this->codal,$this->codart);
													$this->punitplan=$registroinventario->punit*$this->cant*Alconversiones::convierte($this->codart,$this->um);
												//}
												$this->punitreal=0;
												$this->cantaten=0;
											//$this->codobjeto='001';

											$this->est=(empty($this->est))?ESTADO_PREVIO:$this->est; //para que no lo agarre la vista VW-GUIA  HASTA QUE GRABE TODO EL DETALLE

                                                ///el item
                                $criterio=new CDbCriteria;
                                $criterio->condition="hidsolpe=:nguia  ";
                                $criterio->params=array(':nguia'=>$this->hidsolpe);
                                $this->item=str_pad(Desolpe::model()->count($criterio)+1,3,"0",STR_PAD_LEFT);


											
									} else
									{
										 // IF ($this->est=='99') //SI SE TRATA DE UNA GUIA NUEVA COLOCARLE 'PREVIO'
												//$this->est='01';



										///si ha cambiado el material o la cantidad  , el precio debe de actualziarse
										/*********************************************************/
										//$fila=Yii::app()->db->createCommand("SELECT codart,cant FROM  ".Yii::app()->params['prefijo']."desolpe1  WHERE id=".$this->id."")->QueryAll();
										//echo "codiugo   ".gettype($codigo)."  valor ".$codigo."  longitud ".strlen($codigo)."\n";
										//echo "valor del registro ".gettype($this->codart)."  valor ".$this->codart."  longitud ".strlen($this->codart)."\n";
										//yii::app()->end();

											//if($fila['codigo'] <> $this->codart or $fila['cant'] <> $this->cant)
										if($this->tipsolpe<>'S'){ ///Si no se trata de servicios
											if($this->oldattributes['codigo']<> $this->codart  or $this->oldattributes['cant'] <> $this->cant )
											{
												$registroinventario=Alinventario::model()->encontrarregistro($this->centro,$this->codal,$this->codart);
												$this->punitplan=$registroinventario->punit*$this->cant*Alconversiones::convierte($this->codart,$this->um);
											}

										}

										//echo "se cumlpio carajo";
										//yii::app()->end();
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
			'numero' => 'Numero',
			'posicion' => 'Posicion',
			'tipimputacion' => 'Tipimputacion',
			'centro' => 'Centro',
			'punireal' => 'Real',
			'punitplan' => 'Plan',
			'codal' => 'Almacen',
			'codart' => 'Codigo mat',
			'cant' => 'Cantidad',
			'um'=> 'Unid. Medida',
			'txtmaterial' => 'Descripcion',
			'grupocompras' => 'Grupo compras',
			'usuario' => 'Usuario',
			'modificado' => 'Modificado',
			'textodetalle' => 'Textodetalle',
			'fechacrea' => 'Fecha creacion',
			'fechaent' => 'Fecha programada',
			'fechalib' => 'Fechalib',
			'estadolib' => 'Estadolib',
			'imputacion' => 'Imputacion',
			'solicitanet' => 'Solicitante',
			'hidsolpe' => 'Hidsolpe',
			'creado' => 'Creado',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'id' => 'ID',
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

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('tipimputacion',$this->tipimputacion,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('grupocompras',$this->grupocompras,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('textodetalle',$this->textodetalle,true);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('fechalib',$this->fechalib,true);
		$criteria->compare('estadolib',$this->estadolib,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('solicitanet',$this->solicitanet,true);
		$criteria->compare('hidsolpe',$this->hidsolpe,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
                'pageSize' => 100,
            ),
		));
	}


	public function search_por_solpe($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('tipimputacion',$this->tipimputacion,true);
		$criteria->compare('centro',$this->centro,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('txtmaterial',$this->txtmaterial,true);
		$criteria->compare('grupocompras',$this->grupocompras,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('textodetalle',$this->textodetalle,true);
		$criteria->compare('fechacrea',$this->fechacrea,true);
		$criteria->compare('fechaent',$this->fechaent,true);
		$criteria->compare('fechalib',$this->fechalib,true);
		$criteria->compare('estadolib',$this->estadolib,true);
		$criteria->compare('imputacion',$this->imputacion,true);
		$criteria->compare('solicitanet',$this->solicitanet,true);
		$criteria->compare('hidsolpe',$this->hidsolpe,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		//$criteria->addcondition("est <>'99'");
		$criteria->addcondition("hidsolpe=".$id);
		//$criteria->addcondition(" firme='1' ");
		//$criteria->addcondition("est in ('03','06') and tipsolpe='M'");


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_solpe_mas($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		//$criteria->addcondition("est <>'99'");
		$criteria->addcondition("hidsolpe=".$id);
		//$criteria->addcondition("est in ('03') and tipsolpe='M'");


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_solpe_mas_puro($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		//$criteria->addcondition("est <>'99'");
		$criteria->addcondition("hidsolpe=".$id);
		$criteria->addcondition(" vale='1' ");
		//$criteria->addcondition("est in ('03') and tipsolpe='M'");


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function cuantofaltacomprar(){
		///Si ya esta completo
		$retorno=0;
		if($this->cant <= $this->cantcompras){
			$retorno=0;
		}else { ///sI AUN LE FALTA
			$retorno=$this->cant-$this->cantcompras;

		}
			if($retorno<0)
				$retorno=0;
		return $retorno;
		///Si le falta


	}

}