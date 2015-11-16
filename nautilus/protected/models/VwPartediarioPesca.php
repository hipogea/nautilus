<?php

/**
 * This is the model class for table "vw_partediario_pesca".
 *
 * The followings are the available columns in table 'vw_partediario_pesca':
 * @property string $codep
 * @property integer $id
 * @property integer $semana
 * @property string $fecha
 * @property string $harribo
 * @property string $hzarpe
 * @property string $codplantadestino
 * @property string $codplantazarpe
 * @property integer $declarada
 * @property double $descargada
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
 * @property string $comenatrio
 * @property string $latitud
 * @property string $meridiano
 * @property string $zonapesca
 * @property string $evento
 * @property string $fechazarpe
 * @property string $fechaarribo
 * @property double $descargada1
 * @property integer $capbodega
 * @property string $motivozarpe
 * @property string $cuentahoras
 * @property string $nomespecie
 * @property string $nomep
 * @property integer $cbodega
 * @property string $desplantazarpe
 * @property string $plantadestino
 */
class VwPartediarioPesca extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwPartediarioPesca the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
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
		   public $consumoporhora;
	      public $factordescarga;
	      public $horas_trabajadas;
		// public $plantadestino;
		//  public $plantazarpe;
		 
		 
	
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
		
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_partediario_pesca';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, semana, declarada, d2, r1, r2, r3, r4, r5, r6, r7, r8, r9, r10, r11, r12, idespecie, idtemporada, capbodega, cbodega', 'numerical', 'integerOnly'=>true),
			array('descargada, descargada1', 'numerical'),
			array('codep', 'length', 'max'=>3),
			array('codplantadestino, codplantazarpe, codzarpe', 'length', 'max'=>2),
			array('zona, evento, cuentahoras', 'length', 'max'=>1),
			array('latitud, meridiano', 'length', 'max'=>6),
			array('zonapesca, nomep, desplantazarpe, plantadestino', 'length', 'max'=>25),
			array('motivozarpe', 'length', 'max'=>40),
			array('nomespecie', 'length', 'max'=>50),
			array('fecha, harribo, hzarpe, comenatrio, fechazarpe, fechaarribo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codep, id, semana, fecha, harribo, hzarpe, codplantadestino, codplantazarpe, declarada, descargada, d2, codzarpe, r1, r2, r3, r4, r5, r6, r7, r8, r9, r10, r11, r12, zona, idespecie, idtemporada, comenatrio, latitud, meridiano, zonapesca, evento, fechazarpe, fechaarribo, descargada1, capbodega, motivozarpe, cuentahoras, nomespecie, nomep, cbodega, desplantazarpe, plantadestino', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codep' => 'Codep',
			'id' => 'ID',
			'semana' => 'Semana',
			'fecha' => 'Fecha',
			'harribo' => 'Harribo',
			'hzarpe' => 'Hzarpe',
			'codplantadestino' => 'Codplantadestino',
			'codplantazarpe' => 'Codplantazarpe',
			'declarada' => 'Declarada',
			'descargada' => 'Descargada',
			'd2' => 'D2',
			'codzarpe' => 'Codzarpe',
			'r1' => 'R1',
			'r2' => 'R2',
			'r3' => 'R3',
			'r4' => 'R4',
			'r5' => 'R5',
			'r6' => 'R6',
			'r7' => 'R7',
			'r8' => 'R8',
			'r9' => 'R9',
			'r10' => 'R10',
			'r11' => 'R11',
			'r12' => 'R12',
			'zona' => 'Zona',
			'idespecie' => 'Idespecie',
			'idtemporada' => 'Idtemporada',
			'comenatrio' => 'Comenatrio',
			'latitud' => 'Latitud',
			'meridiano' => 'Meridiano',
			'zonapesca' => 'Zonapesca',
			'evento' => 'Evento',
			'fechazarpe' => 'Fechazarpe',
			'fechaarribo' => 'Fechaarribo',
			'descargada1' => 'Descargada1',
			'capbodega' => 'Capbodega',
			'motivozarpe' => 'Motivozarpe',
			'cuentahoras' => 'Cuentahoras',
			'nomespecie' => 'Nomespecie',
			'nomep' => 'Nomep',
			'cbodega' => 'Cbodega',
			'desplantazarpe' => 'Desplantazarpe',
			'plantadestino' => 'Plantadestino',
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
		$criteria->compare('r1',$this->r1);
		$criteria->compare('r2',$this->r2);
		$criteria->compare('r3',$this->r3);
		$criteria->compare('r4',$this->r4);
		$criteria->compare('r5',$this->r5);
		$criteria->compare('r6',$this->r6);
		$criteria->compare('r7',$this->r7);
		$criteria->compare('r8',$this->r8);
		$criteria->compare('r9',$this->r9);
		$criteria->compare('r10',$this->r10);
		$criteria->compare('r11',$this->r11);
		$criteria->compare('r12',$this->r12);
		$criteria->compare('zona',$this->zona,true);
		$criteria->compare('idespecie',$this->idespecie);
		$criteria->compare('idtemporada',$this->idtemporada);
		$criteria->compare('comenatrio',$this->comenatrio,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('meridiano',$this->meridiano,true);
		$criteria->compare('zonapesca',$this->zonapesca,true);
		$criteria->compare('evento',$this->evento,true);
		$criteria->compare('fechazarpe',$this->fechazarpe,true);
		$criteria->compare('fechaarribo',$this->fechaarribo,true);
		$criteria->compare('descargada1',$this->descargada1);
		$criteria->compare('capbodega',$this->capbodega);
		$criteria->compare('motivozarpe',$this->motivozarpe,true);
		$criteria->compare('cuentahoras',$this->cuentahoras,true);
		$criteria->compare('nomespecie',$this->nomespecie,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('cbodega',$this->cbodega);
		$criteria->compare('desplantazarpe',$this->desplantazarpe,true);
		$criteria->compare('plantadestino',$this->plantadestino,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}