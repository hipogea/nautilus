<?php

class CcController extends Controller
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
				'actions'=>array('create','cargagruposclases','update','reporte','reporteporceco'),
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


	public function actioncargagruposclases()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition("codclase=:proved");
		//$valor=$_POST['Cc']['codclase'];
		$criteria->params=array(":proved"=>MiFactoria::cleanInput($_POST['Cc']['codclase']));


		$data=CHtml::listData(	Grupocc::model()->findAll(  $criteria),
			//$data=CHtml::listData(	Direcciones::model()->findAll(),
			"codgrupo",
			"desgrupo"

		);
		echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja un grupo'),true);
		foreach($data as $value=>$name) {
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
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
		$model=new Cc;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cc']))
		{
			$model->attributes=$_POST['Cc'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codc));
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

		if(isset($_POST['Cc']))
		{
			$model->attributes=$_POST['Cc'];
			if($model->save()){
                yii::app()->user->setFlash('success','Se modifico el colector');
                $this->redirect(array('view','id'=>$model->codc));
            }else{
                var_dump($model->geterrors());
                yii::app()->end();
            }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}




	public function actionReporte()
	{
		$model=new CcForm;
		$model->setscenario('resumen');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['CcForm'])) {

			$model->attributes=$_POST['CcForm'];
			$arreglo = Yii::app()->db->createCommand(" select codc,sum(monto) as monti,codmoneda,b.desceco from
                        public_ccgastos a, public_cc b  where trim(a.ceco)=trim(b.codc)
				and   fechacontable > '".$model->fecha1."' and
				fechacontable < '".$model->fecha2."' and
				b.clasecolector='".$model->clasecolector."'
				group by ceco,codmoneda ")->queryAll();

			/*ECHO " select codc,sum(monto),codmoneda,b.desceco from
                        public_ccgastos a, public_cc b where trim(a.ceco)=trim(b.codc)
				and   fechacontable > '".$model->fecha1."' and
				fechacontable < '".$model->fecha2."' and
				b.clasecolector='".$model->clasecolector."'
				group by ceco,codmoneda ";
			Yii::app()->end();*/
			$proveedor=new CArrayDataProvider($arreglo);

			echo $this->renderpartial('adminreporte',array(
				'proveedor'=>$proveedor,
			));

		} else {

		$this->render('reporte_form',array(
			'model'=>$model,
		));

		}
	}


	public function actionReporteporceco()
	{
		$model=new CcForm;
		$model->setscenario('detalle');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['CcForm'])) {

			$model->attributes=$_POST['CcForm'];
			$arreglo = Yii::app()->db->createCommand(" select mes,sum(monto) as monti,codmoneda,b.desceco from
                        public_ccgastos a, public_cc b where trim(a.ceco)=trim(b.codc)
				and   fechacontable > '".$model->fecha1."' and
				fechacontable < '".$model->fecha2."' and
				b.codc='".$model->vceco."'
				group by mes  order by ano, mes asc ")->queryAll();

			$absisas=array();
			$ordenadas=array();
			foreach($arreglo as $fila)

			{
				array_push($absisas,$fila['mes']+0);
				array_push($ordenadas,$fila['monti']+0);


			}

				//print_r($absisas);
			   // print_r($ordenadas);
			$this->render('adminreportedetalle',array(
								'absisas'=>$absisas,'ordenadas'=>$ordenadas)

								);

		} else {

			$this->render('reporte_form',array(
				'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('Cc');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cc('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cc']))
			$model->attributes=$_GET['Cc'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cc the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cc::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cc $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cc-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
