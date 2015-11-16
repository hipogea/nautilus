<?php
const ESTADO_PREVIO='99';
const ESTADO_CREADO='10';
const ESTADO_APROBADO='20';
const ESTADO_ANULADO='50';
const ESTADO_PROCESO_COMPRA='30';
class PeticionController extends ControladorBase
{


	//public $layout='//layouts/column2';
	//public $documento='130';
	//public $documentohijo='430';
	//public $nombre_modelocabecera='Peticion';
	//public $bufferdetalle=array(); ///Es el array de datos originales del detalle , antes de cualqwuier modifricaicon





	public function __construct() {
		parent::__construct($id='peticion',Null);
		$this->modelopadre='Peticion';
		$this->modeloshijos=array('Dpeticion'=>'Tempdpeticion');
		$this->documentohijo='430';
		$this->documento=Documentos::model()->findByPk($this->documentohijo)->coddocupadre;
		$this->campoestado='codestado';
		$this->estados=array(
			'save'=>array(),
			'print'=>array(),
			'out'=>array(),
			'ok'=>array(),
			'mail'=>array(),
			'print'=>array(),
		);
		$this->ConfigArreglos();

	}

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}








	/****************************************************
	 *  muestra la vista de configuracion de LOS VALORES X DEFAULT
	 *+++++++++++++++++++++++++++++++++++++++++++++++++*/

	public function actionConfiguraop(){
		$docu=$this->documento;  //peticion
		$docuhijo=$this->documentohijo; //detalle petricion


		$matrizpadre=Opcionescamposdocu::Model()->findAll(" codocu=:cod",array(":cod"=>$docu));
		for ($i=0; $i < count($matrizpadre); $i++){
			$cantidadregistros=Yii::app()->db->createCommand("SELECT id FROM  ".Yii::app()->params['prefijo']."opcionesdocumentos WHERE IDOPDOC=".$matrizpadre[$i]['id']."")->QueryScalar();
			If (!$cantidadregistros) {
				$command = Yii::app()->db->createCommand("INSERT INTO ".Yii::app()->params['prefijo']."opcionesdocumentos (IDUSUARIO,IDOPDOC,valor) VALUES (".Yii::app()->user->id.",".$matrizpadre[$i]['id'].",'') ");
				$command->execute();
			}
		}

		$matrizpadre1=Opcionescamposdocu::Model()->findAll(" codocu=:cod",array(":cod"=>$docuhijo));
		for ($i=0; $i < count($matrizpadre1); $i++){
			$cantidadregistros=Yii::app()->db->createCommand("SELECT id FROM  ".Yii::app()->params['prefijo']."opcionesdocumentos WHERE IDOPDOC=".$matrizpadre1[$i]['id']."")->QueryScalar();
			If (!$cantidadregistros) {
				$command = Yii::app()->db->createCommand("INSERT INTO ".Yii::app()->params['prefijo']."opcionesdocumentos (IDUSUARIO,IDOPDOC,valor) VALUES (".Yii::app()->user->id.",".$matrizpadre1[$i]['id'].",'') ");
				$command->execute();
			}
		}

		$proveedor=VwOpcionesdocumentos::model()->search_us($docu,Yii::app()->user->id);
		$proveedor1=VwOpcionesdocumentos::model()->search_us($docuhijo,Yii::app()->user->id);
		$this->render('vw_admin_opciones',array(
			'proveedor'=>$proveedor,
			'proveedor1'=>$proveedor1,
		));


	}


//Devuelve el id de la cabecera, pero se asegura de que este no
///lo pasen por la URL, es decir revisa la sesion de edicion del documento, primero
///Muy util cuando se aregan registros hijos
public function obtieneidcabecera($id) {
   $idcabe=Numeromaximo::estasensesion($id,$this->documento);
     if($idcabe){
	     return $idcabe;
     } else {
	throw new CHttpException(500,'Está intentando entrar por la puerta falsa ');
     }

}



















	///Inicia bloqueo
	public function iniciabloqueo($id) {
		 return 	Numeromaximo::bloquea($id,$this->documento);

	}

///Termina bloqueo
	public function terminabloqueo($id) {
      return Numeromaximo::desbloquea($id,$this->documento);

	  }
	///Nos indica si se accede x primera vez al action UPDATE





	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('Creadetalleserv','enviardocumento','salir','generaPDF','aprobar','solicitar','create','update','creadetalle','editable','borraitem','configuraop','modificadetalle'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	///Permite verificar si aluiene sta modificando el miso documento
	///al mosmo tiempo : concurrencia de usuarios en el misom documento
	///DEVUELVE L NOMBRE DEL USUARIO QUE ESTAS EDITNADO EL DOCUMENTO
	public function estaocupado($id) {
		$me=Yii::app()->user->id;
		$quien=Yii::app()->db->createCommand( " select distinct iduser from ".Yii::app()->params['prefijo']."bloqueos WHERE  iduser <> ".$me." and  codocu='".$this->documento."' and iddocu=".$id." ")->queryScalar();
           if($quien) { /// Quiere decir que hay otros que estan ediotnado el documento
			     ///PARA VER SIS ES CIERTO DEEBMOS VERIFICAR Q ESTE USUARIO NO HA DEJADO LA VENTANA ABANDONADA CON E DOMCUENTO EN EDICION
					$elusuario=Yii::app()->user->um->LoadUserById($quien);
			     ///hallando la sesion activa de este usuario
			       $sesion_activa=Yii::app()->user->um->findSession($elusuario);
			         if(is_null($sesion_activa)) {
						 return false;  //No esta ocupado por que estaba editando pero ya temrino sus sesion, alo mejor dejo la ventana abierta
					 }  else {
						 return $elusuario->username;  ///Si esta ocupado por que el usuario tiene sesion activa, y eszta editando
					 }

		   } else {
			   return false;  ///NO esta ocupado porque no hay otros usuarios que esten editando el documento
		   }

	}




















	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		///Verificamos que este bloqueado por el usuario
		if(MiFactoria::estasensesion($id,$this->documento)){
          $this->terminabloqueo($id);
			$this->limpiatemporaldetalle();

		}

			$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionaprobar($id)
	{
	  $model=$this->loadModel($id);
		$model->codestado='20';
		$model->setScenario('cambiaestado');
		$model->save();
		Yii::app()->user->setFlash('success','Se Aprobó el documento');
		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionborraitem($autoId) //Borra un registro de solpe
	{
		$modelito=Tempdpeticion::model()->findByPk($autoId);
		if( !($modelito->id > 0)) {  // sI ES UN REGISTRO AGREGADO
			     if($modelito->deleteByPk($autoId) > 0){
					 Yii::app()->user->setFlash('success', " Item ".$modelito->item."  Se borro sin problemas");

				 } else {
					 Yii::app()->user->setFlash('error', " Item ".$modelito->item."  Hay un error no se pudo borrar");
				 }
		} else {  ///Si es un registro que ya tiene referencia en una tabla

			////Verificar aqui las relacines ne tre tablas si se puede anular el titem



			///////
			$modelito->codestado='20';
			$modelito->idstatus=-1; /// S ele colca este flag paraHACER EL DELETE AL MOMENTO DE VACIAR EL TEMPORAL A TABLAS ORIGINALES
			if($modelito->save()){
				Yii::app()->user->setFlash('success', " Item ".$modelito->item."  Se anulo sin problemas");

			} else {
				Yii::app()->user->setFlash('error', " Item ".$modelito->item."  Hay un error no se pudo anular");
			}
		}



		foreach(Yii::app()->user->getFlashes() as $key => $message) {
			echo "*)". $message . "\n";		}
		//echo $this->renderpartial("vw_mensajes",array());
		Yii::app()->end();
	}


	public function actionsolicitar($id) {
		$model=$this->loadModel($id);
		$modelosolpe=Solpe::model()->find("hidref=".$id." AND codocuref='".$this->documento."' AND estado <>'30'");
		if(is_null($modelosolpe)){
			MiFactoria::CreaSolpeAutomatica($this->documento,$id);
		}else {
			MiFactoria::Mensaje('notice','Este documento ya cuenta con la solicitud '.$model->peticion_solpe->numero);
		}

    $this->render('update',array('model'=>$model));


		/*
		$model=Peticion::model()->findByPk($id);
			$mensa="";
			$registroshijos=MiFactoria::Devuelvepeticioneshijos($id);
			$transaccion=$model->dbConnection->beginTransaction();
			foreach  ($registroshijos as $row) {
				///solo los hijops con estado adecaudo apra reservar
				if($row->numeroreservas == 0){
					$row->setScenario('Atencionreserva');
					$modeloreserva=New Alreserva;
					$modeloreserva->hidpeticion=$row->id;
					$modeloreserva->estadoreserva='10';
					$modeloreserva->fechares=date("Y-m-d H:i:s");
					$modeloreserva->usuario=Yii::app()->user->Name;
					$modeloreserva->codocu='310';
					$modeloreserva1=New Alreserva;
					$modeloreserva1->hidesolpe=$row->id;
					$modeloreserva1->estadoreserva='10';
					$modeloreserva1->fechares=date("Y-m-d H:i:s");
					$modeloreserva1->usuario=Yii::app()->user->Name;
					$modeloreserva1->codocu='800';

					$factorconversion=Alconversiones::convierte($row->codart,$row->um);
					//$cantidadefectiva=($row->um <>$row->maestro->um)?$row->cant*$factorconversion:$row->cant;

					if($row->cant*$factorconversion <= $row->dpeticion_alinventario->cantlibre ){  ///si hay stock sufieciente no hya probelma
						$modeloreserva->cant= $row->cant;
						$modeloreserva1->cant=0;
						// $mensa.=" Stock mayor al que se pide ok!  Se reservo en el item ".$row->item."  ".$modeloreserva->cant." <br> ";
					} else {
						$modeloreserva->cant= $row->dpeticion_alinventario->cantlibre/$factorconversion; //solo reservamos lo qu esta en stock
						$modeloreserva1->cant= $row->cant-$row->dpeticion_alinventario->cantlibre/$factorconversion; ///la diferencia la solicitiamos
						//  $mensa.=" Stock menor al que se pide  Se reservo una parte  en el item ".$row->item."  ".$modeloreserva->cant." <br> ";
						// $mensa.=" Se solicita  una parte  en el item ".$row->item."  ".$modeloreserva1->cant." <br> ";
					}
					////Luego actualizamoes el inventario
					$inventario=$this->devuelveinventario($row->codcen,$row->codal,$row->codart);
					//  echo "<br>"; echo "<br>"; echo "<br>"; echo "<br>"; echo "<br>";
					// echo $inventario->codcen."   ".$inventario->codalm."    ".$inventario->codart."<br>";

					$inventario->cantres+=$modeloreserva->cant*$factorconversion;
					$inventario->cantlibre-=$modeloreserva->cant*$factorconversion;
					$inventario->setScenario('modificacantidad');
					$row->codestado='60';
					if($modeloreserva->cant > 0)
						if(!$modeloreserva->save())
							$mensa.=" No se pudo generar el registro de  reserva para el item ".$row->item." -- ".$row->txtmaterial." <br>";
					if($modeloreserva1->cant > 0)
						if(!$modeloreserva1->save())
							$mensa.=" No se pudo generar el registro de  reserva para el item ".$row->item." -- ".$row->txtmaterial." <br>";
					if(!$row->save())
						$mensa.=" No se pudo actualizar el estado del detalle del item ".$row->item." -- ".$row->txtmaterial." <br>";
					if(!$inventario->save())
						$mensa.=" No se pudo actualizar el registro de inventario del  item ".$row->item." -- ".$row->txtmaterial." <br>";

				}

			}//fin del For
			if(strlen($mensa)==0)  { //Si s epudo actualziar
				$transaccion->commit();
				Mifactoria::Mensaje('success', "Se hizo la reserva automatica del Documento ".$mensa);
				$this->render('update',array('model'=>$model));
				yii::app()->end();
			}     else   {
				$transaccion->rollback();
				Mifactoria::Mensaje('error', "No se pudo reservar automaticamente el documento, hay  errores  :".$mensa);
				$model->refresh();
				$this->render('update',array('model'=>$model));
				//$model->refresh();
			}
*/
	}






	public function actionenviardocumento($id){
		$this->guardaPDF($id,'assets/');
		$model=$this->loadModel($id);
		$destinatarios=Yii::app()->crugemailer->getListMailContacto($model->idcontacto,$model->codocu);
		$usuario=Trabajadores::model()->findByPk(Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtra') );
		//var_dump(Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtra'));
		//yii::app()->end();
		$asunto=$model->peticion_documentos->desdocu.'  -  '.$model->numero;
		$nombrecompleto=$usuario->nombres." ".$usuario->ap;
		$mensaje="Este es un correo automático";
		$filename='assets/'.$model->codocu.$model->id.'.pdf';
		$seenvia=Yii::app()->crugemailer->mail_attachment($destinatarios,Yii::app()->user->email,$nombrecompleto,'',	$asunto,$mensaje,$filename);
		if( is_null($seenvia) )
		{
			 if(is_null(Mensajes::model()->find("codocu='".$model->codocu."' AND hidocu=".$model->id)))
			 {
				 Yii::app()->user->setFlash('success','Se envió el documento a los destinatarios  :'.$destinatarios);
			 } else {
				 Yii::app()->user->setFlash('notice','Se envió el documento a los destinatarios, Ya se había envciado antes, revise los mensajes a los destinatiario s :'.$destinatarios);
			 }
			MiFactoria::Insertamensaje($model->id,$model->codocu,'M',$filename);
		}else{
			Yii::app()->user->setFlash('error','Hubo un error al momento de enviar el correo : '.$seenvia);
		}

		$this->render('update',array('model'=>$model));


		//Yii::app()->crugemailer->probar('assets/130166.pdf');
	}


   public function actiongeneraPDF($id){
	  $PDF=$this->Imprimirsolo($id);
			$PDF->Output();

   }

	public function guardaPDF($id,$ruta=null){
		$PDF=$this->Imprimirsolo($id);
		if(is_null($ruta)) {
			Yii::app()->user->seFlash('error','No especifico la ruta del archivo a guardar');
		}else {
			if(is_dir($ruta)){
				$model=$this->loadModel($id);
				$nombrearchivo=$ruta.$model->codocu.$model->id.'.pdf';
				$PDF->Output($nombrearchivo);
			}else {
				Yii::app()->user->seFlash('error','La ruta especificada : '.$ruta.'no es un directorio');
			}

		}
   return 1;
	}

	public function Imprimirsolo($id)
	{
		$cadena="";
		$peticion=$this->loadModel($id);
		$usuario=Trabajadores::model()->findByPk(Yii::app()->user->um->getFieldValue(Yii::app()->user->id,'codtrabajador') );
		//$usuario=Trabajadores::model()->findByPk('7003');
		$nombrearchivoselloagua=($peticion->estaaprobado())?'APROBADO.png':'NOAPROBADO.png';
		$cadena=$this->renderpartial('reportepeticion',array('peticion'=>$peticion,'usuario'=>$usuario),true,true);
		$mpdf=Yii::app()->ePdf->mpdf();
		$mpdf->SetWatermarkImage(Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].$nombrearchivoselloagua);
		$mpdf->showWatermarkImage = true;
		$hojaestilo=file_get_contents('themes/temita/css'.DIRECTORY_SEPARATOR.'estilooc.css');
		$mpdf->WriteHTML($hojaestilo,1);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($cadena,2);
		return $mpdf;
		//$mpdf->Output();
		//$vacr=md5(time());
		//$mpdf->Output('assets/'.$vacr.'.pdf','F');
		//$mpdf->Output();
		//return $vacr;


	}












/*
	public function actionCreate()
	{
		$this->limpiatemporaltotal();
		$model=new Peticion;
		$model->iduser=Yii::app()->user->id;
		if(isset($_POST['Peticion']))
		{
			$model->attributes=$_POST['Peticion'];
			if($model->save()){

				$this->redirect(array('update','id'=>$model->id));
				//$this->limpiatemporal();
				 //$model->refresh();
			          }
			}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/

	public function actionsalir($id){
		MiFactoria::getDesbloqueo($id,$this->documento);
		$this->redirect(array('admin'));
	}



	public function actionCreate()
	{

		/*ECHO isset($_POST[$this->modelopadre])?"<br><br><br><br><br><br><br><br>SI ES UN  POST['".$this->modelopadre."']":"<br><br><br><br><br><br><br><br>NO es un  POST";
		ECHO isset($_GET[$this->modelopadre])?"<BR> ES UN  GET(MODELOPADRE) ":"<BR> NO  ES UN  GET(MODELOPADRE)";
		ECHO isset($_GET['ajax'])?"<BR> ES UN  GET(ajax) ":"<BR> NO  ES UN  GET(ajax)";
		//ECHO isset($_GET['ajax'])?"<BR> ES UN  GET(ajax) ":"<BR> NO  ES UN  GET(ajax)";
		echo ($this->estasEnSesion($id))?"<BR> ESTAS EN SESION  ":"<BR> NO NO ESTAS EN SESION ";*/

		$this->ClearBuffer($id=NULL);
      //  echo "Ni identidad :". $this->Id;
		$model=new $this->modelopadre;
		$model->codestado=$model::ESTADO_PREVIO;
		$model->codocu=$this->documento;
		$model->valorespordefecto($this->documento);

		//print_r($_POST[$this->modelopadre]);
		if(isset($_POST[$this->modelopadre]))
		{

			$model->attributes=$_POST[$this->modelopadre];
			$model->codestado=$model::ESTADO_CREADO;

			if($model->save()){

				$this->redirect(array('update','id'=>$model->id));
				//$this->limpiatemporal();
				//$model->refresh();
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


























	public function actionprobar(){
$r = Yii::app()->getRequest();
// we can check whether is comming from a specific grid id too
// avoided for the sake of the example
if($r->getParam('editable'))
{
	//echo $r->getParam('attribute');
echo $r->getParam('value');
Yii::app()->end();
}
}




	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		//$this->performAjaxValidation($model);
		/*ECHO isset($_POST[$this->modelopadre])?"<br><br><br><br><br><br><br><br>SI ES UN  POST['".$this->modelopadre."']":"<br><br><br><br><br><br><br><br>NO es un  POST";
			ECHO isset($_GET[$this->modelopadre])?"<BR> ES UN  GET(MODELOPADRE) ":"<BR> NO  ES UN  GET(MODELOPADRE)";
		ECHO isset($_GET['ajax'])?"<BR> ES UN  GET(ajax) ":"<BR> NO  ES UN  GET(ajax)";
		//ECHO isset($_GET['ajax'])?"<BR> ES UN  GET(ajax) ":"<BR> NO  ES UN  GET(ajax)";
		echo ($this->estasEnSesion($id))?"<BR> ESTAS EN SESION  ":"<BR> NO NO ESTAS EN SESION ";
	//	echo " this->es_refreshdegrilla  ".var_dump($this->es_refreshdegrilla($id))."  <br>";
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
				$this->render('update',array('model'=>$model));
				yii::app()->end();
			}

		} else {
			if($this->isRefreshCGridView($id))
			{ //si esta refresh de grilla
				/*echo " NO es primera vez y  Es un refresh carajo";
				yii::app()->end();*/
				$this->render('update',array('model'=>$model));
				yii::app()->end();
			} else { // Si no lo es  tenemos que analizar los dos casos que quedan
				if($this->IsRefreshUrlWithoutSubmit($id))
				{ ///Solo refreso la pagina
					/* echo "NO es primera vez  y reresco si submit ";
					 yii::app()->end();*/
					Yii::app()->user->setFlash('notice', "No has confirmado los datos, solo haz refrescaod la pagina ");
					$this->render('update',array('model'=>$model));
					yii::app()->end();
				} else { 	 ///Ahora si recein se animo a hacer $_POST	, y confirmar los datos
					/*echo "se animo a ha hacer POST ";
					yii::app()->end();*/
					IF(isset($_POST[$this->modelopadre])) {
						$model->attributes=$_POST[$this->modelopadre];
					//$model->validate();
					if($this->hubocambiodetalle($id) OR  $model->hubocambio()) {
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
							$this->render('update',array('model'=>$model));
							yii::app()->end();
							/*Yii::app()->end();
							throw new CHttpException(500,'Hubo un error al momento de grabar la cabecera');*/
						}
					} else   {
						Yii::app()->user->setFlash('notice', "  Enviaste los datos pero no has modificado nada.... ");
						$this->render('update',array('model'=>$model));
						yii::app()->end();
					}
					  } else  { //En este caso quiere decir que la sesion/bloqueo anterior no se ha cerrado correactmente
						       // Y es posble que haya entrado despues de 2 dias, una semana asi
						$this->terminabloqueo($id);
						$this->SetBloqueo($id);
						Yii::app()->user->setFlash('notice', "NO cerraste correctamente, Ya tenías una sesion abierta en este domcuento,");
						$this->render('update',array('model'=>$model));
						yii::app()->end();

					}
				}
			}

		}

	}



		/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$model=Peticion::model()->findByPk($id);
		//$this->performAjaxValidation($model);
		if($this->es_primeravez($id)){
			      if($this->estaocupado($id))
				   { //si esta ocupado
					  // echo " es romer a vez y esta ocupado esta ocpado x otro   ";
					   //yii::app()->end();
					   Yii::app()->user->setFlash('error', "El documento esta siendo modificado por otro usuario ");


					          $this->redirect(array('view','id'=>$model->id));
						} else { // Si no lo esta renderizar sin mas
					    /*echo " es primer avez y renderizar sin mas    ";
					      yii::app()->end();*/
					  	/*	$this->iniciabloqueo($id) ; 	///bloquea
					  		$this->limpiatemporaldetalle(); //Limpia temporal antes de levantar
					 		 $this->grabaitems($this->dpeticion_a_tempdpeticion($id)); //Levanta temporales
					  		$this->render('update',array('model'=>$model));
					  		yii::app()->end();
				   }

		} else {
			if($this->es_refreshdegrilla($id))
			{ //si esta refresh de grilla
				//echo " NO es primera vez y  Es un refresh carajo";
				//yii::app()->end();
				$this->render('update',array('model'=>$model));
				 //yii::app()->end();
			} else { // Si no lo es  tenemos que analizar los dos casos que quedan
				if($this->refresco_sin_submit($id))
				     { ///Solo refreso la pagina
						// echo "NO es primera vez  y reresco si submit ";
						// yii::app()->end();
						 Yii::app()->user->setFlash('notice', "No has confirmado los datos, solo haz refrescaod la pagina ");
						 $this->render('update',array('model'=>$model));
						 yii::app()->end();
					 } else { 	 ///Ahora si recein se animo a hacer $_POST	, y confirmar los datos
					        $model->attributes=$_POST['Peticion'];
					        $model->validate();
					      if($this->hubocambiodetalle($id) OR  $model->hubocambio()) {
					        if($model->save()){
							$this->grabaitems($this->tempdpeticion_a_dpeticion($id)); //Graba temporales a la tabla Dpeticion
					        $this->limpiatemporaldetalle(); //Limpia temporal
					        $this->terminabloqueo($id); // Desbloquea
								Yii::app()->user->setFlash('success', "Se grabo el documento  ");
								$this->redirect(array('view','id'=>$model->id));
							} else {
								//echo CActiveForm::validate($model);
								$this->render('update',array('model'=>$model));
								yii::app()->end();
								/*Yii::app()->end();
								throw new CHttpException(500,'Hubo un error al momento de grabar la cabecera');*/
							/*}
						  } else   {
							  Yii::app()->user->setFlash('notice', "  Enviaste los datos pero no has modificado nada.... ");
							  $this->render('update',array('model'=>$model));
							  yii::app()->end();
						  }
			        }
			}

		}




     /*
        if(!isset($_GET['ajax']) and !isset($_POST['Peticion'])  and !isset($_GET['Peticion'])  ) {  ///Solo si no se trata de ninguno de los tres
			 ///comprobar  el bloqueo
			 $bloqueo=Numeromaximo::establoqueado($id,$this->documento);
			 if( !is_null($bloqueo))
				 throw new CHttpException(500,'Este documento está bloqueado por el Usuario : '.Yii::app()->user->um->LoadUserById($bloqueo->iduser)->username);
		  }

			///cargar el model
			$model=$this->loadModel($id);
		   //Iniciar bloqueo
		    Numeromaximo::bloquea($id,$this->documento);
		    ///Si se ingresa con URL Sin POST, sin AJAX -GRID, sin fn-update-GRID y no esta en sesion, normal NOMAS
		     ////Quiere decir que NO ha refrescado la pagina sin grabar,
		if  (!(  !isset($_GET['ajax']) and !isset($_POST['Peticion'])  and !isset($_GET['Peticion'])  and Numeromaximo::estasensesion($id,$this->documento)))
		  {


		           IF(!isset($_GET['ajax']) and !isset($_GET['Peticion'])) {
					   		if(isset($_POST['Peticion']))
					  						 {
						  							$model->attributes=$_POST['Peticion'];
						  							$itemstemporales=$this->dpeticion_a_tempdpeticion($id);
						   							$this->grabaitems($itemstemporales);
						  									 if($model->save()) {
							   										$itemspeticiones=$this->tempdpeticion_a_dpeticion($model->id);
							   										$this->grabaitems($itemspeticiones);
							   										Yii::app()->user->setFlash('success', "La solicitud se ha grabado!");
																 	$this->limpiatemporaldetalle();
																	 Numeromaximo::desbloquea($id,$this->documento);
																 $this->redirect(array('view','id'=>$model->id));
															        }



											 }  else  {
													$this->limpiatemporaldetalle();
													$modelotemporal=$this->peticion_a_temppeticion($id);
						  							 $modelotemporal->save();
						   							$itemstemporales=$this->dpeticion_a_tempdpeticion($id);
						   							$this->grabaitems($itemstemporales);
					   						}

				      		}
		  }  ELSE {///eN ES TE CSO QUIERE DECIR QUE REFRESOC LA PAGINA POR GUSTO , SIN GRABAR
			Yii::app()->user->setFlash('notice', "Se ha recargado la pagina sin confirmar los datos <br> Usted mantiene el modo ediion para este documento, por lo tanto esta bloqueado para otros usuarios");

		   }

			  $this->render('update',array('model'=>$model));
            */


public function actionModificadetalle($id)
{
	$modeli=new Tempdpeticion('update');
	$modeli=Tempdpeticion::Model()->findByPk($id);
	if ($modeli===null)
		throw new CHttpException(404,'No se encontro ningun documento para estos datos');
	if(isset($_POST['Tempdpeticion']))
	{
		//print_r($model->attributes);

		$modeli->attributes=$_POST['Tempdpeticion'];
		//print_r($model->attributes);

		if($modeli->save())
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
	if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
	$this->render('_form_detalle',array(
		'model'=>$modeli,
	));
}





	public function actionCreadetalle($idcabeza,$cest)
	{
		///Pasa x un filtro de comprobacion(obtieneidcabecera) para evitar que cualquier chistoso
		/// intente crear items desde la URL sin cabecera.
		$modelocabeza=Peticion::model()->findbypk($this->obtieneidcabecera($idcabeza));
		if(is_null($modelocabeza))
			throw new CHttpException(500,'No existe esta solicitud con este ID');
		//if($modelocabeza->estado=='10' OR $modelocabeza->estado=='99') {
			if(true) {
			$model=new Tempdpeticion();
			//$model->isdocParent=false;
				//$model->campoprecio=$this->nombrecampoprecio;
				$model->valorespordefecto($this->documentohijo);
				$model->codocu=$this->documentohijo;
				$model->hidpeticion=$idcabeza;
			//$model->valorespordefecto();
			// Uncomment the following line if AJAX validation is needed
			//$this->performAjaxValidation($model);
			if(isset($_POST['Tempdpeticion']))
			{
				$model->attributes=$_POST['Tempdpeticion'];
				$model->idstatus=+1; ///Agregado
				//crietria para filtrar la cantidad de items del detalle
				$criterio=new CDbCriteria;
				$criterio->condition="hidpeticion=:vid  AND idusertemp=:idusertemp";
				$criterio->params=array(':vid'=>$idcabeza,':idusertemp'=>Yii::app()->user->getId());
				$model->item=str_pad(Tempdpeticion::model()->count($criterio)+1,3,"0",STR_PAD_LEFT);

				//$model->codocu='350'; ///detalle guia
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

			// if (!empty($_GET['asDialog']))
			$this->layout = '//layouts/iframe';
			$this->render('_form_detalle',array(
				'model'=>$model, 'idcabeza'=>$idcabeza
			));

		} else{ //si ya cambio el estado impisble agregar mas items


			if (!empty($_GET['asDialog']))
				$this->layout = '//layouts/iframe';
			$this->render('vw_imposible',array(

			));
		}





	}



	public function actionCreadetalleserv($idcabeza,$cest)
	{
		///Pasa x un filtro de comprobacion(obtieneidcabecera) para evitar que cualquier chistoso
		/// intente crear items desde la URL sin cabecera.
		$modelocabeza=Peticion::model()->findbypk($this->obtieneidcabecera($idcabeza));
		if(is_null($modelocabeza))
			throw new CHttpException(500,'No existe esta solicitud con este ID');
		//if($modelocabeza->estado=='10' OR $modelocabeza->estado=='99') {
		if(true) {
			$model=new Tempdpeticion();

			$model->valorespordefecto($this->documentohijo);
			$model->codocu=$this->documentohijo;
			$model->hidpeticion=$idcabeza;

			/*********************************************
			 * La diferencia
			 */
			$model->setScenario('servicio');
			$model->codart=yii::app()->settings->get('materiales','materiales_codigoservicio');
			$model->tipo='S';


		if(isset($_POST['Tempdpeticion']))
			{
				$model->attributes=$_POST['Tempdpeticion'];
				$model->idstatus=+1; ///Agregado
				//crietria para filtrar la cantidad de items del detalle
				$criterio=new CDbCriteria;
				$criterio->condition="hidpeticion=:vid  AND idusertemp=:idusertemp";
				$criterio->params=array(':vid'=>$idcabeza,':idusertemp'=>Yii::app()->user->getId());
				$model->item=str_pad(Tempdpeticion::model()->count($criterio)+1,3,"0",STR_PAD_LEFT);

				//$model->codocu='350'; ///detalle guia
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

			// if (!empty($_GET['asDialog']))
			$this->layout = '//layouts/iframe';
			$this->render('_form_detalle_servicio',array(
				'model'=>$model, 'idcabeza'=>$idcabeza
			));

		} else{ //si ya cambio el estado impisble agregar mas items


			if (!empty($_GET['asDialog']))
				$this->layout = '//layouts/iframe';
			$this->render('vw_imposible',array(

			));
		}





	}



	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Peticion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Peticion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Peticion']))
			$model->attributes=$_GET['Peticion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Peticion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Peticion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Peticion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Peticion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
