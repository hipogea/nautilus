<?php

class DireccionesController extends Controller
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


	public function actioncargaprovincias()
	{

		$valor=$_POST['Direcciones']['coddepa'];
		$data=CHtml::listData(	Provincias::model()->findAll(  "coddepa='".$valor."'"),
			//$data=CHtml::listData(	Direcciones::model()->findAll(),
			"codprov",
			"provincia"

		);
		echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja una provincia'),true);
		foreach($data as $value=>$name) {
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
	}

	public function actioncargadistritos()
	{

		$valor=$_POST['Direcciones']['coddepa'];
		$valor1=$_POST['Direcciones']['codprov'];
		$data=CHtml::listData(	Ubigeos::model()->findAll(  "coddep='".$valor."' and codprov='".$valor1."'"),
			//$data=CHtml::listData(	Direcciones::model()->findAll(),
			"coddist",
			"distrito"

		);
		echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja un distrito'),true);
		foreach($data as $value=>$name) {
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
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
				'actions'=>array('cargaprovincias','cargadistritos','relaciona','recibevalor','creadireccion', 'create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			
			 array('allow',
          'actions'=>array('Agregar'),
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

	public function actionRelaciona()
	{
			$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$vvalore=$_POST['Direcciones'][$campito];
			$relaciones=$_GET['relaciones'];			
			 Yii::app()->explorador->buscavalor($campito,$vvalore,$ordencampo,$relaciones);
			  //Yii::app()->explorador->buscavalor('c_hcod','107977',1,$relaciones);
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
	
	
	
	
	
	
	public function actionCreate()
	{   
		$model=new Direcciones;
                $model->setScenario('creasolo');
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Direcciones']))
		{
			$model->attributes=$_POST['Direcciones'];
			
			if($model->save())
									if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
			
				$this->redirect(array('view','id'=>$model->n_direc));
		}
								//if (!empty($_GET['asDialog'])and !empty($_GET['codigoproveedor']) ) 
											//{	
											
												//$codigoproveedor=$_GET['codigoproveedor'];
												//$this->render_partial('/clipro/_form_creardirecciones',array('model'=>$model,'codigoproveedor'=>$codigoproveedor,));
											//} else {
											//$codigoproveedor="";
											//}
		   //----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
    //----- end new code --------------------
		$this->render('_form',array(
			'model'=>$model, ///le cocloamso ceor temporalmente 
		));
	}

	
	public function actionAgregar()
	{
		//$model=new Direcciones;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['codigoprov']))
		{
			//echo $_POST['codigoprov']  ;
			
		$model = new Direcciones;
		$this->render_partial('create',array('model'=>$model));
			
			echo Yii::app()->request->baseUrl.'/direcciones/views/_form';
			
			
		} else {
		   echo "nada";
		}

		  Yii::app()->end();
	}

	
	
	
	public function actionAddnew()
	{
		 $model=new Direcciones;
        // Ajax Validation enabled
        $this->performAjaxValidation($model);
        // Flag to know if we will render the form or try to add 
        // new jon.
                $flag=true;
        if(isset($_POST['Direcciones']))
        {       $flag=false;
            $model->attributes=$_POST['Direcciones'];
 
            if($model->save()) {
                //Return an <option> and select it
                           /* echo CHtml::tag('option',array (
                                'value'=>$model->jid,
                                'selected'=>true
                            ),CHtml::encode($model->jdescr),true);*/
                        }
       }
       if($flag) {
                 $this->renderPartial('createDialog',array('model'=>$model,),false,true);
               }
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

		if(isset($_POST['csvfile']))
		{

			$model->attributes=$_POST['Direcciones'];
			if($model->save())
						           if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
			  
			
				$this->redirect(array('view','id'=>$model->n_direc));
		}
			
		 //----- begin new code --------------------
				if (!empty($_GET['asDialog'])){
					$this->layout = '//layouts/iframe';
					//$codigoproveedor=$_GET['codpro'];
					}
    //----- end new code --------------------
		$this->render('_form',array(
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
		$dataProvider=new CActiveDataProvider('Direcciones');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Direcciones('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Direcciones']))
			$model->attributes=$_GET['Direcciones'];

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
		$model=Direcciones::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='direcciones-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
