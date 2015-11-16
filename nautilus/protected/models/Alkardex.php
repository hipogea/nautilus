<?php
const CODIGO_DOCUMENTO_COMPRAS='210';
const CODIGO_DOCUMENTO_DETALLE_COMPRA='220';

class Alkardex extends ModeloGeneral
{
	/**
	 * Regresa el valor de la cantidad equivalente a la unidad de medida en
	 * en inventario,   OJO regresa con todo signo
	 * ES LA CANTIDA DE LA UNIDA DD EMEDIDA BASE
	 */
	public  function  cantidadbase(){
     return $this->cant*Alconversiones::convierte($this->codart,$this->um);

    }
	public  function  preciounitariobase($codmoneda){

	          if($codmoneda==$this->alkardex_alinventario->almacen->codmon){
				  //yii::app()->settings->get('general','general_monedadef'))
				  $conversionmoneda=1;
			  }	else {
				  $conversionmoneda=yii::app()->tipocambio->getcambio($codmoneda,$this->alkardex_alinventario->almacen->codmon);

			  }

		return $this->preciounit*$conversionmoneda/Alconversiones::convierte($this->codart,$this->um);
	}
	/**
	 * Regresa el valor deL MONTO MOVIDO
	 * EL PRECIO UNITARIO LO SACA DEL INVENTARIO , PUED DSER (+)  (-), TODO EXSPRESADO EN MONEDA BASE , CONVIERTE AUTOAMTICAMENTE
	 * observe que paraq anulaciones de vales idkardex <> null ; NO SE REALIZA LA CONVERSION ESTA DEMAS , TODO ES IGUAL AL KARDEX ORIGINAL
	 * EN OTRO CASO CADA QUE ANULAN UN VALE , estarian perdiendo por tipo de cambio
	 */
	public  function getMonto($idkardex=NULL){
		$conversionmoneda=yii::app()->tipocambio->getcambio($this->alkardex_alinventario->almacen->codmon,yii::app()->settings->get('general','general_monedadef'));

		if(is_null($idkardex)){
			RETURN $this->alkardex_alinventario->punit*$conversionmoneda*$this->cantidadbase();
		} else {
			return Self::model()->findByPk($idkardex)->preciounit*$conversionmoneda*$this->cantidadbase();

		}

	}



	public  function getPreciounitario(){
		RETURN $this->alkardex_alinventario->punit;
	}



	/**
	 * Regresa el valor de LA CANTIDAD consiugnad en el registro detalle de compra
	 * 	 */
	public static function cantidadcomprada($idref){
		$modelo=Docompra::model()->findBypK($idref);
		if(is_null($modelo)){
			return $modelo->cant;
		} else {
			throw new CHttpException(500,__CLASS__.'->'.__FUNCTION__.'Intento buscar en una docompra que no existe ');

		}
	}


	/**
	 * Regresa el valor de LA CANTIDAD consiugnad en el registro detalle de LA RESERVA
	 * OJO QUE AUIQ SE TINEN  QUE FIJAR SUI ES UNA SOLPE PARTIDA EN RESERVA +RESERVA PARA COMPRA
	 * 	 */
	public static function cantidadreservada($idref){
	$modelox=Desolpe::model()->findBypK($idref);
		$canti=null;
		foreach($modelox->desolpe_alreserva as $row)
		{
			if($row->codocu=='450')
			{
				$canti=$row->cant;
				break;
			}
		}


	if(!is_null($modelox)){
		return $canti;
	} else {
		throw new CHttpException(500,__CLASS__.'->'.__FUNCTION__.'Intento buscar en una DESOLpe que no existe el id= '.$idref);
	}
   }

public function mueveadicionales(){
	$monedacompras=null;
	/*var_dump($this->codocuref);
	var_dump(ARRAY(CODIGO_DOCUMENTO_COMPRAS,CODIGO_DOCUMENTO_DETALLE_COMPRA ));
	yii::app()->end();*/
	if(in_array($this->codocuref,ARRAY(CODIGO_DOCUMENTO_COMPRAS,CODIGO_DOCUMENTO_DETALLE_COMPRA )))
		$monedacompras=Ocompra::model()->find("numcot=:ndoc",array(":ndoc"=>$this->numdocref))->moneda;
	/*var_dump($monedacompras);
	yii::app()->end();*/
	$monedamain=yii::app()->settings->get('general','general_monedadef');
	switch ($this->codmov) {
		case "10":
			$this->InsertaAtencionReserva();
			$ceco=Desolpe::model()->findByPk($this->idref)->imputacion;
			$this->InsertaCcGastos($ceco);
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),null);
			break;
		case "20":
			$this->InsertaAtencionReserva();
			$ceco=Desolpe::model()->findByPk($this->idref)->imputacion;
			$this->InsertaCcGastos($ceco);
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),null);
			break;break;

		case "30": //INGRESO COMPRA
			$this->InsertaAlentregasCompras();
			///obteniendo la moneda del documento de COMPRAS
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),$this->preciounitariobase($monedacompras));
			break;

		case "40": //ANULAR INGRESO COMPRA
			$this->InsertaAlentregasCompras();
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),null);
			break;

		case "79":
			$this->preciounit=$this->getMonto();
			$this->InsertaAtencionReserva();
			$ceco=Dpeticion::model()->findByPk($this->idref)->imputacion;
			$this->InsertaCcGastos($ceco);
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),null);
			break;
		case "81":
			$this->preciounit=$this->getMonto();
			$this->InsertaAtencionReserva();
			$ceco=Dpeticion::model()->findByPk($this->idref)->imputacion;
			$this->InsertaCcGastos($ceco);
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),null);
			break;
		case "98":
			$moneda=$this->alkardex_alinventario->almacen->codmon;
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),$this->preciounitariobase($moneda));
			break;
		case "89":
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),$this->preciounitariobase(yii::app()->settings->get('general','general_monedadef')));
			break;
		case "60":
			echo "Your favorite color is green!";
			break;
		case "77": //inica traslado

			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),null);
			break;
		case "78": //acepta el traspaso
			$thisoriginal=Alkardex::model()->findByPk($this->idref); ///cone sto busca el kardex del almacen emisor
			//verifica la consistencia
			$thisoriginal->InsertaAlkardexTraslado($this->cant);
			// $thisoriginal->getMonto();
			$movimientoauxiliar='45';
			$thisoriginal->alkardex_alinventario->actualiza_stock($movimientoauxiliar,abs($this->cantidadbase()),null);
			//verificamos la moneda del almacen que emite
			$moneda=$thisoriginal->alkardex_alinventario->almacen->codmoneda;
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()),$this->preciounitariobase($moneda));

			break;

		case "70": //reingreso

			//primero que nada el reingreso usa como referencia el vale de salida
			$kardorigen=Almacendocs::model()->findByPk($this->idref);
			//Siemrpe que no se ahya reingresado el total
			if($kardorigen->cant < $kardorigen->reingreso_cant) {
				$kardorigen->InsertaReingreso();
				$ceco=CcGastos::model()->find("hidref=:vid",array(":vid"=>$this->id));
				$this->InsertaCcGastos($ceco);
				$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()));

			}


			break;

		case "50": //salida para ceco
			$this->InsertaCcGastos($this->colector);
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()));
			break;

		case "60": //Anula salida para ceco
			$this->InsertaCcGastos($this->colector);
			$this->alkardex_alinventario->actualiza_stock($this->codmov,abs($this->cantidadbase()));
			break;
		default:
			throw new CHttpException(500,__CLASS__.'  '.__FUNCTION__.'  No se ha definido este codigo de movimiento');
	}
}

public function InsertaReingreso(){

		$reing=New Reingreso;
		$reing->setAttributes(array('hidkardex'=>$this->id,'cant'=>$this->cant));

}


	
	
	
	public function afterSave() {
		
		$this->mueveadicionales();
		
		return parent::afterSave();
	}

	
	
	
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones
	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->codestado='10';


		} else
		{

			/* echo "saliop carajo";	//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
            */
		}
		return parent::beforesave();
	}
	
	
	
private function devuelvereserva(){
	$modelosolpe=Desolpe::model()->findByPk($this->idref);
	//$reserva=$modelosolpe->desolpe_alreserva;
	if(is_null($modelosolpe))
		throw new CHttpException(500,__CLASS__.' - '.__FUNCTION__.'   Error no se pudo encontrar el detalle de Solpe ');
	//$cantacumulada=$modelosolpe->desolpe_alreserva[0]->alreserva_cantidadatendida;
	$reserva=Alreserva::model()->find("hidesolpe=:vidsolpe AND codocu in ('450','320') AND estadoreserva <> '30' ",array(":vidsolpe"=>$modelosolpe->id));
	if(is_null($reserva))
		throw new CHttpException(500,__CLASS__.' - '.__FUNCTION__.'   Error no se pudo encontrar la reserva asociada a la desolpe');
	return $reserva;
}




	/**
	 * Verifica si es posibel agregar o quitar atenciones a la reserva
	 *
	 * 	 */
	public function VerificaCantAtenReservas (){
		$retorno=false;
		$cantsolicitada=self::cantidadreservada($this->idref);
		$cantacumulada=$this->devuelvereserva()->alreserva_cantidadatendida;

		//var_dump($this->devuelvereserva());
		//yii::app()->end();
		$cantmovida=$this->cant;
		//$signomovimiento=$this->alkardex_almacenmovimientos->signo;
           $retorno=false;
		if($cantmovida < 0)
		{//// Es una salida de almacen, cantidad movida negativa,
			////PARA LA ATENCION DE LAS RESERVA ES POSITIVA QUIERE DECIR QUE AUMENTA
			///DEBSMO ASEGURARNOS QUE NO SOBREPASE LO SOLICITADO
			    if(abs($cantmovida) > $cantsolicitada -$cantacumulada){
					//$this->insertamensaje(InventarioUtil::FLAG_ERROR,"No puede atender mas de lo que ha solicitado, ya se paso");
					//MiFactoria::Mensaje('error',__CLASS__.'-'.__FUNCTION__.'  Material '.$this->codart.' No puede atender '.($cantmovida+$cantacumulada).'  .   mas de lo que ha solicitado '.$cantsolicitada.', ya se paso; cant acumulada : '.$cantacumulada);
					$retorno=false;
				}	else {
					$retorno=true;
				}

		}	else { ///Es un ingreso al almacen, entonces la cantidad es negativa
			 ///PARA LA ATENCION DE LA RESERVA ES NEGATIVA
			  //DEBEMOS ASEGURARNOS QUE NO RESTE MAS DE LO QUE SE HA ACUMULADO
			if($cantmovida > $cantacumulada){
				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,"No puede ingresar mas de lo que ha ya atendido ");
				//MiFactoria::Mensaje('error',__CLASS__.'-'.__FUNCTION__.'  Material '.$this->codart.' No puede ingresar '.($cantmovida+$cantacumulada).'      mas de lo que ha solicitado '.$cantsolicitada.', ya se paso    ; cant acumulada : '.$cantacumulada);

				$retorno=false;
			}else {
				$retorno=true;
			}

		}
     return $retorno;

	}

	/**
	 * Verifica si es posibel agregar o quitar atenciones a la as entrwgas o compras
	 *
	 * 	 */

	public function VerificaCantAtenCompras (){
		$cantsolicitada=self::cantidadcomprada($this->idref);
		$cantacumulada=$this->cantcompras;
		$cantmovida=$this->cant;
		//$signomovimiento=$this->alkardex_almacenmovimientos->signo;

		if($cantmovida < 0)
		{	//es una devolucion decompras , sign nmegativo
			//DEBEMOS ASEGURARNOS QUE NO RESTE MAS DE LO QUE SE HA ACUMULADO
			if(abs($cantmovida) > $cantacumulada){
				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,"No puede devolver mas de lo que ha ingresado POR COMPRA ");
				//MiFactoria::Mensaje('error','Material '.$this->codart.' No puede devolver  '.($cantmovida).'mas de lo que ha comprado '.$cantsolicitada.', ya se paso');

				$retorno=false;
			}


		}	else { //sIGNO POSITIVO, ES UN IMGRESO DE COMPRAS AL INVENTARIO
			///DEBSMO ASEGURARNOS QUE NO SOBREPASE LO COMPRADO
			if($cantmovida > $cantsolicitada -$cantacumulada){
				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,"No puede atender mas de lo que ha COMPRADO, ya se paso");
				//MiFactoria::Mensaje('error','Material '.$this->codart.' No puede atender '.($cantmovida+$cantacumulada).'mas de lo que ha solicitado '.$cantsolicitada.', ya se paso');

				$retorno=false;
			}

		}


	}

	/**
	 *Obiene la cantidad trasladada
	 *
	 * 	 */
/*public static function cantidadtrasladada($idref) {
	return Alkardex::model()->findByPk($idref)->cant;
}*/

	/**
	 * Verifica si es posibel agregar o quitar  a la tabla alkardex taslada
	 *
	 * 	 */
	public function VerificaCantTrasladoDestino ($cantidaddelkardex){
		$canttotaltrasladada=$this->cant;
		$cantacumulada=$this->alkardex_alkardextraslado_emisor_cant;
		$cantmovida=$cantidaddelkardex;
		//$signomovimiento=$this->alkardex_almacenmovimientos->signo;

		if($cantmovida < 0)
		{	//es una ANULACION DE LA ACEPTACION DEL TRASPASO , NEGATIVA
			//DEBEMOS ASEGURARNOS QUE NO RESTE MAS DE LO QUE SE HA ACUMULADO
			if(abs($cantmovida) > $cantacumulada){
				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,"No puede devolver mas de lo que ha TRASLADADO (ACUMULADO) ");
				MiFactoria::Mensaje('error','Material '.$this->codart.' No puede devolver '.($cantmovida+$cantacumulada).'mas de lo que ha trasladado '.$canttotaltrasladada.', ya se paso');

				$retorno=false;
			} else {
				$retorno=true;
			}


		}	else { //sIGNO POSITIVO, ES UNA ACEPTACION DEL TRASALDAO
			//MiFactoria::Mensaje('error','ESTO ES UNA PRUENA  CANTMOVIDA '.$cantmovida.'  cantacumulada '.$cantacumulada.'   lo trasladado '.$canttotaltrasladada.',');

			///DEBSMO ASEGURARNOS QUE NO SOBREPASE LO QUE SE TRASLADO ORIGINALEMTNE
			if($cantmovida > $canttotaltrasladada -$cantacumulada+0){
				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,"No puede INGRESAR MAS DE LOS QUE SE  ha TRASLADADO, ya se paso");
				//MiFactoria::Mensaje('error','Material '.$this->codart.' No puede ingresar '.($cantmovida+$cantacumulada).'mas de lo que se ha trasladado '.$canttotaltrasladada.', ya se paso');

				$retorno=false;
			} else {
				$retorno=true;
			}
     return $retorno;
		}


	}

	public function InsertaAtencionReserva(){
		if ($this->VerificaCantAtenReservas()){

			if ($this->codmov=='79' OR $this->codmov=='81'){ ///Si es ventas
				$tipodoc='310'; //RreEERVA PARA VENTA
			} elseif($this->codmov=='10'  OR $this->codmov=='20' ){ //7Sies comsumos de materialres
				$tipodoc='450'; //RreEERVA PARA CONSUMO        }
				$matrix= Alreserva::model()->findAll("hidesolpe=:vhidsolpe AND codocu='".$tipodoc."' ",array(":vhidsolpe"=>$this->idref));
				$model=new Atencionreserva();
				$model->cant=-1*$this->cant;
				$model->hidkardex=$this->id;
				$model->hidreserva=$matrix[0]['id'];
				$model->estadoatencion=Atencionreserva::ESTADO_CREADO;
				if(!$model->save())
					throw new CHttpException(500,"NO se Pudo insertar el registro de atenciones reservas ");
				unset($model);unset($matrix);
				//self::Mensaje('success','Se inserta atencion reserva  '.$this->codart);
				//unset($row);
				return true;
			}




		} else {
			return null;
		}

	}

	//se debe de infgrear la cantida del  KARDEX RECEPTOR
	public function InsertaAlkardexTraslado($cantidad){
		if($this->VerificaCantTrasladoDestino ($cantidad)){
			MiFactoria::InsertaAlkardexTraslado($this->id,$cantidad);
		} else {

			MiFactoria::Mensaje('error', __CLASS__.'   '.__FUNCTION__.' HUBO UN PROBLEMA EN LA VERIFICAION DE LAS CANTIDADES');
			return null;
		}
	}

	public function InsertaAlentregasCompras(){

		$model=new Alentregas();
		$model->cant=$this->cant;
		$model->idkardex=$this->id;
		$model->iddetcompra=$this->idref;
		$model->estado=Alentregas::ESTADO_CREADO;
		if(!$model->save())
			throw new CHttpException(500,"NO se Pudo insertar el registro de atenciones compras ");
		unset($model);
	}

	public function InsertaCcGastos($ceco){
		//$row=self::CargaModelo('Alkardex',$idkardex);
		//$row=$filakardex;
		$model=new CcGastos();
		$model->ceco=$ceco;
		$model->fechacontable=$this->fecha;
		$model->monto=-1*$this->getMonto(); ///Es el opuesto de todo
		$model->iduser=Yii::app()->user->id;
		$model->tipo='M';
		$model->idref=$this->id;
		if(!$model->save())
			throw new CHttpException(500,"NO se Pudo insertar el registro de Costos ");
		//self::Mensaje('success','Se inserta los gastos  '.$model->monto.'  al ceco '.self::CargaModelo('Desolpe',$row->idref)->imputacion);
		unset($model);//unset($row);
	}


	public function InsertaCcGastosServ(){
		MiFactoria::InsertaCcGastosServ($this->id);
	}











	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['prefijo'].'alkardex';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cant', 'numerical'),
			array('codart', 'length', 'max'=>10),
			array('codmov, codestado, prefijo', 'length', 'max'=>2),
			array('alemi, aldes, coddoc, um, codocuref', 'length', 'max'=>3),
			array('numdoc, numdocref', 'length', 'max'=>15),
			array('usuario, creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel, comentario', 'length', 'max'=>20),
			array('codcentro', 'length', 'max'=>4),
			array('correlativo', 'length', 'max'=>12),
			array('numkardex', 'length', 'max'=>14),
			array('solicitante', 'length', 'max'=>18),
			array('fecha, fechadoc,valido,checki, hidvale', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codart, codmov, cant, alemi,lote, aldes,idref, fecha, coddoc, numdoc, usuario, creadopor, creadoel, modificadopor, modificadoel, um, comentario, codocuref, numdocref, codcentro, id, codestado, prefijo, fechadoc, correlativo, numkardex, solicitante, hidvale', 'safe', 'on'=>'search'),

			/*********ESCENARIO  GENERAL POR DFAULT   *******/

			array('cant', 'required'),
			array('codmov,hidvale,numdocref,codart,cant,alemi,codcentro,iduser, idusertemp, idstatus,
			fecha,codocuref,idref,preciounit,idtemp', 'safe'),
			/*********/



			/*********ESCENARIO   = SALIDARESERVA  *******/

			array('cant', 'required','on'=>'salidareserva'),
			array('codmov,hidvale,numdocref,codart,cant,alemi,codcentro,iduser, idusertemp, idstatus,
			fecha,codocuref,idref,preciounit', 'safe','on'=>'salidareserva'),
			/*********/

			/*********ESCENARIO   = CAMBIO D EEESTADO *******/
			array('codestado,valido', 'safe','on'=>'cambioestado'),
			/*********/
		
		
					/*********ESCENARIO   = CARGA INICIAL *******/
					array('codart', 'required','on'=>'cargainicial'),
					array('codart', 'checkcodigo','on'=>'cargainicial'),
					array('cant', 'required','on'=>'cargainicial'),
					array('um', 'required','on'=>'cargainicial'),
					array('um', 'checkum','on'=>'cargainicial'),
					array('codocuref,numdocref', 'required','on'=>'cargainicial'),

						array('codmov,hidvale,numdocref,codart,cant,alemi,codcentro,iduser, idusertemp, idstatus,
			fecha,codocuref,idref,preciounit','safe','on'=> 'cargainicial'),
					/*********/


			/*********ESCENARIO   = REINGRESO *******/
			//array('codart', 'required','on'=>'reingreso'),
			array('um', 'checkum','on'=>'reingreso'),
			array('cant', 'required','on'=>'reingreso'),
			array('idref', 'required','on'=>'reingreso'),
			array('um', 'required','on'=>'reingreso'),
			array('numdocref', 'required','message'=>'Debes de indicar el vale de salida','on'=>'reingreso'),
			array('numdocref', 'checknumerovale','on'=>'reingreso'),
			array('cant', 'chekcantreingreso','on'=>'reingreso'),
			array('codcentro,codalmacen,codart,cant,um,idref,numdocref', 'safe','on'=>'reingreso'),
			/*********/




			/*********ESCENARIO   = TRASPASO*******/
			array('codart', 'required','on'=>'traspaso'),
			array('codart', 'checkcodigo','on'=>'traspaso'),
			array('um', 'checkumgeneral','on'=>'traspaso'),
			array('cant', 'required','on'=>'traspaso'),
			array('cant', 'checkcantidad','on'=>'traspaso'),
			//array('idref', 'required','on'=>'traspaso'),
			array('um', 'required','on'=>'traspaso'),
			//array('numdocref', 'required','message'=>'Debes de indicar el vale de salida','on'=>'reingreso'),
			//array('numdocref', 'checknumerovale','on'=>'reingreso'),
			//array('cant', 'chekcantreingreso','on'=>'reingreso'),
			array('codcentro,codalmacen,codart,cant,um,codcendestino,codaldestino,preciounit', 'safe','on'=>'traspaso'),
			/*********/



			/*********ESCENARIO   = ingresoTRASPASO*******/
			//array('codart', 'required','on'=>'ingresotraspaso'),
			//array('codart', 'checkcodigo','on'=>'ingresotraspaso'),
			//array('um', 'checkumgeneral','on'=>'ingresotraspaso'),
			//array('cant', 'required','on'=>'ingresotraspaso'),
			//array('cant', 'checkcantidad','on'=>'ingresotraspaso'),
			//array('idref', 'required','on'=>'traspaso'),
			//array('um', 'required','on'=>'ingresotraspaso'),
			//array('numdocref', 'required','message'=>'Debes de indicar el vale de salida','on'=>'reingreso'),
			//array('numdocref', 'checknumerovale','on'=>'reingreso'),
			//array('cant', 'chekcantreingreso','on'=>'reingreso'),
			array('codcentro,codalmacen,codart,cant,um,codcendestino,codaldestino,preciounit', 'safe','on'=>'ingresotraspaso'),








					
					/*********ESCENARIO   = ANULAR CARGA INICIAL *******/
					array('codart', 'required','on'=>'anulacargainicial'),
					//array('codart', 'checkcodigo','on'=>'cargainicial'),
					array('cant', 'required','on'=>'anulacargainicial'),
					array('um', 'required','on'=>'anulacargainicial'),
					//array('um', 'checkum','on'=>'cargainicial'),
					array('preciounit', 'required','on'=>'anulacargainicial'),
					array('codcentro,codalmacen,codmov,fecha,fechadoc', 'safe','on'=>'anulacargainicial'),
					/*********/
		);
	}

	public function checkcantidad($attribute,$params) {
		if ($this->isNewrecord){

		$cantidadlibre=Alinventario::model()->encontrarregistro($this->codcentro,$this->alemi,$this->codart)->cantlibre;
		  }else {

			$cantidadlibre=$this->alkardex_alinventario->cantlibre;
		 }
		$conversion=Alconversiones::model()->convierte($this->codart,$this->um);
		if ($this->cant*$conversion > $cantidadlibre) {
			//$matriz2=Alconversiones::model()->findAll("um1='".trim($unidad)."'");
			$this->adderror('cant','No se puede mover : ['.$this->cant*$conversion.']   mas de los que hay en stock libre : ['.$cantidadlibre.'] ' );
		}
	}




	public function checkumgeneral($attribute,$params) {
		   $um=Maestrocompo::model()->findByPk($this->codart)->um;
		  if($this->um != $um  and is_null($um)) {
				//si no se encontro buscar en la tabla conversiones
				$matriz=Alconversiones::model()->findAll("um2='".trim($this->um)."' and codart='".trim($this->codart)."'");
				if (count($matriz)==0 ) {
					//$matriz2=Alconversiones::model()->findAll("um1='".trim($unidad)."'");
					$this->adderror('um','No hay conversiones para esta Um' );
				}
		     }
	}




	public function checkum($attribute,$params) {
		 if(!Alconversiones::validaum($this->codart,$this->um))
			 $this->adderror('um',' Esta unidad de medida no corresponde a este material');
	           }



public function chekcantreingreso($attribute,$params) {
	//verioficando los reingreso que hacen referencia al item del vale con el que salio el material ( original )
	//Estoq uiere decir para verificar que la suma de las cantidades reingresdas no debe exceder a la cantidad del item del vale de salida

	///verificando la suma de las cantidades
	$cantidadreingresada = Yii::app()->db->createCommand(" select sum(cant) as cantreingresada, idref from
 										".Yii::app()->params['prefijo']."alkardex
	       							  where codestado not in ('98','99')
	       							    and codmov='70' and
	       							   idref=".$this->idref."
										group by idref")->queryScalar();
	$cantidadoriginal = Yii::app()->db->createCommand(" select cant   from
 										".Yii::app()->params['prefijo']."alkardex
	       							  where codestado not in ('98','99') and
	       							   id=".$this->idref )->queryScalar();
	//query scalar deuelve false si no encuentra nada,  asi que nos aseguramos
 		if(!$cantidadreingresada)
			$cantidadreingresada=0;
	   if(!$cantidadoriginal)
		$cantidadoriginal=0;
	    //bien ya tenemos los reingresoas anteriores , ahora  la suma de estos mas la cantidad ingfresda no debe de excceder a
	     //a la cantidad original
	     if(abs($this->cant)+abs($cantidadreingresada) > abs($cantidadoriginal))
			 $this->adderror('cant','Con esta cantidad se ha excedido lo que salio, en el vale original->'.$this->idref."  cantidadingresada : ".$cantidadreingresada ." cant oriignal : ".$cantidadoriginal."   cant cant colocada ".$this->cant);
}
public function checknumerovale($attribute,$params) {
	///verificando el nuemro de vale
	$criteria = new CDbCriteria();
	$criteria->addCondition("numvale=:vnumvale",'AND');
	$criteria->addCondition("codmov in ('50','10')");
	$criteria->params=array(':vnumvale'=>trim($this->numdocref));
	//$valor=$_POST['Eventos']['codocu'];
	$registros=VwKardex::model()->findAll( $criteria);
	  if(count($registros)==0)
		$this->adderror('numdocref','El vale indicado no se ha encontrado o no es una vale de salida, verifique bien' );
}



	public function checkcodigo($attribute,$params) {

					$modelomaterial=Maestrocompo::model()->find("codigo=:codigox",array(":codigox"=>TRIM($this->codart)));
					if (is_null($modelomaterial)) {
												 $this->adderror('codart','Este material no existe' );
												} 

											else {
												    $modelocabecera=Almacendocs::model()->findByPk($this->hidvale);
													$modinventario=Alinventario::model()->find("codart='".trim($this->codart)."' AND codalm='".$modelocabecera->codalmacen."' AND codcen='".$modelocabecera->codcentro."'" );
   		         							 		if(is_null($modinventario))	{	
													//if($this->alkardex_alinventario===null) {
														$this->adderror('codart','Este material tiene que ser ampliado al centro -:  '.$modelocabecera->codcentro.' y almacen '.$modelocabecera->codalmacen.' ' );


													  } else {
													  	//veriicando la unidad de medida 
													  	if($this->um <> $modelomaterial->um) { //si es diferente a la unidad de medida base
													  			//revisar las conversiones
													  		$matrizunidades=Alconversiones::model()->findAll("codart=:codigox and um2=:unitas ",array(":codigox"=>TRIM($this->codart),":unitas"=>$this->um));
													  			if(count($matrizunidades)==0)
													  								$this->adderror('um','No existe conversiones para esta unidad de medida en este material ' );
													  					}

													  }
												

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
			'reingreso'=>array(self::HAS_MANY, 'Reingreso', 'hidkardex'),
			'reingreso_cant'=>array(self::STAT, 'Reingreso', 'hidkardex','select'=>'sum(t.cant)'),
			'codmov0' => array(self::BELONGS_TO, 'Almacenmovimientos', 'codmov'),
			'codcentro0' => array(self::BELONGS_TO, 'Centros', 'codcentro'),
			'coddoc0' => array(self::BELONGS_TO, 'Documentos', 'coddoc'),
			'codocuref0' => array(self::BELONGS_TO, 'Documentos', 'codocuref'),
			'maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'alkardex_atencionreservas'=>array(self::HAS_MANY, 'Atencionreserva', 'hidkardex'),
			'alkardex_atencionesreservas'=>array(self::STAT, 'Atencionreserva', 'hidkardex','select'=>'sum(t.cant)','condition'=>"estadoatencion <> '20'"),
			'alkardex_alentregas'=>array(self::HAS_MANY, 'Alentregas', 'idkardex'),
			'alkardex_almacendocs'=>array(self::BELONGS_TO, 'Almacendocs', 'hidvale'),
  	       'alkardex_almacenmovimientos'=>array(self::BELONGS_TO, 'Almacenmovimientos', 'codmov'),
			'alkardex_alkardextraslado_emisor'=>array(self::HAS_MANY, 'Alkardextraslado', 'hidkardexemi'),
			'alkardex_alkardextraslado_destino'=>array(self::HAS_MANY, 'Alkardextraslado', 'hidkardexdes'),
			'alkardex_alkardextraslado_emisor_cant'=>array(self::STAT, 'Alkardextraslado', 'hidkardexemi','select'=>'sum(t.cant)','condition'=>"codestado <> '30'"),
			'alkardex_alkardextraslado_destino_cant'=>array(self::STAT, 'Alkardextraslado', 'hidkardexdes','select'=>'sum(t.cant)','condition'=>"codestado <> '30'"),
			'cantcompras'=>array(self::STAT, 'Desolpecompra', 'iddesolpe','select'=>'sum(t.cant)','condition'=>"codestado <> '30'"),//el campo foraneo
			'alkardex_despacho'=>array(self::HAS_MANY,'Despacho','hidkardex'),
			//'alkardex_alkardextraslado_destino'=>array(self::HAS_MANY, 'Alkardextraslado', 'hidkardexdes'),
			//'alkardex_alinventario'=>array(self::BELONGS_TO, 'Alinventario', 'hidvale'),
			'alkardex_alinventario'=>array(self::BELONGS_TO,'Alinventario',array('codart'=>'codart','alemi'=>'codalm','codcentro'=>'codcen')),
			//'alkardex_alreserva'=>array(self::BELONGS_TO, 'Almacendocs', 'hidvale'),
			

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codart' => 'Codart',
			'codmov' => 'Codmov',
			'cant' => 'Cant',
			'alemi' => 'Alemi',
			'aldes' => 'Aldes',
			'fecha' => 'Fecha',
			'coddoc' => 'Coddoc',
			'numdoc' => 'Numdoc',
			'usuario' => 'Usuario',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'um' => 'Um',
			'comentario' => 'Comentario',
			'codocuref' => 'Codocuref',
			'numdocref' => 'Numdocref',
			'codcentro' => 'Codcentro',
			'id' => 'ID',
			'codestado' => 'Codestado',
			'prefijo' => 'Prefijo',
			'fechadoc' => 'Fechadoc',
			'correlativo' => 'Correlativo',
			'numkardex' => 'Numkardex',
			'solicitante' => 'Solicitante',
			'hidvale' => 'Hidvale',
		);
	}





	public function Clonaregistro()  {
		if(!$this->isNewRecord)	 {
			$nuevoregistro=New Alkardex();
			$nuevoregistro->attributes=$this->attributes;
			Return $nuevoregistro;
		} ELSE  {
			RETURN NULL;
		}

	}




    public function Actualizainventarioporcompras($codmovimiento= null) {
        //veriifcamos que es un valor promedio según la configruiacion
        // del material "precio variable"
        //$modelo=$this->loadModel($idinventario);
        //verificnado si la uinida de medida es la unidad de medida base

        // $this=
        //cargando el invietario
        $modeloinventario= Alinventario::model()->findByPk($this->alkardex_alinventario->id);
          if ($modeloinventario===null)
              throw new CHttpException(404,'No se pudo cargar el inventario con la llave:'.$this->alkardex_alinventario->id.'- '.$this->codart.'-'.$this->alemi.'-'.$this->codcentro);
        $cantidadmovida=$this->cant; ///siempre estara en unidad de medida base
        //$cantidadactual=$modeloinventario->cantlibre;

            $modeloinventario->setscenario('modificacantidad');
            $nuevoprecio=($this->preciounit*$cantidadmovida + $modeloinventario->punit*($modeloinventario->cantlibre+$modeloinventario->cantres+$modeloinventario->canttran ))/($cantidadmovida+$modeloinventario->cantlibre+$modeloinventario->cantres+$modeloinventario->canttran);
            $modeloinventario->punit=round($nuevoprecio,2);
            $modeloinventario->cantlibre=$modeloinventario->cantlibre+$cantidadmovida;

            return ($modeloinventario->save())?1:0;


    }

public function FrecuenciaMaterial($codmov,$codart,$fecha1=null,$fecha2=null){
    if(!is_null($fecha1))
        $fecha1 = Yii::app()->db->createCommand(" SELECT min(fechadoc) from public_alkardex ")->queryScalar();
    if(!is_null($fecha2))
        $fecha2 =date("Y-m-d H:i:s")."" ;

    $fecha1=$fecha1."";
    $fecha2=$fecha2."";

    ///Calculando los dias entre fechas
    $diaspasados=(strtotime($fecha2)-strtotime($fecha1))/(3600*24);

    //calculando el comsumo
    $consumo=Yii::app()->db->createCommand(" SELECT sum(cant) from public_alkardex where codestado <> '99' and codart= '".$codart."' and (fechadoc < '".$fecha2."' and fechadoc > '".$fecha1."' ) and codmov='".$codmov."' ")->queryScalar();

       if (is_null($consumo))
           $consumo=0;

        if($diaspasados==0 or is_null($diaspasados)) {
            return 0;

        }else {
            return $consumo/$diaspasados;

        }




}


public function Actualizaprecioinventario($codmovimiento= null) {
        //veriifcamos que es un valor promedio según la configruiacion 
        // del material "precio variable"
            //$modelo=$this->loadModel($idinventario);
            //verificnado si la uinida de medida es la unidad de medida base
            
           // $this=
            //cargando el invietario
            $modeloinventario= Alinventario::model()->findByPk($this->alkardex_alinventario->id);
			
            $cantidadmovida=$this->cant*Alconversiones::model()->convierte($this->codart,$this->um); ///
            //$cantidadactual=$modeloinventario->cantlibre;
            if ($cantidadmovida + $modeloinventario->cantlibre <0 ) {
			   return 0; //Se intento mover materiales que  ya noestan en stock 
			   }else {
            $modeloinventario->setscenario('modificacantidad');
            $nuevoprecio=($this->preciounit*$cantidadmovida + $modeloinventario->punit*($modeloinventario->cantlibre+$modeloinventario->cantres+$modeloinventario->canttran ))/($cantidadmovida+$modeloinventario->cantlibre+$modeloinventario->cantres+$modeloinventario->canttran);
            $modeloinventario->punit=round($nuevoprecio,2);
            $modeloinventario->cantlibre=$modeloinventario->cantlibre+$cantidadmovida;
			
            return ($modeloinventario->save())?1:0;
            }
    
        }
	public function Actualizacantidadinventario($codmovimiento= null) {

		$mensajero="";
		$modeloinventario= Alinventario::model()->findByPk($this->alkardex_alinventario->id);
		if(is_null($modeloinventario)){
			$mensajero=$mensajero." No se encontro el registro de inventario relacionado  al kardex ".$this->numkardex."(".$this->id.") <br>";
		} else {
			   $resultado=$modeloinventario->actualizar($this->codmov,$this->cant,$this->um);
			if(strlen($resultado)>0) {  //hubo error
				$mensajero=$mensajero." No se pudo actualizar el inventario ".$resultado."<br>";

			}
		}

		/*$cantidadmovida=$this->cant*Alconversiones::model()->convierte($this->codart,$this->um); ///
		//$cantidadactual=$modeloinventario->cantlibre;
		echo "cantidad kardex".$this->cant."\n";
		echo "coversion ".Alconversiones::model()->convierte($this->codart,$this->um)."\n";
		echo "canti movida".$cantidadmovida."\n";
		echo "canti lubre  ".$modeloinventario->cantlibre."\n";

		if ($cantidadmovida + $modeloinventario->cantlibre <0 ) {
			return 0; //Se intento mover materiales que  ya noestan en stock
		}else {
			$modeloinventario->cantlibre=$modeloinventario->cantlibre+$cantidadmovida;

			if($modeloinventario->save()) {
				echo " grab o   ".$modeloinventario->save();
			} else   {
				echo " no grabo    ".$modeloinventario->save();
			}
			yii::app()->end();
		}
                */
	}

public function Actualizareservainventario($codmovimiento= null) {
         $modeloinventario= Alinventario::model()->findByPk($this->alkardex_alinventario->id);			
            
            $modeloinventario->setscenario('modificacantidad');
			$modeloinventario->cantres=$modeloinventario->cantres+$this->cant*Alconversiones::model()->convierte($this->codart,$this->um); ///;
            return ($modeloinventario->save())?1:0;
            
    
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

		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('alemi',$this->alemi,true);
		$criteria->compare('aldes',$this->aldes,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddoc',$this->coddoc,true);
		$criteria->compare('numdoc',$this->numdoc,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codocuref',$this->codocuref,true);
		$criteria->compare('numdocref',$this->numdocref,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('prefijo',$this->prefijo,true);
		$criteria->compare('fechadoc',$this->fechadoc,true);
		$criteria->compare('correlativo',$this->correlativo,true);
		$criteria->compare('numkardex',$this->numkardex,true);
		$criteria->compare('solicitante',$this->solicitante,true);
		$criteria->compare('hidvale',$this->hidvale,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}