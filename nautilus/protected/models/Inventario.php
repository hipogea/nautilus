<?php

class Inventario extends ModeloGeneral
{
	/**
	 * Returns the static model                                                                                                                                         of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventario the static model class
	 */
	 
	public $imagen ;
	public $lugares_lugar;
	public $codlugar_;
	public $documento_desdocu;
	    public $proceso;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{inventario}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('idinventario', 'required'),
			
			//escenarios para la carga masiva 
			/* BATCH_INS_BASICO               //INSERTA UN REGISTRO DE ACTIVO CONL OS DATOS MINIMOS
			   BATCH_INS_TOTAL					// INSERTA REGISTRO DE ACTIVO CON DATOS COMPLETOS
			   BATCH_UPD_TOTAL                 //ACTUALIZA UN REGISTRO CON DATOS COMPLETOS
			   BATCH_UPD_ESTADO                //ACTUALIZA EL CAMPO ESTADO
			   BATCH_UPD_INVENTARIO_FISICO       //ACTUALIZA LOS CAMPOS DE INVENTARIO FISICO
			   BATCH_UPD_DATOS_TECNICOS         //ACTUALIZA LOS CAMPOS DESCRIPCION MARCA MODELO Y SERIE
			   BATCH_UPD_LUGARES               //ACTUALIZA LOS LUGARES 
			   BATCH_UPD_ACTIVO                // ACTUALIZA EL STATUS DE SI ESTA ACTIVO OU EN OPERACION
			   BATCH_UPD_CODEP                //ACTUALIZA LA EMBARCACION A LA CUAL PERTENECE EL ACTIVO
			   
			   */
			   
			  //atribuitos seguros en los escenarios 
			  //BATCH_INS_BASICO
			  array('codpropietario,
			          codarea,
					  codlugar,
					  codep,
					  codigoaf,
					  tipo,
					  descripcion,
					  fecha,
					  descripcion,
					  marca , 
					  modelo,
					  marca, 
					  codigosap,
					  serie, 
					  comentario',
					 'safe','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL' ),
			 array('codpropietario','exist','allowEmpty' => false, 'attributeName' => 'codcen', 'className' => 'Centros','message'=>'Esta planta no existe','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL'),
			 array('codarea','exist','allowEmpty' => false, 'attributeName' => 'codarea', 'className' => 'Areas','message'=>'Esta area no existe','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL'),
			 array('codlugar','exist','allowEmpty' => false, 'attributeName' => 'codlugar', 'className' => 'Lugares','message'=>'Este lugar no existe','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_INVENTARIO_FISICO,BATCH_UPD_LUGAR'),
        	array('codep','exist','allowEmpty' => false, 'attributeName' => 'codep', 'className' => 'Embarcaciones','message'=>'Esta embarcacion no existe','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_INVENTARIO_FISICO,BATCH_UPD_EMBARCACION'),
				array('codigoaf','required','message'=>'Debes de llenar la plaquita','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL'),	 
			   array('codigoaf', 'match', 'pattern'=>'/90-3[0-5]{1}00-[0-9]{5}/','message'=>'El codigo de placa no es el correcto','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL'),			
			   array('tipo','required','message'=>'Debes de llenar el tipo','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL'),
			    array('descripcion','length','min'=>10,'max'=>40,'message'=>'Descripcion no es del tamaño adecuado ','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_DATOS_TECNICOS'),
				  array('descripcion','required','message'=>'Descripcion es obligatorio ','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_DATOS_TECNICOS'),
				 array('marca','length','max'=>15,'message'=>'Marca no es del tamaño adecuado ','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_DATOS_TECNICOS'),
			     array('modelo','length','max'=>20,'message'=>'modelo no es del tamaño adecuado ','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_DATOS_TECNICOS'),
			      array('serie','length','max'=>25,'message'=>'serie no es del tamaño adecuado ','on'=>'BATCH_INS_BASICO,BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_DATOS_TECNICOS'),
			    ///fin del BATCH_INS_BASICO
				
				 //atribuitos seguros en los escenarios 
				//BATCH_INS_TOTAL
					array('codeporiginal,codepanterior, codestado,coddocu,numerodocumento',
						'safe','on'=>'BATCH_INS_TOTAL,BATCH_UPD_TOTAL' ),
					array('codeporiginal,codepanterior','exist','allowEmpty' => false, 'attributeName' => 'codeporiginal', 'className' => 'Embarcaciones','message'=>'Esta embarcacion no existe','on'=>'BATCH_INS_TOTAL,BATCH_UPD_TOTAL'),
				    array('coddocu','exist','allowEmpty' => false, 'attributeName' => 'coddocu', 'className' => 'Documentos','message'=>$this->coddocu.' Este documento no existe','on'=>'BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_INVENTARIO_FISICO'),
				     array('codestado','required','on'=>'BATCH_INS_TOTAL,BATCH_UPD_TOTAL,BATCH_UPD_ESTADO,BATCH_UPD_INVENTARIO_FISICO'),
				 
				 ///fin del BATCH_INS_TOTAL 
					 
					 //atribuitos seguros en los escenarios 
				//BATCH_UPD_ESTADO
					array('codestado, codigoaf',
						'safe','on'=>'BATCH_UPD_ESTADO' ),	
				 ///fin del BATCH_UPD_ESTADO
				 
				 //BATCH_UPD_INVENTARIO_FISICO
					array('codestado,coddocu,numerodocumento,iddocu,fecha,codlugar,codep,comentario, codigoaf',
						'safe','on'=>'BATCH_UPD_INVENTARIO_FISICO' ),											
						
				 ///fin del BATCH_UPD_INVENTARIO_FISICO
				 
				//BATCH_UPD_DATOS_TECNICOS
					array('descripcion,marca,modelo,serie, codigoaf',
						'safe','on'=>'BATCH_UPD_DATOS_TECNICOS' ),	
				 ///fin del BATCH_UPD_DATOS_TECNICOS
				 
			//BATCH_UPD_EMBARCACION
					array('codep, codigoaf',
						'safe','on'=>'BATCH_UPD_EMBARCACION' ),	
			 ///fin del BATCH_UPD_EMBARCACION
			
			
			
			
			//BATCH_UPD_LUGAR
					array('codlugar, codigoaf',
						'safe','on'=>'BATCH_UPD_LUGAR' ),	
			 ///fin del BATCH_UPD_LUGAR
			 ////paral os updfates es ncensario el campoclave  CODIGOAF
			 array('codigoaf','exist','allowEmpty' => false, 'attributeName' => 'codigoaf', 'className' => 'Inventario','message'=>'No se encontró este activo','on'=>
			 'BATCH_UPD_ESTADO,BATCH_UPD_INVENTARIO_FISICO,BATCH_UPD_DATOS_TECNICOS,BATCH_UPD_EMBARCACION,BATCH_UPD_LUGAR'),
			array('codigoaf', 'match', 'pattern'=>'/90-3[0-5]{1}00-[0-9]{5}/','message'=>'El codigo de placa no es el correcto','on'=>
			'BATCH_UPD_ESTADO,BATCH_UPD_INVENTARIO_FISICO,BATCH_UPD_DATOS_TECNICOS,BATCH_UPD_EMBARCACION,BATCH_UPD_LUGAR'),			
			  
			 
			 
			
			array('codpropietario','exist','allowEmpty' => false, 'attributeName' => 'codcen', 'className' => 'Centros','message'=>'Esta planta no existe','on'=>'inscarga,updacarga'),
			array('codarea','exist','allowEmpty' => false, 'attributeName' => 'codarea', 'className' => 'Areas','message'=>'Esta area no existe','on'=>'inscarga,updacarga'),
			array('codlugar','exist','allowEmpty' => false, 'attributeName' => 'codlugar', 'className' => 'Lugares','message'=>'Este lugar no existe','on'=>'inscarga,updacarga'),			
			array('codep,codepanterior,codeporiginal','exist','allowEmpty' => false, 'attributeName' => 'codep', 'className' => 'Embarcaciones','message'=>'Esta embarcacion no existe','on'=>'inscarga,updacarga'),
			array('coddocu','exist','allowEmpty' => false, 'attributeName' => 'coddocu', 'className' => 'Documentos','message'=>'Este documento no existe','on'=>'inscarga,updacarga'),
			array('codep,fecha,coddocu,codlugar,codigosap,codigoaf,descripcion,marca,modelo,serie,numerodocumento,codepanterior,ubicacion,tipo,codestado,codarea,codpropietario,codeporiginal', 'safe','on'=>'inscarga,updacarga'),
			
			
			array('codestado,codestadoant','safe','on'=>'cambiaestado'),
			array('codestado,codestadoant,codep,codepantant,codepanterior','safe','on'=>'cambiaeP'),
			
			array('codigoaf','required','message'=>'Debes de llenar la plaquita','on'=>'insert,update,inscarga,updacarga'),
			array('codpropietario','required','message'=>'Indica el centro propietario','on'=>'insert,update,inscarga,updacarga'),
			array('codigosap','unique','message'=>'Este valor ya se asignó a otro activo, revise','on'=>'insert,update,inscarga,updacarga'),
			array('codarea','required','message'=>'Debes de llenar el area responsable','on'=>'insert,update,inscarga,updacarga'),
			array('codlugar','required','message'=>'Debes de llenar el lugar actual','on'=>'insert,update,inscarga,updacarga'),
			array('codepanterior','required','message'=>'Indica la Ep Anterior','on'=>'insert,update,inscarga,updacarga'),
			array('codeporiginal','required','message'=>'Indica la Ep Original','on'=>'insert,update,inscarga,updacarga'),
			array('tipo','required','message'=>'Debes de llenar el tipo','on'=>'insert,update,inscarga,updacarga'),
			array('codep','required','message'=>'Debes de indicar de donde es este activo','on'=>'insert,update,inscarga,updacarga'),
			array('descripcion','required','message'=>'...y la descripcion ... ?','on'=>'insert,update,inscarga,updacarga'),
			array('descripcion','required','message'=>'...y la descripcion ... ?','on'=>'insert,update,inscarga,updacarga'),
			array('fecha','required','message'=>'...y la fecha ... ?','on'=>'insert,update,inscarga,updacarga'),
			array('coddocu','required','message'=>'Indica con que documento estas actualizando o creando el inventario','on'=>'insert,update,inscarga,updacarga'),
			array('codigo, codlugar, codigosap, posicion', 'length', 'max'=>6,'on'=>'insert,update,inscarga,updacarga'),
			array('c_estado, rocoto, baja', 'length', 'max'=>1,'on'=>'insert,update,inscarga,updacarga'),
			array('codestado', 'length', 'max'=>2,'on'=>'insert,update,inscarga,updacarga'),
			array('codep, coddocu, codeporiginal, codepanterior', 'length', 'max'=>3,'on'=>'insert,update,inscarga,updacarga'),
			array('creadopor, modificadopor, modelo', 'length', 'max'=>25,'on'=>'insert,update,inscarga,updacarga'),
			array('creadoel, modificadoel, serie, numerodocumento', 'length', 'max'=>20,'on'=>'insert,update,inscarga,updacarga'),
			array('codigoaf', 'unique', 'attributeName'=> 'codigoaf', 'caseSensitive' => 'true','message'=>'Este numero de placa ya esta registrada','on'=>'insert,update,inscarga,updacarga'),
			array('codigosap', 'unique', 'attributeName'=> 'codigosap', 'caseSensitive' => 'true','message'=>'Este codigo ya esta registrada','on'=>'insert,update,inscarga,updacarga'),
			array('codigoaf', 'length', 'max'=>13,'on'=>'insert,update,inscarga,updacarga'),
			array('codigoaf', 'match', 'pattern'=>'/90-3[0-5]{1}00-[0-9]{5}/','message'=>'El codigo de placa no es el correcto','on'=>'insert,update,inscarga,updacarga'),			
			array('descripcion', 'length', 'max'=>40,'on'=>'insert,update,inscarga,updacarga'),
			//array('marca', 'length', 'max'=>15),
			array('clasefoto', 'length', 'max'=>30,'on'=>'insert,update,inscarga,updacarga'),
			array('codigopadre', 'length', 'max'=>5,'on'=>'insert,update,inscarga,updacarga'),
			array('codigoafant', 'length', 'max'=>10,'on'=>'insert,update,inscarga,updacarga'),
			array('codcentro, codcentrooriginal, codcentroanterior, clase', 'length', 'max'=>4,'on'=>'insert,update,inscarga,updacarga'),
			array('comentario,codigoaf,codpropietario,marca,fecha,clasefoto, n_direc,codarea', 'safe','on'=>'insert,update'),
			
			
			array('clasefoto', 'safe','on'=>'subefoto'),
				
				
				array('codlugar, codestado', 'safe','on'=>'procesar'),
				array('codlugar, codestado', 'checkdatitos','on'=>'procesar'),
				array('proceso', 'required','message'=>'Debes de indicar un proceso','on'=>'procesar'),
			

			array('idinventario, codigo,tipo,c_estado,tienecarter, codep, comentario, fecha,clasefoto, coddocu, creadopor, creadoel, modificadopor, modificadoel,  codigosap, codigoaf, descripcion, marca, modelo, serie, clasefoto, codigopadre, numerodocumento, adicional, codigoafant, posicion, codcentro, codcentrooriginal, codeporiginal, rocoto, codepanterior, codcentroanterior, clase, baja, n_direc', 'safe', 'on'=>'search'),
		   array('codestado,lugares_lugar,codlugar,clasefoto,tienecarter',  'safe', 'on'=>'search'),
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
		'barcoactual'=>array(self::BELONGS_TO, 'Embarcaciones', 'codep'),
		'barcoanterior'=>array(self::BELONGS_TO, 'Embarcaciones', 'codepanterior'),
		'barcooriginal'=>array(self::BELONGS_TO, 'Embarcaciones', 'codeporiginal'),
		'lugares'=>array(self::BELONGS_TO, 'Lugares', 'codlugar'),
		'documentox'=>array(self::BELONGS_TO, 'Documentos', 'coddocu'),
		'area'=>array(self::BELONGS_TO, 'Areas', 'codarea'),
		'estado'=>array(self::BELONGS_TO, 'Estado', array('codestado','codigodoc')),
		'fisicodetalle'=>array(self::HAS_MANY, 'Inventariofisicodetalle', 'idinventario'),
		'guia'=>array(self::BELONGS_TO, 'Guia', 'iddocu'),
		);
	}

	
	
public static function canttransporte(){
	/*$criteria = new CDbCriteria();
 $criteria->condition = "rocoto='1'";
 
 return self::model()->count($criteria);*/
 
 	$model=new VwLoginventari('search');		
	   $criter=new CDbCriteria;
			$criter->addCondition('codestado = :pcodestado');
			$criter->params = array(':pcodestado' => '01');		///solo los log s qusestan sin tratar	
			return $model->count( $criter);
 
 
 
}
	
	
	
		public function checkdatitos($attribute,$params) 	{  
		  if ($this->proceso==1 and (is_null($this->codestado) or empty($this->codestado)  ))
			  $this->adderror('codestado', 'Llene el estado');
		  
		  if ($this->proceso==2 and (is_null($this->codlugar) or empty($this->codlugar)  ))
			  $this->adderror('codlugar', 'Llene el estado');
		
		}
	
	
	
	
	
	
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(			
			'c_estado' => 'C Estado',
			'codep' => 'Embarcacion actual',
			'codarea'=>'Area responsable',
			'comentario' => 'Comentario',
			'fecha' => 'Fecha',			
			'codlugar' => 'Lugar',
			'codigosap' => 'Codigo SAP',
			'codigoaf' => 'Codigo de placa',
			'descripcion' => 'Descripcion',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'codpropietario' => 'Dueño ',
			'serie' => 'Serie',
			'coddocu'=>'Documento',
			'clasefoto' => 'Fotografia ',
			'codigopadre' => 'Codigopadre',
			'numerodocumento' => 'Numero documento',
			'adicional' => 'Observacion ',		
			'posicion' => 'Posicion',
			'codcentro' => 'Codcentro',
			'codcentrooriginal' => 'Codcentrooriginal',
			'codeporiginal' => 'Embarcacion original',
			'rocoto' => 'En transporte',
			'codepanterior' => 'Embarcacion anterior',
			'codcentroanterior' => 'Codcentroanterior',
			'clase' => 'Clase',
			'baja' => 'Baja',
			'tienecarter'=>'Tiene control de lubricacion',
			'lugares.deslugar'=>'Lugar',			
			'barcoactual.nomep'=>'Ep actual',
			'barcoanterior.nomep'=>'Ep anterior',
			'barcooriginal.nomep'=>'Ep origen',
			'n_direc' => 'N Direc',
		);
	}

	
		/**
	
	
*/
	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchlimpio()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('codep',$this->codep,true);	
		$criteria->compare('codlugar',$this->codlugar,true);	
		$criteria->compare('codestado',$this->codestado,true);	
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->addcondition(" descripcion like '%".$this->descripcion."%' ");
		$criteria->addcondition(" marca like '%".$this->marca."%' ");
		$criteria->addcondition(" modelo like '%".$this->modelo."%' ");
		$criteria->compare('rocoto',$this->rocoto,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codcentroanterior',$this->codcentroanterior,true);			
						$criteria->compare('codigosap',$this->codigosap,true);	
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 40,
            ),
		));
	}
	
	
	
	
	public static function recordByplate($codigoplaca){
	
	    return  self::model()->find("codigoaf=:placa",array(":placa"=>$codigoplaca));
	
	}
	
	
	//guarda el log de inventario para el historial 
	public function loguea($vcodep,$codigodoc,$idguia,$numerodocmov) {
		$modelog=New Loginventario;
		$modelog->hidinventario=$this->idinventario;
		$modelog->codep=$vcodep; //7COn que barco 
		$modelog->comentario=$this->comentario;
		$modelog->fecha=$this->fecha;
		$modelog->coddocu=$this->coddocu;
		$modelog->codocumov=$codigodoc; ///el codigo del doc de trabnsporte no dle invnetairo 
		$modelog->codestado='20';
		$modelog->codlugar=$this->codlugar;		
		$modelog->numerodocumento=$this->numerodocumento;
		$modelog->numerodocumentomov=$numerodocmov;
		$modelog->codepanterior=$this->codep; //ka orignal 
		$modelog->iddocu=$this->iddocu;
		$modelog->iddocumov=$idguia;
		$modelog->codcentro=$this->codcentro;
		$modelog->save();
		unset($modelog);
		
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

		//$criteria->compare('idinventario',$this->idinventario,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codestado',$this->codestado,true);
		//$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->addcondition(" descripcion like '%".$this->descripcion."%' ");
		$criteria->addcondition(" marca like '%".$this->marca."%' ");
		$criteria->addcondition(" modelo like '%".$this->modelo."%' ");
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('clasefoto',$this->clasefoto,true);
		$criteria->compare('codigopadre',$this->codigopadre,true);
		$criteria->compare('numerodocumento',$this->numerodocumento,true);
		$criteria->compare('adicional',$this->adicional,true);
		$criteria->compare('codigoafant',$this->codigoafant,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codcentrooriginal',$this->codcentrooriginal,true);
		$criteria->compare('codeporiginal',$this->codeporiginal,true);
		$criteria->compare('rocoto',$this->rocoto,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codcentroanterior',$this->codcentroanterior,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('baja',$this->baja,true);
		$criteria->compare('n_direc',$this->n_direc,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('codlugar',$this->codlugar_,true);
		$criteria->compare('t.codlugar', $this->codlugar,true);
		
		 if(isset($_SESSION['sesion_Inventario'])) {
					$criteria->addInCondition('idinventario', $_SESSION['sesion_Inventario'], 'AND');
													  	   } ELSE {
															 //  yii::app()->end();
						//$criteria->compare('idinventario',$this->idinventario,true);
													  	   }
														   
		
		
		
						//$criteriazo->params = array(':idt' => $idt);
						//$criteria->params = array(':idt'=>$this->codlugar);
		//$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->together  =  true;
		$criteria->with = array('lugares');
		 if($this->lugares_lugar){
				//$criteria->compare('deslugar',$this->lugares_lugar,true);
			}
				$sort=new CSort;
				/*$sort->attributes=array(
										'codlugar',
									// For each relational attribute, create a 'virtual attribute' using the public variable name
										'lugares_lugar' => array(
																	'asc' => 'lugares.deslugar  ASC',
																	'desc' => 'lugares.deslugar DESC ',
																	'label' => 'lugares',
																	),
										'*',
										);*/
		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>$sort,'pagination' => array(
                'pageSize' => 10,
            ),
		));
	}
	
	public function searchprove()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('idinventario',$this->idinventario,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codestado',$this->codestado,true);
		//$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->addcondition(" descripcion like '%".$this->descripcion."%' ");
		$criteria->addcondition(" marca like '%".$this->marca."%' ");
		$criteria->addcondition(" modelo like '%".$this->modelo."%' ");
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('clasefoto',$this->clasefoto,true);
		$criteria->compare('codigopadre',$this->codigopadre,true);
		$criteria->compare('numerodocumento',$this->numerodocumento,true);
		$criteria->compare('adicional',$this->adicional,true);
		$criteria->compare('codigoafant',$this->codigoafant,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codcentrooriginal',$this->codcentrooriginal,true);
		$criteria->compare('codeporiginal',$this->codeporiginal,true);
		$criteria->compare('rocoto',$this->rocoto,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codcentroanterior',$this->codcentroanterior,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('baja',$this->baja,true);
		$criteria->compare('n_direc',$this->n_direc,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('codlugar',$this->codlugar_,true);
		$criteria->compare('t.codlugar', $this->codlugar,true);
		$criteria->addCondition("lugares.codpro <>'R00001'", 'AND');
		 if(isset($_SESSION['sesion_Inventario'])) {
					$criteria->addInCondition('idinventario', $_SESSION['sesion_Inventario'], 'AND');
													  	   } ELSE {
															 //  yii::app()->end();
						//$criteria->compare('idinventario',$this->idinventario,true);
													  	   }
														   
		
		
		
						//$criteriazo->params = array(':idt' => $idt);
						//$criteria->params = array(':idt'=>$this->codlugar);
		//$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->together  =  true;
		$criteria->with = array('lugares');
		 if($this->lugares_lugar){
				$criteria->compare('deslugar',$this->lugares_lugar,true);
			}
				$sort=new CSort;
				$sort->attributes=array(
										'codlugar',
									// For each relational attribute, create a 'virtual attribute' using the public variable name
										'lugares_lugar' => array(
																	'asc' => 'lugares.deslugar  ASC',
																	'desc' => 'lugares.deslugar DESC ',
																	'label' => 'lugares',
																	),
										'*',
										);
		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'sort'=>$sort,'pagination' => array(
                'pageSize' => 10,
            ),
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search_trata()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('idinventario',$this->idinventario,true);
		$criteria->addInCondition('idinventario', Mifactoria::devuelvearrayactivostratados()) ;	
	
		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 40,
            ),
		));
	}
	
	public function search2($codep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idinventario',$this->idinventario,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codestado',$this->codestado,true);
		//$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('clasefoto',$this->clasefoto,true);
		$criteria->compare('codigopadre',$this->codigopadre,true);
		$criteria->compare('numerodocumento',$this->numerodocumento,true);
		$criteria->compare('adicional',$this->adicional,true);
		$criteria->compare('codigoafant',$this->codigoafant,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codcentrooriginal',$this->codcentrooriginal,true);
		$criteria->compare('codeporiginal',$this->codeporiginal,true);
		$criteria->compare('rocoto',$this->rocoto,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codcentroanterior',$this->codcentroanterior,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('baja',$this->baja,true);
		$criteria->compare('n_direc',$this->n_direc,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->addCondition("codep = '".$codep."'");
		$criteria->addCondition("codlugar = '000015'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 10,
            ),
		));
	}
	
	

	
	
		public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones
	public function beforeSave() {
				
		if ($this->isNewRecord) {
			       $this->codigodoc='390';
				if(is_null($this->codigosap) or empty($this->codigosap) or trim($this->codigosap=="")) 
				{
					/*$criterio=new CDbCriteria;
				$criterio->condition="tipo=:vtipo ";
				$criterio->params=array(':vtipo'=>$this->tipo);
				$model->codigosap=$this->tipo.str_pad(Inventario::model()->count($criterio)+1,4,"0",STR_PAD_LEFT);*/
				}
				
               

		} else
		{

		}
		return parent::beforesave();
	}

	
	
	public function search3($codep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idinventario',$this->idinventario,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codestado',$this->codestado,true);
		//$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('clasefoto',$this->clasefoto,true);
		$criteria->compare('codigopadre',$this->codigopadre,true);
		$criteria->compare('numerodocumento',$this->numerodocumento,true);
		$criteria->compare('adicional',$this->adicional,true);
		$criteria->compare('codigoafant',$this->codigoafant,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codcentrooriginal',$this->codcentrooriginal,true);
		$criteria->compare('codeporiginal',$this->codeporiginal,true);
		$criteria->compare('rocoto',$this->rocoto,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codcentroanterior',$this->codcentroanterior,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('baja',$this->baja,true);
		$criteria->compare('n_direc',$this->n_direc,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->addCondition("codep = '".$codep."'");
		$criteria->addCondition("tienecarter = '1'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array(
                'pageSize' => 10,
            ),
		));
	}
	
	
	public function search_dueno($codcentro)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->addCondition("codep = '001'");
		$criteria->addCondition("codpropietario=:vcodecentro");
		$criteria->params=array(":vcodecentro"=>$codcentro);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		                 ));
	}
}