<?php

class MaestroAtributosController extends Controller
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
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

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
				'actions'=>array('create','update','Relaciona','Recibevalor'),
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

	
	public function actionRelaciona()
	{
			$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$vvalore=$_POST['MaestroAtributos'][$campito];
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
												//$modeliz=new MaestroGrupos;
												//$relaciones=$modeliz->relations();
												$nombreclase=Yii::app()->explorador->nombreclase($campo,$relaciones);
												//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MaestroAtributos;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['MaestroAtributos']))
		{
			$model->attributes=$_POST['MaestroAtributos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['MaestroAtributos']))
		{
			$model->attributes=$_POST['MaestroAtributos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('MaestroAtributos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MaestroAtributos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaestroAtributos']))
			$model->attributes=$_GET['MaestroAtributos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MaestroAtributos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MaestroAtributos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MaestroAtributos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='maestro-atributos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
