<?php
define('PROCESO_ALTA','100');
define('PROCESO_BAJA','200');
define('PROCESO_ASIGNACION','300');
define('PROCESO_DESASIGNACION','400');
define('ESTADO_BAJA','03');
define('ESTADO_OPERANDO','01');
define('ESTADO_FUERAOPERACION','02');

define('ESTAD_CREADA','01');
define('ESTAD_ANULADO','03');
define('ESTAD_APROBADA','02');
define('ESTAD_PREVIA','99');





class ControlactivosController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array('accessControl',array('CrugeAccessControlFilter'));
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
				'actions'=>array('cambiaestado','revertir','relaciona','recibevalor','enviacorreo','index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionRelaciona()
	  {
			$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$vvalore=$_POST['Controlactivos'][$campito];
			$relaciones=$_GET['relaciones'];			
			  Yii::app()->explorador->buscavalor($campito,$vvalore,$ordencampo,$relaciones);
			 //Fotos::buscavalor($campito,$vvalore,$ordencampo,$relaciones);
	}
	
	
	public function actionRecibevalor()
	{
		
		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
				{
				$autoIdAll = $_GET['checkselected']; ///The records selecteds 
				};
				if(count($autoIdAll)>0)
										{
												echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');													                    
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');	
																		var valoresclave= new Array();
																		var cadenita='{$autoIdAll[0]}';
																		var valoresclave=cadenita.split('_');																		
																		window.parent.$('#'+caja+'').attr('value',valoresclave[0]);
																		window.parent.$('#'+caja+'_99').html(valoresclave[1]);
																		");
														Yii::app()->end();
										} else{
												$campo=$_GET['campo'];
												$relaciones=$_GET['relaciones'];
												$nombreclase=Yii::app()->explorador->nombreclase($campo,$relaciones);
												$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
												$model=Yii::app()->explorador->devuelvemodelo($campo,$relaciones);												
												$model->unsetAttributes(); 
												if(isset($_GET[$nombreclase]))
												$model->attributes=$_GET[$nombreclase];
												$this->layout='//layouts/iframe' ;
												$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
												 //$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												
												}
										
	}
	
	
	
	
	
	
	
	
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	
	
	public function actionCambiaestado()
	{
		 $valor=MiFactoria::cleanInput($_GET['id']);
		 $modelo=$this->loadModel((INT)$valor);
		 $inventario=Inventario::model()->findByPk($modelo->idactivo);
		 
		 IF ($modelo->codtipoop==PROCESO_BAJA) //SI SE TRABA DE UNA BAJA 
				      { $inventario->codestado=ESTADO_BAJA; ///inicar el tramite de baja
					    //$minventario->numerodocumento=substr($model->numeroref,0,19); ///inicar el tramite de baja
						$inventario->setscenario('cambiaestado');						
					    $inventario->save();
					 }	
			 IF ($modelo->codtipoop==PROCESO_ASIGNACION or $modelo->codtipoop==PROCESO_DESASIGNACION) //SI SE TRABA DE UNA BAJA 	
                      { 		
					             $inventario->setscenario('cambiaep');
								if(!$modelo->operando=='1'){
										
											$inventario->codestado=ESTADO_OPERANDO;
								
								 } else {
									$inventario->codestado=ESTADO_FUERAOPERACION;
									 
								 }
								
					    //$minventario->numerodocumento=substr($model->numeroref,0,19); ///inicar el tramite de baja
						       
								$inventario->codepantant=$inventario->codepanterior; ///guarda el valor antes de cambiarlo
								$inventario->codep=$modelo->codep;
								$inventario->codepanterior=$inventario->codep; ///avanza un barco mas 
								
								$inventario->save();
					 }	

				
		// $inventario->codestado='04';
		 $modelo->codestado=ESTAD_APROBADA; //aprobar 
		 $modelo->save();
		// $inventario->save();
		/* echo CHtml::textField('hola',
			  Estado::model()->find('codestado=:miestado and codocu=:midocumento',array(':midocumento'=>'017',':miestado'=>ESTAD_APROBADA))->estado,
			  array('id'=>'pepin','disabled'=>'disabled','size'=>20));
			  yii::app()->user->setFlash('notice','Se ha confirmado');*/
			 $this->render('update',array(
			'model'=>$modelo,'inventario'=>$inventario,
		)); 
		 
		 
	}
	
	
	
	
	
	public function actionRevertir()
	{
		 $valor=MiFactoria::cleanInput($_GET['id']);
		 $modelo=$this->loadModel((INT)$valor);
		 $inventario=Inventario::model()->findByPk($modelo->idactivo);
		 
		 IF ($modelo->codtipoop==PROCESO_BAJA) //SI SE TRABA DE UNA BAJA 
				      { 
					  $inventario->codestado=$inventario->codestadoant; 
					    $inventario->codestadoant='';  //borrar este adto apra a
					  
						//$minventario->numerodocumento=substr($model->numeroref,0,19); ///inicar el tramite de baja
						$inventario->setscenario('cambiaestado');						
					    $inventario->save();
					 }	
			 IF ($modelo->codtipoop==PROCESO_ASIGNACION or $modelo->codtipoop==PROCESO_DESASIGNACION) //SI SE TRABA DE UNA BAJA 	
                      { 		
					             $inventario->setscenario('cambiaep');
								if(!$modelo->operando=='1'){
										
											$inventario->codestado=ESTADO_OPERANDO;
								
								 } else {
									$inventario->codestado=ESTADO_FUERAOPERACION;
									 
								 }
								 $inventario->codestado=$inventario->codestadoant;
					    //$minventario->numerodocumento=substr($model->numeroref,0,19); ///inicar el tramite de baja
						        $inventario->codep=$inventario->codepanterior;
								$inventario->codepanterior=$inventario->codepantant;
								$inventario->codepantant=''; 
								$inventario->save();
					 }	

				
		// $inventario->codestado='04';
		 $modelo->codestado=ESTAD_CREADA; //aprobar 
		 $modelo->save();
		// $inventario->save();
		 /*echo CHtml::textField('hola',
			  Estado::model()->find('codestado=:miestado and codocu=:midocumento',array(':midocumento'=>'017',':miestado'=>'02'))->estado,
			  array('id'=>'pepin','disabled'=>'disabled','size'=>20));*/
			  
			  $this->render('update',array(
			'model'=>$modelo,'inventario'=>$inventario,
		));
			  
		 
		 
	}
	
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		/*$cadena='ase,derge,guri,smens,loja';
		print_r(explode(",",$cadena));
		yii::app()->end();*/
		
		
		
		$model=new Controlactivos;
		$model->codestado='99';
		$inventario=Inventario::model()->findByPk((int)$id);
		if(is_null($inventario))
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		
			//print_r($_GET['micodigomov']);
			//yi::app()->end();
		if(isset($_GET['micodigomov']))
		{
			
			$model->codtipoop=$_GET['micodigomov'];
			
			$model->setScenario('create');
			
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Controlactivos']))
		{
			$model->attributes=$_POST['Controlactivos'];
			//creando el numero de serie 
			
				$model->idactivo=$inventario->idinventario;					   
			if($model->save())
			     
					 
				//$this->enviacorreo($model);
				//yii::app()->user->setFlash('success','Se generó el documento ');
				$this->redirect(array('update','id'=>$model->idformato));
				
			
		}

		$this->render('create',array(
			'model'=>$model,'inventario'=>$inventario,
		));
	}

	public function loadInventario($id)
	{
		$model=Inventario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}

	
	public function enviacorreo($model)
			{
				
				/********************************
				*	Temporalment lo almacenamos asi hasta que se definan los grupos en tablas 								
				**********************************/
				$listacorreos=array(
				'hipogea@hotmail.com',				
				//'ecastaneda@exalmar.com.pe',
				
				);
				/***********************************************************
				**************************************************************/
				
				
				//array_push($listacorreos,Yii::app()->user->email);	
				$listadirecciones=implode (  "," ,  $listacorreos );					
				$titulo='Solicitud de ACTIVO FIJO-'.$model->numformato;
				$contenido=$model->comentario;
				$contenido.="<br>";
				
				//Los campos que se pintaran em la vista 
				$campos= array( 'barcoactual.nomep',
							    'barcoanterior.nomep',
								'centro.nomcen',
								'solicitante.ap',
								'solicitante.am',
								'solicitante.nombres',
								);
				//El nombre de 	
				Yii::app()->crugemailer->mail_general($listadirecciones,"NOVEDAD-".$titulo,$contenido,$model,$campos);	         
				
			
			
	
			}
	
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$inventario=Inventario::model()->findByPk($model->idactivo);
		if(is_null($inventario))
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
       
		if(isset($_POST['Controlactivos']))
		{
			//yii::app()->end();
			$model->attributes=$_POST['Controlactivos'];
			if($model->save()){}
			
				yii::app()->user->setFlash('success','Se han grabado los datos  '.$model->codestado);
				//$this->redirect(array('view','id'=>$model->idformato));
		}

		$this->render('update',array(
			'model'=>$model,'inventario'=>$inventario,
		));
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
		$dataProvider=new CActiveDataProvider('ControlActivos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Controlactivos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Controlactivos']))
			$model->attributes=$_GET['Controlactivos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ControlActivos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Controlactivos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ControlActivos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='control-activos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}