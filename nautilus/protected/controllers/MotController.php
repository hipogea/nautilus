<?php

class MotController extends Controller
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
				'actions'=>array('create','update'),
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
		$model=new Mot;
		$naleatorio=1; ///esto es por gusto apra evitar errroes limia esta varialbe ya que no sirve 
        // $naleatorio=Numeromaximo::numero_aleatorio(10,10001);
		// $model->numeroauxiliar=$naleatorio;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (!isset(Yii::app()->session['numeropedido'])) {
		   // unset(Yii::app()->session['numeropedido']);
		   Yii::app()->session['numeropedido'] = Numeromaximo::numerounico();
			} ELSE {
			   /* if(!isset($_POST['Mot']) and isset(Yii::app()->session['numeropedido']))
			     unset(Yii::app()->session['numeropedido']); ///LIMPIAMOS CAULQUIER SESION QUE HAYA QUEDADO , SIEMPER Y CUANDO NO VENGA DE UN POST 
			      Yii::app()->session['numeropedido'] = Numeromaximo::numerounico();*/
			}
		
		
		if(isset($_POST['Mot']))
		{
			$model->attributes=$_POST['Mot'];
			if($model->save()) {
					//si grabo bien
					
					
				$model->refresh();  //ahora si ya 
				$cadenasql="UPDATE mot_mat_det  SET hidmot =".$model->id." where hidmot= ".Yii::app()->session['numeropedido']." ";
				Yii::app()->db->createCommand($cadenasql)->execute();
				//destrumos al sesion del numero de pedidod 
				unset(Yii::app()->session['numeropedido']);
				unset(Yii::app()->session['numeroitem']);
																								//echo " este es elutlimo id ---------------------->".$model->id."<br>";
																							
				
			
			
			
			
			
			
				$this->redirect(array('view','id'=>$model->id));
				}
		}

		/*if (!empty($_GET['aleatorio']))	
			$model->numeroauxiliar=$_GET['aleatorio'];
		*/
		
		$this->render('create',array(
			'model'=>$model,
			'naleatorio'=>$naleatorio,
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mot']))
		{
			$model->attributes=$_POST['Mot'];
			if($model->save())
			    unset(Yii::app()->session['numeroitem']);
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'naleatorio'=>$model->id,
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
		$dataProvider=new CActiveDataProvider('Mot');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Mot('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mot']))
			$model->attributes=$_GET['Mot'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Mot::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mot-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
