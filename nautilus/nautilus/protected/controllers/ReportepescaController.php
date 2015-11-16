<?php

class ReportepescaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	 
	 public $direcciones;
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
				'actions'=>array('index','view','A'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('eficiencia','gestionaparte','plantas','gestionaparte1','plantasedita','plantascrea'),
				'users'=>array('@'),
			),
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('eficiencia','creanovedad','respondenovedad','actualizanovedad','create','gestionaparte','update','updatehoras'),
				'users'=>array('arojas','admin','focana','gfillies','jtoledo','ovalenzuela','fangulo'),
			),
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crearparte'),
				'users'=>array('arojas','admin'),
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
	
	   $this->layout = '//layouts/column3';
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
		$model=new Reportepesca;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reportepesca']))
		{
			$model->attributes=$_POST['Reportepesca'];
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reportepesca']))
		{
			$model->attributes=$_POST['Reportepesca'];
														if(empty($model->fechaarribo))
												$model->fechaarribo=null;
			   
											if(empty($model->codplantadestino))
												$model->codplantadestino=null;
			
			if($model->save()) {
			
			//nos aseguramos que las coordenadas se guarden en le historial 
			if(!empty($model->latitud)&&!empty($model->meridiano)) {
			
			$modelocoor=NEW ReportepescaCoor;
			$modelocoor->latitud=$model->latitud;
			$modelocoor->meridiano=$model->meridiano;
			$modelocoor->aliaszona=$model->zonapesca;
			//$modelocoor->insert(array('id'=>1,'latitud'=>$model->latitud,'meridiano'=>$model->meridiano,'aliaszona'=>$model->zonapesca,'hidreporte'=>$model->id));
			$modelocoor->insert();
			}
			
			   if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog2').dialog('close');
													                    window.parent.$('#cru-frame2').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		window.parent.$.fn.yiiGridView.update('plantas-grid');
																		window.parent.$.fn.yiiGridView.update('anchoveta-grid');");
														Yii::app()->end();
												}
			}	
		}
		   //$this->redirect(array('view','id'=>$model->id));
			if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdatehoras($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reportepesca']))
		{
			$model->attributes=$_POST['Reportepesca'];
			$model->setScenario('escenarioreporte'); 
			$model->declarada= max($model->r1,$model->r2,$model->r3,$model->r4,$model->r5,$model->r6,$model->r7,$model->r8,$model->r9,$model->r10,$model->r11,$model->r12);
		
			if($model->save())
			
			   if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-frame').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		window.parent.$.fn.yiiGridView.update('anchoveta-grid');
																		window.parent.$.fn.yiiGridView.update('plantas-grid');
																		
																		");
														Yii::app()->end();
												}
				
		}
		//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_reporte',array(
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

	
	
	
	public function actionEficiencia($idtemporada)																																						
	{
		 // obtebiendo la matriz de datos
          $datos=VwBodegas::model()->search_temporada_anchoveta($idtemporada)->getdata();
		  $datosanchoveta=VwReportepescaTemporada::model()->search_por_temporada_anchoveta($idtemporada)->getdata();
		   //$datosjurel=VwReportepescaTemporada::model()->search_temporada_jurel($idtemporada)->getdata();
		  //arreglando bonito las  matrices
		  $this->layout="";
		  //nombres de la embarcaiones 
		  $barcos=array('001','002');
		  //pescadescargada 
		  $descargada=array(120,240);
		  //capcidad de bodega;
		  $bodega=array(500,300);
		  unset($barcos);
		    unset($descargada);
			  unset($bodega);
			//  array_multisort($datos,SORT_ASC, $datos['eficienciabodega']);
		 
		 // $matriz=$proveedor->getdata();
														$i=0;
															//$presionesmotor=array();
															//$presionescaja=array();
																	foreach ($datos as $clave => $valor) {
																			$barcos[$i]=$datos[$i]['nomep']	;
																			$descargada[$i]=$datos[$i]['sdescargada']+0	;  //tener cuiadado que los guarada com strings y on fucniona le grafico
																			$bodega[$i]=$datos[$i]['bodega']-$descargada[$i]	;//tener cuiadado que los guarada com strings y on fucniona le grafico
																				$i=$i+1;
																			}
		  
		  
		  
		  
		  
		  
		  
		/*  for ($i = 0; $i <= count($datos)-1 ; $i++) {
		  
		            array_push($barcos,$datos[$i]['nomep']);
					 array_push($descargada,$datos[$i]['sdescargada']);
					  array_push($bodega,$datos[$i]['bodega']);
		        
			}*/
		  
		  
		  if ((!is_null($datos)) && count($datos)>0) {
				$this->render('vw_eficienciabodega',array(
			//'model'=>$model
			       'barcos'=>$barcos,
				    'descargada'=>$descargada,
				    'bodega'=>$bodega,
					'globalito'=>$datosanchoveta[0]['eficienciabodega']+0,
					));
					
					}else {
					throw new CHttpException(404,'No se pudo encontrar el registro solicitado');
					}
	}
	
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	
		
		
	//$dataProvider=new CActiveDataProvider('Reportepesca');
	//	$this->render('index',array(
			//'dataProvider'=>$dataProvider,
		//));
	}
	public function actionPlantas($fecha,$idt)	
	{
	  $this->layout='//layouts/column2';
	  //preparando los subtotales :
	  $modelo=VwSPescatotalplantas::model()->find("fecha=:fechita",array('fechita'=>"".$fecha));
	  
	  $this->render("vw_plantas",array('fecha'=>$fecha,'modelo'=>$modelo,'idtemporada'=>$idt));
	}
	
	
	
	
	
	
	public function actionPlantasedita($fecha,$codplanta,$idtemporada)	
	{
		$model=pescaterceros::model()->find("fecha=:fechita and idtemporada=:tempito and codplanta=:plantita",
										array('fechita'=>"".$fecha,'tempito'=>$idtemporada,'plantita'=>$codplanta));
		if(isset($_POST['Pescaterceros']))
		{
			$model->attributes=$_POST['Pescaterceros'];
			if($model->save()) {
			   if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-frame').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId2']}');
																		");
														Yii::app()->end();
												}
				} else{
				throw new CHttpException(404,'No se pudo Grabar');
				}
		}
		//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
					$this->render("vw_pescaterceros",array('model'=>$model,'fecha'=>$fecha,'codplanta'=>'01'));
	}

	 public function actionPlantascrea($fecha,$codplanta,$desplanta)	
	{
		//$model=new Pescaterceros('search');
		$model=new Pescaterceros;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pescaterceros']))
		{
			$model->attributes=$_POST['Pescaterceros'];
		
			if($model->save()) {
			   if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-frame').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		
																		");
														Yii::app()->end();
												}
				} else{
				throw new CHttpException(404,'No se pudo Grabar');
				}
		}
		//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
					$this->render("vw_pescaterceros",array('model'=>$model,'fecha'=>$fecha,'desplanta'=>$desplanta,'codplanta'=>$codplanta));
	}

	
	
	
	public function actionCrearparte($idtemporada)
	{
	  $model=Temporadas::model()->findByPk($idtemporada);
	  $model->setScenario('escenarioparte');
	 // $this->performAjaxValidation($model);
		if(isset($_POST['ajax']) && $_POST['ajax']==='temporadas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		if(isset($_POST['Temporadas']))
		{
			
			$model->attributes=$_POST['Temporadas'];
			//$model->validate('escenarioparte')	;		
			 //$model->setScenario('escenarioparte');
             // if ($model->validate('escenarioparte')) {
			$command = Yii::app()->db->createCommand("select fn_crea_reporte_pesca('".$model->fechadehoy."',".$model->idespecie.",".$model->id.",'".$model->zonalitoral."')"); 
			$command->execute();
			$this->redirect(array('gestionaparte','fecha'=>$model->fechadehoy,'idt'=>$idtemporada));
			Yii::app()->end();
			//}
		}
		$this->render('creaparte',array(
			'model'=>$model,
		));
	
	}
	
	
	public function actionGestionaparte($fecha,$idt)
	{
	 
			
			$modeloreportes=	new Reportepesca;
							$modeloreportes->unsetAttributes(); 
						$criteriazo=new CDbCriteria;
						$criteriazo->addCondition('fecha = :idfecha');
						
						$criteriazo->addCondition('idtemporada = :idt');
						//$criteriazo->params = array(':idt' => $idt);
						$criteriazo->params = array(':idfecha' => $fecha,':idt'=>$idt);

					
		$criteriazo->compare('codep',$modeloreportes->codep,true);
		$criteriazo->together  =  true;
		$criteriazo->with = array('embarcacion');

			/*$criteriazo->together  =  true;
			$criteriazo->with = array('plantazarpe');
		 if($modeloreportes->plantazarpe_desplanta){
				$criteriazo->compare('plantazarpe.desplanta',$modeloreportes->plantazarpe_desplanta,true);
			}*/
			
		
			
				$sort=new CSort;
				$sort->attributes=array(
										//'embarcacion.nomep',
									// For each relational attribute, create a 'virtual attribute' using the public variable name
										'embarcacion.nomep' => array(
																	'asc' => 'embarcacion.nomep  ASC',
																	'desc' => 'embarcacion.nomep DESC ',
																	'label' => 'Embarcacion',
																	),
										'consumoportonelada'=>array('asc'=>'consumoportonelada ASC',
										            'desc'=>'consumoportonelada DESC',
													'label' => 'Fac',
										        ),
												//'codplantadestino',
											/*	'plantazarpe.desplanta'=>array(
																	'asc' => 'plantazarpe.desplanta  ASC',
																	'desc' => 'plantazarpe.desplanta DESC ',
																	//'label' => 'PD',
																	),*/
										'*',
										
										
										);

					Yii::app()->user->setFlash(
                'OKI', //a string for key usage
                'EST ES MI EMNSAJE'
							);
						//$modeloreportes->refrescacampos();	
						//$modeloreportes->refresh();
						$proveedorreportes= new  CActiveDataProvider($modeloreportes, array(
									'criteria'=>$criteriazo,
									'sort'=>$sort,
									'pagination' => array(
										'pageSize' => 40,
												),
									));	
									
										
			if(isset($_GET['Reportepesca']))
				$modeloreportes->attributes=$_GET['Reportepesca'];	
				           // $this->layout = '//layouts/column3';
							 $this->layout = '';
							 
							 $datas=$proveedorreportes->getdata();
							 //obteniendo los arrys de las fechas para navegacion
							if (count($datas) > 0 ) {
											$vtemporada=$datas[0]['idtemporada'];
											$vespecie=$datas[0]['idespecie'];
											$this->render('reportepordia',array('idtemporada'=>$vtemporada,'idespecie'=>$vespecie,'fecha'=>$fecha,'proveedorreportes'=>$proveedorreportes,'modeloreportes'=>$modeloreportes));
									}	else {
										$this->render('vw_mensaje');
										}
		
	
	}
	
	public function actionGestionaparte1($fecha)
	{
	 
			
			$modeloreportes=	new VwPartePesca;
							$modeloreportes->unsetAttributes(); 
						$criteriazo=new CDbCriteria;
						$criteriazo->addCondition('fecha = :idfecha');
						$criteriazo->params = array(':idfecha' => $fecha);



					
		
						//$modeloreportes->refrescacampos();	
						//$modeloreportes->refresh();
						$proveedorreportes= new  CActiveDataProvider($modeloreportes, array(
									'criteria'=>$criteriazo,
									//'sort'=>$sort,
									'pagination' => array(
										'pageSize' => 40,
												),
									));	
									
										
			if(isset($_GET['VwPartePesca']))
				$modeloreportes->attributes=$_GET['VwPartePesca'];	
				           // $this->layout = '//layouts/column3';
							 $this->layout = '';							 
							 $datas=$proveedorreportes->getdata();
							 //obteniendo los arrys de las fechas para navegacion 
							 $vtemporada=$datas[0]['idtemporada'];
							 $vespecie=$datas[0]['idespecie'];
							$this->render('reportepordia_1',array('idtemporada'=>$vtemporada,'idespecie'=>$vespecie,'fecha'=>$fecha,'proveedorreportes'=>$proveedorreportes,'modeloreportes'=>$modeloreportes));
					
		
	
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Reportepesca('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reportepesca']))
			$model->attributes=$_GET['Reportepesca'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionA()
	{
//$model=new Reportepesca('search');
		//$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Novedades']))
			$model->attributes=$_GET['Novedades'];

		$this->render('vw_novedades',array(
			//'model'=>$model,
		));
	}

	
	/**
	 * Manages all models.
	 */
	public function actionCreanovedad($novel)
	{
		
		$modelito=$this->loadModel($novel);
		  if (!is_null($modelito))  {
		  
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
         $model=new Novedades('miescenario');
		if(isset($_POST['Novedades']))
		{
			$model->attributes=$_POST['Novedades'];
				$model->setScenario('miescenario');
			if($model->save()) {
						$model->setScenario('miescenario');
						  //if(($model->criticidad =='A') OR ($model->criticidad =='B')) 
								//$this->enviacorreo(substr($model->descridetalle,0,35),$model->descridetalle,$model->idnovedad);
						         	$modelito->setAttribute('evento','1');
			  //$modelito->evento='1';
									$modelito->save();
						//throw new CHttpException(404,'No se pudo grabar');
								 $this->enviacorreo($modelito,$model);
						
					
			
			   if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');
													                    window.parent.$('#cru-frame3').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		window.parent.$.fn.yiiGridView.update('novedades-grid');
																		
																		");
														Yii::app()->end();
												}
				}
		}
		//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('crearnovedad',array(
			'model'=>$model, 'identidadparte'=>$novel,
		));
		
		} else {
		  throw new CHttpException(404,'No se pudo encontrar el registro solicitado para crear esta novedad');
		}
	}
	
	
	public function actionActualizanovedad($novel,$id)
	{
		 $model=$this->cargaNovedad($novel);
		 $modelito=$this->loadModel($id);
		  if (!is_null($model))  {
		  
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
		if(isset($_POST['Novedades']))
		{
			$model->attributes=$_POST['Novedades'];
			$model->setScenario('radiooperador');
			if($model->save()) {
			   if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog5').dialog('close');
													                    window.parent.$('#cru-frame5').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		
																		");
														Yii::app()->end();
												}
				} else{
				throw new CHttpException(404,'No se pudo Grabar');
				}
		}
		//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('crearnovedad',array(
			'model'=>$model, 'identidadparte'=>$modelito->id,
		));
		
		} else {
		  throw new CHttpException(404,'No se pudo encontrar el registro solicitado para crear esta novedad');
		}
	}
	
	
	
	public function actionRespondenovedad($novel,$id)
	{
		 $model=$this->cargaNovedad($novel);
		 $modelito=$this->loadModel($id);
		  if (!is_null($model))  {
		  
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
		if(isset($_POST['Novedades']))
		{
			$model->attributes=$_POST['Novedades'];
			$model->setScenario('responder');
			//echo $model->ultimares;
			if($model->save()) {
			   if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog6').dialog('close');
													                    window.parent.$('#cru-frame6').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		
																		");
														Yii::app()->end();
												}
				} else{
				throw new CHttpException(404,'No se pudo Grabar');
				}
		//} else {
		//throw new CHttpException(404,'No es el formaulrio');
		}
		//----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('respondenovedad',array(
			'model'=>$model, 'identidadparte'=>$modelito->id,
		));
		
		} else {
		  throw new CHttpException(404,'No se pudo encontrar el registro solicitado para crear esta novedad');
		}
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Reportepesca::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}
	
	public function cargapescaterceros($id)
	{
		$model=Pescaterceros::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'No se pudo cargar la pesca de terceros.');
		return $model;
	}
	
	public function cargaNovedad($id)
	{
		$model=Novedades::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'NO se encontro la novedad indicada.');
		return $model;
	}
	
	public function cargaTemporada($id)
	{
		$model=Temporadas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'NO se encontro la novedad indicada.');
		return $model;
	}
	

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reportepesca-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function enviacorreo($modelito,$model)
			{
				
				/********************************
				*	Temporalment lo almacenamos asi hasta que se definan los grupos en tablas 								
				**********************************/
				$listacorreos=array(
				'jramirez@exalmar.com.pe',
				'ecastro@exalmar.com.pe',
				'jtoledo@exalmar.com.pe',
				'focana@exalmar.com.pe',
				'mhuaman@exalmar.com.pe',				
				'ovalenzuela@exalmar.com.pe',
				'anarvaez@exalmar.com.pe',
				
				);
				/***********************************************************
				**************************************************************/
				
				
				array_push($listacorreos,Yii::app()->user->email);	
				$listadirecciones=implode (  "," ,  $listacorreos );					
				$titulo=$model->descri;
				$contenido=$model->descridetalle;
				$contenido.="<br>";
				
				//Los campos que se pintaran em la vista 
				$campos= array( 'embarcacion.nomep',
							    'plantadestino.desplanta',
								'plantazarpe.desplanta',
								//'harribo',
								'fechazarpe',
								'fechaarribo',
								'declarada',
								'descargada',
								'eficienciabodega');
								
				//El nombre de 	
				Yii::app()->crugemailer->mail_general($listadirecciones,"NOVEDAD-".$titulo,$contenido,$modelito,$campos);	         
				
			
			
	
			}
	
	
	
}
