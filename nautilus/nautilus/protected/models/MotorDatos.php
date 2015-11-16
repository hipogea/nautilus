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
class MotorDatos 
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
	
	
	/**
	 * @return string the associated database table name
	 */
	
/*	public function __construct($pcsap,$pruta,$pextension) {
				$this->codigosap=trim($pcsap);
				$this->rutadearchivos=trim($pruta);
				$this->extension=trim($pextension);
			//	$this->rutarelativa=Yii::app()->params['rutafotosinventario_'];
		*/		
				
			
	public  function BaseDatos() {
	            
				//Yii::app()->db->connectionString
			//	$this->rutarelativa=Yii::app()->params['rutafotosinventario_'];
				$retazo=explode(':',':'. Yii::app()->db->connectionString);
				//return $retazo[1];
				print_r( Yii::app()->db->schema->tableNames);
				} 
				
				
				

	
	}