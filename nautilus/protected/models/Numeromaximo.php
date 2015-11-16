<?php


class Numeromaximo 
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


	///Pinta una imagen verificando primiero sius existe
	//EN caos de nos exiostor colocar una imagen generica

public function Pintaimagen($rutarelativaimg,$rutaimganonima,$ancho=null,$alto=null){
if(file_exists(Yii::getPathOfAlias('webroot').$rutarelativaimg)){
 echo CHtml::image(Yii::app()->baseUrl.$rutarelativaimg,'',array("width"=>$ancho,"height"=>$alto));
} ELSE {
	echo CHtml::image(Yii::app()->baseUrl.$rutaimganonima,'',array("width"=>$ancho,"height"=>$alto));
}
}

	/**
	 * @return string the associated database table name
	 */
		
	public  function BaseDatos() {
	            
				//Yii::app()->db->connectionString
			//	$this->rutarelativa=Yii::app()->params['rutafotosinventario_'];
				$retazo=explode(':',':'. Yii::app()->db->connectionString);
				//return $retazo[1];
				print_r( Yii::app()->db->schema->tableNames);
				} 
				
		public  static function numero($modelito,$campo,$aliascampo,$anchocampo,$campocriterio=NULL,$campocriterio2=null,$prefijo=null) {
			//$this->numkardex=$gg->numero($this,'correlativ','maximovalor',12,'codmov');
			//$this->numero=$gg->numero($this,'correlativ','maximovalor',7,'codocu');
				//$campo : es el campo en el cual se va a sacar el valor maximo de la tabla segun u criterio o 2 segun se hayan 
				//         definido en los campos $campocriterio y $campocriterio2
				//$campocriterio: El criterio WHERE que filtra a los valores de $campo 
				//$campocriterio2: El criterio AND  que filtra a los valores de $campo y where de $criterio
	  
					$criteria=new CDbCriteria;
					$criteria->select='max('.$campo.') AS '.$aliascampo.'';
					 if (!is_null($campocriterio))
					 	 $criteria->addCondition(" ".$campocriterio."='".$modelito->{$campocriterio}."' ");
					 if (!is_null($campocriterio2))
					 	 $criteria->addCondition(" ".$campocriterio2."='".$modelito->{$campocriterio2}."' ");
						
					
					$row = $modelito->model()->find($criteria);  ///el resultado de efectuar el maximo valor de la tabla 
					$somevariable =is_null($row)?1:$row[$aliascampo]+1;	 //a esto se le agrega uno mas
					
					$modelito->{$campo}=(gettype($modelito->{$campo})=='string')?$somevariable.'':$somevariable;
					if(!is_null($campocriterio) ){
					 return  $modelito->{$campocriterio}.str_pad($somevariable.'',$anchocampo,"0",STR_PAD_LEFT);
					    } else {
					    	 return str_pad($somevariable,$anchocampo,"0",STR_PAD_LEFT);

					    }
						
						Yii::app()->end();
			//return "0000000000".$somevariable;
	}
		                 
  public  function numero_aleatorio($inicio,$final) {		
				mt_srand (time());	
				
				 return  mt_rand($inicio,$final);

							}

  public  function numerounico() {		
					
				
				 return  microtime(TRUE)*10000;

							}						


	public function bloquea($id,$codigodoc)	{

		$criterio=New CDbCriteria();
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser =:vusuario");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		  if(is_null($block)) {
			  $block=New Bloqueos;
			  $block->codocu=$codigodoc;
			  $block->iduser=Yii::app()->user->id;
			  $block->fechabloqueo=date("Y-m-d H:i:s");
			  $block->iddocu=$id;
			  $block->ip=Yii::app()->request->userHostAddress;
			  if(!$block->save()){
				  throw new CHttpException(500,' no se grabo el blqouoe');

				  return true;
		 			 } else {
			 			 return false;  /// nos epudo bloquear;
		 				 }
		  } else {
			  return false;  /// ya esta blqoeuado
		  }
	}


	public function establoqueado($id,$codigodoc)	{

		$criterio=New CDbCriteria;
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser = :vusuario");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		if(!is_null($block)) { ///Tendremos que revisar la sesion del usuario que esta ocupando
			$elusuario=Yii::app()->user->um->LoadUserById($block->iduser);
			///hallando la sesion activa de este usuario
			$sesion_activa=Yii::app()->user->um->findSession($elusuario);
			if(is_null($sesion_activa)) {
				return null;
			}  else {
				return $block;
				//echo "  Estaa cupado por el usuario ".$elusuario->username;  ///Si esta ocupado por que el usuario tiene sesion activa, y eszta editando
			}

		} else {
			return null;
		}
	}





	/*Verifica que estas modificando tu mismo el documento
	*  Valido cuando recargas la pagina e invocas al evento UPDATE (Por las huevas ) , esto sucede cuando el usuario  deliberada o casualmente refresca la pagina ,
	 * En plena EDICION o modificacion de un documento
	 *  Se fija si el bloqueo del usuario esta activo
	 */
	public function estasensesion($id,$codigodoc)	{

		$criterio=New CDbCriteria;
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser =:vusuario ");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		if(!is_null($block)) {
                 return $block->iddocu ; ///Sui existe bloqueo, estas en sesion
		} else {
			return false;  /// NO hay blqieo esta libre no hay sesion
		}
	}




	public function desbloquea($id,$codigodoc)	{

		$criterio=New CDbCriteria;
		$criterio->addcondition(" codocu=:vdocu AND iddocu=:vid AND iduser =:vusuario ");
		$criterio->params=array(":vdocu"=>$codigodoc,":vid"=>$id, ":vusuario"=>Yii::app()->user->id);
		$block=Bloqueos::model()->find($criterio);
		if(!is_null($block)) {

			if($block->delete()){
				return true;
			} else {
				return false;  /// nos epudo bloquear;
			}
		} else {
			return true;  /// NO hay blqieo esta linre
		}
	}





	public  function cambiomoneda($monedainicial,$monedadestino) {
	                  $modelmoneda=Tipocambio::model()->find(" codmon1='".$monedainicial."' and codmon2='".$monedadestino."' ");
	                  if (!is_null($modelmoneda)) {

	                  	   return ($modelmoneda->numerador/$modelmoneda->denominador);

	                     }else {
	                     	throw new CHttpException(404,'No se ha encontrado el tipo de cambio');
						 		                     	  		
	                     }					
				
				 

							}						
							
							
							
		
				} 
		
	


	
	
	
	
	