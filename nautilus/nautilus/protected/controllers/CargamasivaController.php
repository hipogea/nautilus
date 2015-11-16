<?php

class CargamasivaController extends ControladorBase
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


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
				'actions'=>array('create','cargaescenario','carga','update','modificadetalle','borradetalle','import'),
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

	
public function actionModificadetalle($id)
	{
	$model=Cargamasivadet::Model()->findByPk($id);
		 if ($model===null)
		 	 throw new CHttpException(404,'No se encontro ningun documento para estos datos');
	  //	$this->performAjaxValidation($model);
      if(isset($_POST['Cargamasivadet']))
		{
			$model->attributes=$_POST['Cargamasivadet'];
			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													//Yii::app()->user->setFlash('success', "..Se agrego el item!");
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');																		
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");

														Yii::app()->end();
												}
		}
		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';

		$this->render('_cargamasiva',array(
			'model'=>$model, 'idcabeza'=>$model->id,
		));
		
	}
	
	public function actionBorradetalle()
	{
         if(isset($_GET['identi'])){
			 $model=Cargamasivadet::model()->findByPk($_GET['identi']+0)->delete();
			 
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

	
	public function actioncargaescenario() 
			
	{
		if(isset($_POST['Cargamasiva']['modelo']))
		$valormodelo=MiFactoria::cleanInput($_POST['Cargamasiva']['modelo']);
		 $modelInventariox=new $valormodelo;
			 $datosx = $modelInventariox->getScenarios();
			 unset($modelInventariox);
			 /*print_r($datosx);
			 yii::app()->end();*/
			 $valoresx=array();
			 foreach ($datosx  as $clavex => $valorx) {
				  $valoresx[$valorx]=$valorx;
			 }
		
			echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja un escenario'),true);
			foreach($valoresx as $value=>$name) { 
			    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			   } 
	}
		
	  
	
	
	
	
	
		public function actionimport($id)
		{
			$nombreprimercampo=null;
			 MiFactoria::limpialogcarga();
																						
			$carga=Cargamasiva::model()->findByPk($id);
			$carga->setScenario('search');
			//verificando que haya llenado bien los campos de longitud y orden 
				$filas=$carga->detalle;	
				foreach ($filas as $filita) {
					
					if(!((int)$filita->longitud > 0)  or !((int)$filita->orden >0) )
						throw new CHttpException(500,'Revise la longitud  y el orden del campo '.$filita->nombrecampo.'   ');
					
					if(is_null($nombreprimercampo))
					$nombreprimercampo=((int)$filita->orden ==1)?$filita->nombrecampo:null;
					
				}
		     if(is_null($nombreprimercampo)) {				
				 throw new CHttpException(500,'NO asignó un campo clave para la carga, debe tener el numero de orden 1   ');
					
			 }

		/*$modelito= new Inventario();
			var_dump(get_parent_class($modelito));
			echo "<br><br><br>";
			yii::app()->end();*/
			/*$modelito=Inventario::model()->findByPk(2000);
			var_dump($modelito);
			yii::app()->end();*/
			
            //hallando el modelo a cargar 
			
			
				if(isset($_POST['Cargamasiva']))
								{	
									//$model->attributes=$_POST['Alinventario'];
									
									$filelist=CUploadedFile::getInstancesByName('csvfile'); 
									
									
															
													foreach($filelist as $file)
																{
																	  $carga->ruta=Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.time().'.'.$file->getExtensionName();
																	  $file->saveAS($carga->ruta,false);	
																				//$transaction = Yii::app()->db->beginTransaction();
																				$handle = fopen("$file->tempName", "r");
																																							
																				$row = 1;
																		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
																		{


																			if($row>1){
																							if($carga->insercion=='1') 
																								{
																										$cadena="\$model= new ".$carga->modelo.";";	
																					            } else {
																										$cadena=" \$model= ".$carga->modelo."::Model()->find('".$nombreprimercampo."=:param ', array(':param'=>'".$data[0]."')); ";
																										
																								}
																										
																										eval($cadena);
																										if(is_null($model))	{
																									      MiFactoria::registralogcarga($row-1,$carga->id,' No se encontro ningun registro para el valor : '.$filas[$i]->nombrecampo.' =  '.$data[0].'  '   ,$filas[$i]->nombrecampo,0);
																					                       continue;
																										}
																										$model->setScenario($carga->escenario);   
																										
																			//Si el numero de  campos leidos = numero de campos de la carga
																			 if (count($data) != $carga->numeroitems) {
																				  MiFactoria::registralogcarga($row-1,$carga->id,'El numero de campos del objeto Carga y el archivo no coinciden.','todos',0);
																				throw new CHttpException(500,'El numero de campos del objeto Carga ('.$carga->numeroitems.') y el archivo ('.count($data).') no coinciden.');
																			 }
																			 //verificando que los datos ean ocnsistentes
																			  foreach ($data as $i=>$valorx) 
																			     {
																					  //si excede la longitud 
																					  /* var_dump(strlen(trim($data[$i])));
																					   echo "<br>";
																					    $model->{$filas[$i]->nombrecampo}='amigi';	
																					   var_dump($model->{$filas[$i]->nombrecampo});
																			           yii::app()->end();	*/
																				 
																					
																				
																			        if(!($carga->insercion !='1'  and $i==0 )) ///Si  es actuyalizacion y es el primer campo
																					  if(($filas[$i]->longitud < strlen(trim($valorx))))
																						  MiFactoria::registralogcarga($row-1,$carga->id,' El valor es demasiado largo para este campo',$filas[$i]->nombrecampo,0);
																					    //$huboerror=true;
																					  if(!($carga->insercion !='1'  and $i==0 )) ///Si no  es actuyalizacion y es el primer campo
																					  //si es requerido y no hay nada 
																					  if($filas[$i]->requerida=='1' and (is_null($valorx)  or  $valorx=="" or empty($valorx) or trim($valorx)=="" ))
																					    MiFactoria::registralogcarga($row-1,$carga->id,' Este campo es obligatorio',$filas[$i]->nombrecampo,0);
																					    //si no es del tipo 
																					    if($filas[$i]->tipo=='date' and preg_match('/^\d{4}-\d{2}-\d{2}$/',$valorx)==0  )
																					   	MiFactoria::registralogcarga($row-1,$carga->id,' Los formatos de fecha deben ser de la forma YYYY-MM-DD ',$filas[$i]->nombrecampo,0);
																					   ///ahora colocar los campos del modelo a llenar 
																					    
																					 if($carga->insercion!='1')
																					 {
																						if($i > 0)$model->{$filas[$i]->nombrecampo}=$valorx;
																					} else {
																						$model->{$filas[$i]->nombrecampo}=$valorx;
																					}
																					 
																																											
																					}
																				///Listo ya tratamos la fila ahora a validar el registro del $model llenado 
																						$model->validate();
																						$errores=$model->geterrors();
																						$mensaje="";
																						/*echo $model->getScenario();
																						echo "<br>";
																						echo "<br>";
																						print_r($model->attributes);
																						echo "<br>";
																						echo "<br>";
																						print_r($errores);																						
																						
																						yii::app()->end();*/
																					if(count($errores)==0 ) {
																						 MiFactoria::registralogcarga($row-1,$carga->id,' OK',$nombreprimercampo,1);
																						
																					}  else {
																						 foreach($errores as $clave=>$valor) {
																							  foreach($valor as $clavi=>$valori) {
																								  $mensaje.=$clavi.")".$valori."\n";
																							  }
																						  MiFactoria::registralogcarga($row-1,$carga->id,$valori,$clave,0);
																						  
																						 }
																						
																					}
																			   
																			  }                     
																									
																			$row++;
																		}
																		
																}
																
																$this->render('logerrores',array(
																'model'=>$carga,
																'ruta'=>$carga->ruta,
																		));
																yii::app()->end();
								} else  {
										echo "NO se ha enviado ningun form";						
										}
											$this->render('cargainventario',array(
												'model'=>$carga,
															));
    }
	
	
	public function actionCarga($id) {
		$carga=$this->loadModel($id);
		$cadena="\$model= new ".$carga->modelo.";";
			eval($cadena);
			$model->setScenario($carga->escenario);  
			
		
		if(isset($_POST['Cargamasiva'])){
			$carga->ruta=$_POST['Cargamasiva']['ruta'];
				
																				//$transaction = Yii::app()->db->beginTransaction();
																				$handle = fopen("$carga->ruta", "r");																																							
																				$row = 1;
																				$filas=$carga->detalle;	
																		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
																		{
																			if($row>1){
																			if($carga->insercion=='1') 
																								{
																										$cadena="\$model= new ".$carga->modelo.";";	
																					            } else {
																										$cadena=" \$model= ".$carga->modelo."::Model()->find('".$filas[0]->nombrecampo."=:param ', array(':param'=>'".$data[0]."')); ";
																										
																								}
																										
																										/*var_dump($carga->insercion);
																										yii::app()->end();*/
																										eval($cadena);
																										if(is_null($model))	throw new CHttpException(500,__CLASS__.' - '.__FUNCTION__.' - '.__LINE__.'  Error en la linea : '.($row-1).' del archivo de carga,   Revise el valor de la primera columna ');
																										
																										$model->setScenario($carga->escenario);   
																			//Si el numero de  campos leidos = numero de campos de la carga
																			 if (count($data) != $carga->numeroitems) {
																				  //MiFactoria::registralogcarga($row-1,$carga->id,'El numero de campos del objeto Carga y el archivo no coinciden.','todos',0);
																				throw new CHttpException(500,'El numero de campos del objeto Carga ('.$carga->numeroitems.') y el archivo ('.count($data).') no coinciden.');
																			 }
																			 //verificando que los datos ean ocnsistentes
																			  foreach ($data as $i=>$valorx) {
																					  //si excede la longitud 
																					  /* var_dump(strlen(trim($data[$i])));
																					   echo "<br>";
																					    $model->{$filas[$i]->nombrecampo}='amigi';	
																					   var_dump($model->{$filas[$i]->nombrecampo});
																			           yii::app()->end();	*/
																				 
																					
																				
																			        if(!($carga->insercion !='1'  and $i==0 )) ///Si no  es actuyalizacion y es el primer campo
																					  if(($filas[$i]->longitud < strlen(trim($valorx))))
																						  //MiFactoria::registralogcarga($row-1,$carga->id,' El valor es demasiado largo para este campo',$filas[$i]->nombrecampo,0);
																					     throw new CHttpException(500,'Linea '.($row-1).' El valor es demasiado larg.o para el campo  '.$filas[$i]->nombrecampo);
																					   //$huboerror=true;
																					  if(!($carga->insercion !='1'  and $i==0 )) ///Si no  es actuyalizacion y es el primer campo
																					  //si es requerido y no hay nada 
																					  if($filas[$i]->requerida=='1' and (is_null($valorx)  or  $valorx=="" or empty($valorx) or trim($valorx)=="" ))
																					   // MiFactoria::registralogcarga($row-1,$carga->id,' Este campo es obligatorio',$filas[$i]->nombrecampo,0);
																					     throw new CHttpException(500,'Linea '.($row-1).' Este campo es obligatorio '. $filas[$i]->nombrecampo);
																					  
																						//si no es del tipo 
																					    if($filas[$i]->tipo=='date' and preg_match('/^\d{4}-\d{2}-\d{2}$/',$valorx)==0  )
																					   //	MiFactoria::registralogcarga($row-1,$carga->id,' Los formatos de fecha deben ser de la forma YYYY-MM-DD ',$filas[$i]->nombrecampo,0);
																					     throw new CHttpException(500,'Linea '.($row-1).' Los formatos de fecha deben ser de la forma YYYY-MM-DD '.$filas[$i]->nombrecampo );
																					  
																					  ///ahora colocar los campos del modelo a llenar 
																					      if($carga->insercion!='1')
																					 {
																						if($i > 0)$model->{$filas[$i]->nombrecampo}=$valorx;
																					} else {
																						$model->{$filas[$i]->nombrecampo}=$valorx;
																					}
																																											
																					}
																				///Listo ya tratamos la fila ahora a validar el registro del $model llenado 
																						
																						$model->validate();
																						$errores=$model->geterrors();
																						$mensaje="";
																						/*echo $model->getScenario();
																						echo "<br>";
																						echo "<br>";
																						print_r($model->attributes);
																						echo "<br>";
																						echo "<br>";
																						print_r($errores);	*/																				
																						
																					
																					if(count($errores)==0 ) {
																						  //aqui esta la chicha
																						   ECHO "OK ";
																						   $model->save();
																							//$model->refresh();
																							
																						   echo "<br>";
																						 echo "<br>";
																					}  else {
																						 /*foreach($errores as $clave=>$valor) {
																							  foreach($valor as $clavi=>$valori) {
																								  $mensaje.=$clavi.")".$valori."\n";
																							  }
																						 // MiFactoria::registralogcarga($row-1,$carga->id,$valori,$clave,0);
																						  throw new CHttpException(500,'Linea '.($row-1).' '.$mensaje);
																					  
																						  
																						 }*/
																						 echo $model->getScenario();
																						  echo "<br>";
																						 echo "<br>";
																						 print_r($model->attributes);
																						 echo "<br>";
																						 echo "<br>";
																						
																						 print_r($errores);
																						 echo "<br>";
																						 echo "<br>";
																						 echo "<br>";
																						 echo "<br>";
																						
																					}
																			     unset($model);
																			  }                     
																									
																			$row++;
																		}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			 
		} else {
			throw new CHttpException(500,'NO ha enviado el formulario de datos');
			
		}
		
		
	}
	
	
	
	public function actionImportwer($idcargamasiva){
			$carga=Cargamasiva::model()->findByPk($idcargamasiva);
            //hallando el modelo a cargar 
			$cadena="\$model= new ".$carga->modelo.";";
			eval($cadena);
			if($cargamasiva->insert=='1') {$modelo->setScenario('insert');} else {$modelo->setScenario('update');}	   
				if(isset($_POST['Alinventario']))
								{	
									//$model->attributes=$_POST['Alinventario'];
									$filelist=CUploadedFile::getInstancesByName('csvfile');          
													foreach($filelist as $file)
																{
																			try{
																				$transaction = Yii::app()->db->beginTransaction();
																				$handle = fopen("$file->tempName", "r");
																				$row = 1;
																		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
																			  $filas=$carga->detalle;
																			     
																							if($row>1){
																								//Recorriendo los campos
																								foreach($filas as $filacampos){
																									
																									
																								   }
                       
																									}
																							$row++;
																																}
																							$transaction->commit();
																			}catch(Exception $error){
																		print_r($error);
																		$transaction->rollback();
																										}
																				yii::app()->end();
																}
           //} else

		  // {
			 //  echo "NO se valido CSM ";
			   //yii::app()->end();
		   //}
								} else  {
										echo "NO se ha enviado ningun form";
						//yii::app()->end();
										}
											$this->render('cargainventario',array(
												'model'=>$model,
															));
   }


	
	
	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Cargamasiva;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cargamasiva']))
		{
			$model->attributes=$_POST['Cargamasiva'];
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
 
		if(isset($_POST['Cargamasiva']))
		{
			$model->attributes=$_POST['Cargamasiva'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Cargamasiva');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cargamasiva('search');
		$model->unsetAttributes();  // clear any default values
		 
		if(isset($_GET['Cargamasiva']))
			$model->attributes=$_GET['Cargamasiva'];
		

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cargamasiva the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cargamasiva::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cargamasiva $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cargamasiva-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
