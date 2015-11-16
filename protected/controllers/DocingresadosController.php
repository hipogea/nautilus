<?php

class DocingresadosController extends Controller
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
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','admin'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('relaciona','recibevalor','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
										
												//echo CHtml::script("window.parent.$('#cru-frame3').attr('src','');														
																		//");
												$campo=$_GET['campo'];
												$relaciones=$_GET['relaciones'];
												$nombreclase=Yii::app()->explorador->nombreclase($campo,$relaciones);
												
												
												$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
												
												$model=Yii::app()->explorador->devuelvemodelo($campo,$relaciones);												
												$model->unsetAttributes();  // clear any default values
												//$HFDSF
												//ECHO $SKHFKSFH;
												if(isset($_GET[$nombreclase]))
												$model->attributes=$_GET[$nombreclase];
												$this->layout='//layouts/iframe' ;
												$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
												 //$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												 
												}
										
	}
	
	public function Creasesiones($model)
	{
											Yii::app()->session['codprov'] = $model->codprov;
											 Yii::app()->session['desprov'] = $model->clipro->despro;
											 Yii::app()->session['codlocal'] = $model->codlocal;
											 Yii::app()->session['desprov'] = $model->clipro->despro;
										    Yii::app()->session['fechain'] = $model->fechain;  
											Yii::app()->session['tipodoc'] = $model->tipodoc; 
											Yii::app()->session['moneda'] = $model->moneda;  
											Yii::app()->session['codepv'] = $model->codepv; 
											Yii::app()->session['codresponsable'] = $model->codresponsable; 
											
	}
	
	public function Destruyesesiones()
	{
											unset(Yii::app()->session['codprov'] );
											unset(Yii::app()->session['desprov']);
											unset(Yii::app()->session['codlocal'] );  
											unset(Yii::app()->session['desprov']); 
											unset(Yii::app()->session['fechain'] );  
											unset(Yii::app()->session['tipodoc'] ); 
											unset(Yii::app()->session['moneda'] ); 
											unset(Yii::app()->session['codepv'] ); 
											unset(Yii::app()->session['codresponsable'] ); 
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Docingresados;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Docingresados']))
		{
			$model->attributes=$_POST['Docingresados'];
			if($model->save()) {
			// if ($model->conservarvalor==0 ) 
						$this->enviacorreo($model);
				$this->Creasesiones($model);
				if ($model->conservarvalor==0 )
				 $this->Destruyesesiones();
			   
				$this->redirect(array('view','id'=>$model->id));
				} ELSE {
				   throw new CHttpException(404,'No se pudo grabar ');
				}
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

		if(isset($_POST['Docingresados']))
		{
			$model->attributes=$_POST['Docingresados'];
			if($model->save())  {
			       //verificando si se slecciono la opcion de conservarlos valores 
						if ($model->conservarvalor=='0' ) 
						 $this->Destruyesesiones();
					 if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog1').dialog('close');
													                    window.parent.$('#cru-frame1').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');																		
																		
																		");
														Yii::app()->end();
												}
				
		   
		                       }
		}
		$this->layout = '//layouts/iframe';
		$this->render('update',array(
				'model'=>$model,
						));
	}

	public function enviacorreo($model)
			{
				
				$miusuario = Yii::app()->user->um->loadUserByCustomField('codigotra', $model->codresponsable);
				if (!is_null($miusuario)) {
				
				$listadirecciones=$miusuario->email;	
				
				//array_push($listacorreos,Yii::app()->user->email);	
				//$listadirecciones=implode (  "," ,  $listacorreos );					
				$titulo='INGRESO-'.$model->docus->desdocu.'-'.$model->barcos->nomep.'-'.$model->clipro->despro;
				$contenido="Se ingreso ".$model->docus->desdocu."  :".$model->numero;
				$contenido.="<br>";
				
				//Los campos que se pintaran em la vista 
				$campos= array( 'correlativo',
								'barcos.nomep',
							    'clipro.despro',
								'descorta',
								'trabajador.ap',
								'trabajador.am',
								'trabajador.nombres',
								
								);
				//El nombre de 	
				Yii::app()->crugemailer->mail_general($listadirecciones,$titulo,$contenido,$model,$campos);	         
				
			
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
		$dataProvider=new CActiveDataProvider('Docingresados');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VwDocuIngresados('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwDocuIngresados']))
			$model->attributes=$_GET['VwDocuIngresados'];

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
		$model=Docingresados::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='docingresados-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
