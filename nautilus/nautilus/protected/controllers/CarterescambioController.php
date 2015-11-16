<?php

class CarterescambioController extends Controller
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

	public function accessRules()
	{
		Yii::app()->user->loginUrl = array("/cruge/ui/login");
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
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)	{
		$model=$this->loadModel($id);
		/********
		Estos atributos son para almacenar temporalmente
		los antiguos valores del horomtro y la fecha del ultimo
		cambio	
		**********/
		$model->setAttribute('fucambiox',$model->fucambio);
        $model->setAttribute('hucambiox',$model->hucambio);			
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
				if(isset($_POST['Carterescambio']))
							{
								$model->attributes=$_POST['Carterescambio'];
													 if($model->checkhorometroparteesmenor() )  //si la fecha de cambio es mayor que cualquier lectira del parte 
													    {
															//actualizar  la lectua del horometro tambien
															$model->setAttribute('horometro',$model->hucambio);
															$model->setAttribute('fulectura',$model->fucambio);
														}
								
											if($model->save()) {
													
												$this->redirect(array("partes/index"));
											
											}
							}

		/*Luego con estos valores  nos vamos a renderizar la vista apra poder pintar los valores y 
		ayudar al usuario para
		*/
		$fucambioant=$model->fucambiox;
		$hucambioant=$model->hucambiox;
		$this->render('update',array(
			'model'=>$model,'fucambioant'=>$fucambioant,'hucambioant'=>$hucambioant,
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
		$dataProvider=new CActiveDataProvider('Carterescambio');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Carterescambio('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Carterescambio']))
			$model->attributes=$_GET['Carterescambio'];

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
		$model=Carterescambio::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='carterescambio-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
