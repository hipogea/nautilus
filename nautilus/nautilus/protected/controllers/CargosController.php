<?php

class CargosController extends Controller
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
				'actions'=>array('create','pruebas','update','pruebasesion'),
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



/****************************************************
	 *	Retorna una cadena '' o 'disabled' para deshabilitar los controles del form de la vista
	 ****************************************************/
	public function eseditable($estadodelmodelo)
	{
		if ($estadodelmodelo=='01' or $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return '';} else{return 'disabled';}
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
		$model=new Cargos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cargos']))
		{
			$model->attributes=$_POST['Cargos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->cnumcargo));
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cargos']))
		{
			$model->attributes=$_POST['Cargos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->cnumcargo));
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
		$dataProvider=new CActiveDataProvider('Cargos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cargos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cargos']))
			$model->attributes=$_GET['Cargos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
     * Manages all models.
     */
    public function actionpruebasesion()
    {
        //unset(Yii::app()->session['carrito']);
       /* $session = Yii::app()->session;*/
       if(!isset($_SESSION['carrito'])||count($_SESSION['carrito'])==0) {
           $_SESSION['carrito']=array();

       }

        array_push( $_SESSION['carrito'],date("Y-m-d H:i:s"));

       // echo array_push( Yii::app()->session['carrito'],date("Y-m-d H:i:s"));
       //Yii::app()->session['carrito'][]=date("Y-m-d H:i:s");
             // echo count(Yii::app()->session['carrito']);


    }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cargos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cargos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cargos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cargos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function actionpruebas(){
echo " base url   : ".yii::app()->request->baseUrl."<br>";

echo " host info  : ".yii::app()->request->hostInfo."<br>";
echo " pathInfo  : ".yii::app()->request->pathInfo."<br>";
echo " requestType  : ".yii::app()->request->requestType."<br>";
echo " server name   : ".yii::app()->request->serverName."<br>";
echo " server port  : ".yii::app()->request->serverPort."<br>";
echo " URL   : ".yii::app()->request->url."<br>";
echo " useragent  : ".yii::app()->request->userAgent."<br>";
echo " userHost   : ".yii::app()->request->userHost."<br>";
echo " userHostAddres  : ".yii::app()->request->userHostAddress."<br>";






}
	
	
	
}
