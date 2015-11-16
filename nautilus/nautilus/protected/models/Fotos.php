<?php

/**
 * This is the model class for table "inventario".
 *
 * The followings are the available columns in table 'inventario':
 * @property string $idinventario
 * @property string $codigo
 * @property string $c_estado
 * @property string $codep
 * @property string $comentario
 * @property string $fecha
 * @property string $coddocu
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $codlugar
 * @property string $codigosap
 * @property string $codigoaf
 * @property string $descripcion
 * @property string $marca
 * @property string $modelo
 * @property string $serie
 * @property string $clasefoto
 * @property string $codigopadre
 * @property string $numerodocumento
 * @property string $adicional
 * @property string $codigoafant
 * @property string $posicion
 * @property string $codcentro
 * @property string $codcentrooriginal
 * @property string $codeporiginal
 * @property string $rocoto
 * @property string $codepanterior
 * @property string $codcentroanterior
 * @property string $clase
 * @property string $baja
 * @property string $n_direc
 */
class Fotos  
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventario the static model class
	 */
	 
	public $codigosap ; //el codigo del archivo a poner correlativo 
	public $rutadearchivos;  //la ruta de la carpera a nalizar
	public $extension; //guarad ala exotension delos archivos 
	public $rutarelativa;
	
	private function existe($foto)  {
		 if (file_exists($this->rutadearchivos.$foto)) {
			 return true;
			 
		 } else {
			 //throw new CHttpException(500,__CLASS_.'-'.__FUNCTION__.'    El archivo solicatdo no existe.');
			 return false;
		 }
		
		
	}
	
	public function errorexiste(){
		throw new CHttpException(500,__CLASS_.'-'.__FUNCTION__.'    El archivo soliciatdo no existe.');
	}
	
	
	public static  function devuelvenombresolo($foto) {
		
			  if(strpos($foto,"_")>0){
				  $nombre=substr($foto,0,strpos($foto,"_"));
			  }
			  else {
				  $nombre=substr($foto,0,strpos($foto,"."));
			  }
			     
			 return $nombre;
		 
		
	}
	
	
	/**
	 * @return string the associated database table name
	 */
	
	public function __construct($pcsap,$pruta,$pextension) {
				$this->codigosap=trim($pcsap);
				$this->rutadearchivos=trim($pruta);
		$pextension=trim($pextension);
		       if(substr($pextension,0,1)!='.')
				   $pextension='.'.trim($pextension);
				$this->extension=trim($pextension);

			//	$this->rutarelativa=Yii::app()->params['rutafotosinventario_'];
				
				
				}
	 
	 
	public  function devuelveFotos()
	{
		//ruta del directorio a escanear
		//$directory = "../images/team/harry/";

//obtiene todos los archivos de extensión "jpg"
		$fotos = glob($this->rutadearchivos."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
        $nuevasfotos=array();
		 foreach($fotos as $clave=>$fotito){
			 //obteniendo el nombre de archivo
			  $nombrefoto=array_pop(explode(DIRECTORY_SEPARATOR,$fotito));
			    if(strpos($nombrefoto,'_')>0) {
					$nombrefoto = substr ( $nombrefoto , 0 , strpos ( $nombrefoto , '_' ) );
				}else {
					$nombrefoto = substr ( $nombrefoto , 0 , strpos ( $nombrefoto , '.' ) );
				}


			 if($nombrefoto.''==$this->codigosap.'')
			  $nuevasfotos[]=substr($fotito,strpos($fotito,yii::app()->baseUrl));

		 }
//imprime el nombre de cada archivo

	   /* $foto=$this->codigosap.$this->extension;
	  if (file_exists($this->rutadearchivos.$foto)) {
		    $fotos=array($this->codigosap.$this->extension);
	  } else {
		  $fotos=array();
	  }
	 
		//$ruta=Yii::app()->params['rutafotosinventario_'];
		//$ruta1=Yii::app()->params['rutafotosinventario'];
		for ($i = 1; $i <= 100; $i++) {
		           $foto=$this->codigosap."_".trim(strval($i)).$this->extension;
		       if (file_exists($this->rutadearchivos.$foto)) {
						//echo"D:/web/motoristas/assets/FOTOS/".$foto."<BR>";
						array_push($fotos,$foto);
						//echo $this->rutadearchivos.$foto;
				}
				// array_push($fotos,trim($model->codigosap)."-".trim($i).".JPG");
			}
		if (count($fotos)==0)	
			$fotos[]="NOFOTO.JPG";

	  */
			
		return $nuevasfotos;
		
	}

	public  function buscavalor($nombrecampo,$vvalor,$ordencampo,$relaciones)
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		//$relaciones=$this->relations();
		//$matriz= $this->relations();
		//return $matriz[1][2];
		$eureka="idgd";
		foreach ($relaciones as $clave => $valor) {
							foreach ( $relaciones[$clave] as $clave2=>$valor2 ) {
												//echo $valor2."<br>";
											if ($valor2==$nombrecampo) {
												$mitabla=  $relaciones[$clave][1];
												$aliastabla=$clave;
											 // break;
											}
										
								}
		
						}
				$cadena="\$mimodelo=".$mitabla."::model()->findBypK('".$vvalor."');";
				eval($cadena);
				//Verofocando que sea un valor valido que se enjcuentre n la tabla foranea:
				if (is_null($mimodelo)) {
						$this->adderror('coddocu','El valor ingresado no existe ');
						echo "--";
									} else 		{
													$adel=$mimodelo->attributeNames();
				//echo $adel[1];
													$cadena="echo \$mimodelo->".$adel[$ordencampo].";";
												eval($cadena);
										}	
				
				
				
	}
   
	
	
	
	
	public  function devuelveFotosGaleria($tamanoenpixeles)
	{
	 
        $rutaalternativa=Resuelveruta::Arreglaruta(Yii::app()->baseUrl.Yii::app()->params['rutainternafotos']) ;	  
          $rutarelativa=Resuelveruta::Arreglaruta(Yii::getPathOfAlias(Yii::app()->params['aliasfotosinventario']).DIRECTORY_SEPARATOR);
		//ECHO $rutarelativa."<br>";
		//echo     $rutaalternativa;
		// ECHO  Yii::getPathOfAlias('webroot.assets.FOTOS');
		//ECHO  DIRECTORY_SEPARATOR;
		//ECHO  DIRECTORY_SEPARATOR;
		//echo 
	 $fotosg=array(CHtml::image( $rutaalternativa.$this->codigosap.$this->extension,'1', array ('width'=>$tamanoenpixeles,'height'=>$tamanoenpixeles )));
		//$ruta=Yii::app()->params['rutafotosinventario_'];
		//$ruta1=Yii::app()->params['rutafotosinventario'];
		for ($i = 1; $i <= 100; $i++) {
		               //echo $this->rutadearchivos.$this->codigosap."_".trim(strval($i)).$this->extension."<br>";
					 //  echo $this->rutarelativa.$this->codigosap."_".trim(strval($i)).$this->extension."<BR>";
			     // echo $rutarelativa.$this->codigosap."_".trim(strval($i)).$this->extension."<BR>";
			 if (file_exists($rutarelativa.$this->codigosap."_".trim(strval($i)).$this->extension)) {
						
						
						array_push($fotosg,CHtml::image( $rutaalternativa.$this->codigosap."_".trim(strval($i)).$this->extension,'1', array ('width'=>$tamanoenpixeles,'height'=>$tamanoenpixeles )));
		  
						//echo $this->rutadearchivos.$foto;
				}
				// array_push($fotos,trim($model->codigosap)."-".trim($i).".JPG");
			}
		return $fotosg;
		
	}
	
	
	
	
	public function siguiente_numero()
	{
	
	   if (file_exists($this->rutadearchivos.$this->codigosap.$this->extension)) 
				{
				 for ($i = 1; $i <= 100; $i++)
						{
									$foto=$this->codigosap."_".trim(strval($i)).$this->extension;
									if (!file_exists($this->rutadearchivos.$foto)) 
									{		           
																				break;
						//echo"D:/web/motoristas/assets/FOTOS/".$foto."<BR>";
						//array_push($fotos,$foto);
									}
				// array_push($fotos,trim($model->codigosap)."-".trim($i).".JPG");
						}
						return $foto;
					
				} else {
				  return $this->codigosap.$this->extension;
				}	
		
	}
	
	
	}