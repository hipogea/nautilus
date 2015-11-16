<?php

class LugaresController extends Controller
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
				'actions'=>array('create','display','crear','crearconcodpro','ver','verlugares','update','crear','cargadirecciones'),
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


	public function actiondisplay(){
		$model=new Lugares;

		if (isset($_GET['codpro'])) {
			$filtro=MiFactoria::cleanInput($_GET['codpro']);

			echo $this->renderpartial("direcciones_y_lugares",array('model'=>$model,'codpro'=>$filtro),true);
		} else {
			echo "NO SE DEFINIO EL CODIGO DEL PROVEEDOR";
		}



	}

	
public function actionRelaciona()
	{
			$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$vvalore=$_POST['Guia'][$campito];
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrea()
	{
		$model=new Lugares;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lugares']))
		{
			$model->attributes=$_POST['Lugares'];
			
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->codlugar));
		}

		$this->render('crear',array(
			'model'=>$model,
		));
	}



public function actionCargadirecciones()
	{
			
		$criteria = new CDbCriteria();
		$criteria->addCondition("c_hcod=:proved");
		$valor=$_POST['Lugares']['codpro'];
		$data=CHtml::listData(	Direcciones::model()->findAll(  "c_hcod='".$valor."'"),
		  //$data=CHtml::listData(	Direcciones::model()->findAll(),
												"n_direc",
												"c_direc"
											
												); 
			echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja una direccion'),true);
			foreach($data as $value=>$name) { 
			    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			   } 
			  
			//echo "h add  ola";
			   
	}





	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Lugares;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lugares']))
		{
			$model->attributes=$_POST['Lugares'];
			
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,'codpro'
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)  //codpro hace la de codlugar
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lugares']))
		{
			$model->attributes=$_POST['Lugares'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->codlugar));
		}

		$this->render('update',array(
			'model'=>$model,'codpro'=>$model->codpro,
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
		$dataProvider=new CActiveDataProvider('Lugares');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	
	
	/**
	 * Manages all models.
	 */
	public function actionVerlugares()
	{
		$model=new VwLugares;
		//$model->unsetAttributes();  // clear any default values
		
		/*if(isset($_GET['Lugares']))
			$model->attributes=$_GET['Lugares']; */
	$valor=$_POST['Lugares']['n_direc'];
	$prove=$model->search_($valor);
		$this->renderpartial('admin_completo',array(
			'prove'=>$prove,
		));
		//echo "hola amiguito  ".count($prove->getdata());
	}
	
	
	
	
	
	
	
	
	public function actionCrear(){
		$model=new Lugares;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lugares']))
		{
			$model->attributes=$_POST['Lugares'];
				$this->redirect(array('Crearconcodpro','codpro'=>$model->codpro));




		}

		$this->render('crear_con_codpro',array(
			'model'=>$model,'codpro'
		));

	}


	public function actionCrearconcodpro(){
		$model=new Lugares;
		if(isset($_GET['codpro']))
		{
			$codigoprov=MiFactoria::cleanInput($_GET['codpro']);
			$registro=Clipro::model()->findBypK($codigoprov);
			IF(IS_NULL($registro))
				throw new CHttpException(500,__CLASS__.''.__FUNCTION__.'   '.__LINE__.'    El codigo de proveedor Especificado no existe');

			if(count($registro->direcciones)==0)
				Yii::app()->user->setFlash('error', " Error :  El proveedor indicado no cuenta con direcciones fiscales, debe de crear una por lo menos ");
			if(isset($_POST['Lugares']))
			{
				$model->attributes=$_POST['Lugares'];
				$model->codpro=$codigoprov;
				if ($model->save()) {
					Yii::app()->user->setFlash('success', " Se ha creado el Lugar  ".$model->deslugar);

				}else {
					Yii::app()->user->setFlash('error', " Error :  ");
				}

				$this->redirect(array('admin'));


			}

			$this->render('_form_con_codpro',array(
				'model'=>$model,'codpro'=>$codigoprov,'modeloclipro'=>$registro
			));




		} else {

				throw new CHttpException(500,'El codigo de proveedor no ha sido espeificado');
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);



	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

		$model=new VwLugares('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwLugares']))
			$model->attributes=$_GET['VwLugares'];




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
		$model=Lugares::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='lugares-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
