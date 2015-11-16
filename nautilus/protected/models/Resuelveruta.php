<?php

/**
 * Esta es una clase para resilver lsa rutas de los 
 *  archivos de imagenes y 
 * 
 * @property string $n_direc
 */
class Resuelveruta  
{
	/**
	 *
	 */
	 
	public $ruta ; //La ruta a arreglar
	
	
	/**
	 * @return string the associated database table name
	 */
	
	public function __construct($pruta) {
				$this->codigosap=trim($pruta);
				//$this->rutadearchivos=trim($pruta);
				//$this->extension=trim($pextension);
			//	$this->rutarelativa=Yii::app()->params['rutafotosinventario_'];
				
				
				}
	 
	
	
   public static function ArreglaRuta($path)
    {
        $runningOnWindows = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
        $slash = $runningOnWindows ? '\\' : '/';
        $wrongSlash = $runningOnWindows ? '/' : '\\' ;
        return (str_replace($wrongSlash, $slash, $path));
    }
	
	
	
	
	}