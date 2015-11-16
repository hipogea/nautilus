<?php
const ESTADO_PREVIO='99';
const ESTADO_CREADO='10';
const ESTADO_EFECTUADO='20';
const ESTADO_ANULADO='30';


const MOV_SALIDA_RESERVA='10';
const AN_MOV_SALIDA_RESERVA='20';
const MOV_INGRESO_COMPRA='30';
const AN_MOV_INGRESO_COMPRA='40';

const MOV_SALIDA_CECO='50';
const AN_MOV_SALIDA_CECO='60';
const MOV_INGRESO_CONSIGNACION='31';
const AN_MOV_INGRESO_CONSIGNACION='13';

const MOV_DEVOLUCION_PROVEEDOR='41';
const MOV_INICIAR_TRASLADO='77';
const AN_MOV_INICIAR_TRASLADO='64';
const MOV_SALIDA_TRASLADO='45';
const MOV_INGRESA_TRASLADO='78';
const AN_MOV_INGRESA_TRASLADO='54';

const MOV_REINGRESO_MATERIAL='70';
const MOV_SALIDA_VENTA='79';
const AN_MOV_SALIDA_VENTA='81';

const MOV_MOV_CARGA_INICIAL='98';
const AN_MOV_CARGA_INICIAL='89';
const MOV_DEVOLUCION_CLIENTE='97';

const COD_DOCUMENTO_COMPRAS='210';


class AlmacendocsController extends ControladorBase
{
	public function __construct() {
		parent::__construct($id='almacendocs',Null);
		$this->documento='101';
		$this->modelopadre='Almacendocs';
		$this->modeloshijos=array('Alkardex'=>'Tempalkardex');
		$this->documentohijo='460';
		$this->campoestado='cestadovale';
		$this->ConfigArreglos();
		//$nuevo=new $this->modelopadre;
		//$this->campoenlace=$nuevo->getFieldLink($nuevo->relations(),$this->modelopadre,);

	}


	private function Verificamov($mov){
		if(is_null(Almacenmovimientos::model()->findByPk($mov)) )
			throw new CHttpException(500,'La Seleccion del movimiento debe de hacerse, desde el formulario, No se encontro el movimiento ');
	}


	public function actionAlmacenes(){
		$model=new VwStocktotalAlmacenes('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwStocktotalAlmacenes']))
			$model->attributes=$_GET['VwStocktotalAlmacenes'];
			$nuevo=New Alinventario();
		// new CArrayDataProvider($dataArray);
		$datostocktotales=$nuevo->getStockValTotal();
		$proveedor=new CArrayDataProvider($nuevo->getStockValAlmacen());
		$this->render('adminalmacenes',array(
			'model'=>$model,
			'proveedor'=>$proveedor,
			'stocktotales'=>$datostocktotales,
		));
	}





//	public $layout='//layouts/column2';
//
	public function actionEditar($id)
	{

		$model=MiFactoria::CargaModelo($this->modelopadre,$id);
		$this->performAjaxValidation($model);
		/*ECHO isset($_POST[$this->modelopadre])?"<br><br><br><br><br><br><br><br>SI ES UN  POST['".$this->modelopadre."']":"<br><br><br><br><br><br><br><br>NO es un  POST";
			ECHO isset($_GET[$this->modelopadre])?"<BR> ES UN  GET(MODELOPADRE) ":"<BR> NO  ES UN  GET(MODELOPADRE)";
		ECHO isset($_GET['ajax'])?"<BR> ES UN  GET(ajax) ":"<BR> NO  ES UN  GET(ajax)";
		ECHO isset($_GET['ajax'])?"<BR> ES UN  GET(ajax) ":"<BR> NO  ES UN  GET(ajax)";
		echo ($this->estasEnSesion($id))?"<BR> ESTAS EN SESION  ":"<BR> NO NO ESTAS EN SESION ";
		echo " this->es_refreshdegrilla  ".var_dump($this->isRefreshCGridView($id))."  <br>";
		echo " this->IsRefreshUrlWithoutSubmit  ".var_dump($this->IsRefreshUrlWithoutSubmit($id))."  <br>";*/

		if($this->itsFirsTime($id))
		{
			if($this->getUsersWorkingNow($id))
			{ //si esta ocupado
				/* echo " es romer a vez y esta ocupado esta ocpado x otro   ";
				yii::app()->end();*/
				Yii::app()->user->setFlash('error', "El documento esta siendo modificado por otro usuario ");


				$this->redirect(array('view','id'=>$model->id));
			} else { // Si no lo esta renderizar sin mas
				/*echo " es primer avez y renderizar sin mas    ";
				  yii::app()->end();*/
				$this->setBloqueo($id) ; 	///bloquea
				$this->ClearBuffer($id); //Limpia temporal antes de levantar
				$this->IniciaBuffer($id); //Levanta temporales



				$this->render('n_form',array('model'=>$model));
				yii::app()->end();
			}

		} else {
			if($this->isRefreshCGridView($id))
			{ //si esta refresh de grilla
				/*echo " NO es primera vez y  Es un refresh carajo";
				yii::app()->end();*/
				$this->render('n_form',array('model'=>$model));
				yii::app()->end();
			} else { // Si no lo es  tenemos que analizar los dos casos que quedan
				if($this->IsRefreshUrlWithoutSubmit($id))
				{ ///Solo refreso la pagina
					/* echo "NO es primera vez  y reresco si submit ";
					 yii::app()->end();*/
					Yii::app()->user->setFlash('notice', "No has confirmado los datos, solo haz refrescaod la pagina ");
					$this->render('n_form',array('model'=>$model));
					yii::app()->end();
				} else { 	 ///Ahora si recein se animo a hacer $_POST	, y confirmar los datos
					/*echo "se animo a ha hacer POST ";
					yii::app()->end();*/
					IF(isset($_POST[$this->modelopadre])) {
						$model->attributes=$_POST[$this->modelopadre];
						//$model->validate();
						if($this->hubocambiodetalle($id) OR  $model->hacambiado()) {
							if($model->save()){
								$this->ConfirmaBuffer($id); //Levanta temporales
								//$this->grabaitems($this->tempdpeticion_a_dpeticion($id)); //Graba temporales a la tabla Dpeticion
								$this->ClearBuffer($id);
								//$this->limpiatemporaldetalle(); //Limpia temporal
								$this->terminabloqueo($id);
								//$this->terminabloqueo($id); // Desbloquea
								Yii::app()->user->setFlash('success', "Se grabo el documento  ".$this->SQL);
								//$this->render('update',array('model'=>$model));
								$this->redirect(array('view','id'=>$model->id));
							} else {
								//echo CActiveForm::validate($model);
								$this->render('n_form',array('model'=>$model));
								yii::app()->end();
								/*Yii::app()->end();
								throw new CHttpException(500,'Hubo un error al momento de grabar la cabecera');*/
							}
						} else   {
							Yii::app()->user->setFlash('notice', "  Enviaste los datos pero no has modificado nada.... ");
							$this->render('n_form',array('model'=>$model));
							yii::app()->end();
						}
					} else  { //En este caso quiere decir que la sesion/bloqueo anterior no se ha cerrado correactmente
						// Y es posble que haya entrado despues de 2 dias, una semana asi
						$this->terminabloqueo($id);
						$this->SetBloqueo($id);
						Yii::app()->user->setFlash('notice', "NO cerraste correctamente, Ya tenías una sesion abierta en este domcuento,");
						$this->render('n_form',array('model'=>$model));
						yii::app()->end();

					}
				}
			}

		}

	}

public function efectuamovimiento($model /*$id*/){
	//$kardexhijos=MiFactoria::DevuelveKardexHijos($id);
	if($model->codocuref==$this->documento) //Si en este vale se ha tratado otro vale como referencia
	{
		$valetratado= $registro=Almacendocs::model()->find("numvale=:nimi",array("nimi"=>trim($model->numdocref)));
	     $valetratado->setScenario('cambioestado');
		 $valetratado->cestadovale=$model->almacendocs_almacenmovimientos->eventos->estadofinal;
		$valetratado->save();
		unset($valetratado);
	}



}

public function actionexpedicion(){

	if (!isset($_POST['codiguito'])  OR is_null($_POST['codiguito'])){
		echo "Error:  debes de selecccionar un punto de expediucion";
	} else {
		$punto=$_POST['codiguito'];
        $identidad=$_POST['identidad'];
		$responsable=$_POST['responsable'];
		echo " es idetidad ".$identidad;
		$hijos=MiFactoria::DevuelveKardexHijos($identidad);
		foreach($hijos as $filita){
			MiFactoria::insertadespacho($filita->id,$punto,$responsable);
		    }
             echo "Se ha colocado los materiales en Expedicion ";
	}




}

	public function borrakardexhijos($id){
		MiFactoria::Borrahijoskardex($id);

	}



//	public $layout='//layouts/column2';
//
	public function actionConfirmar($id)
	{
		$model=MiFactoria::CargaModelo($this->modelopadre,$id);

		$this->performAjaxValidation($model);
		if($this->itsFirsTime($id))
		{
			if($this->getUsersWorkingNow($id))
			{ //si esta ocupado
					$this->redirect(array('view','id'=>$model->id));
			} else { // Si no lo esta renderizar sin mas
				$this->setBloqueo($id) ; 	///bloquea
				$this->ClearBuffer($id); //Limpia temporal antes de levantar
				MiFactoria::insertadetalles($model->id,$model->codmovimiento,$model->numdocref);
				/*echo "<br><br><br><br>";
				print_r(yii::app()->user->getFlashes());*/
				$this->render('n_form',array('model'=>$model));
				yii::app()->end();
			}
		} else {
			if($this->isRefreshCGridView($id))
			{ //si esta refresh de grilla
				$this->render('n_form',array('model'=>$model));
				yii::app()->end();
			} else { // Si no lo es  tenemos que analizar los dos casos que quedan
				if($this->IsRefreshUrlWithoutSubmit($id))
				{ ///Solo refreso la pagina
					Yii::app()->user->setFlash('notice', "No has confirmado los datos, solo haz refrescaod la pagina ");
					$this->render('n_form',array('model'=>$model));
					yii::app()->end();
				} else { 	 ///Ahora si recein se animo a hacer $_POST	, y confirmar los datos
					IF(isset($_POST[$this->modelopadre])) {

						$model->attributes=$_POST[$this->modelopadre];
						   $model->cestadovale='20';
						$transacc=$model->dbConnection->beginTransaction();
						if($model->save()){
								$this->efectuamovimiento($model/*$id*/); //oJO SOLO DESPUES DE COFIRMAR BUFFER
								$this->ConfirmaBuffer($id); //Levanta temporales
										if(!$this->detectaerrores())
											{ $transacc->commit();
												Yii::app()->user->setFlash('success', "Se grabo el documento  ".$this->SQL);
												$this->ClearBuffer($id);
												$this->terminabloqueo($id);
												$this->redirect(array('editar','id'=>$model->id));
											} else {//print_r(yii::app()->user->getFlashes());
											Yii::app()->user->setFlash('error', "Se ha presentado algunos inconvenientes ".$this->displaymensajes('error'));
											$transacc->rollback();
											$this->terminabloqueo($id);
											$this->render('n_form',array('model'=>$model));
											yii::app()->end();
											}
							} else {
								Yii::app()->user->setFlash('error', " No se pudo grabar el documento  ".$this->SQL);
								//$transacc->rollback();
								$this->render('n_form',array('model'=>$model));
								yii::app()->end();
								/*Yii::app()->end();
								throw new CHttpException(500,'Hubo un error al momento de grabar la cabecera');*/
							}


					} else  { //En este caso quiere decir que la sesion/bloqueo anterior no se ha cerrado correactmente
						// Y es posble que haya entrado despues de 2 dias, una semana asi
						$this->terminabloqueo($id);
						$this->SetBloqueo($id);
						Yii::app()->user->setFlash('notice', "NO cerraste correctamente, Ya tenías una sesion abierta en este domcuento,");
						$this->render('n_form',array('model'=>$model));
						yii::app()->end();

					}
				}
			}

		}

	}





	public function actionCrearvale()
	{
		$model=new $this->modelopadre;
		$model->valorespordefecto($this->documento);
		//echo "<br><br><br><br> al inicio   ". count$this->camposlink."<BR>";
		//print_r($this->camposlink);
		if(isset($_GET['micodigomov']))
		{
			$this->Verificamov($_GET['micodigomov']);
			$model->codmovimiento=$_GET['micodigomov'];
			$model->setEscenarioMov();
			$model->setScenario($model->getEscenarioMov());
			$model->codocuref=Almacenmovimientos::model()->findByPk($model->codmovimiento)->codocu;
			//echo "<br><br><br><br> El escenario es   ".$model->getScenario()."<BR>";
		}
		$this->ClearBuffer($id);
		$model->iduser=Yii::app()->user->id;

		if(isset($_POST[$this->modelopadre]))
		{$model->attributes=$_POST[$this->modelopadre];

			if($model->save()){
				$this->redirect(array('confirmar','id'=>$model->id));
			}
		}
		//echo "<br><br><br><br> al final   ".($model->isnewRecord)?"ES NUEVO ":"YA NO ES NUVEO";
		$this->render('n_create',array('model'=>$model));
	}

	public function actionCrearvale1()	{


		echo " El vlaor de mov es : ".$_GET['mov'];
		yii::app()->end();
	}



	/**
	 * @return array action filters
	 */
	public function filters()
	{

		return array('accessControl',array('CrugeAccessControlFilter'));
	}

public	function bloquearPost($postID) {

		if(isset($_SESSION['postID'])) {
			if ($postID == $_SESSION['postID']) {
				return false;
			} else {
				$_SESSION['postID'] = $postID;
				return true;
			}
		} else {
			$_SESSION['postID'] = $postID;
			return true;
		}
	}

    /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{

		Yii::app()->user->loginUrl = array("/cruge/ui/login");


		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','salir','confirmar','borraitems','almacenes','expedicion','editar','crearvale','Ingresatraslado','Updateingresatraslado','stock','updatetraspaso','creadetalletraspaso','pio','create','Configuraop','conformidad','crear','actualizacostos','updatereingreso','cargaums','Creadetallereingreso','cargainicial','Borraitem','AnulaSalidaReserva','Imprimirsolo','anulacargainicial',
                    'Confirmaanulacargainicial','updatesalidaceco','salidaceco','anulasalidaceco','creadetalle','Ingresacompra','Updateingresacompra','Traspaso',
                    'Confirmaanulacioningresocompra','Anulaingresocompra','reingreso',
					'atiendesolpe','imprimir','reservar','Confirmaanulacionsalidareserva','pruebax','updatecargainicial','salidareserva','updatesalidareserva',
					'update','pinta','pintakardex','generadetalle','generacontabilidad','modificadetalle'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

/*   Pinat el stock mendiante una envio de una jax */
	public function actionstock() {
			if (isset($_POST['codiguito'])) {
			$codigox=$_POST['codiguito'];
			$centro=$_POST['centrito'];
			$almacen=$_POST['almacencito'];
			echo $this->renderpartial("stocks",array('codigo'=>$codigox,'centro'=>$centro,'codal'=>$almacen),true);
		}
	}

   //Pinta la configuracion de los campos por defecto
	public function actionConfiguraop()
	{
		$this->render('vw_admin_opciones',array(
			'proveedor'=>MiFactoria::OpcionesDefault($this->documento),
			'proveedor1'=>MiFactoria::OpcionesDefault($this->documentohijo),
		));
	}


	public function actionIngresatraslado() {
		$movimiento='78';
		//$signo=-1;
		$model=new Almacendocs;
		$model->valorespordefecto($this->documento);
		$model->codmovimiento=$movimiento;
		$model->setscenario("traspaso");
		$this->performAjaxValidation($model);
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];
			if($model->save()) {
                 $model->refresh();
				//$this->render('reingreso',array('model'=>$model,'movimiento'=>$movimiento));
				$this->redirect(array('Updateingresatraslado','id'=>$model->id,'movimiento'=> $movimiento));

				//Yii::app()->end();
			}
		}
		//la diferenci en ter un render y el tro lo encontramos en la condicion isenew record de la vista REINGRESO
		$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
	}


public function Actualizaatenciones($modelokardex,$modelodesolpe=null) {
	//verificando que la cantidad este bien
	   $mensaj="";
	    if($modelokardex->VerificaCantAtenReservas()){
			$modelokardex->InsertaAtencionReserva();
            /* $modelodesolpe->RefrescaestadoSolpe();
			 $modelodesolpe->RefrescaestadoSolpe();*/
		} else {
			foreach($modelokardex->mensajes() as $clave=>$valor) {
				if($clave=='error')
					$mensaj.=$valor."<br>";
			 }
		}
	return $mensaj;

	/*	//Verificando que no haya exceso de cantidades
		//Al igual que los costos cambiamos el signo del kardex porque se trata de algo opuesto , son atenciones
		//guardamos el valor original
		$cantidadoriginal=$modelokardex->cant;
		$signo=-1;
		$mensaj="";
		$modelokardex->cant=$signo*$modelokardex->cant;
		$criteria=New CDbCriteria;
		$criteria->addcondition("hidesolpe=:vhidesolpe AND estadoreserva <> '30' and codocu='450'");
		$criteria->params=Array(":vhidesolpe"=>$modelodesolpe->id);
		$modeloreserva=Alreserva::model()->find($criteria);
		$cantidadatendidaacumulada=$modeloreserva->alreserva_cantidadatendida;
		if($cantidadatendidaacumulada + $modelokardex->cant <= $modeloreserva->cant) {
			$modeloatenciones=New Atencionreserva();
			//$mensaj.="sE CREO EL AREGISTRO ATENCIONES <BR> ";

			$modeloatenciones->cant=$modelokardex->cant ;  // VALORES POSITIVOS PARA  LAS ATENCIONES y NEGATIVOS EN ANULACIONES
			$modeloatenciones->hidkardex=$modelokardex->id;
			$modeloatenciones->hidreserva=$modeloreserva->id;
			$modeloatenciones->estadoatencion='10';
			$modelodesolpe->est='50'; ///atendido parcial por ahora, luegop veremos si es una atencion completa
			$modeloreserva->estadoreserva='40';///atendido parcial por ahora, luegop veremos si es una atencion completa
			//si con este movimiento ya se completo la cantidad total
						if(($cantidadatendidaacumulada+$modelokardex->cant== $modeloreserva->cant))
							{
								///$mensaj.="OK LA CANTIDAda tendida es igual a la pedida  <BR> ";
								$modeloreserva->estadoreserva='20';
							///Completo...!
				///Veriifcar primero si DESOLPE tiene partido RESERVA +RESERVA PARA COMPRA
				 				IF($modelodesolpe->numero_reservascompras == 0 ){ ///Si no tiene solicitudes de compra
					       			$modelodesolpe->est='40';///Completo...!
									//$mensaj.="OK se trata d una desol,pe de solo reserva  <BR> ";
									//$mensaj.="eato de la desolpe ".$modelodesolpe->est."  <BR> ";
							                                                 }
							}

			//si con este movimiento se REVERSA el total (Solo se cumple para movimientos de anulacion )
			if(($cantidadatendidaacumulada+$modelokardex->cant== 0))
			{
				///$mensaj.="OK LA CANTIDAda tendida es igual a la pedida  <BR> ";
				$modeloreserva->estadoreserva='10';
				///CREADA...!
				///Veriifcar primero si DESOLPE tiene partido RESERVA +RESERVA PARA COMPRA
				IF($modelodesolpe->numero_reservascompras == 0 ){ ///Si no tiene solicitudes de compra
					$modelodesolpe->est='60';///RESERVADO...!
					//$mensaj.="OK se trata d una desol,pe de solo reserva  <BR> ";
					//$mensaj.="eato de la desolpe ".$modelodesolpe->est."  <BR> ";
				}
			}



						///cambiamos los escenarios y luego los restablecemos
			                $Escenariosolpe=$modelodesolpe->getScenario();$Escenareserva=$modeloreserva->getScenario();
							$modelodesolpe->setscenario('Atencionreserva') ; $modeloreserva->setscenario('cambiaestado');
			                   if($modeloatenciones->save() and $modelodesolpe->save() and $modeloreserva->save())
					                          {

											  }else {
						                         $mensaj.="No se pudieron actualizar los registros de atenciones, y  los status de las reservas y de la solicitud original del material ".$alkardex->codart;
					                          }
			       				//dejamos los escenarios tal cual los encontramos para no entrar en cnflictos con nadie

							$modelodesolpe->setscenario($Escenariosolpe) ; $modeloreserva->setscenario($Escenareserva);
		      }  else {
			$mensaj.=" Se ha intentado atender una cantidad que sobrepasa la cantidad reservada original para el material ".$modelokardex->codart;
                   }
		//Restablecemos ek valor para no afecatra a otro sprocedimientos
		$modelokardex->cant=$cantidadoriginal;
		return $mensaj;
*/

	}



/*  Devuelve un comob box para un ajax */
	public function actionPintakardex() {
		$numerovale=trim($_POST['Tempalkardex']['numdocref']);
		$criteria = new CDbCriteria();
		$criteria->addCondition("numvale=:vnumvale");
		$criteria->params=array(':vnumvale'=>$numerovale);
		//$valor=$_POST['Eventos']['codocu'];
		$data=CHtml::listData(	VwKardex::model()->findAll( $criteria),id,descripcion);
		print_r($data);
	//	yii::app()->end();
		echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja un item'),true);
		foreach($data as $value=>$name) {
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}

	}


	public function actionCargaums() {

		$numerovale=trim($_POST['Alkardex']['numdocref']);
		$referencia=$_POST['Alkardex']['idref'];
		$criteria = new CDbCriteria();
		$criteria->addCondition("idref=:vidref");
		$criteria->params=array(':vnumvale'=>$numerovale,':vidref'=>$referencia);
		$criteria->addCondition("numvale=:vnumvale ");

		$modelokardex=VwKardex::model()->find($criteria);
		$material=trim($modelokardex->codart);

		$criteria2 = new CDbCriteria();
		$criteria2->addCondition("codart=:vcodart ");
		$criteria2->params=array(':vcodart'=>$material);
         VwAlconversiones::model()->findAll($criteria2);
		//$valor=$_POST['Eventos']['codocu'];
		$data=CHtml::listData(	VwKardex::model()->findAll( $criteria),um2,desum2);

		$modelomaterial=Maestrocompo::model()->findByPk($material);
		//este vacio ono , garegamos la unidad de medida base
		if(count($data)==0)
		array_push($data,array($modelomaterial->um=>$modelomaterial->maestro_ums->desum));
		print_r($data);
		yii::app()->end();

		//print_r($data);
		//yii::app()->end();
		echo CHtml::tag('option', array('value'=>null),CHtml::encode('um'),true);
		foreach($data as $value=>$name) {
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}

	}







	public function actionPio() {
		echo "  falta copmpraer ".Desolpe::model()->findByPk(730)->cuantofaltacomprar();
		yii::app()->end();


		ECHO  "  del material azufre <br>";
		echo "   una caja   vale :  ".Alconversiones::convierte('18004728','190')."     unidades <br>";
		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123')."     unidades <br>";
		echo "   unA caja  vale :  ".Alconversiones::convierte('18004728','190','120')."     unidades <br>";
		echo "   unA UNIDAD  vale :  ".Alconversiones::convierte('18004728','120','190')."    CAJAS <br>";
		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123','120')."     unidades <br>";
		echo "   unA UNIDAD  vale :  ".Alconversiones::convierte('18004728','120','123')."    KILOGRAMOS <br>";


		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123','190')."    CAJAS <br>";
		echo "   unA CAJA  vale :  ".Alconversiones::convierte('18004728','190','123')."    KILOGRAMOS <br>";
		yii::app()->end();
             $model=new Noticias();

		var_dump(get_class($model));
		yii::app()->end();


		var_dump(count(Peticion::model()->search()->getdata()));
		yii::app()->end();


		ini_set ( 'soap.wsdl_cache_enable' , 0 ); ini_set ( 'soap.wsdl_cache_ttl' , 0 );
		$wsdlURL='https://www.sunat.gob.pe/ol-ti-itcpgem-beta/billService?wsdl';
		$client=new SoapClient($wsdlURL);
		var_dump($client->__getFunctions());
		ECHO "<BR>";
		ECHO "<BR>";
		var_dump($client->__getTypes());
		//var_dump($client);
		yii::app()->end();
		//$result=$client->giveTimestamp();
		//echo $result;




		var_dump(yii::app()->user);
		echo "<br>";
		echo "<br>";
		echo "<br>";
			$elusuario=Yii::app()->user->um->LoadUserById(yii::app()->user->id);
		var_dump($elusuario);
		$sesion_activa=Yii::app()->user->um->findSession($elusuario);
		echo "<br>";
		ECHO " LA DURACION MAXIMA DE LA SESION ".Yii::app()->user->um->getDefaultSystem()->getn('sessionmaxdurationmins')."   Minutos";
		echo "<br>";
		ECHO " la sesion expira  ".date("Y-m-d H:i:s",$sesion_activa->expire);
		echo "<br>";
		ECHO " la sesion inicio en ".date(" H:i:s",$sesion_activa->created);
		echo "<br>";
		ECHO " Ultimo uso  ".date("H:i:s",$sesion_activa->lastusage);
		echo "<br>";
		ECHO " la hora actual  ".date("H:i:s");
		echo "<br>";
		ECHO " Han pasado :   " .((time()-$sesion_activa->created)/(60))."   minutos       con  ";
		echo "<br>";
		echo "  Sesion expirada? :
		        ->             ".var_dump($sesion_activa->isSessionExpired());
		echo "<br>";
		echo "  Sesion name  : ".$sesion_activa->getSessionName();
		echo "<br>";
		echo"  Sesion valida : ".$sesion_activa->validateSession();

		//	$sesion_activa->getSessionFilter();
		echo "<br>";
		//print_r($sesion_activa);
		yii::app()->end();








		echo yii::getPathOfAlias('webroot.materiales');
		//echo yii::app()->baseUrl;
		YII::APP()->END();
		/*var_dump(yii::app()->request);
		echo "<br>";
		print_r(yii::app()->request->baseUrl);*/
		echo yii::app()->getBaseUrl(true);
		echo "<br>";
		var_dump( is_dir(yii::app()->getBaseUrl(true)));

		YII::APP()->END();


		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
		print_r($images);
		yii::app()->end();



	var_dump( is_dir("/public_html/recurso/materiales/"));

        YII::APP()->END();


		var_dump(yii::app()->estadisticas->linear_regression(array(2,3,3.5,5), array(2,3,4,6)));



		$this->render('//alinventario/vw_loginventario',array());

		yii::app()->end();


  $modelinv=Alinventario::model()->findByPk(343569);
		$modelinv->actualiza_stock('77',1,null);
		yii::app()->end();



		echo Yii::app()->baseUrl;
		yii::app()->end();



		$criterio=new CDbcriteria;
		$criterio->addcondition("hidsolpe=:vid");
		$criterio->params=array(":vid"=>387);
		$objeto= new Miproveedor('Desolpe',array('criteria'=>$criterio));
		//var_dump($objeto->getdata());
		$objeto->camposasumar=array("TOTAL CANTIDAD"=>'cant','SUBTOTAL PLANEADO'=>"punitplan",'SUBTOTAL REAL'=>"punitreal");
		$subtotales=$objeto->Total();
		var_dump($subtotales);
		yii::app()->end();



		$nuevoarray=array();
		$nuevoarray['uno']=1;
		$nuevoarray['dos']=2;
		var_dump($nuevoarray);
		yii::app()->end();


		$criterio=new CDbcriteria;
		$objeto= new CActiveDataProvider('Impuestos');
// $dataProvider->getData() will return a list of Post objects
         var_dump($objeto->getdata());
		yii::app()->end();







		//echo Almacendocs::model()->findByPk(709)->almacendocs_almacenmovimientos->eventos->estadofinal;
		var_dump(Almacendocs::model()->findByPk(709)->almacendocs_almacenmovimientos);
		yii::app()->end();


		$criterio=New CDbCriteria();
		$criterio->addCondition("hidguia=:xdet");
		$criterio->params=array(':xdet'=>59);
		//var_dump($criterio->condition);
		print_r(MiFactoria::arrayColumnaSQL(Docompra::model()->tableName(),'id',$criterio));
      yii::app()->end();



		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
          print_r($images);
       yii::app()->end();

		$modelito=new Ocompra();
		$modelito->codocu=$this->documento;
		echo $modelito->correlativo('numcot');
		yii::app()->end();

		echo dirname(__FILE__).'/css/estilogrid.css';
		var_dump(is_file($_SERVER['SCRIPT_NAME'].'/css/estilogrid.css'));
		//ECHO "..//".(strlen(dirname($_SERVER['SCRIPT_NAME']))>1 ? dirname($_SERVER['SCRIPT_NAME']) : '' ) . '/css/estilogrid.css';
		yii::app()->end();

		// una ffraccion de la forma   1/2 , 3/4 , 45/3, 1 /2 , 7./3 , 1/ 3, 234/567,  4/.5 ,
		$cadena1="PERNO  11/45 INOXIDABLE  7/8 HF   1/2 x 3/4  1/12 * 5/16 ";
		$cadena2="PERNO   12./. 56  3 1/2 INOXIDABLE  17/8 HF ";
		$cadena3="PERNO  45/ 34 INOXIDABLE  7./ 8 HF ";
		$cadena4="PERNO  1/2 4 5/34 INOXIDABLE  7 /8  HF ";
		$cadena5=" PERNO   4/.63 INOXIDABLE  756/458 HF ";
		$cadena6="3/4 PERNO  1 / 3 INOXIDABLE  17/8*1 HF ";
		$cadena7="PERNO INOXIDABLE  3*41 25/16 1781 HF ";

		$patron="/^(\s)[0-9]{1,}[\.|\s]?[\/]{1}[\.|\s]?[0-9]{1,}(\s)$/";
		$patron2='/[1-9]{0,}+[\s|*|x|X]{1}[0-9]{1,}[\.|\s]{0,1}[\/]{1}[\.|\s]{0,1}[0-9]{1,}[\s|*|x|X]{1}/';
		echo $cadena1. "    ". preg_match_all($patron2,$cadena1,$resultado1) ."<br>";
		print_r($resultado1);
		echo "<br>";
		echo "<br>";
		echo $cadena2. "    ". preg_match_all($patron2,$cadena2,$resultado2) ."<br>";
		print_r($resultado2);
		echo "<br>";
		echo "<br>";
		echo $cadena3. "    ". preg_match_all($patron2,$cadena3,$resultado3) ."<br>";
		print_r($resultado3);
		echo "<br>";echo "<br>";
		echo $cadena4. "    ". preg_match_all($patron2,$cadena4,$resultado4) ."<br>";
		print_r($resultado4);
		echo "<br>";echo "<br>";
		echo $cadena5. "    ". preg_match_all($patron2,$cadena5,$resultado5) ."<br>";
		print_r($resultado5);
		echo "<br>";echo "<br>";
		echo $cadena6. "    ". preg_match_all($patron2,$cadena6,$resultado6) ."<br>";
		print_r($resultado6);
		echo "<br>";echo "<br>";
		echo $cadena7. "    ". preg_match_all($patron2,$cadena7,$resultado7) ."<br>";
		print_r($resultado7);
		echo "<br>";echo "<br>";
		//echo $cadena8. "    ". preg_match('/^(\s)[0-9]{1,}[\.|\s]?[\/]{1}[\.|\s]?[0-9]{1,}(\s)$/',$cadena1) ."<br>";


		yii::app()->end();

		print_r(Yii::app()->user->rbac->getMenu());
		yii::app()->end();
		//$model=new Impuestos;
		yii::app()->crugemailer->mail_con_archivo ('neotegnia@gmail.com','hipogea@hotmail.com','hi','130165');
	//	var_dump(mail('neotegnia@gmail.com','holas','holas'));
		yii::app()->end();
		echo Valorimpuestos::getimpuesto ( '200');

		$model->codocumento='1';
		ECHO Valorimpuestos::model()->getimpuesto('100');
		yii::app()->end();
		$model->codocumento='130';
		echo $model->Correlativo('numero');
		yii::app()->end();
		$modelin=CactiveRecord::model('Alkardex');
		print_r($modelin->getTableSchema());
		yii::app()->end();


		echo get_include_path();
		yii::app()->end();


		ECHO " la sesion expira  ".date("Y-m-d,H-i:s");
		yii::app()->end();


		echo MiFactoria::decimal(47/3);
		yii::app()->end();


		print_r(MiFactoria::opcionestoolbar(345,'130','20'));
		yii::app()->end();
		$model=new Inventario();
		$objeto=$model->getMetaData();
		foreach($objeto->columns as $columna)
		{
			echo "campo  ".$columna->name."    ancho ".$columna->size."  el tipo  : ".$columna->dbType."<br>";

		}
		print_r($objeto->columns);

		//$model->rucpro='121212121212121';
		//$model->save();
		//print_r($model->getMetaData());
		yii::app()->end();




		$movimientoauxiliar='45';
		$filakardexoriginal=Alkardex::model()->findByPk(1691);
		$filakardexoriginal->alkardex_alinventario->actualiza_stock($movimientoauxiliar,abs(3),null);
		yii::app()->end();




		$modeloreserva=Alreserva::model()->findByPk(255);
		var_dump($modeloreserva->alreserva_cantidadatendida);
		yii::app()->end();
		var_dump($kardex=Alkardex::model()->findByPk(1514)->alkardex_despacho);
		yii::app()->end();
		//tag(string $tag, array $htmlOptions=array ( ), mixed $content=false, boolean $closeTag=true)
		$arrayes=Almacendocs::model()->findAll("numvale=:nimi",array("nimi"=>trim('130200000129')));
		echo count($arrayes);
		yii::app()->end();


		if(is_dir('assets'))
			echo " si es un directrio";
		yii::app()->end();

		Yii::app()->crugemailer->prueba();

		//echo CHtml::tag("div",array("style"=>"font:23px;fotn-size:445;"),"AQUI",true);
		$calse=new Cc();
		ECHO $calse::BELONGS_TO;
	//	var_dump($calse);

		//phpinfo(INFO_MODULES);
		yii::app()->end();
		//tag(string $tag, array $htmlOptions=array ( ), mixed $content=false, boolean $closeTag=true)
		$arrayes=Almacendocs::model()->findAll("numvale=:nimi",array("nimi"=>trim('130200000129')));
       echo count($arrayes);
		yii::app()->end();

		echo strpos("manicomo","c");

		Yii::app()->user->setFlash('error', "MENSAJE ERRO1");
		Yii::app()->user->setFlash('error2', "MENSAJE ERR2");
		Yii::app()->user->setFlash('error3', "MENSAJE ERR3");
		Yii::app()->user->setFlash('notice', "MENSAJE NORICE1");
		Yii::app()->user->setFlash('notice2', "MENSAJE NOTICE2");
		Yii::app()->user->setFlash('notice3', "MENSAJE NOTICE3");
		Yii::app()->user->setFlash('success', "SUCCESS ERRO1");
		Yii::app()->user->setFlash('success2', "SUCCESS ERR2");
		Yii::app()->user->setFlash('success3', "SUCCESS ERR3");

     // PRINT_R(Yii::app()->user->getFlashes());



		yii::app()->end();
		//$this->ConfirmaBuffer($id);

		$kardexhijos=MiFactoria::DevuelveKardexHijos($id);

		echo count($kardexhijos);
		/*foreach ( $kardexhijos as $filakardex ) {
			//$filakardex->preciounit=$filakardex->getMonto();
			//$filakardex->VerificaCantAtenReservas();
			//$filakardex->InsertaAtencionReserva($filakardex->id);
			echo "   id del kardex ".$filakardex->id."<br>";
			//$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmov,abs($filakardex->cantidadbase()),null);

			//$filakardex->InsertaCcGastos();
		}
	*/
		yii::app()->end();




		$id=160;
		$modeloreserva=Alreserva::model()->findByPk($id);
		$modeloreserva->anular();
		PRINT_R(Yii::app()->user->getFlashes());
		yii::app()->end();




		$id=490;
			$kardexhijos=MiFactoria::DevuelveKardexHijos($id);
		//var_dump($kardexhijos);

			foreach ( $kardexhijos as $filakardex ) {

				//calculando el precio unitario
				$filakardex->preciounit=$filakardex->getMonto();
				IF($filakardex->VerificaCantAtenReservas())
					PRINT_R($filakardex->mensajes);

				//ECHO " GRABA  ".$filakardex->InsertaAtencionReserva($filakardex->id);

				$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmov,abs($filakardex->cantidadbase()),null);
                print_r($filakardex->alkardex_alinventario->mensajes);
				//verificandso si hay errrores recoger los mensajes
				/*if(!$filakardex->VerificaCantAtenReservas() or
                    !$filakardex->InsertaAtencionReserva() or
                    !$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmovimiento,$filakardex->cant,null)
                   )
                 $this->mensajes=array_merge($this->mensajes,$filakardex->mensajes,$filakardex->alkardex_alinventario->mensajes);
          */

				$filakardex->InsertaCcGastos();

			}

		yii::app()->end();




		//$nuevo=new MiFactoria();
		//Mifactoria::InsertaAtencionReserva(1357);


		$row=Alkardex::model()->findByPk(NULL);
		$matrix= Alreserva::model()->findAll("hidesolpe=:vhidsolpe AND codocu='450' ",array(":vhidsolpe"=>$row->idref));
		$model=new Atencionreserva();
		$model->cant=$row->cant;
		$model->hidkardex=$row->id;
		$model->hidreserva=$matrix[0]['id'];
		$model->estadoatencion=Atencionreserva::ESTADO_CREADO;
		if(!$model->save())
			throw new CHttpException(500,"NO se Pudo insertar el registro de atenciones reservas ");
		unset($model);unset($matrix);unset($row);
		yii::app()->end();



           $mimo=new ModeloGeneral();
		   $mimo->insertamensaje('success','primermamesaje');
		$mimo->insertamensaje('success1','segundo mensaje');
		$mimo->insertamensaje('error','tercer mensaje');
		$mimox=new ModeloGeneral();
		$mimox->insertamensaje('successx','primermamesaje');
		$mimox->insertamensaje('success1x','segundo mensaje');
		$mimox->insertamensaje('errorx','tercer mensaje');
		/*$gg= new Alinventario();*/
		print_r($mimo->mensajes);
		echo "<br><br>";
		print_r($mimox->mensajes);
		$mensaj=array();
		$mensaj=array_merge($mensaj,$mimo->mensajes);
		$mensaj=array_merge($mensaj,$mimox->mensajes);
		//array_merge($mensaj,$mimox->mensajes);
		//$mensaj[]=$mimo->mensajes;
		//$mensaj[]=$mimox->mensajes+$mimo->mensajes;
		//array_push($mensaj,$mimox->mensajes);
		echo "<br><br>";
		print_r($mensaj);

		yii::app()->end();


		var_dump(Almacenmovimientos::model()->findByPk('10')->signo);
		//echo "total   ".Alinventario::getStockTotal('11000004');
		yii::app()->end();
		/*if(Yii::app()->periodo->getModel()->HoyDentroPeriodo()){
			echo "ESTAMOS DENTRO DEL PERIODO";
		} else {
			echo "no  ESTAMOS DENTRO DEL PERIODO";
		}

		yii::app()->end();*/

		if(Yii::app()->periodo->verificaFechas('2015-03-5','2015-03-4')){
			echo "ESTAMOS DENTRO DEL PERIODO";
		} else {
			echo "no ESTAMOS DENTRO DEL PERIODO";
		}

		yii::app()->end();


$gg=new Alkardex();
		//$gg=Alkardex::model()->findByPk(1236);
		//var_dump($gg->oldAttributes);
		ECHO "<BR><BR> ESCENARIO :".$gg->getScenario()."<BR>";
		$gg->save();
		var_dump($gg->errors);


		$ggt=new Tempalkardex();
		//$gg=Alkardex::model()->findByPk(1236);
		//var_dump($gg->oldAttributes);
		ECHO "<BR><BR> ESCENARIO :".$ggt->getScenario()."<BR>";
		$ggt->save();
		var_dump($ggt->errors);
		yii::app()->end();
		$matriz=$gg->relations();
		$nuevoarr=array();
		//print_r($matriz);
		foreach($matriz as $clave=>$matricita)
		{
				     if($matricita[0]=='CHasManyRelation')
					   $nuevoarr[$matricita[2]]=$matricita[1];
			        }
		print_r($nuevoarr);
		//$hallo=array_search('CHasManyRelation',$matriz);
    // echo var_dump($hallo);
		yii::app()->end();
		$arreglo=array();
		/*$arreglo1=array('uno'=>1);
		$arreglo2=array('dos'=>2);
		$arreglo3=array('tres'=>3);*/
		$arreglo['uno']=1;
		$arreglo['dos']=2;


		print_r($arreglo);
		yii::app()->end();

		/***********************************************
		 * Prueba de la propieda mensajes ARRAY() de
		 * la clase MODELOGENERAL
		 *
		 * *******************       */
		$modelo=new ModeloGeneral();
		$modelo->insertamensaje('error','MENSAJE 1');
		$modelo->insertamensaje('error','MENSAJE 2');
		$modelo->insertamensaje('error','MENSAJE 3');
		$modelo->insertamensaje('notice','notice 1');
		$modelo->insertamensaje('notice','notice 2');
		$modelo->insertamensaje('success','succes 3');
         echo $modelo->parsemensajes('error');
		echo $modelo->parsemensajes('notice');
		echo $modelo->parsemensajes('success');
		//PRINT_R($modelo->mensajes);
		yii::app()->end();
		foreach($arreglo as $registro) {
			echo $registro->cant;
			echo " <br><br>";
		}
		//var_dump($modelo->desolpe_alreserva);
		yii::app()->end();
		/***********************************************************
		 *
		 */



		/***********************************************
		 * Prueba de que los registros hijos pueden ser
		 * llmados desde la relacion
		*  HAS:MANY                                   */
		$modelo=Desolpe::model()->findByPk(168);
		$arreglo=$modelo->desolpe_alreserva; ///LLAMA A LA RELACION Y RETORNA OBJETOS HIJOS
		   PRINT_R($arreglo);
		foreach($arreglo as $registro) {
			  echo $registro->cant;
			  echo " <br><br>";
		  }
		//var_dump($modelo->desolpe_alreserva);
		yii::app()->end();
		/***********************************************************
		 *
		 */



		echo Alconversiones::convierte('18005239','120');
           yii::app()->end();
		$petri=new Peticion();
		print_r($petri->behaviors());
		if(array_key_exists('ActiveRecordLogableBehavior',$petri->behaviors()))echo "salio";
		yii::app()->end();


		/*print_r(MiFactoria::ExisteRegistroTemporal('Tempdpeticion',127));
		yii::app()->end();*/
		/*print_r(Peticion::relations());
		$campoenlace=Peticion::getFieldLink(Peticion::relations(),'Peticion','Tempdpeticion');
		echo "<br>";
		echo "campo enl ace   :   ".$campoenlace;
		yii::app()->end();*/
		$id=127;
		$con=$this->IniciaBuffer($id);
		foreach($con as $grupo)
		{
			echo "<br>";
			foreach($grupo as $objeto){
				echo "<br>";
				   foreach( $objeto as $row){
							echo "======================================================<br>";
								print_r($row);
								echo "======================================================<br>";
					  		 echo "<br>";
				   }
			}
			echo "<br>";
		}

		$nombremodelocabecera='Peticion';
		foreach($con as $registroshijos)
		{

			// foreach ($grupo as $registroshijos)
			//{
			// $campoenlace=$nombremodelocabecera::getFieldLink($nombremodelocabecera::relations(), $nombremodelocabecera,$nombremodelohijo);
			// $registroshijos=MiFactoria::getRegistrosHijos($nombremodelohijo,$campoenlace,$id);
			foreach  ($registroshijos as $row)
			{

				if(is_null(MiFactoria::ExisteRegistro('Tempdpeticion',$id))){

					if($row->save()){
					echo " <br>";
					 echo " *********************************";
				echo " <br>";
				   echo "grabo     ".$row->getTableAlias();
				echo " <br>";
				echo " *********************************";
				  echo " <br>";
						}
				}

			  }
		}

		yii::app()->end();
		 print_r($con);
		yii::app()->end();

	//	$lalo=null;
		$modeloant=Solpe::model()->findByPk(239);
		$matriz=$modeloant->relations();
		$palo=$this->recorro($matriz);
		//echo Solpe::HAS_MANY;
		print_r($palo);
		yii::app()->end();

		$modeloant=Solpe::model()->findByPk(239);
		print_r($modeloant->relations());
		//echo $modeloant->codart;
		yii::app()->end();

		$modelo="Dpeticion";
		$s=new $modelo;
		print_r($s);
		yii::app()->end();

		$clasetemporal="Alinventario";
		$valor=$clasetemporal::model()->hasAttribute('codart');
		echo "   gfgfgf ".$valor;
		yii::app()->end();



		$registroshijos=$modelo::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=54 ");

		print_r($registroshijos);
		yii::app()->end();


		$inv='Alinventario';

		$arraymodelos=array();
		$modelo=$inv::model()->findByPk(343563);
		$modelo2=$inv::model()->findByPk(343564);
		array_push($arraymodelos,$modelo);
		array_push($arraymodelos,$modelo2);
		//$nuevomod=Bloqueos::prueba();
		echo $arraymodelos[0]->codart;
		//print_r($modelo);
		yii::app()->end();
         // $modelo=new ModInventario();
		$modelo=ModInventario::loadModel(343563);
		$modeloant=ModInventario::loadModel(343563);
		//echo " hola  ".gettype($modelo->codart);
		//$modelo->actualizaprecio($cantmov,1.23,$this->CAMPO_STOCK_LIBRE);
		$nuevoprecio=500;
		$cantmov=100;
		if($modelo->actualizaprecio($cantmov,$nuevoprecio,ModInventario::CAMPO_STOCK_LIBRE)) {
			echo "ok se relaizo el proceso :<br>";
			echo "cant libre :  ".$modelo->cantlibre."                 anterior : ".$modeloant->cantlibre."<br>";
			echo "cant reserva :  ".$modelo->cantres."                  anterior : ".$modeloant->cantres."<br>";
			echo "cant reserva :  ".$modelo->canttran."                    anterior : ".$modeloant->canttran."<br>";
			echo "Precio unitario :".$modelo->punit."                      anterior : ".round($modeloant->punit,3)."<br>";
			echo "dif de precio unitario :  ".$modelo->punitdif."                 anterior : ".$modeloant->punitdif."<br>";
			echo "cant stock afectado por el ambio de precio  :  ".$modelo->getStockCamposAfectadosPrecio()."<br>";
			echo "cant movida  :   ".$cantmov."<br>";
			echo "precio unitario nuevo  :   ".$nuevoprecio."<br>";
			echo "-------<br><br>";
		} else {
			$matriz=$modelo->getMensajes();
             echo " HAY  ".COUNT($matriz)."     Elementos";
			print_r($matriz);
         foreach( $matriz as $arreglo){
			// echo   "  ".$arregloclave."  :   ".$valor."<br>";
		 }
			echo "hu,,-------<br><r>";
		}

		yii::app()->end();

		$am = new MyCrugeAuthManager;
		$am->init();
		foreach($am->autoDetect() as $itemName)
			printf("%s\n",$itemName);
		echo "  la direccion IP:  ".CrugeUtil::hash("julian");


		echo " es una instancia de ". gettype(Yii::app()->crugemailer);
		/*if (Yii::app()->CrugeMailer instanceof CrugeMailer) {
			echo 'Crugemailer';
		} else  {
			echo "que carajo sera";
		}*/
		yii::app()->end();
        $id=54;
		$difiere=false; ///Asumismos que no ha variado
		$registrosactuales =Tempdpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."tempdpeticion
  																 where
  																 hidpeticion=".$id." and idusertemp = ".Yii::app()->user->id." ");
		$registrosviejos =Dpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=".$id." ");
		foreach ($registrosactuales as $row)
		{   $newattributes = $row->getAttributes(); ///Los valores de este instante
			foreach ($registrosviejos as $rowviejo){
				$oldattributes=$rowviejo->getAttributes();
				echo " Emparewjando : ".$oldattributes['id']."  con  ".$newattributes['id']." <br>";
				if($oldattributes['id']==$newattributes['id'] )  //compaRlo s
				{
					echo " En la fila ".$oldattributes['id']."  : <br>";
					foreach($oldattributes as $clave=>$valor) {
						echo "Comparando  :<br>";
						echo " original  :  ".$clave."                               original=".$valor."   actual=".$newattributes[$clave]."<br>";
						if($valor<>$newattributes[$clave] and $clave<>'idtemp' and $clave<>'idusertemp' ) {
							echo " DIFERENTE <br><br> ";
							$difiere=true;
							break;
						}

					}
					echo "  <br><br><br><br>";
				}

				/* print_r($newattributes );
                    echo "<br>";
                     print_r($atributos);
                   echo "<br><br><br>";*/
				if($difiere)
					break;
			}

			/*print_r($this->bufferdetalle);
			echo "<br>";
			        if($difiere)
				   break;*/
			if($difiere)
				break;
		}

		echo "<br><br>   total    ".$difiere;
		yii::app()->end();




























		$registrostemporalesdpeticion=array();
		$datosdebuffer=array(); ///Estos datos
		$datosbufferdefila=array();
		$registroshijos =Dpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=".$hidpeticion."  ");
		foreach  ($registroshijos as $row) {
			///Evitamos levantar items duplicados
			$existeregistro= Tempdpeticion::model()->find("id= ".$row->id." AND idusertemp=".Yii::app()->user->id." ");
			if(is_null($existeregistro)) {  ///Solo si no existe
				$modelotempdpeticion=new Tempdpeticion;
				$modelotempdpeticion->attributes=$row->attributes;
				$modelotempdpeticion->idusertemp=Yii::app()->user->id;
				array_push($registrostemporalesdpeticion,$modelotempdpeticion);

				$datosbufferdefila=$row->attributes;
				//array_push($datosbufferdefila,array('micalve'=>$row->id));
				array_push($datosdebuffer,$datosbufferdefila);
			}
		}
		//print_r($datosdebuffer);

		foreach ($datosdebuffer as $clave=>$atributos){
			 print_r($atributos);
			echo "<br><br>";

		}
		//$this->bufferdetalle=$registrostemporalesdpeticion; ///Guarda el bu¡ffer de datos
		//return $registrostemporalesdpeticion;
		yii::app()->end();










		$arreglo=array();
		$arreglo1=array('uno'=>1);
		$arreglo2=array('dos'=>2);
		$arreglo3=array('tres'=>3);

		array_push($arreglo,array('uno'=>1));
		array_push($arreglo,array('dos'=>2));

		print_r($arreglo);
		yii::app()->end();

    $id=34;
		if($id)
			echo "dsdsdsds eco ";
		yii::app()->end();

		$me=Yii::app()->user->id;
		$cadena= " select distinct idusertemp from ".Yii::app()->params['prefijo']."temppeticion WHERE id=".$id." and idusertemp <> ".$me." ";
		$quien=Yii::app()->db->createCommand($cadena)->queryScalar();
		echo $cadena;
		echo " El tipo de quien ".gettype($quien)."    -----    ".$quien;
		//yii::app()->end();
		if($quien) { /// Quiere decir que hay otros que estan ediotnado el documento
			///PARA VER SIS ES CIERTO DEEBMOS VERIFICAR Q ESTE USUARIO NO HA DEJADO LA VENTANA ABANDONADA CON E DOMCUENTO EN EDICION
			$elusuario=Yii::app()->user->um->LoadUserById($quien);
			///hallando la sesion activa de este usuario
			$sesion_activa=Yii::app()->user->um->findSession($elusuario);
			if(is_null($sesion_activa)) {
				echo "  NO esta cupado man ";  //No esta ocupado por que estaba editando pero ya temrino sus sesion, alo mejor dejo la ventana abierta
			}  else {
				echo "  Estaa cupado por el usuario ".$elusuario->username;  ///Si esta ocupado por que el usuario tiene sesion activa, y eszta editando
			}

		} else {
			echo "  NO esta cupado , estas solo mano  ";
		}

		yii::app()->end();







		$usuariojesus=Yii::app()->user->um->loadUser('admin',false);
		print_r($usuariojesus);

		echo "<br><br><br><br>";
		$modelo=Yii::app()->user->um->findSession($usuariojesus);
       echo  " el tipo retoranado es ".gettype($modelo);
		print_r($modelo);


		echo "<br><br><br><br>El  modelo de sesion de Jesus";
		$modelo=Yii::app()->user->um->findSession(Yii::app()->user->um->loadUser('jesus',false));
		echo  " el tipo retoranado es ".gettype($modelo);
		print_r($modelo);




		yii::app()->end();

		$modelo->isSessionExpired();
		if($expiro){
			echo "   Ya expiro ";
		}  else {
			echo "   Todavia esta vignte la sesion  ";
		}


		yii::app()->end();




		$this->layout = '//layouts/iframe';
		$this->render('carachita');
		yii::app()->end();
        // $modelosolpe=Desolpe::model()->findByPk(79);
		$modelokardex=Alkardex::model()->findByPk(1236);
		$clonado=$modelokardex->clonaregistro();
		//echo $clonado->cant;
		print_r($clonado);
		yii::app()->end();
		echo " numeor reservar compras ". $modelosolpe->numero_reservascompras;
		echo " modelo cant ".$modelosolpe->cant;
		yii::app()->end();
		if(($cantidadatendidaacumulada+$modelokardex->cant)== $modeloreserva->cant)
		{$modeloreserva->estadoreserva='20';///Completo...!
			///Veriifcar primero si DESOLPE tiene partido RESERVA +RESERVA PARA COMPRA
			IF($modelodesolpe->numero_reservascompras == 0 ) ///Si no tiene solicitudes de compra
				$modelodesolpe->est=='40';///Completo...!
		}



		$kardex=Alkardex::model()->findByPk(1125);
		echo "  la sumatoria de las cantidades :  ".$kardex->alkardex_alkardextraslado_emisor_cant;
		echo "  la cantidad  :  ".$kardex->cant;
		yii::app()->end();

		$modelo=New Alkardex;
		$centro=$modelo->alkardex_alinventario->cantlibre;
		echo "  el cento es  ".$centro;
		yii::app()->end();
		$modelo=Desolpe::model()->findByPk(74)->desolpe_alinventario;
		$modelo->cantlibre=1234;
		$modelo->setScenario('modificacantidad');
		$modelo->save();
		echo "  ES ".$modelo->codart;
		yii::app()->end();
		//$modelo->Actualizar($movimiento,$cantidad,$unidad,$punitario=null);
		$mensaje=$modelo->Actualizar('80',0.03,'140',null);

		//echo " El almacen : ".$modelo->desolpe_alinventario->codalm."  \n";
		 if(strlen($mensaje)== 0){
			 echo " cantidad  libre : ".$modelo->cantlibre."  \n";
			 echo " cantidad  libre : ".$modelo->cantlibre."  \n";
			 echo " cantidad reservada : ".$modelo->cantres."  \n";
			 echo " cantidad  transito : ".$modelo->canttran."  \n";
			 echo " precio unitario : ".$modelo->punit."  \n";
			 echo " cantidad  movida : ".$modelo->cantidadmovida."  \n";
			 echo " monto movido : ".$modelo->montomovido."  \n";
			// echo " La conversion  : ".Alconversiones::model()->convierte($modelo->codart,$modelo->um)."  \n";
			 //echo " catidad reservada  : ".$modelo->desolpe_alinventario->cantres."  \n";

		 } else {
			 echo "  ".$mensaje;
		 }
		yii::app()->end();
	   }

	public function actionBorraitems()
	{
		$cadeni="";
		$autoIdAll = $_POST['cajita'];
		foreach($autoIdAll as $autoId)
		{

			$cadeni.=$this->Borraitem($autoId);

		}

		echo $cadeni."<BR><BR>";

	}


public function Borraitem($id) {
	//$identidad=$_GET["id"];
	$mensaje="";
	$model=Tempalkardex::model()->findByPk($id);
	if(!is_null($model)){
		 			//verificar si el movimietno permite borrar Items
		  if($model->alkardex_almacenmovimientos->borraritems=='1'){
			  if($model->delete())
			  {$mensaje.="Se elimino el item sin problemas <br>";}  else{
				  $mensaje.="No se pudo eliminar el registro  <br>";
			  }

		  }else{
			  $mensaje.=" Este movimiento no permite borrar registros <br>";
		  }


				}else {
		$mensaje.=" No se encotro un registro con ese ID <br>";
	}
  RETURN $mensaje;
  }

    public function actionimprimir($id) {
		$modelo=$this->loadModel($id);
		$this->redirect(array('/coordocs/hacereporte',
			'id'=>$modelo->almacendocs_documentos->idreportedefault,
			'idfiltrodocu'=>$modelo->id
		));
        yii::app()->end();
        $cadena=$this->renderpartial('vw_grilla_imprimir',array('idcabecera'=>$id));
        $mpdf=Yii::app()->ePdf->mpdf();
        $mpdf->pagenumPrefix = 'Página  ';
        $mpdf->pagenumSuffix = ' ';
        $mpdf->nbpgPrefix = ' de  ';
        $mpdf->nbpgSuffix = '';
        $mpdf->SetFooter('{PAGENO}{nbpg}');
        // $mpdf->setFooter('{PAGENO}');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($cadena);
        //$mpdf->AddPage();
        //$mpdf->WriteHTML("esta es la segunda pagina");
        //$mpdf->Output();
        $vacr=md5(time());
        $mpdf->Output();
        return 1;
    }

    public function actionTraspaso(){
        $model=new Almacendocs;
		$model->valorespordefecto($this->documento);
        $model->setscenario("traspaso");
        if(isset($_POST['Almacendocs']))        {
            $model->attributes=$_POST['Almacendocs'];
            $model->codmovimiento='77';
            if($model->save()) {
                $movimiento='UpdateTraspaso';
                $this->redirect(array('updateTraspaso','id'=>$model->id,'movimiento'=> $movimiento));
            }
        }
        $this->render('traspaso',array(
            'model'=>$model,
        ));
    }

	public function actionupdatetraspaso($id){
		/*echo  "salio carajo";
		yii::app()->end();*/
		$movimiento='77';
		$signo=-1;
		$model=$this->loadModel($id);

		$model->codmovimiento=$movimiento;
		$model->setscenario("traspaso");
		$this->performAjaxValidation($model);
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save()) {
				$mensa="";
				$registroshijos= Mifactoria::DevuelveKardexHijos($id);
				foreach  ($registroshijos as $row) {
					//@$modeloinventario=$this->actualizainventario($row);
					if(!$row->alkardex_alinventario->actualiza_stock($row->codmov,$row->cant,$row->preciounit))
						$mensa.=$row->alkardex_alinventario->parsemensajes('error');
					   //@ $mensa.=$row->alkardex_alinventario->parsemensajes('notice');
					//@$mensa.=(GETTYPE($modeloinventario)=='object')?"":$modeloinventario;
					//@if(GETTYPE($modeloinventario)=='object')
					   /*@  {
							 $modeloinventario->setScenario('modificacantidad');
							 if( !$modeloinventario->save())
								 $mensa.="Hubo un error al actualizar el inventario <br>";
						 }@*/
					//$mensa.=$this->actualizacostos($modeloinventario,$row,$registrosolpe,'K','M'); //iNVENTARIO, KARDEX, DETALLESOLPE, TIPO DE COLECTOR Y SI S MATERIAL O SERVICIO
					$row->setScenario('cambioestado');
					$row->valido='1';
					$row->codestado='10';
					IF(!$row->save())
						$mensa.="Error al momento de cambiar el estado del Kardex del material ".$row->codart;
				} //fon del for
				if(strlen($mensa)==0)  { //Si s epudo actualziar
					$transaccion->commit();
					Yii::app()->user->setFlash('success', "Se genero  el documento!".$mensa);
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					yii::app()->end();
				}     else   {
					$transaccion->rollback();
					Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensa);
					$model->refresh();
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					yii::app()->end();
					//$model->refresh();
				}
			} else {// en caso de error
				$transaccion->rollback();
				Yii::app()->user->setFlash('error', "No se pudo grabar el documento :".$mensa);
				//$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
				$model->refresh();
			}
		}
		//la diferenci en ter un render y el tro lo encontramos en la condicion isenew record de la vista REINGRESO
		$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
		yii::app()->end();
	}


    public function actionImprimirsolo($id)
    {

        $vale=$this->loadModel($id);

        $usuario=Trabajadores::model()->findByPk(Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtrabajador') );
        $cadena=$this->renderpartial('reportevale',array('vale'=>$vale,'usuario'=>$usuario),true,true);
        $mpdf=Yii::app()->ePdf->mpdf();
        $hojaestilo=file_get_contents('themes/abound/css'.DIRECTORY_SEPARATOR.'estilovale.css');
        $mpdf->WriteHTML($hojaestilo,1);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($cadena,2);
        //$mpdf->Output();
       // $vacr=md5(time());
        //$mpdf->Output('assets/'.$vacr.'.pdf','F');
        $mpdf->Output();
        //return $vacr;


    }

public function actionAtiendesolpe($id)

	{
		 $modelo=Solpe::model()->findByPk($id);
		if($modelo===null ) {
			 throw new CHttpException(500,'No se encontro esta solped  :'.$id);

		} else {
			$this->render('vw_atiendesolpe',array(
				'modelo'=>$modelo,

				)

				);

		}

	}






public function actionCreadetalle($idcabeza,$cest){
	$modelocabeza=$this->loadModel((int)MiFactoria::cleanInput($idcabeza));
		$model=new Tempalkardex();
		//$model->setscenario("cargainicial");
	    $model->codmov=$modelocabeza->codmovimiento;
	    $model->setScenario($modelocabeza->codmovimiento."_SCN");
			$this->transfieredatosalhijo($model,$modelocabeza);

		if(isset($_POST['Tempalkardex']))
		{
			$model->attributes=$_POST['Tempalkardex'];
						if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
														Yii::app()->end();
											}
		}
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle',array(
			'model'=>$model, 'idcabeza'=>$idcabeza
		));

}


	public function actionCreadetalletraspaso($idcabeza){
		$modelocabeza=$this->loadModel((int)MiFactoria::cleanInput($idcabeza));
		$model=new Tempalkardex();
		$model->setscenario("traspaso");
		$model->codmov=$modelocabeza->codmovimiento;

			$this->performAjaxValidation($model);
			if(isset($_POST['Tempalkardex']))
			{
				$model->attributes=$_POST['Tempalkardex'];
				///agregamos los atributois quye faltan para compeltar
				///los datos
				$modeloreferencia=Almacendocs::model()->findByPk($idcabeza);
			//	$modelocabecera=Almacendocs::model()->findByPk($idcabeza);
				$model->fechadoc=$modeloreferencia->fechavale;
				$model->codmov='77';
				$model->codcentro=$modeloreferencia->codcentro;
				$model->alemi=$modeloreferencia->codalmacen;
				$model->aldes=$modeloreferencia->codaldestino;
				$model->fecha=$modeloreferencia->fechacont; //la fecha contable
				//$model->um=$modeloreferencia->um;
				$model->codocuref=$modeloreferencia->codocu;
				$model->idref=$modeloreferencia->id; //aqui esta lapublic_auditor
				$registroinv=Alinventario::model()->encontrarregistro($model->codcentro,$model->alemi,$model->codart);
				$model->preciounit=$registroinv->punit;
				//echo "  centro  emisro :  ".$model->codcentro."<br>";
				//echo "  almacen  emisto  :  ".$model->alemi."<br>";
				//echo "  material  :  ".$registroinv->codart."<br>";
				//echo " preciounitario  :  ".$registroinv->punit."<br>";
				//yii::app()->end();

				if($model->save()){
					  ///
					if (!empty($_GET['asDialog']))
					{
						echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");

					}
				}
			  }
			$this->layout = '//layouts/iframe';
			$this->render('_detalle_traspaso',array(
				'model'=>$model, 'idcabeza'=>$idcabeza
			));

	}




	public function actionCreadetallereingreso($idcabeza){
		$modelocabeza=$this->loadModel((int)MiFactoria::cleanInput($idcabeza));
		$model=new Tempalkardex();
		$model->setscenario("reingreso");
		$model->codmov=$modelocabeza->codmovimiento;
			//$this->performAjaxValidation($model);
			if(isset($_POST['Tempalkardex']))
			{
				$model->attributes=$_POST['Tempalkardex'];
				$modeloreferencia=Alkardex::model()->findByPk($model->idref);
				$modelocabecera=Almacendocs::model()->findByPk($idcabeza);
				$model->codart=$modeloreferencia->codart;
				$model->codmov='70';
				$model->alemi=$modeloreferencia->alemi;
				$model->aldes=$modeloreferencia->aldes;
				$model->fecha=$modelocabecera->fechacont; //la fecha contable
				$model->um=$modeloreferencia->um;
				$model->codocuref=$modeloreferencia->coddoc;
				$model->idref=$modeloreferencia->id; //aqui esta la clave de todo el asunto
				$model->preciounit=$modeloreferencia->preciounit;
				$model->codcentro=$modeloreferencia->codcentro;
				if($model->save()){			///
					if (!empty($_GET['asDialog']))
					{
						echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");

					}
				}
			}
			$this->layout = '//layouts/iframe';
			$this->render('_detalle_reingreso',array(
				'model'=>$model, 'idcabeza'=>$idcabeza
			));

	}










public function actionCrear() {
				$this->render('vw_escojer');

				}


	/*

public function actionReservar()

	{
			//$modelodesolpe=Desolpe::model()->findBypk(124);
			//echo $modelodesolpe->numeroreservas;
			$idsolpe=$_POST['vidsolpe'];
			$cantcompra=$_POST['vcantcompra'];
		  // $idsolpe=168;
			$cantreservada=$_POST['vcantreserva'];
			//$cantreservada=1;
			//$cantcompra=0;
			$modelodesolpe=Desolpe::model()->findBypk($idsolpe);
			
			$cadena="";
	 if (($cantreservada+$cantcompra) <= $modelodesolpe->cant ) {
///verificando primero que no se haya reservado antes , si hay breservas 
//simplemente no hacer nada
		if ($modelodesolpe->numeroreservas ==0 ) {
					$transaccion=$modelodesolpe->dbConnection->beginTransaction();
					
					$modelo=new Alreserva;
					$modelo->hidesolpe= $idsolpe;
					$modelo->cant=$cantreservada;
					$modelo->flag='1';
					
					//ahora tratamos el inventario
					$modeloinventario=Alinventario::model()->findByPk($modelodesolpe->desolpe_alinventario->id);
			   if(!is_null($modeloinventario)) {
					    //verificando consitencia de las cantidades del inventario
					    if( $cantreservada <= $modeloinventario->cantlibre) { // Si se intenta reservar algo que no hay en stock

								

									if ($cantcompra > 0 ) {
		 									$modelin=new Alreserva;
											$modelin->hidesolpe= $idsolpe;
											$modelin->cant=$cantcompra ;
											$modelin->flag='0';
											
									}

										$modelodesolpe->est='60'; //estado 'TOMADO'
											$modeloinventario->setscenario('modificacantidad');
											$modeloinventario->cantlibre=$modeloinventario->cantlibre-$cantreservada;
											$modeloinventario->cantres=$modeloinventario->cantres+$cantreservada;
										

									/*	$cadena="a";									   
									if (!$modelo->save()) $cadena=$cadena." -reserva reserva  falla";
										if (!$modelin->save()) $cadena=$cadena." -reserva compra  falla";
										if (!$modeloinventario->save()) $cadena=$cadena." -inventario  falla";
										 if (!$modelodesolpe->save()) $cadena="solpe falla";
										 $transaccion->commit();
										 echo $cadena;
											//$transaccion->rollback();
											*/
											
										/*if(
										$modelodesolpe->save() and 
										$modelo->save() and
										$modeloinventario->save() and 
										($cantcompra>0)?$modelin->save():true ) {
										$transaccion->commit();
									  } else {
									  	$transaccion->rollback(); ///regresar todo a como estaba
									  	throw new CHttpException(500,'Hubo un error al intentar escribir datos en Disco ');
									  } 
							} ///si se intenta reserva algo que no hay no hacer nada
							else {
									$cadena=" Esta intentado reservar una cantidad mayor al stock libre ";

							}

			      } // SI no se encuentra el registro inventario
			       else {
			       		$cadena= " No se encontro este material en el inventario, revise si esta ampliado en el alamcen y el centro ";
			       }
		} //fin de si encontro la reserva 
		else {
			$cadena=" Ya hay reservas para esta solicitud ";
		}

	} else {
		$cadena=" Esta intentando atender una cantidad mayor a la solicitada ";

	}
	
	$command = Yii::app()->db->createCommand(" insert into logdesolpe (mensa) values ('".$cadena."') "); 
	$command->execute();
		//$transaccion->commit(); 
																
	}
*/



		public function actionModificadetalle($id)
		{
		$model=Tempalkardex::Model()->findByPk($id);
		 if ($model===null)
		 	 throw new CHttpException(500,'No se encontro ningun documento Kardex para estos datos :'.$id);
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
			$model->setScenario($model->codmov."_SCN");
		if(isset($_POST['Tempalkardex']))
		{
			$model->attributes=$_POST['Tempalkardex'];
			//$model->setScenario('salidareserva');
			// echo "cantidad ".$model->cant;
			// yii::app()->end();
			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													/*echo "cantidad ".$model->cant;
													 yii::app()->end();*/
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
														Yii::app()->end();
												}
		}
		
		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';

			$this->render('_form_detalle',array(
										'model'=>$model, 'idcabeza'=>$model->hidvale,
		            							)
						);
	}


/****************************************************
	 *	Retorna una cadena '' o 'disabled' para deshabilitar los controles del form de la vista
	 *   este es un flag para deshabilitar controles y no recarga Sqls , ES PLANO
	 ****************************************************/
	public function eseditable($estadodelmodelo)
	{
		if ( $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return '';} else{return 'disabled';}
	}
	

	/****************************************************
	 *	Retorna una BOOEANO  para deshabilitar los controles del form de la vista
	 *   ESTE SI VERIFICA EN  LA BASE DE DATOS
	 ****************************************************/
	public function eseditablecab($id)

	{
		$modelin=$this->loadModel($id);
		$estadodelmodelo=$modelin->cestadovale;

		if ($estadodelmodelo=='10' or $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return 'si';} else{return 'no';}
	}




    public function actionCargainicial() {

        $model=new Almacendocs;
		$model->valorespordefecto();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if(isset($_POST['Almacendocs']))
        {
            $model->attributes=$_POST['Almacendocs'];
            $model->setscenario("cargainicial");
            $model->codmovimiento='98';


            if($model->save()) {
                /*$model->refresh();
                echo  "salio ".$model->id;
                Yii::app()->end();
                    */

                 $movimiento='Updatecargainicial';
                $this->redirect(array('updatecargainicial','id'=>$model->id,'movimiento'=> $movimiento));


            }
        }


        $this->render('cargainicial',array(
            'model'=>$model,

        ));
    }









	
	public function actionIngresacompra() {
		$model=new Almacendocs;
		$model->valorespordefecto();
        $model->setscenario("ingresacompra");
           if(isset($_POST['Almacendocs']))
									{
										$model->attributes=$_POST['Almacendocs'];			

						 					$model->codmovimiento='30';

						if($model->save()) {
                           // echo  "salio ".$model->id;
                           // Yii::app()->end();
									/*
                                     $model->refresh();*/
									 $movimiento='UpdateIngresacompra';
									$this->redirect(array('updateIngresacompra','id'=>$model->id,'movimiento'=> $movimiento));

			     						}
									}

			
		$this->render('cargainicial',array(
			'model'=>$model,
															
			));
	}
	
	public function actionSalidaReserva() {

		$model=new Almacendocs;
		$model->valorespordefecto($this->documento);
		$model->setscenario("salidareserva");
				// Uncomment the following line if AJAX validation is needed
				// $this->performAjaxValidation($model);
				if(isset($_POST['Almacendocs']))
									{
										$model->attributes=$_POST['Almacendocs'];			
						 					
						 					$model->codmovimiento='10';
						 			

						if($model->save()) {
									//$this->generadetalle($model);
									 $movimiento='UpdateSalidaReserva';
									$this->redirect(array('updateSalidaReserva','id'=>$model->id,'movimiento'=> $movimiento));

			     						}
									}

			
		$this->render('salidareserva',array(
			'model'=>$model,
															
			));
	}

	public function actionSalidaceco() {

		$model=new Almacendocs;
		$model->valorespordefecto();
		$model->setscenario("salidaceco");
		$movimiento='50';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];

			$model->codmovimiento='50';


			if($model->save()) {
				//$this->generadetalle($model);
				$movimiento=$movimiento;
				$this->redirect(array('updatesalidaceco','id'=>$model->id,'movimiento'=> $movimiento));

			}
		}


		$this->render('salidaceco',array(
			'model'=>$model,'movimiento'=> $movimiento

		));
	}





    Public function actualizaoc($movimiento, $model,$transaccion) {
        //debemos de actusalizar los registros de kardex hijos
        //recorriendo el kardex
        $statusacolocar=null;

            if ($movimiento=='30') {
                $hijos=Alkardex::model()->findall("hidvale=:hid",array(":hid"=>$model->id));
                for ($i=0; $i < count($hijos); $i++) {
                    $modelodetalle=Docompra::model()->findByPk($hijos[$i]['idref']);
                    $cantiatendida=$modelodetalle->cantidadentregada; ///la cantidada atendida
                    $cantidadingresada=$hijos[$i]['cant'];
                    $modelodetalle->setScenario('ingresacompra');

                  if($cantidadingresada <= $modelodetalle->cant-$cantiatendida) {
                      $modelentregas=new Alentregas;

					  $modelentregas->iddetcompra=$modelodetalle->id;
                      $modelentregas->cant=$hijos[$i]['cant'];
                      $modelentregas->fecha=date("Y-m-d H:i:s");
                      $modelentregas->idkardex=$hijos[$i]['id'];
                      $modelentregas->usuario=Yii::app()->user->name;
                      //actualizando el status del detalle de la OC
                      $modelodetalle->estadodetalle=($cantidadingresada==($modelodetalle->cant-$cantiatendida))?'60':'50';

							//revisando las reservas
					     $modeloreserva=Alreserva::model()->find("hidesolpe=:xidsolpe AND codocu='800' ",array(":xidsolpe"=>$modelodetalle->id));
					  if(!is_null($modeloreserva)) {

									$modeloreserva->setscenario('cambiaestado');
									$modeloreserva->estadoreserva=($cantidadingresada==($modelodetalle->cant-$cantiatendida))?'40':'20';
									$modeloreserva->save();
						 					 ECHO "SI SALIO LA RESERVA";
											 $transaccion->rollback();
						  							Yii::app()->end();
													}

                            } else {
                             $transaccion->rollback();
                             //revertimos la transaccion
                             throw new CHttpException(500,'La cantidad del item excede a lo que se ha comprado');
                            }
                    $modelodetalle->save();
                    $modelentregas->save();
               // $statusacolocar='02'; ///actualizar EL VALE
                    }  //FIN DEL BUCLE
                   }  // fin de si es un ingreso

        if ($movimiento=='40') {
            //SACAMOS LOS KARDEX HIJOS DEL VALE REFRENCIADO, OJO , NO EL VALE ACTUAL
            $valeref=Almacendocs::model()->findAll("numvale=:xnumvale",array(":xnumvale"=>trim($model->numdocref)));
            if(count($valeref) > 0) {


                $hijos=Alkardex::model()->findall("hidvale=:hid",array(":hid"=>$valeref[0]['id']));

                             for ($i=0; $i < count($hijos); $i++) {
                                 //detalle de la OC

                                 $modelentregas=Alentregas::model()->find("idkardex=:xidkardex",array(":xidkardex"=>$hijos[$i]['id']));

                                 if( !$modelentregas==null) {



                                    // $transaccion->rollback();
                                     //throw new CHttpException(500,'qeup paso   '.$modelentregas->idkardex);
                                     $detalleoc=Docompra::model()->findByPk($modelentregas->iddetcompra);
                                     $detalleoc->setScenario('ingresacompra');

                                     ///!CUIDADO LA ETREHA VAYA  A ESTAR FACTURADO
                                     if($modeloentregas->estado=='20')  {
                                         $transaccion->rollback();
                                         throw new CHttpException(500,'No se puede anular hay entregas facturadas, OC :'.$detalleoc->docompra_ocompra->numcot.'Item :'.$detalleoc->item.' ');
                                     }

                                 ///resolviendo el tema de los status del detalle de la OC
                                     $cantiatendida=$detalleoc->cantidadentregada;
                                     if (abs($hijos[$i]['cant']) == $cantiatendida)  //Si es un ingreso unico
                                         $detalleoc->estadodetalle='20'; ///aprobado
                                     if (abs($hijos[$i]['cant']) < $cantiatendida)  //Si es un ingreso parcial
                                         $detalleoc->estadodetalle='50'; ///atencionm parcial
                                     $modelentregas->delete(); //borrar las entregas
                                 } ELSE {
                                     $transaccion->rollback();
                                     throw new CHttpException(500,'No se pudo hallar la entrega correspondiente al item del vale '.$hijos[$i]['id']);
                                 }

                                if( !($detalleoc->save() and $modelentregas->save())) {
                                    $transaccion->rollback();
                                   throw new CHttpException(500,'No se pudograbar el detalle de la OC, o borrar las entregas');
                                  }

                             }
               }else {
                $transaccion->rollback();
                throw new CHttpException(500,'El numero de vale a anular no es valido, verifique la entrada :   Vale a anular:'.$model->numdocref.'   Vale actual:'.$model->numvale);
             }

            }
        }     ///SI SE TRATA DE UNA ANULACION





    public function actionUpdateIngresacompra($id)  {
        $codigomovimiento='30';
        $model=$this->loadModel($id);
        $model->setscenario("ingresacompra");
        if(isset($_POST['Almacendocs']))
        {
            $model->attributes=$_POST['Almacendocs'];
            //iniciamos la transaccion
            $model->cestadovale='20';
            $transaccion=$model->dbConnection->beginTransaction();
            if($model->save()) {
                $this->actualizahijos($codigomovimiento,$model,$transaccion);
                $this->actualizaoc($codigomovimiento,$model,$transaccion);
                 $transaccion->commit();
                 Yii::app()->user->setFlash('success', "..El ingreso   se ha grabado!");
                $this->render('update',array(
                    'model'=>$model,
                    'movimiento'=> $codigomovimiento,
                ));
            } else {
                $transaccion->rollback();
                throw new CHttpException(500,'No se pudo grabar');
            }
        } else {
            $movimiento='Updatecargainicial';
            //rellenamos los registros hijos del kardex
                    $registro=Ocompra::model()->findAll("numcot=:nimi",array("nimi"=>trim($model->numdocref)));
				if(!(count($registro)>0)) {
                    throw new CHttpException(500,'No se pudo encontrar la OC indicada');
                }else{
                    ////Verfiicando que existan en esa solpe items que esten reservadas
                    $itemscompras=Docompra::model()->findAll( "hidguia=:mipa and estadodetalle in ('20','50')  and codentro=:centrox and codigoalma=:codalx ",array(":mipa"=>$registro[0]['idguia'], ":codalx"=>$model->codalmacen, ":centrox"=>$model->codcentro));
                    if(count($itemscompras) ==0 )  {
                        throw new CHttpException(500,'Esta OC no tiene items Habilitados '.$registro[0]["idguia"].'--'.$model->codalmacen.'--'.$model->codcentro);
                    } else {
                        for ($i=0; $i < count($itemscompras); $i++) {
                                $itemcompra=Docompra::model()->findByPk($itemscompras[$i]['id']);
                                $cantatendida=$itemcompra->cantidadentregada; ///Cantidad ya entregada de la tabla alentregas
                                   if ($cantatendida < $itemcompra->cant) { ///Siempre que la cantidad comprada exceda a lo atendido
                                       if( count(Alkardex::model()->findAll("idref=:refe and codestado='99' ", array(":refe"=>$itemcompra->id)))==0) {
                                         ///siempre que el kardex no se haya creado antes, en otro caso cada que
                                           //refresca al pagina se insertarian ergistros
                                       $modelokardex=new Alkardex();
                                       $modelokardex->setscenario('ingresacompra');
                                       $modelokardex->codmov=$codigomovimiento;
                                       $modelokardex->hidvale=$model->id;
                                       $modelokardex->codart=$itemscompras[$i]['codart'];
                                       $modelokardex->alemi=$model->codalmacen;
                                       $modelokardex->codcentro=$model->codcentro;
                                       $modelokardex->fecha=$model->fechacont;
                                       $modelokardex->codocuref='210'; //Ocompra
                                       $modelokardex->numdocref=$model->numdocref;	//numero de la OC
                                       $modelokardex->idref=$itemscompras[$i]['id']; //el id del detalle de la oc
                                       $modelokardex->preciounit=$itemscompras[$i]['punit'];
                                          if($cantatendida == 0 )  {
                                       $modelokardex->cant=$itemscompras[$i]['cant'];
                                          }else {
                                        $modelokardex->cant=$itemscompras[$i]['cant']-$cantatendida;
                                          }



                                       if( !$modelokardex->save()) throw new CHttpException(500,'no grabo');
                                       }
                                   }
                                 }
                              }
                             }
            ////////////////////
            $this->render('update',array(
                'model'=>$model,
                'movimiento'=> $movimiento,
            ));

        }

        }


    public function actionAnulaCargainicial() {
        $movimiento='99';
        $signo=-1;
		$model=new Almacendocs;
		$model->valorespordefecto();
		$model->setscenario("anulacargainicial");
		$model->codmovimiento=$movimiento;
				// Uncomment the following line if AJAX validation is needed
				$this->performAjaxValidation($model);
				if(isset($_POST['Almacendocs']))
									{
									$modeloaanular=Almacendocs::model()->find("numvale=:nimi",array("nimi"=>trim($_POST['Almacendocs']['numdocref'])));		
										$model->attributes=$_POST['Almacendocs'];			
						 					
						 					$model->codmovimiento=$movimiento;
											$model->codcentro=$modeloaanular->codcentro; 
						 			

						if($model->save()) {
											//$matriz=Almacendocs::model()->findAll("numvale=:nimi",array("nimi"=>trim($_POST['Almacendocs']['numdocref'])));
											$matrizkardex=Alkardex::model()->findall("hidvale=:xid",array("xid"=>$modeloaanular->id));
											//echo $matriz[0]['id'];
											//Yii::app()->end();
							 //echo "salio".count($matrizkardex);
							   for ($i=0; $i < count($matrizkardex); $i++) { 
							   
							   //creando un clon de lo que s equiere anular 
							   $modelok=new Alkardex;
							   $modelok->hidvale=$model->id;
							   $modelok->codocuref='101'; //vale almacen
							   $modelok->numdocref=$model->numvale;
							   $modelok->setscenario('anulacargainicial'); ///El escenario es el mismo de la carga inicial
							   $modelok->codart=trim($matrizkardex[$i]['codart']);
							   $modelok->cant=$signo*$matrizkardex[$i]['cant'];
							   $modelok->um=$matrizkardex[$i]['um'];
							   $modelok->preciounit=$matrizkardex[$i]['preciounit'];
							   $modelok->codcentro=$matrizkardex[$i]['codcentro'];
							   $modelok->alemi=$matrizkardex[$i]['alemi'];
							   $modelok->fechadoc=$model->fechavale;
							   $modelok->fecha=$model->fechacont;
							    $modelok->idref=$modeloaanular->id;
							     $modelok->codmov=$movimiento ;
							   $modelok->save();
							   $modeloaanular->cestadovale='30'; //ANULAR
							   $modeloaanular->save();
							 
							
							 
								///anulacion 
								
							   //actualiza el precio pero con los id de los kardex originales
									//Alkardex::model()->findByPk($matrizkardex[$i]["id"])->Actualizaprecioinventario( $modelok->codmov);
										
							}
						 $movimiento='Confirmaanulacioncargainicial';
							 $this->redirect(array('confirmaanulacargainicial','id'=>$model->id,'movimiento'=> $movimiento));
							 
						
						
									//$this->generadetalle($model);
									// $movimiento='Updatecargainicial';
									//$this->redirect(array('updatecargainicial','id'=>$model->id,'movimiento'=> $movimiento));

			     						}
									}

			
		$this->render('anulacargainicial',array(
			'model'=>$model,
															
			));
	
	/*
		$model=$this->loadModel($id);
						$transaccion=$model->dbConnection->beginTransaction();
							$matrizkardex=Alkardex::model()->findall("hidvale=:xid",array("xid"=>$id));
							 //echo "salio".count($matrizkardex);
							   for ($i=0; $i < count($matrizkardex); $i++) { 
							   //creando un clon de lo que s equiere anular 
							   $modelok=new Alkardex;
							   $modelok->setscenario('anulacargainicial'); ///El escenario es el mismo de la carga inicial
							   $modelok->codart=trim($matrizkardex[$i]['codart']);
							   $modelok->cant=$matrizkardex[$i]['cant'];
							   $modelok->um=$matrizkardex[$i]['um'];
							   $modelok->preciounit=$matrizkardex[$i]['preciounit'];
							   $modelok->codcentro=$matrizkardex[$i]['codcentro'];
							   $modelok->alemi=$matrizkardex[$i]['alemi'];
							     $modelok->codmov='99' ;
							   $modelok->save();
							 
								///anulacion 
								
							   //actualiza el precio pero con los id de los kardex originales
									Alkardex::model()->findByPk($matrizkardex[$i]["id"])->Actualizaprecioinventario( $modelok->codmov);
										
							}
							
							$transaccion->commit();
		*/
	                    }
	public function actionAnulaingresocompra() {
        $movimiento='40';
        $signo=-1; ///el signo es opuesto al signo de la anulacion
        $model=new Almacendocs;
		$model->valorespordefecto();
        $model->codmovimiento=$movimiento;
        $model->setscenario("anulaingresocompra");
        $this->performAjaxValidation($model);
        if(isset($_POST['Almacendocs']))
        {
            $modeloaanular=Almacendocs::model()->find("numvale=:nimi",array("nimi"=>trim($_POST['Almacendocs']['numdocref'])));
            $model->attributes=$_POST['Almacendocs'];
            $model->codmovimiento=$movimiento;
            $model->codcentro=$modeloaanular->codcentro;
            $modeloaanular->cestadovale='30'; //ANULAR

            if($model->save()) {
                $matrizkardex=Alkardex::model()->findall("hidvale=:xid",array("xid"=>$modeloaanular->id));
                for ($i=0; $i < count($matrizkardex); $i++) {
                    //creando un clon de lo que s equiere anular
                    //Verificando el stock, si existe libre disponibilidad del stock para anular
                    $cantidadstocklibre=Alkardex::model()->findByPk($matrizkardex[$i]['id'])->alkardex_alinventario->cantlibre;
                    if ($cantidadstocklibre > $matrizkardex[$i]['cant'] ) {
                        //identificando la entrega que corresponde
                      // $modeloentrega= Alentregas::model()->find("idkardex=:xidkardex",array(":xidkardex"=>$matrizkardex[$i]['id']));
                    $modelok=new Alkardex;
                    $modelok->hidvale=$model->id;
                    $modelok->codocuref='350'; //Detalle solped
                    $modelok->numdocref=$model->numvale;
                    $modelok->setscenario('anulaingresocompra'); ///El escenario es el mismo de la carga inicial
                    $modelok->codart=trim($matrizkardex[$i]['codart']);
                    $modelok->cant=$signo*$matrizkardex[$i]['cant'];
                    $modelok->um=$matrizkardex[$i]['um'];
                    $modelok->preciounit=$matrizkardex[$i]['preciounit'];
                    $modelok->codcentro=$matrizkardex[$i]['codcentro'];
                    $modelok->alemi=$matrizkardex[$i]['alemi'];
                    $modelok->fechadoc=$model->fechavale;
                    $modelok->fecha=$model->fechacont;
                    $modelok->idref=$matrizkardex[$i]['idref'];
                    $modelok->codmov=$movimiento ;
                    $modelok->save();
                       // if(!$modeloentrega===null)
                   //  $modeloentrega->delete(); ///borrar la entrega correspondiente
                     } else {
                        throw new CHttpException(500,'No se puede anular este vale, ya se ha conusmido el stock libre resultadio del ingreso de la compra ');

                    }


                }
                $modeloaanular->save();
                $movimiento='Confirmaanulacioningresocompra';
                $this->redirect(array('Confirmaanulacioningresocompra','id'=>$model->id,'movimiento'=> $movimiento));
            }
        }
        $this->render('anulaingresocompra',array(
            'model'=>$model,

        ));



    }

   public function actionconfirmaanulacioningresocompra($id) {
       $movimiento='40';
       $model=$this->loadModel($id);
       $model->setscenario("anulaingresocompra");
       if(isset($_POST['Almacendocs']))
       {
           $model->attributes=$_POST['Almacendocs'];
           //iniciamos la transaccion
           $model->cestadovale='20';
           $transaccion=$model->dbConnection->beginTransaction();
           if($model->save()) {
               //Yii::app()->end();

               $this->actualizahijos($movimiento,$model,$transaccion);
               $this->actualizaoc($movimiento,$model,$transaccion);
               //$this->generacontabilidad($model);
               //finalizamos la transaccion
               $transaccion->commit();
               //$this->redirect(array('view','id'=>$model->id));
               Yii::app()->user->setFlash('success', "..El vale se ha anulado!");
               $this->render('update',array(
                   'model'=>$model,
                   'movimiento'=> $movimiento,
               ));
           } else {
               //revertimos la transaccion
               throw new CHttpException(500,'No se pudo grabar');
           }
       } else {
           $movimiento='Confirmaanulacioningresocompra';
           $this->render('update',array(
               'model'=>$model,
               'movimiento'=> $movimiento,
           ));

   }
   }

	public function actionReingreso() {
       $movimiento='70';
		$signo=-1;
		$model=new Almacendocs;
		$model->valorespordefecto();
	   $model->codmovimiento=$movimiento;
		$model->setscenario("reingreso");
		$this->performAjaxValidation($model);
			if(isset($_POST['Almacendocs']))
									{
										$model->attributes=$_POST['Almacendocs'];
						if($model->save()) {

								//$this->render('reingreso',array('model'=>$model,'movimiento'=>$movimiento));
							$this->redirect(array('updatereingreso','id'=>$model->id,'movimiento'=> $movimiento));

							//Yii::app()->end();
								}
							}
					//la diferenci en ter un render y el tro lo encontramos en la condicion isenew record de la vista REINGRESO
				$this->render('reingreso',array('model'=>$model,'movimiento'=>$movimiento));
	}


	public function actionConformidad() {
		$movimiento='80';
		//$signo=1;
		$model=new Almacendocs;
		$model->valorespordefecto();
		$model->codmovimiento=$movimiento;
		$model->setscenario("reingreso");
		$this->performAjaxValidation($model);
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];
			if($model->save()) {

				//$this->render('reingreso',array('model'=>$model,'movimiento'=>$movimiento));
				$this->redirect(array('updateacta','id'=>$model->id,'movimiento'=> $movimiento));

				//Yii::app()->end();
			}
		}
		//la diferenci en ter un render y el tro lo encontramos en la condicion isenew record de la vista REINGRESO
		$this->render('conformidad',array('model'=>$model,'movimiento'=>$movimiento));
	}







/*	public function actualizainventario($kardex) {
						//recorro todos los hijos
							$modeloinventario= Alinventario::model()->findByPk($kardex->alkardex_alinventario->id);
								//actualizando el inventario
								$mensa.=$modeloinventario->Actualizar($kardex->codmov,$kardex->cant,$kardex->um,$kardex->preciounit);
									$mensa.=(strlen($mensa) > 0)?"<br>":"";
									$modeloinventario->setScenario('modificacantidad');
									$mensa.=($modeloinventario->save())?"":"No se pudo actualizar el registro de Inventario del  material ".$row->codart."  <br>";
	       RETURN (strlen($mensa)==0)?$modeloinventario:$mensa;
	         //7SI HAY EXITO DEVULE UN REGISTRO ACTIVE RECORD DE INVENTARIO, SINO UNA CADENA
	}*/


	Public function actualizasolpenueva($kardex, $desolpe,$inventario) {
          $cadena="";
		$modeloreserva=Alreserva::model()->find("hidesolpe=:hidesolpex and codocu='450' ", array("hidesolpex"=>$kardex->idref));
		$modeloreserva->setScenario('cambiaestado');
		if ($kardex->codmov=='10') {
			$modeloreserva->estadoreserva='20'; ///actualizar a reserva ATENDIDA
			$cantidadreservada=$modeloreserva->cant;
			if ($cantidadreservada==$modelodetalle->cant ) { //si lo que pidio es lo que se reresvo es una atencion total
				$modelodetalle->est='40'; //atendido totalmente
			} else { //en cambio
				if (!$cantidadreservada > 0 ) //si es una cantidad reservada > 0 quiere decir que es parcial , si es cero el status no varia
					$modelodetalle->est='50';  //atendido parcialmente
			}			//actualizamos el precio unitario real del detalle de la Solpe
			$desolpe->punitreal=$inventario->punit+$inventario->punitdif;
			$desolpe->atendido=date("Y-m-d H:i:s");
		    }

		if ($kardex->codmov=='20') {
			$desolpe->est='60'; //Volver a colocar el estado 'reservado'
			//refrescar  el status de la reserva tambien pe...
			$desolpe->estadoreserva='10'; ///
			$desolpe->punitreal=0;
			$desolpe->atendido=null;
		}

		if ($kardex->codmov=='70') {
			//Insertar un nuevo registro en  la solpe para dar fe de que se ha reingresado
			$desolpe->punitreal=$inventario->punit+$inventario->punitdif;
			$nuevasolpe=New Desolpe;
			$nuevasolpe->atttributes=$desolpe->getAttributes();
			$nuevasolpe->cant=-1*abs($kardex->cant);
			$nuevasolpe->um=$kardex->um;
			  if(!$nuevasolpe->save())
				  $cadena.=" Hubo un error al registrar el reingreso de la Solpe  ".$desolpe->desolpe_solpe->numero."-".$desolpe->item." ";

			//$desolpe->est='06'; //Volver a colocar el estado 'reservado'
			//refrescar  el status de la reserva tambien pe...
			//$desolpe->estadoreserva='01'; ///
			//$desolpe->punitreal=0;
			//$desolpe->atendido=null;
		}

		if($desolpe->save() and $modeloreserva->save()) {
			//Yii::app()->user->setFlash('succcess', " La solicitud  ".$modelodetalle->desolpe_solpe->numero."-".$modelodetalle->item. " se ha actualizado");

		} else {
			$cadena.=" Hubo un error al grabar los datos de la solicitud  ".$desolpe->desolpe_solpe->numero."-".$desolpe->item. " ";
			//$transaccion->rollback();
			//yii::app()->end();
		}


	}

  public function devuelvehijos($id){
	  return MiFactoria::DevuelveKardexHijos($id);
  }





	public function actionUpdateReingreso($id) {
		$movimiento='70';
		$signo=-1;
		$model=$this->loadModel($id);
		$model->codmovimiento=$movimiento;
		$model->setscenario("reingreso");
		$this->performAjaxValidation($model);
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save()) {
				  /* $mensa=$this->actualizahijos($movimiento,$model,$transaccion);
				if(strlen($mensa)==0)  { //Si s epudo actualziar
						$this->actualizacostes($model,$transaccion);
					$transaccion->commit();
					Yii::app()->user->setFlash('success', "Se genero  el documento!".$mensa);
					//$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
				*/
				 $mensa="";
				$registroshijos=$this->devuelvehijos($model->id);
				 ///Recorrer los hijos
				//GETTYPE()
				foreach  ($registroshijos as $row) {
					     //gettype()
					 $registrosolpe=Desolpe::model()->findByPk($row->idref);
					 $modeloinventario=$this->actualizainventario($row);

					 $mensa.=(GETTYPE($modeloinventario)=='object')?"":$modeloinventario;
					 $mensa.=$this->actualizacostos($modeloinventario,$row,$registrosolpe,$registrosolpe->tipimputacion,$registrosolpe->tipsolpe); //iNVENTARIO, KARDEX, DETALLESOLPE, TIPO DE COLECTOR Y SI S MATERIAL O SERVICIO
                         $row->setScenario('cambioestado');
					$row->valido='1';
					     $row->codestado='10';
					    IF(!$row->save())
							$mensa.="Error al momento de cambiar el estado del Kardex del material ".$row->codart;
                       } //fon del for
							if(strlen($mensa)==0)  { //Si s epudo actualziar
					            $transaccion->commit();
					            Yii::app()->user->setFlash('success', "Se genero  el documento!".$mensa);
								$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
								yii::app()->end();
							}     else   {
								$transaccion->rollback();
								Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensa);
								$model->refresh();
								$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
								//$model->refresh();
							}
				} else {// en caso de error
					$transaccion->rollback();
					Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay un error en el stock :".$mensa);
					//$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					$model->refresh();
				}


		}
		//la diferenci en ter un render y el tro lo encontramos en la condicion isenew record de la vista REINGRESO
		$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
	}


	public function actionAnulasalidareserva() {
	$movimiento='20';
	$signo=-1; ///el signo es opuesto al signo de la anulacion
		$model=new Almacendocs;
		$model->valorespordefecto();
		$model->codmovimiento=$movimiento;
		$model->setscenario("anulacargainicial");$this->performAjaxValidation($model);
				if(isset($_POST['Almacendocs']))
									{
									$modeloaanular=Almacendocs::model()->find("numvale=:nimi",array("nimi"=>trim($_POST['Almacendocs']['numdocref'])));		
										$model->attributes=$_POST['Almacendocs'];
						 					$model->codmovimiento=$movimiento;
											$model->codcentro=$modeloaanular->codcentro; 
						if($model->save()) {
											$matrizkardex=Alkardex::model()->findall("hidvale=:xid and codestado <> '98'",array("xid"=>$modeloaanular->id));
											  for ($i=0; $i < count($matrizkardex); $i++) { 
											  //creando un clon de lo que s equiere anular 
							   $modelok=new Alkardex;
							   $modelok->hidvale=$model->id;
							   $modelok->codocuref='350'; //Detalle solped
							   $modelok->numdocref=$model->numvale;
							   $modelok->setscenario('anulacargainicial'); ///El escenario es el mismo de la carga inicial
							   $modelok->codart=trim($matrizkardex[$i]['codart']);
							   $modelok->cant=$signo*$matrizkardex[$i]['cant'];
							   $modelok->um=$matrizkardex[$i]['um'];
							   $modelok->preciounit=$matrizkardex[$i]['preciounit'];
							   $modelok->codcentro=$matrizkardex[$i]['codcentro'];
							   $modelok->alemi=$matrizkardex[$i]['alemi'];
							   $modelok->fechadoc=$model->fechavale;
							   $modelok->fecha=$model->fechacont;
							    $modelok->idref=$matrizkardex[$i]['idref'];
							     $modelok->codmov=$movimiento ;
							   $modelok->save();
							   //$modeloaanular->cestadovale='30'; //ANULAR
							  // $modeloaanular->save();
							   }
						 $movimiento='Confirmaanulacionsalidareserva';
							 $this->redirect(array('confirmaanulacionsalidareserva','id'=>$model->id,'movimiento'=> $movimiento));
							 }
									}
		$this->render('anulasalidareserva',array(
			'model'=>$model,
															
			));
	
	
	                    }
	
	
	/*public function actionCreate()
	{

		if (empty($_POST['opciondocu'])) {
				throw new CHttpException(404,'Tiene que elegir una opcion');
		} else {
			    $opcionmovimiento=$_POST['opciondocu'];
			
		}

			switch ($opcionmovimiento) {   
						
						 			case '98': 
						 					$this->redirect(array('Cargainicial'));
						 					break;
						 			case '99': 
											$this->redirect(array('AnulaCargainicial'));
						 					break;
						 			case '10':
											$this->redirect(array('SalidaReserva'));
						 					break;
									case '20':
											$this->redirect(array('AnulaSalidaReserva'));
						 					break;
											
									case '30':
											$this->redirect(array('Ingresacompra'));
						 					break;
                                    case '40':
                                            $this->redirect(array('Anulaingresocompra'));
                                            break;

                                     case '50':
                                            $this->redirect(array('Salidaceco'));
                                            break;
										case '70':
									$this->redirect(array('Reingreso'));
											break;
									case '60':
											$this->redirect(array('Anulasalidaceco'));
											break;
									case '77':
										$this->redirect(array('Traspaso'));
									break;
									case '78':
										$this->redirect(array('Ingresatraslado'));
										break;

               						 default:
											 throw new CHttpException(500,'-Se ha tomado un movimiento que no es valido '.$opcionmovimiento);
	  								}











		
	}/*

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Almacendocs']))
		{
			
			
			$model->attributes=$_POST['Almacendocs'];
			if($model->save()) {

				//Yii::app()->end();
				$this->generacontabilidad($model);
				//$this->cestadovale='02';
				$this->redirect(array('view','id'=>$model->id));


			      } else {
			      	throw new CHttpException(500,'No se pudo grabar');
			      }
		} else {
				$this->render('update',array(
			'model'=>$model,
		));
			      }



		
	}



	public function actionUpdateingresatraslado($id)
	{		$codigomovimiento='78';
		$model=$this->loadModel($id);
		$model->setscenario("traspaso");
		/*print_r($model);
		yii::app()->end();*/
		if(isset($_POST['Almacendocs']) ) //siempre que no sea un ajax
		{
			$model->attributes=$_POST['Almacendocs'];
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save()) {
				$mensa="";
				$registroshijos=$this->devuelvehijos($model->id);
				foreach  ($registroshijos as $row) {
					$modeloinventario=$this->actualizainventario($row);
					//ahora toca actualizar el inventario del almacen emisor para bajar el stock en transito
					$inventarioemisor=Alkardex::model()->findByPk($row->idref)->alkardex_alinventario;
					$inventarioemisor->canttran=$inventarioemisor->canttran-$row->cant;
					IF($inventarioemisor->canttran < 0)
						$mensa.="  El material ".$row->codart." :  Esta intentado ingresar una cantidad que sobrepasa a lo que hay en transito <br>";
					$inventarioemisor->setScenario('modificacantidad');

					//ahora registramos las entgrgas en la tabla puente
					$entrega=New Alkardextraslado;
					$entrega->hidkardexemi=$row->idref;
					$entrega->hidkardexdes=$row->id;
					$entrega->cant=$row->cant;
					$entrega->codestado='10';
					$entrega->save();

					IF(!$inventarioemisor->save())
						$mensa.="Error al momento de actualizar el stock de transito del almacen emisor ".$row->codart;
					$row->setScenario('cambioestado');
					$row->valido='1';
					$row->codestado='10';
					IF(!$row->save())
						$mensa.="Error al momento de cambiar el estado del Kardex del material ".$row->codart;
				} //fon del for
				if(strlen($mensa)==0)  { //Si s epudo actualziar
					$transaccion->commit();
					Yii::app()->user->setFlash('success', "Se genero  el documento!".$mensa);
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					yii::app()->end();
				}     else   {
					$transaccion->rollback();
					Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensa);
					$model->refresh();
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					yii::app()->end();
				}

			} else {  //7En caso de que no se haya grabado el domcumento cabecera
				$transaccion->rollback();
				Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  en la cebecera :".$mensa);
				$model->refresh();
				$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
			}


		} else {
			$movimiento='78';
			/*$itemsremitidos = Alkardex::model()->findAllBySql(" select   t.id, t.codart,t.um,t.codcentro, t.cant,t.alemi,t.codcendes,t.preciounit from
  																".Yii::app()->params['prefijo']."alkardex t
  																 where
  																 t.codmov='77' and
  																 t.codestado <> '99' and
  																 t.valido = '1' and
  																 t.codcentro='".$model->codcendestino."' and
  																  t.alemi='".$model->codaldestino."'");*/


			$itemsremitidos =Alkardex::model()->findAllBySql ("
 									select t.id, t.codart,t.um,t.codcentro, t.cant,t.alemi,t.codcendes,t.preciounit , sum(x.cant) as sumita
 									 from
 									 ".Yii::app()->params['prefijo']."alkardex t
 									LEFT JOIN ".Yii::app()->params['prefijo']."alkardextraslado x ON t.id=x.hidkardexemi
 									where
 									                             t.codmov='77' and
  																 t.codestado <> '99' and
  																 t.valido = '1' and
  																 t.codcentro='".$model->codcendestino."' and
  																  t.alemi='".$model->codaldestino."'  and
																	t.codestado='10'
 									group by t.id, t.codart,t.um,t.codcentro, t.cant,t.alemi,t.codcendes,t.preciounit
 									HAVING sum(x.cant) < t.cant or sum(x.cant) is null ");




				if(count($itemsremitidos) ==0 )  {
					throw new CHttpException(500,'Para el centro '.$model->codcendestino.' y almacen  '.$model->codaldestino.' indicados como emisores no existen items trasladados');
				} else {
					foreach  ($itemsremitidos as $row) {
						if($row->alkardex_alkardextraslado_emisor_cant < $row->cant and !isset($_GET['ajax'])) { //solo si se aun no se han completado las cantidades agregar

							$modelokardex=new Alkardex();
							$modelokardex->setscenario('ingresotraspaso');
							$modelokardex->codmov=$codigomovimiento;
							$modelokardex->hidvale=$model->id;
							$modelokardex->codart=$row->codart;
							$modelokardex->alemi=$model->codalmacen;
							$modelokardex->codcentro=$model->codcentro;
							$modelokardex->fecha=$model->fechacont;
							$modelokardex->fechadoc=$model->fechavale;
							$modelokardex->codocuref='101'; //detalle solpe
							//$modelokardex->numdocref=$model->numdocref;	//numero de la solpe
							$modelokardex->um=$row->um; //La misma unidad no nos compliqemos con conerswiones
							$modelokardex->idref=$row->id; //el id del kardex emisor
							$modelokardex->preciounit=$row->preciounit;
							echo " <br><br><br><br><br> el precio unitario pasado del kardex ".$row->id."   es    : ".$row->preciounit."<br>";
							$modelokardex->cant=abs($row->cant-$row->alkardex_alkardextraslado_emisor_cant); //la mism acantida dx defaul si no la puede cambiar por una menor, si llega x partes
							if( !$modelokardex->save()) throw new CHttpException(500,'no grabo');
						}
					}
				}

			}
			////////////////////
			$this->render('update',array(
				'model'=>$model,
				'movimiento'=> $movimiento,
			));
		}

	public function actionUpdateSalidaReserva($id)
	{		$codigomovimiento='10';
		$model=$this->loadModel($id);
		$model->setscenario("salidareserva");
		if(isset($_POST['Almacendocs']) ) //siempre que no sea un ajax
		{
			$model->attributes=$_POST['Almacendocs'];
			//iniciamos la transaccion 
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save()) {
				$mensa="";$registroshijos=$this->devuelvehijos($model->id);
				foreach  ($registroshijos as $row) {
					$registrosolpe=Desolpe::model()->findByPk($row->idref);
					$modeloinventario=$this->actualizainventario($row);
					$mensa.=(GETTYPE($modeloinventario)=='object')?"":$modeloinventario;
					$mensa.=$this->actualizacostos($modeloinventario,$row,$registrosolpe,$registrosolpe->tipimputacion,$registrosolpe->tipsolpe); //iNVENTARIO, KARDEX, DETALLESOLPE, TIPO DE COLECTOR Y SI S MATERIAL O SERVICIO
					$mensa.=$this->Actualizaatenciones($registrosolpe,$row);
					$row->setScenario('cambioestado');
					$row->valido='1';
					$row->codestado='10';
					IF(!$row->save())
						$mensa.="Error al momento de cambiar el estado del Kardex del material ".$row->codart;
				} //fon del for



				if(strlen($mensa)==0)  { //Si s epudo actualziar
					$transaccion->commit();
					Yii::app()->user->setFlash('success', "Se genero  el documento!".$mensa);
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					yii::app()->end();
				}     else   {
					$transaccion->rollback();
					Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensa);
					$model->refresh();
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					//$model->refresh();
				}

			} else {  //7En caso de que no se haya grabado el domcumento cabecera
				$transaccion->rollback();
				Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  en la cebecera :".$mensa);
				$model->refresh();
				$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
			}


		} else {
			$movimiento=$model->codmovimiento;
			//rellenamos los registros hijos del kardex
			$registro=Solpe::model()->findAll("numero=:nimi",array("nimi"=>trim($model->numdocref)));
				if(!(count($registro)>0)) {
					throw new CHttpException(500,'No se pudo encontrar la Solpe indicada');
						}else{
			              $itemsreservados=MiFactoria::DevuelveSolpespendientes($registro->id);
						if(count($itemsreservados) ==0 )
						   {
								throw new CHttpException(500,'Esta solpe no tiene items reservados');
							} else
						   {						      //
							   foreach  ($itemsreservados as $row)
							   {
								  MiFactoria::CreaTempKardex($model->id,$model->codmovimiento,$row);
							   }
							}
				  
							}
			////////////////////
				$this->render('update',array(
			'model'=>$model,
			'movimiento'=> $movimiento,
		));
			      }		
	}


	public function actionUpdateSalidaceco($id)
	{

		$codigomovimiento='50';
		$model=$this->loadModel($id);
		$model->setscenario("salidaceco");
		//echo gettype($_POST['Almacendocs']);
		//echo "se grabo";
		//Yii::app()->end();
		if(isset($_POST['Almacendocs']) ) //siempre que no sea un ajax
		{
			//echo "se grabo";
			//Yii::app()->end();
			$model->attributes=$_POST['Almacendocs'];			//iniciamos la transaccion
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save() and
				($this->actualizacostes($model,$transaccion,$model->ceco)) and
				($this->actualizahijos($codigomovimiento,$model,$transaccion)) ) {
							$transaccion->commit();
							Yii::app()->user->setFlash('success', "..La salida  se ha grabado!");

			} else {
				$transaccion->rollback();
			  Yii::app()->user->setFlash('error', "No se pudo grabar el documento!");
				//revertimos la transaccion
				//throw new CHttpException(500,'No se pudo grabar');
			}

			$this->render('update',array(
				'model'=>$model,
				'movimiento'=> $codigomovimiento,
			));

		} else {
			//$movimiento='Updatesalidaceco';
			////////////////////
			$this->render('update',array(
				'model'=>$model,
				'movimiento'=> $codigomovimiento,
			));
		}
	}


public function actionUpdatecargainicial($id)
	{
    
		$movimiento='99';
		$model=$this->loadModel($id);
		$model->setscenario("cargainicial");
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];
			//iniciamos la transaccion 
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save()) {
				$mensa="";
				$registroshijos=$this->devuelvehijos($model->id);
						foreach  ($registroshijos as $row) {
											$modeloinventario=$this->actualizainventario($row);
											$mensa.=(GETTYPE($modeloinventario)=='object')?"":$modeloinventario;
							                   echo " <br> <br> Est ee s l precio unitario de l kardex  ".$row->id."    es  : ".$row->preciounit."   <br>";
												$row->setScenario('cambioestado');
												$row->valido='1';
												$row->codestado='10';
														IF(!$row->save())
																$mensa.="Error al momento de cambiar el estado del Kardex del material ".$row->codart;
				     									} //fin del for
								if(strlen($mensa)==0)  { //Si s epudo actualziar
								$transaccion->commit();
								Yii::app()->user->setFlash('success', "Se genero  el documento!".$mensa);
									$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
									yii::app()->end();
						}     else   {
							$transaccion->rollback();
								Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensa);
								$model->refresh();
								$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
									yii::app()->end();
								}
			      } else {
				$transaccion->rollback();
				Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensa);
				$model->refresh();
				$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
				yii::app()->end();
			}
		} else {
			$movimiento=$codigomovimiento;
				$this->render('update',array(
			'model'=>$model,
			'movimiento'=> $movimiento,
		));
			      }		
	}



	
public function actionConfirmaanulacargainicial($id)
	{
    
		$movimiento='99';
		$model=$this->loadModel($id);
		$model->setscenario("anulacargainicial");
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];
			//iniciamos la transaccion 
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save()) {
				//Yii::app()->end();
				
				$this->actualizahijos($movimiento,$model,$transaccion);
				//$this->generacontabilidad($model);				
				//finalizamos la transaccion
				$transaccion->commit();
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->setFlash('success', "..La carga inicial se ha anulado!");
						$this->render('update',array(
							'model'=>$model,
							'movimiento'=> $movimiento,
							));
			      } else {
			      	//revertimos la transaccion
			      	throw new CHttpException(500,'No se pudo grabar');
			      }
		} else {
			$movimiento='Confirmaanulacargainicial';
				$this->render('update',array(
			'model'=>$model,
			'movimiento'=> $movimiento,
		));
			      }		
	}

public function actionConfirmaanulacionsalidareserva($id)
	{
    
		$movimiento='20';
		$model=$this->loadModel($id);
		$model->setscenario("anulacargainicial");
		if(isset($_POST['Almacendocs']))
		{
			$model->attributes=$_POST['Almacendocs'];
			//iniciamos la transaccion 
			$model->cestadovale='20';
			$transaccion=$model->dbConnection->beginTransaction();
			$mensa="";
			if($model->save())
			{
			               $registroshijos=$this->devuelvehijos($model->id);
				foreach  ($registroshijos as $row)
				         {
				              $modeloinventario=$this->actualizainventario($row);
							  $registrodesolpe=Desolpe::model()->findByPk($row->idref);
				               $mensa.=(GETTYPE($modeloinventario)=='object')?"":$modeloinventario;
				              if(GETTYPE($modeloinventario)=='object')
				                  {
					                 $modeloinventario->setScenario('modificacantidad');
					                   if( !$modeloinventario->save())
						                   $mensa.="Hubo un error al actualizar el inventario <br>";
									     $this->actualizacostos($modeloinventario,$row,$registrodesolpe,$registrodesolpe->tipimputacion,$registrodesolpe->tipsolpe);

				                  }
							 $this->Actualizaatenciones($registrodesolpe,$row);
							 $row->setScenario('cambioestado');
							 $row->valido='1';
							 $row->codestado='10';
							 IF(!$row->save())
								 $mensa.="Error al momento de cambiar el estado del Kardex del material ".$row->codart;

			                }
				                  //Ahora actualizamos el status del vale original, ANULARLO !!!!
				                       $valeoriginal=Almacendocs::model()->find("numvale=:vnumvale",array(":vnumvale"=>trim($model->numdocref)));
				                         $valeoriginal->setScenario('cambioestado');
												$valeoriginal->cestadovale='30'; //anulado
				                             IF(!$valeoriginal->save())
					                             $mensa.="Error al momento de cambiar el estado del Vale del material ".$valeoriginal->numvale;
				if(strlen($mensa)==0)  { //Si s epudo actualziar
					$transaccion->commit();
					Yii::app()->user->setFlash('success', "Se genero  el documento!".$mensa);
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					yii::app()->end();
				}     else   {
					$transaccion->rollback();
					Yii::app()->user->setFlash('error', "No se pudo grabar el documento, hay  errores  :".$mensa);
					$model->refresh();
					$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
					yii::app()->end();
					//$model->refresh();
				}
			} else {// en caso de error
				$transaccion->rollback();
				Yii::app()->user->setFlash('error', "No se pudo grabar el documento :".$mensa);
				$model->refresh();
				$this->render('update',array('model'=>$model,'movimiento'=>$movimiento));
				yii::app()->end();

			}
			  }else {
			$movimiento='Confirmaanulacargainicial';
			$this->render('update',array(
				'model'=>$model,
				'movimiento'=> $movimiento,
			));
		}

		/*if($model->save()) {
				//Yii::app()->end();
				$this->actualizasolpe($movimiento,$model,$transaccion);
				$this->actualizacostes($model,$transaccion);
				$this->actualizahijos($movimiento,$model,$transaccion);
				//$this->generacontabilidad($model);				
				//finalizamos la transaccion
				$transaccion->commit();
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->setFlash('success', "..La salida para reserva  se ha anulado!");
						$this->render('update',array(
							'model'=>$model,
							'movimiento'=> $movimiento,
							));
			      } else {
			      	//revertimos la transaccion
			      	throw new CHttpException(500,'No se pudo grabar el documento vale');
			      }
		} else {
			$movimiento='Confirmaanulacargainicial';
				$this->render('update',array(
			'model'=>$model,
			'movimiento'=> $movimiento,
		));
			      }		*/
	}
	
	
  Public function actualizahijos($codigomovimiento,$model,$transaccion) {
  	//debemos de actusalizar los registros de kardex hijos
     //recorriendo el kardex
	  //solo en caso de que le movimiewto sea 98 y 99
	  $todook='';
	    if ( $codigomovimiento=='99' or $codigomovimiento=='98') {
			$hijos=Alkardex::model()->findall("hidvale=:hid  and codestado <> '98' ",array(":hid"=>$model->id));
			for ($i=0; $i < count($hijos); $i++) {
					if(Alkardex::model()->findByPk($hijos[$i]["id"])->Actualizaprecioinventario()==0) {
						//$transaccion->rollback();
						$mensaje='Verifique el stock del material :  '. $hijos[$i]['codart']."<br>";
						Yii::app()->user->setFlash('error', $mensaje);
						//throw new CHttpException(500,'Verifique el stock del material :  '. $hijos[$i]['codart']);
						$todook=$todook.$mensaje;
																										}
											}
		               }
		 if ( $codigomovimiento=='10' or $codigomovimiento=='20') {
		           $hijos=Alkardex::model()->findall("hidvale=:hid and codestado <> '98'",array(":hid"=>$model->id));
						for ($i=0; $i < count($hijos); $i++) { 
								if(Alkardex::model()->findByPk($hijos[$i]["id"])->Actualizareservainventario()==0) {
									$mensaje='Verifique el stock del material :  '. $hijos[$i]['codart']."<br>";
									Yii::app()->user->setFlash('error', $mensaje);
									$todook=$todook.$mensaje;
								                   }
											}
                                            }

      if ( $codigomovimiento=='30' or $codigomovimiento=='40') {
          $hijos=Alkardex::model()->findall("hidvale=:hid and codestado <> '98' ",array(":hid"=>$model->id));
          for ($i=0; $i < count($hijos); $i++) {
              if(Alkardex::model()->findByPk($hijos[$i]["id"])->Actualizainventarioporcompras()==0) {
				  $mensaje='Verifique el stock del material :  '. $hijos[$i]['codart']."<br>";
				  Yii::app()->user->setFlash('error', $mensaje);
				  $todook=$todook.$mensaje;
                  }
          }


      }

	  if ( $codigomovimiento=='50' or $codigomovimiento=='60') {
		  $hijos=Alkardex::model()->findall("hidvale=:hid  and codestado <> '98' ",array(":hid"=>$model->id));
		  for ($i=0; $i < count($hijos); $i++) {

				//  Yii::app()->user->setFlash('error', 'Verifique la cantidad en stock del material  '. $hijos[$i]['codart']);
				  $todook='';
				 // throw new CHttpException(500,'No se pudo grabar actualizar el registro de inventario');
			  }
		  }




	  if ( $codigomovimiento=='70' ) {
		  $hijos=Alkardex::model()->findall("hidvale=:hid  and codestado <> '98'",array(":hid"=>$model->id));
		  for ($i=0; $i < count($hijos); $i++) {
			  $registrokardex=Alkardex::model()->findByPk($hijos[$i]["id"]);
			  if(!is_null($registrokardex)) {
				  $modeloinventario= Alinventario::model()->findByPk($registrokardex->alkardex_alinventario->id);
				  //actualizando el inventario
				  $resultado=$modeloinventario->Actualizar($registrokardex->codmov,
					  										$registrokardex->cant,
					 										 $registrokardex->um,
					  										$registrokardex->preciounit
					  											);
				  ///tambien es necesario actualizar el detalle de la solpe
				  if(strlen($resultado)> 0){ ///	Quiere decir que hubo error
					  $mensaje=$mensaje."<br>".$resultado."<br>";
					  Yii::app()->user->setFlash('error', $mensaje);
					  $todook=$todook.$mensaje;
				  } else { //se actualizo ok
					  $modeloinventario->setScenario('modificacantidad');
					  if(!$modeloinventario->save())
						  $mensaje=$mensaje."<br> No se pudo actualizar el registro del Inventario del material ".$modeloinventario->codart. "<br>";
				  }

			  }
		  }//fon del for


	  } //fon del codigo de moimievto





	  $command1 = Yii::app()->db->createCommand(" delete from  ".Yii::app()->params['prefijo']."alkardex  where codestado='98' and hidvale=".$model->id."  ");
	  $command1->execute();
      $command = Yii::app()->db->createCommand(" update ".Yii::app()->params['prefijo']."alkardex set codestado='10', valido='1' where hidvale=".$model->id."  ");
      $command->execute();

	  return $todook;
  }
  
  Public function actualizasolpe($movimiento, $model,$transaccion) {
  	//debemos de actusalizar los registros de kardex hijos
     //recorriendo el kardex
	  $todook=true;
	 $statusacolocar=null;
	 $hijos=Alkardex::model()->findall("hidvale=:hid and codestado='99' ",array(":hid"=>$model->id));
			for ($i=0; $i < count($hijos); $i++) {
						$modelodetalle=Desolpe::model()->findByPk($hijos[$i]['idref']);
						$modelodetalle->setScenario('Atencionreserva');
				        $modeloreserva=Alreserva::model()->find("hidesolpe=:hidesolpex and codocu='450' ", array("hidesolpex"=>$hijos[$i]['idref']));
						$modeloreserva->setScenario('cambiaestado');
					             if ($movimiento=='10') {
					                     $modeloreserva->estadoreserva='20'; ///actualizar a reserva ATENDIDA
						                  $cantidadreservada=$modeloreserva->cant;
					                    if ($cantidadreservada==$modelodetalle->cant ) { //si lo que pidio es lo que se reresvo es una atencion total
							                $modelodetalle->est='40'; //atendido totalmente
								                } else { //en cambio
						                 if (!$cantidadreservada > 0 ) //si es una cantidad reservada > 0 quiere decir que es parcial , si es cero el status no varia
						                     $modelodetalle->est='50';  //atendido parcialmente
								            }
												//actualizamos el precio unitario real del detalle de la Solpe
									 $modelodetalle->punitreal=$modelodetalle->desolpe_alinventario->punit+$modelodetalle->desolpe_alinventario->punitdif;
									 $modeloreserva->atendido=date("Y-m-d H:i:s");
					                         }
				//echo "movimiento ".$movimiento;
				//yii::app()->end();
				            if ($movimiento=='20') {

					                 $statusacolocar='10'; ///actualizar a reserva creada
						            $cantidadreservada=$hijos[$i]['cant']; ///para la nualacion no nos hacemos probelmas solo es  la misma cantidad de kardex original
							    //  if ($cantidadreservada==$modelodetalle->cant ) { //si lo que se anula es el total de lo que se pide
							            $modelodetalle->est='60'; //Volver a colocar el estado 'reservado'
									          //refrescar  el status de la reserva tambien pe...
												$modeloreserva->estadoreserva='10'; ///
								          //  } else { //en cambio  si es menor (solo puede ser menor a lo que se solicita)
						             //if (!$cantidadreservada==0 ){//si es una cantidad reservada > 0 quiere decir que es parcial , si es cero el status no varia

										// $modelodetalle->est='06';  //atendido parcialmente
										 ///refrdescar el status de la reserva
										 //refrescar  el status de la reserva tambien pe...
										// $modeloreserva->estadoreserva='01'; ///

									///El precio unitario real debe de ser descontado tambien en la misma proporcion
									$modelodetalle->punitreal=0;
										//$modelodetalle->punitreal*(1-$cantidadreservada/$modelodetalle->cant);
									  $modeloreserva->atendido=null;
						                  }


				if($modelodetalle->save() and $modeloreserva->save()) {
							  Yii::app()->user->setFlash('succcess', " La solicitud  ".$modelodetalle->desolpe_solpe->numero."-".$modelodetalle->item. " se ha actualizado");

						  } else {
							  Yii::app()->user->setFlash('error', " Hubo un error al grabar los datos de la solicitud  ".$modelodetalle->desolpe_solpe->numero."-".$modelodetalle->item. " ");
								$transaccion->rollback();
							    yii::app()->end();
						  }





			}//fin del for

  }


Public function actualizacostos($registroinventario,$registrokardex,$registrosolpe,$tipocolector,$materialoservicio) {

	$todook="";
	//Consiguiendo el CECCO
	$modelogastos=New CcGastos;
	$modelogastos->ceco=$registrosolpe->imputacion;
	$modelogastos->monto=$registroinventario->montomovido; ///
	$modelogastos->fechacontable=$registrokardex->fecha;
	$modelogastos->idref=$registrokardex->id; //con el kardex lo amarramos
	$modelogastos->clasecolector=$tipocolector; //CENTRO DE COSTO
	$modelogastos->tipo=$materialoservicio; //materialkes
	$modelogastos->codmoneda=Yii::app()->params['monedadef'];
	if(!$modelogastos->save()) {
		$todook.='No se pudieron grabar los costes '.$modelogastos->ceco.'  Del material  '.$registrokardex->codart.'<br>';
	     }
                 return $todook;
         }






 	Public function actualizacostes($model,$transaccion,$ceco=null) {
  	//Public function actionpruebax() {
		$todook=true;
 $hijos=Alkardex::model()->findall("hidvale=:hid and codestado not in('98')  ",array(":hid"=>$model->id));
	  // $hijos=Alkardex::model()->findall("id=437");
			for ($i=0; $i < count($hijos); $i++) {
				$modelogastos=New CcGastos;
				      if(is_null($ceco)) {
						  ///Rebuscamos la solpe
						  			if($hijos[$i]['codmov']=='70'){ //Si es un reingreso debemos de buscar recursivamente en el Kardex
							   					 $modelodetalle=Desolpe::model()->findByPk(Alkardex::model()->findByPk($hijos[$i]['idref'])->idref);
						  				} else {
												$modelodetalle=Desolpe::model()->findByPk($hijos[$i]['idref']);
									}
							  $modelogastos->ceco=$modelodetalle->imputacion;
					  } else {
						   $modelogastos->ceco=$ceco;
					  }
						//$modelodetalle=Desolpe::model()->findByPk(232);
						$modelogastos->fechacontable=$hijos[$i]['fecha'];

				//Los costos salen del inventario no del precio unitario del Kardex; (Punit+ Punitdif)

				  $registroinventario=Alinventario::model()->findByPk(Alkardex::model()->findByPk($hijos[$i]['id'])->alkardex_alinventario->id);
				///////////////haciendo el calculo estandar de signo y conversiones
				$signo=Almacenmovimientos::model()->findByPk($hijos[$i]['codmov'])->signo*-1;  /// Como son costos , es el opuesto
				$conversion=Alconversiones::model()->convierte($hijos[$i]['codart'],$hijos[$i]['um']);
				//echo " la conversion  ".$conversion."  ".gettype($conversion)."      \n";
				//echo " material y um  ".$hijos[$i]['codart']."  ".$hijos[$i]['um']."      \n";
				//echo " el signo  es ".Almacenmovimientos::model()->findByPk($hijos[$i]['codmov'])->signo."  ".gettype(Almacenmovimientos::model()->findByPk($hijos[$i]['codmov'])->signo)."      \n";
				//$signo=Almacenmovimientos::model()->findByPk($movimiento)->signo*-1;  /// Como son costos , es el opuesto
				$cantidadmovida=$signo*abs($conversion)*abs($hijos[$i]['cant']);
				///////////ok///////////////////////////////////////

				////ahora calculando el precio unitario real, para esto actualizamos el Registro de Inventario,
				///Esto es indiependiente si el material tiene control de precio S o V
						$registroinventario->Actualizar($hijos[$i]['codmov'],$hijos[$i]['cant'],$hijos[$i]['preciounit']);
						$modelogastos->monto=$cantidadmovida*($registroinventario->punit+$registroinventario->punitdif); ///
									//echo  " la conversion ".$conversion."\n";
									//echo  " la cantidad movida ".$cantidadmovida."\n";
									 //echo " precio unitario ".$registroinventario->punit."\n";
				                  // echo   "El monto    ".$modelogastos->monto."\n";
				//echo " la diferencia  ".$registroinventario->punit."  ".gettype($registroinventario->punit)."      \n";
				//echo " la diferencia  ".$registroinventario->punitdif."  ".gettype($registroinventario->punitdif)."      \n";
				//yii::app()->end();

				$modelogastos->idref=$hijos[$i]['id']; //con el kardex lo amarramos
						$modelogastos->clasecolector='K'; //CENTRO DE COSTO
						$modelogastos->tipo='M'; //materialkes
						$modelogastos->codmoneda=Yii::app()->params['monedadef'];
						if(!$modelogastos->save()) {
								//$transaccion->rollback();
								//throw new CHttpException(500,'No se pudo grabar los costos');
							Yii::app()->user->setFlash('error', 'No se pudieron grabar los costes');
							$todook=false;

						}
				
						}
		  return $todook;
				
			}

  

/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionAnular($id)
	{
		$model=$this->loadModel($id);
		$this->anulavale($model);

		
			
			
	}







	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Almacendocs');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Almacendocs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Almacendocs']))
			$model->attributes=$_GET['Almacendocs'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


 
	public function generadetalle($model)
							//codigo del documento a tomar como referencia
							//numero del doc a tomar como referncia 
							//codigo del movimiento
	{
         //  $model=$this->loadModel($id);
		//generar todas las claves del kardex 
		//throw new CHttpException(500,'Nque carajo');		
           $codigodocumento=$model->codocuref;
           $numerodocumento=trim($model->numdocref);
           $tipomovimiento=$model->codmovimiento;

            switch ($codigodocumento) {   ///Luego hacer los procedimientos segun sea el caso 
						
						 case '210': //orden de compra
								//throw new CHttpException(500,'No se encontro el doucmento de compras indicado');		
							//$this->redirect(array("Aprobarguia",'id'=>$id));
						 //rellenar el domcuento de items 


						 //VERIFICAR LA ORDEN COMPRA PRIMERO , SOLO LOS ITEMS QUE ESTAN LIBERADOS O ATENDIDOS PARCIALMENTE
						 $mocompra=VwOcompra::model()->findall("numcot=:numerox and estadodetalle in ('20','50')  ",array(":numerox"=>$numerodocumento));
						 $transaccion=$model->dbConnection->beginTransaction();
						 if (count($mocompra) > 0) {

						 	for ($i = 0; $i < count($mocompra); ++$i) {

						 		                  $modelodetalle=New Alkardex;
						 		                  $modelodetalle->codart=$mocompra[$i]['codart'];
						 		                  $modelodetalle->codmov=$tipomovimiento;
						 		                  $modelodetalle->cant=$mocompra[$i]['cant'];
						 		                  $modelodetalle->aldes=$model->codalmacen;
						 		                  $modelodetalle->fecha=$model->fechavale;
						 		                  $modelodetalle->usuario=Yii::app()->user->name;
						 		                  $modelodetalle->um=$mocompra[$i]['um'];
						 		                  $modelodetalle->codocuref=$codigodocumento;
						 		                   $modelodetalle->numdocref=$numerodocumento;
						 		                    $modelodetalle->codcentro=$model->codcentro;
						 		                     $modelodetalle->codestado='99';
						 		                     $modelodetalle->hidvale=$model->id;
						 		                      $modelodetalle->idref=$mocompra[$i]['id']; //el enganche 

						 		                     if (!$modelodetalle->save()) {
						 		                     	 $transaccion->rollback(); 
						 		                     	Yii::app()->end();
						 		                     	throw new CHttpException(500,'Se produjo un error al momento de insertar el detalle kardex ');
						 		                     	    }


						 		                      }
						 		        $transaccion->commit();  										


						 }else {
						 		 throw new CHttpException(500,'No se encontro el doucmento de compras indicado');

						 }
















							break;
						case '340': // Solicitud de pedido
							//$modelosolpe=Solpe::model()->findByPk(75);
						 $modelosolpe=Solpe::model()->find(" numero='".trim($model->numdocref)."' ");
						//$modelosolpe=Solpe::model()->findall(" numero='0000000043' ");
						    if (gettype($modelosolpe)=='object') {
						    			///
						    	//$modelito=Solpe::model()->findByPk($);
			$matrizdetalle=$modelosolpe->solpe_desolpe;
				for ($i=0; $i < count($matrizdetalle); $i++) { 
								$modelodesolpe=Desolpe::model()->findByPk($matrizdetalle[$i]['id']);

								///Si el registro del kardex no ha sido creado aun
								$modelokardex=Alkardex::model()->find(" valido='1' AND  idref=".$modelodesolpe->id);
								if ($modelokardex===null) {
								//creamos el registro Kardex 
								$modelokardex= new Alkardex;
								//Colocamos los valores 
								$modelokardex->codart=trim($modelodesolpe->codart); //el codigo material
								$modelokardex->cant=$modelodesolpe->cant; //el codigo material
								$modelokardex->codmov= $tipomovimiento; //el codigo MOVIMIENTO
								$modelokardex->alemi=$model->codalmacen; //el almacen emisor
								$modelokardex->aldes=$model->codalmacen;; //el almacen emisor
								$modelokardex->fecha=date("Y-m-d H:i:s"); //contable
								$modelokardex->coddoc=$codigodocumento; //el codigo documento que caisa el mov
								$modelokardex->numdoc=$numerodocumento; //el numero de doc que causa el mov
								$modelokardex->usuario=Yii::app()->user->name;
								$modelokardex->um=$modelodesolpe->um; //el codigo material
								$modelokardex->codocuref= '101'; //el cod del doc vale almacen
								$modelokardex->numdoc=$model->numvale; //el numero vale alamcen 
								$modelokardex->codcentro=$model->codcentro; //el codigo documento que caisa el mov
								//$modelokardex->codestado='01'; //el estado
								$modelokardex->fechadoc=date("Y-m-d H:i:s"); //fecah del documetno
								$modelokardex->hidvale=$model->id; //fecah del documetno
								$modelokardex->idref=$modelodesolpe->id; //fecah del documetno
								//$modelokardex->valido='0';
		  					if($modelodesolpe->numeroreservas > 0) { ///solo las que tienen reservas valen 

		  									$modelokardex->checki='1'; //es valido

		 										 } else {
		 										 	$modelokardex->checki='0'; //no es valido

		 										 }

		 										 $modelokardex->save();
									}

								 else { /// en el caso de que ya exista el kardex no hacer nada


								}

									}




						    } else {

						    	throw new CHttpException(500,gettype($modelosolpe).'No se encontro la solicitud de pedido indicada : '.trim($model->numdocref).'-  -'.strlen(trim($model->numdocref)).'  ' ) ;


						    }
							//verificando los detalles de la solicitud de pedido

							//SOLO LOS ITEMS RESERVADOS CON SUS RESPECTIVAS CANTIDADES





							break;
						
						default:
								 throw new CHttpException(500,$codigodocumento.'-Se ha tomado un documento que no es valido');
	  	
									 }
			


		

	}


	public function generacontabilidad($model)
	{
        
		 $transaccion=$model->dbConnection->beginTransaction(); 
			 	 switch ($model->codocuref) {   ///Luego hacer los procedimientos segun sea el caso 
						 case '210':
						 	           ///un documento de compras
						 				//sacando de una vez el descuento y la conversion  moneda para calcular preciosn 
						  				$modelocompra=Ocompra::model()->find("numcot=:numerox  ",array(":numerox"=>trim($model->numdocref)));	
						  				$descuento=(is_null($modelocompra->descuento))?0:$modelocompra->descuento/100;
										$moneda=$modelocompra->moneda;
										 if($moneda==Yii::app()->params['monedadef'])
										 	    {$conversion=1; }else{
										 	    	$conversion=Numeromaximo::cambiomoneda($moneda,Yii::app()->params['monedadef']);
										 	      }
						   /***********************************************************************
						   +		LLENAMOS EL LOG DE ENTREGAS DE LA POSICION DE LA ORDEN DE COMPRA
						   ************************************************************************/
						 	    $modelokardex=Alkardex::model()->findall("hidvale=".$model->id."  and codestado='99' ");
				               if (count($modelokardex) > 0) {
						 						for ($i = 0; $i < count($modelokardex); ++$i) {
						 		                										   		 	$modeloentregas=New Alentregas;
						 		                  													$modeloentregas->iddetcompra=$modelokardex[$i]['idref'];
						 		                   													$modeloentregas->cant=$modelokardex[$i]['cant'];
						 		                    												$modeloentregas->idkardex=$modelokardex[$i]['id'];
						 		                     																if (!$modeloentregas->save()) {
						 		                     																								$transaccion->rollback();
						 		                     																								throw new CHttpException(500,'Se produjo un error al registrar las entregas');

						 		                     																								}
						 		                  																			 ///TAMBIEN ACTUALIZAMOS EL STATRUS DE LAS POSCIONES DE LA ORDEN DE COMPRA
						 		                     	 									
						 		                     	 																	 // $modelodetoc=New Docompra;
						 		                     	  									 $modelodetoc=Docompra::model()->findByPk($modelokardex[$i]['idref']);
						 		                     	  											 if(!is_null($modelodetoc)) {
						 		                     	   																//verificando primero cuanto ya se ha atendido antes
						 		                     	   																			$criteria=new CDbCriteria;
																																	$criteria->select='sum(cant) AS sumatoria';
																																	$criteria->addCondition(" iddetcompra= ".$modelokardex[$i]['idref']."   and idkardex <> ".$modelokardex[$i]['id']);					
																																	$rowsuma = Alentregas::model()->find($criteria);
																											    					 $totalatendido =is_null($rowsuma)?0:$rowsuma['sumatoria'];	///esto es lo que se ha atendido
																																				if($totalatendido >= $modelodetoc->cant  ) {
																																															$transaccion->rollback();
																																															throw new CHttpException(500,'Se produjo un error, esta poscionde pedido ya estaba atendida por completo');
						 		                     	  		

																				    																										 } else {

																				     																														if( ($modelokardex[$i]['cant']+$totalatendido) >  ($modelodetoc->cant) ) //si tambien con esta atencion se cae en exceso
																				     		                																											{
																				     		                																													$transaccion->rollback();
																				     		                																													throw new CHttpException(500,'Se produjo un error, con este ingreso se sobrepasa la cantidad comprada'.$totalatendido);
						 		                     	  		
																				     		               																												 } else {
																				     		                																															if(($modelokardex[$i]['cant']+$totalatendido) < ($modelodetoc->cant)) 
																				     		                																																						{
																				     		                																																								$modelodetoc->estadodetalle='50' ; //atencion parcial
																				     		                																																											} else {
																				     		                																																								$modelodetoc->estadodetalle='60' ; //atencion total
																				     		                																																						}
																				     		                																																			if(!$modelodetoc->save()) {
																				     		                																																				$transaccion->rollback();
																				     		                																																						throw new CHttpException(500,'No se pudo grabar la actualizacion del detalle del pedido');
						 		                     	  		

																				     		                																																										}
																				     		                																											} 
																				     		                																							}
																				     		                						} 
																				     		                		


																				     		                

																				     		                						
						
																											/***************************************************************
																											*			ACTUALIZAR EL INVENTARIO TAMBIEN 
																											*              Datos a actualizar 
																											*				CANTIDAD , PRECIO , PONDERADO PRECIO UNITARIO
																											*				
																											****************************************************************/
																													//la cantidad 
																																	
																													$inventario=Alinventario::model()->find(" codalm=:almacencito and codart=:articulito and codcen=:centrito",
																																	array(":almacencito"=>$model->codalmacen,":articulito"=>$modelokardex[$i]['codart'], ":centrito"=>$model->codcentro));
																																	
																							    						if(!is_null($inventario)) {
																							    									//$inventario->codalm=$model->codalmacen;
																							        								//$inventario->codart=$model->codalmacen;
																							        								//$inventario->codcentro=$model->codcentro;
																							        								//$inventario->codmon=Yii->app()->params['monedadef'];
																							        										$inventario->um=$modelokardex[$i]['um'];
																							        										$inventario->cantlibre=$inventario->cantlibre+$modelokardex[$i]['cant'];
																							        										$inventario->punit=($modelodetoc->punit*(1-$descuento)*$conversion*$modelokardex[$i]['cant']+($inventario->cantlibre+$inventario->cantres)*$inventario->punit)/($inventario->cantlibre+$inventario->cantres+$modelokardex[$i]['cant']);
																							        										$inventario->codmon=Yii::app()->params['monedadef'];
																							       											 }else {
																							        												$inventario=New Alinventario;
																							        												$inventario->codalm=$model->codalmacen;
																							        												$inventario->codart=$modelokardex[$i]['codart'];
																							        												$inventario->codcen=$model->codcentro;
																							        												$inventario->codmon=Yii::app()->params['monedadef'];
																							        												$inventario->um=$modelokardex[$i]['um'];
																							        												$inventario->cantlibre=$modelokardex[$i]['cant'];
																							        												$inventario->canttran=0;
																							        												$inventario->cantres=0;



						 		                    
																							       												 }

																							       							if(!$inventario->save()) 
																							       							{
																							       								$transaccion->rollback();
																							       								echo "hola". $inventario->codalm."--".$inventario->codart."--".$inventario->codcen."--".$inventario->codmon."--".$inventario->um."--".$inventario->cantlibre;
																																throw new CHttpException(500,'NO se pudieron actualizar los datos de inventario '.$inventario->codalm."--".$inventario->codart."--".$inventario->codcen."--".$inventario->codmon."--".$inventario->um."--".$inventario->cantlibre);
																																//throw new CHttpException(500,'NO se pudieron actualizar los datos de inventario ');');
						 		                    
																				     		                						
																							       							}
																							       						/*************************************
																							       						*
																							       						************************************************************************/
																								
																							       				}

																				     		                																																						


																				     		                				

																				     		                						

																				     		                		
																				                   
																				                   


																	   
																		

						 		                     	   }else{ //si no enuentra kardex hijos 
						 		                     	   	    $transaccion->rollback();
																throw new CHttpException(500,'Se produjo un error , no se hallaron kardex hijos');
						 		                    } //fin de si encuentra kardex hijos 
						 		                   /// debemos tambien de colcoar el status de cambio de estado al KARDEX
		 											$command = Yii::app()->db->createCommand(" UPDATE Alkardex set codestado='10' where hidvale=".$model->id);
		 															 $modelocompra->codestado='60';
													
													if ( $command->execute() > 0 and $modelocompra->save() ) {
						 		        						$transaccion->commit();  
						 		        					} else {
						 		        						$transaccion->rollback();
															   throw new CHttpException(500,'Hubo un error inesperado al moemento de actualizar el kardex  ');
						 		                    

						 		        					}


							break;
						case '340': // Solicitud de pedido
							///primero cambiamos el estado de los  kardex 
									$command = Yii::app()->db->createCommand(" UPDATE alkardex  set codestado='10' , valido='1' where checki='1' and  hidvale=".$model->id." ");
									$command->execute();
						  ///luego cambiamos el estado del vale
									$model->cestadovale='20';
									$model->save();
						//actualizamos el estado de las solpe y desolpe
								




									$transaccion->commit();



							
						 break;
						default:
								 throw new CHttpException(500,'Se ha tomado un codigo/documento que no es valido');
	  	
									 }


	}

public function actionPinta($id){
		 $modelogrande=$this->loadModel($id);
		 if ( $modelogrande->cestadovale=='20' ) {
 		$transaccion=$modelogrande->dbConnection->beginTransaction();  
 		//echo gettype($transaccion);
		//Yii::app()->end();
		$itemsk=Alkardex::model()->findall('hidvale=:valoi',array(':valoi'=>$id));
	/// registas kardex pcn valores negativos 
		
		foreach($itemsk as $v) {
			$modeloentregas=new Alentregas;
			$modelokardex= new Alkardex;
			//echo $v['id'];
			//Yii::app()->end();
			$modeloentregasant=Alentregas::model()->find(' idkardex=:clave',array(  ':clave'=> $v['id']  ));

				$modeloentregas->setAttributes(array('iddetcompra'=>$modeloentregasant->iddetcompra,'cant'=>$modeloentregasant->cant*-1,'idkardex'=>$v['id']),true);

				$modelokardex->setAttributes(array('codart'=>$v['codart'],'codmov'=>$v['codmov'],'cant'=>$v['cant']*-1,'alemi'=>$v['alemi'],
													 'aldes'=>$v['aldes'],'fecha'=>date("Y-m-d H:i:s"),'coddoc'=>$v['coddoc'],'numdoc'=>$v['numdoc'],
													   'um'=>$v['um'],'codocuref'=>$v['codocuref'], 'numdocref'=>$v['numdocref'],'codcentro'=>$v['codcentro'],
													   'codestado'=>'10','numdocref'=>$v['numdocref'],'hidvale'=>$v['hidvale']),true);
				$modelokardex->save();
				$modelokardex->refresh();
				$modeloentregas->idkardex=$modelokardex->id;
				$modeloentregas->save();

				$modocompra=Docompra::model()->findByPk($modeloentregasant->iddetcompra);
				 ///cuantos hay
						if( $modocompra->cantidadentregada =$v['cant'])  ///si es la unica entrega 
											{
											$modocompra->estadodetalle='20'; //regresar a colocarlo  como aprobado por que se reversa toda la atencion

											} else {
													if( $modocompra->cantidadentregada > $v['cant'] ) //si ha habido mas d euna entrega
													 {
														 $modocompra->estadodetalle='50';// de hecho pasa a ser parcial
														} else { ///Error:: quiere decir qu se atendio una cantidad en exceso  al ingreos 
															 $transaccion->rollback();
																throw new CHttpException(500,'Se produjo un error, Se ha atrendido una cantidad mayor al del pedido ');
						 		                 			

													}
						      				}

				//actualizar el invetario
						      				$moneda=$modocompra->docompra_ocompra->moneda;
										 if($moneda==Yii::app()->params['monedadef'])
										 	    {$conversion=1; }else{
										 	    	$conversion=Numeromaximo::cambiomoneda($moneda,Yii::app()->params['monedadef']);
										 	      }
				$modeloinventario=Alinventario::model()->findByPk($modocompra->docompra_alinventario->id);
				$cantidad=$modeloinventario->cantlibre;
				 			if ($cantidad  >=$v['cant'] ) {
				 											$descuento=($modocompra->docompra_ocompra->descuento===null)?0:$modocompra->docompra_ocompra->descuento/100;
				 											$modeloinventario->cantlibre=$cantidad-$v['cant'];
				 											//$modeloinventario->punit=
				 											$modeloinventario->punit=(($cantidad+$modeloinventario->cantres)*$modeloinventario->punit-$modocompra->punit*$conversion*(1-$descuento)*$v['cant'])/($cantidad+$modeloinventario->cantres-$v['cant']);
															$inventario->codmon=Yii::app()->params['monedadef'];

				 											}else
				 					 							{
				 											 $transaccion->rollback();
																throw new CHttpException(500,'Se produjo un error, EL stock libre utilizacion esta por debajo para  devolucion ');
						 		                 			 }
				

							} ;//for each 
	//$modelito=$this->loadModel(9);
	//$hijos= $modelito->numeroitems;
	//$nietos=$modelito->almacendocs_alkardex->numeroitems;
	//$criteria=new CDbCriteria;
	//$criteria->with=array('alentregas_alkardex.alkardex_almacendocs');
	//$criteria->with=array('almacendocs_alkardex');
	//$criteria->addCondition('alkardex_almacendocs.id=9');
	//$registros=Almacendocs::Model()->findAll($criteria);
	//$registros=Ocompra::Model()->with('ocompra_docompra')->findAll($criteria);
	//echo $registros[0]['numvale']."\n";
	//echo $registros[0]['almacendocs_alkardex'][0]['codmov']."\n";;
	//echo $registros[0]['almacendocs_alkardex'][0]['alkardex_alentregas'][0]['iddetcompra']."\n";
	//echo $registros[0]['almacendocs_alkardex'][0]['alkardex_alentregas'][1]['iddetcompra']."\n";
	//echo 
	//echo $modelito->almacendocs_alkardex[0]->alkardex_alentregas[1];
	//echo $modelito->codocu;
	//ECHO Ocompra::model()->findByPk(19)->subtotal;
	//echo Docompra::model()->findByPk(31)->docompra_alinventario->cantlibre;
				$modocompra->save();
				$modeloinventario->save();
				$modelogrande->$cestadovale='30';
				$transaccion->commit();
		} else {
				throw new CHttpException(500,'Este vale ya se anulo, o tiene un estado que no permite su anulacion ');
		}

}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Almacendocs the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Almacendocs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(500,'The requested page does not exist.');
		return $model;
	}
public function  actionpruebax (){
throw new CHttpException(500,'ADAFAFes una prueba.');

}
	/**
	 * Performs the AJAX validation.
	 * @param Almacendocs $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='almacendocs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function pintadocref($codmov,$model,$form){
		echo $this->renderpartial('vw_matchcode',
				array(
					'model'=>$model,
					'form'=>$form,
					'nombreclase'=>$this->eligeclase($codmov),
					'controlador'=>$this->id,
				)
		);
		
	}
	
	public function eligeclase($codmov){
		switch($codmov) {
			case MOV_SALIDA_RESERVA:
			return 'Solpe';
				break;
				case AN_MOV_SALIDA_RESERVA: 
				case AN_MOV_INGRESO_COMPRA: 
				case AN_MOV_SALIDA_CECO: 
				case MOV_INGRESO_CONSIGNACION:
				case AN_MOV_INICIAR_TRASLADO:
				case MOV_INGRESA_TRASLADO:
				case AN_MOV_INGRESA_TRASLADO:
				//case MOV_REINGRESO_MATERIAL:
				case AN_MOV_SALIDA_VENTA:
				case AN_MOV_CARGA_INICIAL:
			return 'VwAlmacendocs';
				break;
			case MOV_REINGRESO_MATERIAL: case MOV_INGRESO_COMPRA: case AN_MOV_INGRESO_CONSIGNACION: case MOV_DEVOLUCION_PROVEEDOR:
			return 'VwOcompra';
				break;
				case MOV_SALIDA_VENTA: case MOV_DEVOLUCION_CLIENTE: 
			return 'Peticion';
				break;
				case MOV_SALIDA_CECO: 
			return 'Cc';
				break;
		
					}
		
	}


	public function transfieredatosalhijo($model,$modelcabeza){
		$model->alemi=$modelcabeza->codalmacen;
		$model->aldes=$modelcabeza->codaldestino;
		$model->codocuref=$modelcabeza->codocuref;
		$model->numdocref=$modelcabeza->numdocref;
		$model->aldes=$modelcabeza->codaldestino;
		$model->codcentro=$modelcabeza->codcentro;
		$model->codcendes=$modelcabeza->codcendestino;
		$model->hidvale=$modelcabeza->id;


	}

	public function actionsalir($id){
		$this->out($id);
		$this->redirect(array('admin'));


	}
	
	
	
	
	
}