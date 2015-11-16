<?php

/**
 * This is the model class for table "reportepesca".
 *
 * The followings are the available columns in table 'reportepesca':
 * @property string $codep
 * @property integer $id
 * @property integer $semana
 * @property string $fecha
 * @property string $harribo
 * @property string $hzarpe
 * @property string $codplantadestino
 * @property string $codplantazarpe
 * @property integer $declarada
 * @property integer $descargada
 * @property integer $d2
 * @property string $codzarpe
 * @property integer $r1
 * @property integer $r2
 * @property integer $r3
 * @property integer $r4
 * @property integer $r5
 * @property integer $r6
 * @property integer $r7
 * @property integer $r8
 * @property integer $r9
 * @property integer $r10
 * @property integer $r11
 * @property integer $r12
 * @property string $zona
 * @property integer $idespecie
 * @property integer $idtemporada
 *
 * The followings are the available model relations:
 * @property Temporadas $idtemporada0
 * @property Especie $idespecie0
 * @property Tipozarpe $codzarpe0
 * @property Plantas $codplantadestino0
 * @property Plantas $codplantazarpe0
 * @property Embarcaciones $codep0
 */
class Reportepesca extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reportepesca the static model class
	 */
	 
	 	 public $embarcacion_nomep;
	  public $tipozarpe_motivozarpe;
	  public $plantadestino_desplanta;
	   public $plantazarpe_desplanta;
	   public $eficienciadescarga;
	   public $horasdejornada;
	   public $eficienciabodega;
	    public $especie_nomespecie;
	     public $temporadas_destemporada;
		 
		 
		 ///campos calculados 
		  public $consumoportonelada;
	      public $factordescarga;
	      public $horas_trabajadas;
		// public $plantadestino;
		//  public $plantazarpe;
		 
		 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public  function petroleoportonelada()
	{
		 
		 
		 if($this->descargada>0) {
		         $this->consumoportonelada=round($this->d2/$this->descargada,1);
		 	} else {
			      $this->consumoportonelada=0;
			}
			return  $this->consumoportonelada;
		 
	}
	
	public  function factordescarga(){		 
	
			if($this->descargada>0) {
						$this->factordescarga=(string)(round($this->descargada/$this->declarada,3)*100)."%"; 
									} else {
										$this->factordescarga="";
									}
							return $this->factordescarga;
							}
			
	public  function horastrabajadas(){		 
	
		   // if(!empty($this->hzarpe) and !empty($this->harribo)){	
				 //if( Tipozarpe::model()->findByPk($this->codzarpe)->cuentahoras=='1') 
						//$this->horas_trabajadas=round((strtotime($this->fechaarribo)-strtotime($this->fechazarpe))/3600,1);  
		   //   } else {
			  // $this->horas_trabajadas=0;
			  //}
			  if (!is_null($this->fechaarribo) and !empty($this->codzarpe) ) { //si ya se ha llenado la fecha de arribo bacan 
			      if( Tipozarpe::model()->findByPk($this->codzarpe)->cuentahoras=='1') 
						$this->horas_trabajadas=round((strtotime($this->fechaarribo)-strtotime($this->fechazarpe))/3600,1);  
		   //   
						return $this->horas_trabajadas;
				}else{ // si no todavia no pintar nada
				   return 0;
				
				}


     }

	 
	 public function d2porhora(){
	 
				if ( $this->horastrabajadas() > 0 )
				   return round($this->d2/$this->horastrabajadas(),1);
				  return null;
	 
						}
	 
	 
	 
	 		public function refrescadeclarada () {
		    if((is_null($this->declarada)) or empty($this->declarada) or ($this->declarada==0)){

			
				$this->declarada= max($this->r1,$this->r2,$this->r3,$this->r4,$this->r5,$this->r6,$this->r7,$this->r8,$this->r9,$this->r10,$this->r11,$this->r12);
			} 
				return $this->declarada;	
			
		
				}
				
				
				
				

		
		public function colocafechazarpe(){
			if ((strtotime($this->fecha)==strtotime($this->fechazarpe)) or is_null($this->fechazarpe))
			  return "";
		   return   date("d/m H:i",strtotime($this->fechazarpe));
		}
		
		
public function colocafechaarribo(){
     if(!empty($this->codzarpe))
			{
					if((Tipozarpe::model()->findByPk($this->codzarpe)->cuentahoras=='0') or (is_null($this->fechaarribo) )) 
							return "";
					if ($this->codplantadestino=='07')
							return "";
							
			} else {
			
					
						
					return "";
					
			}
	  
		  return   date("H:i",strtotime($this->fechaarribo));
		
		   
		
		}
		
		
				
		public function beforeSave() {
							if ($this->isNewRecord) {
									   

									   } else {
									     if( Tipozarpe::model()->findByPk($this->codzarpe)->cuentahoras=='1') 
										 {
										    //si s etrata de una jornada debemos de validar cosas 
											if ($this->codplantadestino=='07') { //si se queda en zona 
											    $this->fechaarribo=$this->fecha." 23:59";
																			}
											if ($this->codzarpe=='04') { //Si viene del dia anterior
											    $this->fechazarpe=$this->fecha." 00:00"; //registrar la hora de salida
																		}
										}else {
										    $this->fechazarpe=$this->fecha." 00:00"; 
											$this->fechaarribo=$this->fecha." 23:59";
											$this->codplantadestino=$this->codplantazarpe;
											}
										 

									   
									   }
									return parent::beforeSave();
									}
	




	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reportepesca';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		
		///escenarios inser y update 
			array('semana, declarada, d2, r1, r2, r3, r4, r5, r6, r7, r8, r9, r10, r11, r12, idespecie, idtemporada', 'numerical', 'integerOnly'=>true,'on'=>'insert,update'),
			array('codep', 'length', 'max'=>3,'on'=>'insert,update'),
			array('codplantadestino, codplantazarpe, codzarpe', 'length', 'max'=>2,'on'=>'insert,update'),
			array('codplantazarpe','required','message'=>' Indica de que planta esta zarpando ','on'=>'insert,update'),
			array('codzarpe','required','message'=>' Debes llenar como esta saliendo ','on'=>'insert,update'),
			array('fechazarpe','required','message'=>' Debes llenar la hora en la que esta saliendo ','on'=>'insert,update'),
			array('idespecie','required','message'=>' Llena la especie ','on'=>'insert,update'),
			array('zona', 'length', 'max'=>1,'on'=>'insert,update'),
			array('fecha, fechaarribo, fechazarpe', 'safe','on'=>'insert,update'),
			array('descargada', 'checkDescargada','on'=>'insert,update'),
			array('declarada', 'checkDescargada','on'=>'insert,update'),
			array('fechazarpe','checkih','on'=>'insert,update'),
			array('fechaarribo','checkih','on'=>'insert,update'),
			//array('latitud', 'match', 'not' => true, 'pattern' => '([0-4]){1}([0-9]){1}\º([0-8]){1}([0-9]){1}\'',
					//	'message' => 'Esta coordenada esta mala'),
			// array('meridiano', 'match', 'not' => true, 'pattern' => '([0-4]){1}([0-9]){1}\º([0-8]){1}([0-9]){1}\'',
						//'message' => 'Esta coordenada esta mala'),		
			//array('descargada', 'checkDescargada'),
			array('r1, r2, r3, r4, r5, r6, r7, r8, r9, r10, r11, r12','safe','on'=>'escenarioreporte'),
			
			
			
			array('evento','safe','on'=>'miescenario'),
			
			
			array('latitud', 'length', 'max'=>6,'message'=>'Lalongitues : '.strlen($this->latitud),'on'=>'insert,update'),
			array('meridiano',  'length', 'max'=>6,'on'=>'insert,update'),
			//array('latitud', 'checkCoordenadas','on'=>'insert,update'),
			//array('meridiano', 'checkCoordenadas','on'=>'insert,update'),
		//	array('latitud', 'checkCoordenadas','on'=>'update'),
		//	array('meridiano', 'checkCoordenadas','on'=>'update'),
			
				array('codplantazarpe,fechazarpe,fechaarribo,motivozarpe,comenatrio,latitud,meridiano', 'safe','on'=>'insert,update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('evento,motivozarpe,latitud,meridiano,zonapesca,codep,comenatrio,consumoportonelada,factordescarga,horas_trabajadas,comenatrio,id, semana, fecha, harribo, hzarpe, codplantadestino, codplantazarpe, declarada, descargada, d2, codzarpe, r1, r2, r3, r4, r5, r6, r7, r8, r9, r10, r11, r12, zona, idespecie, idtemporada', 'safe', 'on'=>'search'),
		);
	}
	
	
	
	
				
	
	  public function checkCoordenadas($attribute,$params) 	{  
	    // if (!ereg("([0-4]){1}([0-9]){1}\º([0-8]){1}([0-9]){1}\'",$this->latitud)&&(is_null($this->latitud))) 
		   if (!preg_match("/([0-4]){1}([0-9]){1}\-([0-8]){1}([0-9]){1}\'/",$this->latitud )&&!empty($this->latitud))
		   $this->adderror('latitud','Esta latitud no es valida:'.$this->latitud);
		   if (!ereg("([6-9]){1}([0-9]){1}\-([0-8]){1}([0-9]){1}",$this->meridiano)&&(!empty($this->meridiano))) 		
					$this->adderror('meridiano','Esta coordenada no es valida ');
	  }
	

     public function checkDescargada($attribute,$params) 	{  
			//VERIFICAMOS QUE LA DESCARAGHDA NO EXCEDA LA CAPCIDA DE BODEGA 
			$bodega=Embarcaciones::model()->findByPk($this->codep)->cbodega;
			if (!is_null($bodega))  {
			    if($bodega +150 < $this->descargada)
				 $this->adderror('descargada','Esto no puede ser, la pesca descargada es mayor que el tamaño de la bodega ');
				if($bodega +150 < $this->declarada)
				 $this->adderror('declarada','Esto no puede ser, la pesca declarada es mayor que el tamaño de la bodega ');											
	              }
			if (( $this->declarada==0 or is_null($this->declarada) or empty($this->declarada) ) and ($this->descargada > 0))
			 $this->adderror('declarada','Te estas olvidando de llenar la pesca declarada ');											
	             
			if($this->descargada > ($this->declarada)+150)
				  $this->adderror('declarada','Esto no puede ser, la pesca declarada es menor que la descargada');		
	 }
	
	
	
	public function checkih($attribute,$params) 	{  
	
	///verificando que la fecha de zarpe sea obligatoria 
	if (  ($this->codzarpe=='01') and  (  empty($this->fechazarpe) or is_null($this->fechazarpe)  )  )
	  $this->adderror('fechazarpe','Debes de Ingresar la fecha/hora de Zarpe');
	 
	 
	    
	if (!empty($this->fechaarribo) and  !is_null($this->fechaarribo)) {
							if (strtotime($this->fechaarribo) < strtotime($this->fechazarpe)) 
								$this->adderror('fechazarpe','Esta hora '.strtotime($this->fechazarpe).'es mayor que la hora de arribo ');
							}
	  

	  
	      
	if (!empty($this->fechazarpe) and  !is_null($this->fechazarpe)) {
							if (abs(strtotime($this->fechazarpe)- strtotime($this->fecha)) > 14*60*60 )  //Esta salida ya no es del dia 
								$this->adderror('fechazarpe','Esta fecha  no corresponde a la jornada de hoy ');
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
			'temporadas' => array(self::BELONGS_TO, 'Temporadas', 'idtemporada'),
			'especie' => array(self::BELONGS_TO, 'Especie', 'idespecie'),
			'tipozarpe' => array(self::BELONGS_TO, 'Tipozarpe', 'codzarpe'),
			'plantadestino' => array(self::BELONGS_TO, 'Plantas', 'codplantadestino'),
			'plantazarpe' => array(self::BELONGS_TO, 'Plantas', 'codplantazarpe'),
			'embarcacion' => array(self::BELONGS_TO, 'Embarcaciones', 'codep'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codep' => 'Embarcacion',
			'id' => 'ID',
			'semana' => 'Semana',
			'fecha' => 'Fecha',
			'harribo' => 'Hora de Arribo',
			'hzarpe' => 'Hora de Zarpe',
			'codplantadestino' => 'Planta de descarga',
			'codplantazarpe' => 'Planta de donde zarpa',
			'declarada' => 'Pesca Declarada',
			'descargada' => 'Pesca Descargada',
			'd2' => 'D2',
			'codzarpe' => 'Tipo de salida',
			'r1' => '02:00',
			'r2' => '04:00',
			'r3' => '06:00',
			'r4' => '08:00',
			'r5' => '10:00',
			'r6' => '12:00',
			'r7' => '14:00',
			'r8' => '16:00',
			'r9' => '18:00',
			'r10' => '20:00',
			'r11' => '22:00',
			'r12' => '00:00',
			'zona' => 'Zona',
			'idespecie' => 'Especie',
			'comenatrio' => 'Comentario',
			'idtemporada' => 'Idtemporada',
			'especie.nomespecie'=>'Especie',
			'plantazarpe.desplanta'=>'P.Zarpa',
			'plantadestino.desplanta'=>'P.Desc.',
			'consumoportonelada'=>'Gl/t',
			'factordescarga'=>'Fac.',
			'horas_trabajadas'=>'Horas',
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

		$criteria->compare('codep',$this->codep,true);
			$criteria->compare('comenatrio',$this->comenatrio,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('semana',$this->semana);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('harribo',$this->harribo,true);
		$criteria->compare('hzarpe',$this->hzarpe,true);
		$criteria->compare('codplantadestino',$this->codplantadestino,true);
		$criteria->compare('codplantazarpe',$this->codplantazarpe,true);
		$criteria->compare('declarada',$this->declarada);
		$criteria->compare('descargada',$this->descargada);
		$criteria->compare('d2',$this->d2);
		$criteria->compare('codzarpe',$this->codzarpe,true);		
		$criteria->compare('zona',$this->zona,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('fechaarribo',$this->fechaarribo);
		$criteria->compare('fechazarpe',$this->fechazarpe);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
		
	
}