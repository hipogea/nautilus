<?php

class TMonedaController extends Controller
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
				'actions'=>array('create','update','admin','cambio','colocacambio','actualizacambio'),
				'users'=>array('@'),
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
		$model=new TMoneda;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TMoneda']))
		{
			$model->attributes=$_POST['TMoneda'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codmoneda));
		}

		$this->render('create',array(
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
		$dataProvider=new CActiveDataProvider('TMoneda');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actioncambio()
	{
		$model=new Tipocambio('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TMoneda']))
			$model->attributes=$_GET['TMoneda'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function actioncolocacambio()
	{
		$model=new Tipocambio('general');
		//$model->unsetAttributes();  // clear any default values
		$monedas= yii::app()->db->createCommand()->selectDistinct('codmon1')->
		from('{{tipocambio}}')->queryColumn();
		$monedasfirme=array_combine($monedas,$monedas);

		
		if(isset($_POST['Tipocambio'])){
			//$model->attributes=$_POST['Tipocambio'];
			$model->attributes=$_POST['Tipocambio'];
			if ($model->validate()) {
				yii::app ()->tipocambio->setcompra ( $model->monedaref , $model->compra );
				yii::app ()->tipocambio->setventa ( $model->monedaref , $model->venta );
			}
			$this->redirect(array('cambio'));
		}
		$this->render('_form',array(
			'model'=>$model,'monedas'=>$monedasfirme,
		));

	}

	public function actionactualizacambio($moneda1,$moneda2)
	{

		$moneda=MiFactoria::cleanInput($moneda2);
		$moneda=MiFactoria::cleanInput($moneda1);
		$monedas= yii::app()->db->createCommand()->selectDistinct('codmon1')->
		from('{{tipocambio}}')->queryColumn();
		if(!in_array($moneda1,$monedas))
			throw new CHttpException(500,__CLASS__.'   '.__FUNCTION__.' '.__LINE__.' ...parametro de moneda incorrecto .');

		if(!in_array($moneda2,$monedas))
			throw new CHttpException(500,__CLASS__.'   '.__FUNCTION__.' '.__LINE__.' ...parametro de moneda incorrecto .');

		$model=Tipocambio::model()->find("codmon1='".$moneda1."' and codmon2='".$moneda2."'");
		$model->setScenario('general');
		$model->compra=yii::app()->tipocambio->getcompra($moneda2);
		$model->venta=round(1/yii::app()->tipocambio->getventa($moneda2),2);
		$model->monedaref=$moneda1;

		$monedasfirme=array_combine($monedas,$monedas);
		if(isset($_POST['Tipocambio'])){
			//$model->attributes=$_POST['Tipocambio'];
			$model->attributes=$_POST['Tipocambio'];
			if ($model->validate()) {
				yii::app ()->tipocambio->setcompra ( $model->monedaref , $model->compra );
				yii::app ()->tipocambio->setventa ( $model->monedaref , $model->venta );
			}
			$this->redirect(array('cambio'));
		}
		$this->render('_form',array(
			'model'=>$model,'monedas'=>$monedasfirme,
		));

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TMoneda the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TMoneda::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TMoneda $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tmoneda-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
