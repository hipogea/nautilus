<?php

class TemporadasController extends Controller
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
				'actions'=>array('vertempo','create','imprimebarco','update','admin','verbarcos','seriebarcos'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionverbarcos($id,$idespecie)
	{
	   

		$model=new VwPescaEmbarcaciones('search');
		$model->unsetAttributes();  // clear any default values
	   $criter=new CDbCriteria;
	   
			$criter->addCondition(" idtemporada= :tempito and idespecie = :tempito2 ");
			$criter->params = array(':tempito' => $id,':tempito2' => $idespecie);		///solo los log s qusestan sin tratar	
			$criter->addCondition(" idespecie= :tempito2 ");
			//$criter->params = array(':tempito2' => $idespecie);	

	
			
			$proveedor= new  CActiveDataProvider($model, array(
									'criteria'=>$criter,
									'sort'=>array(
									'defaultOrder'=>'nomep ASC',
            )						,
            'pagination' => array(
                'pageSize' => 40,
            ),

									
									));	






	   
		
		
		
		$this->render('vw_pesca_barcos',array(
			'idtemporada'=>$id,
			'proveedor'=>$proveedor,
		));
	}
	
	public function actionVertempo($idespecie,$idtemporada)
	{
	         //sacando los arrays para ointar la viostas 
			// $model=$this->loadmodel($idtemporada);
			 //el resumen de la temporada
				$modi=new VwReportepescaPorDia('search');
				$modi->unsetAttributes();  // clear any default values
				$criter=new CDbCriteria;
			//$criter->addCondition('codestado = :pcodestado');
			//$criter->params = array(':pcodestado' => '01');		///solo los log s qusestan sin tratar	
				$criter->addCondition("idtemporada = ".$idtemporada."");
				$criter->addCondition("idespecie = ".$idespecie."");
	
			
			$modresumen= new  CActiveDataProvider($modi, array(
									'criteria'=>$criter,
									'sort'=>array(
									'defaultOrder'=>'fecha ASC',
            )						,
            'pagination' => array(
                'pageSize' => 200,
            ),

									
									));	
			
			
			
			
			
			
			
			$model=VwReportepescaTemporada::model()->find('idtemporada=:identidad and idespecie=:especie',array(':identidad'=>$idtemporada,'especie'=>$idespecie));;
			// $modresumen=VwReportepescaPorDia::model()->search_por_temporada($idtemporada,$idespecie);
			 $metaespecie=$model->cuota_anchoveta;
			 $ancho=$modresumen->getdata();
			// echo count($ancho);
			 //obteniendo las fechas 
			 $fechas=array()	;
					$pescas=array();
					$acumulado=array();
					$meta=array();
					$ahoras=array();
					$abodega=array();
							$i=0;
								foreach ($ancho as $clave => $valor) {
											$fechas[$i]=substr($ancho[$i]['fecha'],5,5)	;
											$ahoras[$i]=$ancho[$i]['horas']+0	;
											$abodega[$i]=$ancho[$i]['bodega']+0	;
											//$aahoras[$i]=$ancho[$i]['horas']+0	;
											$pescas[$i]=$ancho[$i]['sdescargada']+0	;
												if ($i==0) {
																	$acumulado[$i]=$pescas[$i];
														}else {
																$acumulado[$i]=$acumulado[$i-1]+$pescas[$i]-0;
															}
											$meta[$i]=$model->cuota_anchoveta;
																$i=$i+1;
													}
			//$cumplimiento
	       ///ahora si salen a pintra las vistras :
		 $this->render('view_copia',array(
														'modresumen'=>$modresumen,
														'fechas'=>$fechas,
														'pescas'=>$pescas,
														'acumulado'=>$acumulado,
														'cumplimiento'=>$model->cumplimiento,
														'ancho'=>$ancho,
														'model'=>$model,
														'meta'=>$meta,
														'ahoras'=>$ahoras,
														'abodega'=>$abodega,
														//'cumplimiento'=>$cumplimiento,
														//'modresumen'=>$modresumen,
								)); 
		   
	
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	
	public function actionSeriebarcos($id,$codep,$idespecie) {
				$especies=VwReportepescaEspeciesTemporada::model()->search_por_temporada($id);
			if (!is_null($especies)) 
	            {	$matrices= VwPescaEmbarcacionesParametros::model()->retornadatos ($id,$idespecie,$codep);
												
												if (!is_null($matrices) ) {
													$this->render('view_barcos_series',array(
														'matrices'=>$matrices,
														'id'=>$id,
														'codep'=>$codep,
														'idespecie'=>$idespecie,
														)); 
													
													}else {
													  throw new CHttpException(404,'No se pudo encontrar el registro solicitado para visualizar datos');
													
													}
				}else{
					throw new CHttpException(404,'No se pudo encontrar el registro solicitado para visualizar la temporada');
				}
	
	
	}
	
	public function actionImprimebarco($id,$codep,$idespecie) {
	   $this->layout="";
				$especies=VwReportepescaEspeciesTemporada::model()->search_por_temporada($id);
			if (!is_null($especies)) 
	            {	$matrices= VwPescaEmbarcacionesParametros::model()->retornadatos ($id,$idespecie,$codep);
												
											
								# You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
 
        # render (full page)
        $mPDF1->WriteHTML($this->render('index', array(), true));
 
        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);
 
        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML(
								$this->render('vw_resumen_barco',array(
														'matrices'=>$matrices,
														'id'=>$id,
														'codep'=>$codep,
														'idespecie'=>$idespecie,
														),true)
		
							);
 
        # Renders image
        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
 
        # Outputs ready PDF
        $mPDF1->Output();





											//if (!is_null($matrices) ) {
													 
													
													//}else {
													 // throw new CHttpException(404,'No se pudo encontrar el registro solicitado para visualizar datos');
													
													//}
				}else{
					throw new CHttpException(404,'No se pudo encontrar el registro solicitado para visualizar la temporada');
				}
	
	
	}
	
	public function actionView($id)
	{
	//cargando el numero de especies de esa temporada
	$especies=VwReportepescaEspeciesTemporada::model()->search_por_temporada($id);
	//$resumenanchoveta=VwReportepescaEspeciesTemporada::model()->search_por_temporada($id);
			if (!is_null($especies)) 
	            {
					///prepara loa arrays para mostar las vistas 
							//$modeloresumen=VwReportepescaTemporada::model()->find('idtemporada=:identidad and idespecie=:especie',array(':identidad'=>$id,'especie'=>$resumenan));
	 
	 $model=$this->loadModel($id);
	 /* $anchovetapro=VwRppescaAnchoveta::model()->search_por_temporada($model->id);
	$anchoveta=$anchovetapro->getdata();
	$fechas=array()	;
	$pescas=array();
	$acumulado=array();
	$meta=array();
	$i=0;
    foreach ($anchoveta as $clave => $valor) {
								$fechas[$i]=substr($anchoveta[$i]['fecha'],5,5)	;
								$pescas[$i]=$anchoveta[$i]['sdescargada']+0	;
								if ($i==0) {
								      $acumulado[$i]=$pescas[$i];
								}else {
								   $acumulado[$i]=$acumulado[$i-1]+$pescas[$i];
								}
								 $meta[$i]=800000;
								
								//$presionescaja[$i]=$matriz[$i]['caja_paceite']	;
								$i=$i+1;
						}
	  $modeloresumen=*/
	  
						$this->render('vw_especies',array(
														'especies'=>$especies,
														'model'=>$model,
														//'modresumen'=>$modresumen,
														)); 
				     if ( $especies->totalItemCount>=1) 
					 {			
					
											
					 }	else {
							
							
						}					 
					 
				}else{
					throw new CHttpException(404,'No se pudo encontrar el registro solicitado para visualizar la temporada');
				}
	
	//cargando el modelo del reumen de la tenmporada 
	/*$modresumen=VwReportepescaTemporada::model()->find('idtemporada=:identidad',array(':identidad'=>$id));
	   if (!is_null($modresumen)) {
	    $this->layout = '//layouts/column3';
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'modresumen'=>$modresumen,
		));} else {
		
		 $this->render('view_nuevo',array(
					'model'=>$this->loadModel($id),
					//'modresumen'=>$modresumen,
					));
		
		}*/
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Temporadas;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Temporadas']))
		{
			$model->attributes=$_POST['Temporadas'];
			//$model->validate();
			$model->idespecie=1;
			$model->fechadehoy=$model->inicio;
			if($model->save()) {
			 // $modresumen=VwReportepescaTemporada::model()->find('idtemporada=:identidad',array(':identidad'=>15));
			 // echo gettype($modresumen);
			   
				$this->render('view_nuevo',array(
					'model'=>$model,
					//'modresumen'=>$modresumen,
					));
				} ELSE {
				  
				  ECHO "HUBO UN ERROR";
				}	
					
					
		} else {

		$this->render('create',array(
			'model'=>$model,
		));
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Temporadas']))
		{
			$model->attributes=$_POST['Temporadas'];
			//$this->redirect(array('view','id'=>$model->id));
			
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}	else{
					$this->render("xx",array('model'=>$model));
					//throw new CHttpException(404,'No se pudo Grabar');
				}   
		}
         
		$this->render('update',array(
			'model'=>$this->loadmodel($id),
		));
		
		//$this->render('view',array(
			//'model'=>$model,
		//));
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
		$dataProvider=new CActiveDataProvider('Temporadas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Temporadas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Temporadas']))
			$model->attributes=$_GET['Temporadas'];

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
		$model=Temporadas::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='temporadas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
