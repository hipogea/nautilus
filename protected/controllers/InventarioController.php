<?php

class InventarioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $direcciones='';

	
	
	
	/**
	 * Esta es una funcion que usa las extensione spara exportar a Excel 
	 * 
	 */
	
	public function behaviors() {
    return array(

        'exportableGrid' => array(
            'class' => 'application.components.ExportableGridBehavior',
            'filename' => 'Inventario.csv',
            'csvDelimiter' =>(Yii::app()->user->isGuest)?",":Yii::app()->user->getField('delimitador') , //i.e. Excel friendly csv delimiter
            ));
}
	
	
	
	
	
	
	
	
	
	

		public function filters()
	{
		return array('accessControl',array('CrugeAccessControlFilter'));
	}
	
	public function accessRules()
	{
		 Yii::app()->user->loginUrl = array("/cruge/ui/login");
		
		
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
		
			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','admin','prove','view','observaciones','envia','exporta','detalle','confrimar','update','gestionafotos','pio','updatetotal','subearchivo','seleccionaactivo','borrafotos','tratavarios','llenaproceso','borrafoto'),
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

	public function actionaviso()
	{
		$this->render('aviso');
	}
	
	
	
	public function actionObservaciones()
	{
		$this->redirect(array('observaciones/admin'));
	}

	
public function actiontratavarios(){
 $model=new Inventario('search');
 $model->setScenario('procesar');
            if(isset($_POST['Inventario']))
		{
			$model->attributes=$_POST['Inventario'];
			/*var_dump($model->attributes);
			  yii::app()->end();*/
			if($model->save()) {
				//limpiamos le eporal de tratamiento
				Mifactoria::limpiaactivostratados();
				yii::app()->user->SetFlash('success','Se trataron los activos');
			  // $this->render('admin_trata',array('model'=>$model));
		      
			  
			}
		}
	
			$this->render('admin_trata',array('model'=>$model));
			
		
}	
	
public function actionSeleccionaactivo()
	{
		$id=$_POST['codiguito'];
		if (isset($_POST['ajax'])){
			echo " es un ajax  ";
		
			yii::app()->end();
		}
		  
	      MiFactoria::trataactivo($id);
		//echo "salio ".$id;
		return 1;
	}

	
	public function actionllenaproceso()
	{
		$id=$_POST['codiguito'];
		$model=new Inventario;
		$form=New CActiveForm();
		$this->renderpartial('_trata_'.$id,array('model'=>$model,'form'=>$form));
	}
	
	public function actionborrafotos($modelid,$id, $action){
			
		if($action == 'select') {  
		   // $this->render("vw_cli",array("id"=>$id));
		  // $command = Yii::app()->db->createCommand("insert into fifo (uno) values ('".trim($id)."')"); 
			//$command->execute();
			Yii::app()->end();
			//$this->render("vw_cli",array("id"=>$id));
			} 
		if($action == 'delete') {
				unlink(trim(Yii::app()->params['rutafotosinventario'].$id));
			//$command = Yii::app()->db->createCommand("insert into fifo (uno) values ('".$id."')"); 
			//$command->execute();
			//$cadenita="\";
			//$imagen=Yii::app()->file->set(trim(Yii::app()->params['rutafotosinventario'].$id));
			//$imagen=Yii::app()->file->set('');
			//if($imagen->delete(true)){
									//$command = Yii::app()->db->createCommand("insert into fifo (uno) values ('".trim(Yii::app()->params["rutafotosinventario"].$id)."')"); 
									//$command->execute();
									//echo Yii::app()->params['rutafotosinventario'].$id;
							//} else {
									//throw new CHttpException(500,'No se pudo borrar el archivo');	;
								//}
			$modelonue=$this->loadmodel($modelid);
					$logfotos=new Logfotosinventario();
					$logfotos->ip=CHttpRequest::getUserHostAddress();
					$logfotos->iduser=Yii::app()->user->id;
					$logfotos->fecha= date("Y-m-d H:i:s"); 
					 $logfotos->hidinventario=$modelid; 
					  $logfotos->operacion= "BORRA"; 					  
					   $logfotos->nombrefoto= $id; 
					   if(!$logfotos->save()) {
						   print_r($logfotos->getErrors());
					   Yii::app()->end();
					   }
					$modelonue->setScenario("subefoto");
					$modelonue->clasefoto="ELIMINADA";
					if(!$modelonue->save()) {
					  print_r($modelonue->getErrors());
					   Yii::app()->end();
					}
						//echo CHtml::script("window.parent.location.href = 'http://www.google.com';");

			Yii::app()->end();
		}
	}
	
	
	public function actionConfirmar($id)
	{
		$this->render('vw_confirmar',array(
			'id'=>$id,
		));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Inventario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventario']))
		{
			$model->attributes=$_POST['Inventario'];
			
			
			  
			  
			if($model->save()) {
				Yii::app()->user->setFlash('success',' Se ha creado el activo Fijo ');
			   $this->render('update',array(
			'model'=>$model,
		           ));
				Yii::app()->end();   
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
public function actionpio() {
		echo Yii::app()->getBaseUrl(true);
		echo "<br>";
		echo "BASE PAT   " .Yii::app()->basePath;
		echo "<br>";
		echo "BASE URL   " .Yii::app()->baseUrl;
		echo "<br>";
		echo "HOME URL ". Yii::app()->homeUrl;
		echo "<br>";
		echo Yii::getPathOfAlias('webroot');
		
	}
	
	public function actualizainventario () {
		
		
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

		if(isset($_POST['Inventario']))
		{
			$model->attributes=$_POST['Inventario'];
			  //echo "OJO CON ESTO ".$_POST['Inventario']['tienecarter'];
			if($model->save()) {
			 // echo "pso";
			 //echo $model->codep;
			  Yii::app()->user->setFlash('success',' Se ha actualizado el activo Fijo ');
			// echo $_POST['Inventario']['codestado'];
				 $this->render('update',array(
			'model'=>$model,
		           ));
				   Yii::app()->end();  
				
				}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	
	
	
	
	
	
	public function actionUpdatetotal($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventario']))
		{
			
			$model->attributes=$_POST['Inventario'];
			$model->tienecarter=$_POST['Inventario']['tienecarter'];
			 // echo $_POST['Inventario']['codep'];
			if($model->save()) {
			 // echo "pso";
			 //echo $model->codep;
			  Yii::app()->user->setFlash('success',' Se ha actualizado el activo Fijo ');
			// echo $_POST['Inventario']['codestado'];
				 $this->render('update',array(
			'model'=>$model,
		           ));
				   Yii::app()->end();  
				
				}
				
		}

		$this->render('update_total',array(
			'model'=>$model,
		));
	}
	
	public function actionSubearchivo($id)
    {
        $model=new Inventario;
		//ECHO "la magen ".$_POST['image'];
        if(isset($_POST['Inventario']))
        {		  
            $model->attributes=$_POST['Inventario'];
            $model->imagen=CUploadedFile::getInstance($model,'imagen');
		         $mensaje="";
				 $mensaje2="";
			     $extensionimagen=strtoupper($model->imagen->getExtensionName());
			     $extensionpermitida=array('JPEG','JPG','PNG','GIF','BMP');
				if (!in_array($extensionimagen,$extensionpermitida))
					$mensaje="El archivo no es una imagen valida  ".$model->imagen->getExtensionName();
			    $tamanomaximo=1100;
				if ($model->imagen->getSize() > 1024*$tamanomaximo)
					$mensaje2="El archivo  es muy pesado :".(ROUND($model->imagen->getSize()/1024,2))." suba imagenes menores a ".$tamanomaximo." KB ";
				
				if (trim($mensaje.$mensaje2==""))  
				{
				  
					$modelonue=$this->loadmodel($id);
					//$rutaagrabar=Yii::app()->params['rutafotosinventario'].trim($modelonue->codpropietario);

					IF(!is_dir(Yii::getPathOfAlias('webroot.fotosinv')))
						throw new CHttpException(500,' No existe el directorio de fotos de activos : fotosinv ');

					$rutaagrabar=Yii::getPathOfAlias('webroot.fotosinv').DIRECTORY_SEPARATOR.trim($modelonue->codpropietario).DIRECTORY_SEPARATOR ;
					//$rutaagrabar=yii::app()->baseUrl.'/recurso/fotosinv/';
					//echo $extensionimagen."<br>";
					//var_dump(is_dir($rutaagrabar));
					//yii::app()->end();
					if(!is_dir($rutaagrabar))
						if(mkdir($rutaagrabar))
							throw new CHttpException(500,' No se pudo generar el directorio: '.$rutaagrabar);
					$fot=new Fotos($modelonue->idinventario,$rutaagrabar,$extensionimagen) ;
					$fotonueva=$fot->siguiente_numero();

					$model->imagen->saveAs($fot->rutadearchivos.$fotonueva);
					
					$logfotos=new Logfotosinventario();
					$logfotos->ip=CHttpRequest::getUserHostAddress();
					$logfotos->iduser=Yii::app()->user->id;
					$logfotos->fecha= date("Y-m-d H:i:s"); 
					 $logfotos->hidinventario=$id; 
					  $logfotos->operacion= "SUBIR"; 					  
					   $logfotos->nombrefoto= $fotonueva; 
					   if(!$logfotos->save()) {
						   print_r($logfotos->getErrors());
					   Yii::app()->end();
					   }
					$modelonue->setScenario("subefoto");
					$modelonue->clasefoto=$fotonueva;
					if(!$modelonue->save()) {
					  print_r($modelonue->getErrors());
					   Yii::app()->end();
					}
					$this->redirect(array('detalle','id'=>$id));
					
				}
				  
				else 
				{
				   $this->render('vw_error_foto',array('mensaje'=>$mensaje,'mensaje2'=>$mensaje2));
				   Yii::app()->end();
				  }
        }
		$model=$this->loadModel($id);
        $this->render('vw_subir_archivo', array('model'=>$model,'id'=>$id));
    }
	
	
	 
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSube($id)
	{
		$model=$this->loadModel($id);

		$this->render('vw_subearchivo',array('model'=>$model));
	}
	
	
	public function ActionEnvia() {
	$model=$this->loadModel(1997);
	$this->enviacorreo('erer',$model);
	}
	
	
	public function enviacorreo($codigoplaquita,$model)
	
			{
			$subject="CREACION DE ACTIVO-".$codigoplaquita." ".$model->descripcion;
			//$modeloparte=Inventarioartes::model()->find('id=:hidparte',array(':hidparte'=>$id));
			//echo "el tipo es ".gettype($id). "--".$id;
			//$subject="Novedad   ".$modeloparte->embarcaciones->nomep."   ".
			$this->direcciones='mcampana@exalmar.com.pe,rnoriega@exalmar.com.pe,jramirez@exalmar.com.pe,ecastaneda@exalmar.com.pe,aruiz@exalmar.com.pe,jdominguez@exalmar.com.pe,jcarrasco@exalmar.com.pe,jtoledo@exalmar.com.pe,focana@exalmar.com.pe,gfillies@exalmar.com.pe,fangulo@exalmar.com.pe,tvictorio@exalmar.com.pe' ;
		// $this->direcciones='jramirez@exalmar.com.pe';
		  // Contactos::model()->find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro))
    	//$this->direcciones='jramirez@exalmar.com.pe';
		 
		$adminEmail =Yii::app()->getModule('user')->user()->profile->lastname." ".Yii::app()->getModule('user')->user()->profile->amaterno." ".Yii::app()->getModule('user')->user()->profile->firstname." <". Yii::app()->getModule('user')->user()->email .">" ;
	    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    
			$message="<head>";
			$message=$message."<style type='text/css'> ";
			$message=$message."table.gridtable {font-family: verdana,arial,sans-serif;font-size:11px;color:#333333;padding: 18px;border-width: 1px;width :600border-color: #ccddee;border-collapse: collapse;background-color: #dedede;}";
			$message=$message."table.gridtable th {border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #dedede;}";
			$message=$message."table.gridtable td {border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #ddeeff;}";
			$message=$message."</style></head>";
		$message = $message."Correo automatico : ";
        $message = $message."Se ha asignado la matricula  <b> ".$codigoplaquita." </b> al activo : <br><br>";
		  $message =$message."<table  class='gridtable'  ><tr><td>  DESCRIPCION : </td><td>".$model->descripcion."</td></tr><br>";
		  $message =$message."<tr><td> MARCA :</td><td>".$model->marca."</td></tr><br>";
		  $message =$message."<tr><td>MODELO :</td><td>".$model->modelo."</td></tr><br>";
		  $message =$message."<tr><td>SERIE :</td><td>".$model->serie."</td></tr><br>";
		$modi=Embarcaciones::model()->findByPk(trim($model->codep));
			$meny=(is_null($modi->nomep))?"   ":$modi->nomep;
			$message =$message."<tr><td>REFERENCIA :</td><td>".$meny."</td></tr><br>";
			$message =$message."<tr><td>Foto :</td><td><img src='http://".Yii::app()->params['ipservidor'].Yii::app()->params['rutafotosinventario_'].trim($model->codigosap).".jpg'></td></tr><br>";
			$message =$message."<tr><td>Observacion :</td><td>".$model->comentario."</td></tr><br></table>";
			$message =$message." <br>Si no desea recibir este correo, notifique al remitente para eliminarlo de la lista";
		   // echo "sietieotoe".$modi->nomep;
		$message = wordwrap($message, 70);
	    //$message = str_replace("\n.", "\n..", $message);
	    return mail($this->direcciones,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	         
	
			}
	
	
	
	
	
	public function actionExporta()
{
    // Load data with a CActiveDataProvider (note that we can easily apply conditions over the result set)
   // ini_set('memory_limit','164M');
	$model = new Inventario('search');
   //$this->toExcel($model->search() , array('creator' => 'Zen',  ),'Excel5');
    // Export it (note the way we define columns, the same as in CGridView, thanks to EExcelView)
   $this->toExcel($model->search(), array('descripcion','marca'),array('creator'=>'Zen'),'Excel5');
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

	
	public function actionVaa($idinventario)
	{
		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
			$this->redirect('/motoristas/index.php?r=observaciones/create&idinventario='.$idinventario);
	}
	
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Inventario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Inventario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventario']))
			$model->attributes=$_GET['Inventario'];		
		
		    if ($this->isExportRequest()) { //<==== [[ADD THIS BLOCK BEFORE RENDER]]
            //set_time_limit(0); //Uncomment to export lage datasets
            //Add to the csv a single line of text
         //   $this->exportCSV(array('POSTS WITH FILTER:'), null, false);
            //Add to the csv a single model data with 3 empty rows after the data
          //  $this->exportCSV($model, array_keys($model->attributeLabels()), false, 3);
            //Add to the csv a lot of models from a CDataProvider
			
            $this->exportCSV($model->search(), array(
													'idinventario', 
													'codigo', 
													'descripcion', 
													'marca',
													'modelo',
													'serie',
													'codestado',
													'estado.estado',
													'codigosap',
													'codigoaf',
													/*'comentario',*/
													'fecha',
													'codlugar',
													'codigopadre',
													'numerodocumento',
													'rocoto',
													'codep',
													'codeporiginal',
													'codepanterior',
													'lugares.deslugar',
													'barcoactual.nomep',
													'barcoanterior.nomep',
													'barcooriginal.nomep',
													)
			
			);
        } else {
			$this->render('admin',array(
			'model'=>$model,
		));
			/*echo "no pasa nada ";
			Yii::app()->end();*/
		}
		
		
			 //$cadenita=Yii::app()->request->baseUrl.DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."fotos".DIRECTORY_SEPARATOR.$model->codigosap."jpg";
			
			// if (file_exists ($cadenita)) {
 							                      //$camarita="<img src='/exalmar/nocamarita.jpg' width=15 height=15  border=0>";
												  
											//} else {
											  // $camarita="";
											  
											//}
			
			
		   
		
	}

	
		/**
	 * Manages all models.
	 */
	public function actionProve()
	{
		$model=new Inventario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventario']))
			$model->attributes=$_GET['Inventario'];		
		
		    if ($this->isExportRequest()) { //<==== [[ADD THIS BLOCK BEFORE RENDER]]
            //set_time_limit(0); //Uncomment to export lage datasets
            //Add to the csv a single line of text
         //   $this->exportCSV(array('POSTS WITH FILTER:'), null, false);
            //Add to the csv a single model data with 3 empty rows after the data
          //  $this->exportCSV($model, array_keys($model->attributeLabels()), false, 3);
            //Add to the csv a lot of models from a CDataProvider
			
            $this->exportCSV($model->searchprove(), array(
													'idinventario', 
													'codigo', 
													'descripcion', 
													'marca',
													'modelo',
													'serie',
													'codestado',
													'estado.estado',
													'codigosap',
													'codigoaf',
													/*'comentario',*/
													'fecha',
													'codlugar',
													'codigopadre',
													'numerodocumento',
													'rocoto',
													'codep',
													'codeporiginal',
													'codepanterior',
													'lugares.deslugar',
													'barcoactual.nomep',
													'barcoanterior.nomep',
													'barcooriginal.nomep',
													)
			
			);
        } else {
			$this->render('adminprove',array(
			'model'=>$model,
		));
			/*echo "no pasa nada ";
			Yii::app()->end();*/
		}
		
		
	}
	
	
	
	
	public function codigobarco() {
				if (isset(Yii::app()->user->um)) { //si tiene cruge 
				  return Yii::app()->user->um->getFieldValue(Yi::app()->user->id,'codep'); 
					}
						 else { //si tienen el modeulo user 
							return Yii::app()->getModule('user')->user()->profile->codep;
						} 
	 }
	 
	 public function verificaidentidad($codigobarco) {
	    if ($this->codigobarco()==$codigobarco) {
			return true;
		}else{
			return false;
		}
	 
	 }
	
	
	
	
	/**
	 * Manages all models.
	 */
	public function actionMisactivos($codigobarco)
	{
	   if ($this->verificaidentidad($codigobarco)) {
		$model= new inventario;	
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventario']))
			$model->attributes=$_GET['Inventario'];
			 //$cadenita=Yii::app()->request->baseUrl.DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."fotos".DIRECTORY_SEPARATOR.$model->codigosap."jpg";
		//$model->codep=$epasignada;
		$this->render('admin_filtrado',array(
			'model'=>$model,'codep'=>$codigobarco,
			//'model'=>$model,
		));
		}else{
		throw new CHttpException(404,'Ha intentado ver los activos de otro barco');
		
		}
		
	}

	
	
	
	
	
	
	
	
	
	
	

	
	
	
	public function actionDetalle($id)
	{
	   $model=$this->loadModel($id);
		//$model=new Inventario('search');
		//$model->unsetAttributes();  // clear any default values
		if(isset($id)) {
		$fot=new Fotos($model->idinventario,Yii::getPathOfAlias('webroot.fotosinv').DIRECTORY_SEPARATOR.$model->codpropietario.DIRECTORY_SEPARATOR,null ) ;
		
		$misfotos=$fot->devuelveFotos();
		
		/***********************************************************************************
		*
		*	ESTE FRAGEMENTO DE CODIGO SIRVE PARA SACCAR LOS DATOS QUE NCESITA ESTA ACCION 
		*	PARA RENDERIZAR LA VISTA :    DATOS DEL LOG , DE LAS OBSERVACIONES ETC 
		*
		************************************************************************************
		************************************************************************************
		
	  SACANDO EL LOG */
	    $modelolog= new Loginventario;
		$criteriazo=new CDbCriteria;		
		$criteriazo->addCondition('hidinventario = :phidinventario and codestado <> :pcodestado');								
		$criteriazo->params = array(':phidinventario' => $model->idinventario,':pcodestado' => '01');	
		$criteriazo->order ='fecha DESC ';
		$proveedorlog = new CActiveDataProvider($modelolog, array('criteria'=>$criteriazo,));									
				
	
		$modeloobs= new VwObservaciones;
		$criteri=new CDbCriteria;		
		$criteri->addCondition('hidinventario = :phidinventario');								
		$criteri->params = array(':phidinventario' => $model->idinventario);		
		$proveedorobs = new CActiveDataProvider($modeloobs, array('criteria'=>$criteri,));	
		
		
		//$modeloobs= new VwObservaciones;
		//$criteri=new CDbCriteria;		
		//$criteri->addCondition('hidinventario = :phidinventario');								
		//$criteri->params = array(':phidinventario' => $model->idinventario);		
		//$proveedorobs = new CActiveDataProvider($modeloobs, array('criteria'=>$criteri,));	
		

		
		$this->render('view',array(
							'model'=>$model,
							'fotos'=>$misfotos,
							//'ruta'=>Yii::app()->params['rutafotosinventario_'],
							//'fot'=>$fot,
							 'modelolog'=>$modelolog,
							  'modeloobs'=>$modeloobs,
							  'proveedorlog'=>$proveedorlog,
							  'proveedorobs'=>$proveedorobs,
								));
		
		}
			
	}

	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Inventario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
	/**
	 * Borra el archivo de imagen en el disco
	 * 
	 * 
	 */
	public function actionborrafoto()
	{
		//$id=$_GET['cualfoto'];
		$id=MiFactoria::cleanInput($_GET['cualfoto']);
		//$ruta = Yii::app()->params['rutafotosinventario'];
		if (strpos($id,"_") > 0) {
			$identidad = substr ( $id , 0 , strpos ( $id , "_" ) );
		}else {
			$identidad=substr ( $id , 0 , strpos ( $id , "." ) );
		}
		  //echo "esta e e  ".$identidad;
		//Yii::app()->end();
			$modelonue=Inventario::model()->findByPk($identidad);
						//echo 	Fotos::devuelvenombresolo($id);		
					$logfotos=new Logfotosinventario();
					$logfotos->ip=CHttpRequest::getUserHostAddress();
					$logfotos->iduser=Yii::app()->user->id;
					$logfotos->fecha= date("Y-m-d H:i:s"); 
					 $logfotos->hidinventario=$modelonue->idinventario; 
					  $logfotos->operacion= "BORRA"; 					  
					   $logfotos->nombrefoto= $id; 
					   if(!$logfotos->save()) {
						   print_r($logfotos->getErrors());
					   Yii::app()->end();
					   }
					$modelonue->setScenario("subefoto");
					$modelonue->clasefoto='X';
					if(!$modelonue->save()) {
					  print_r($modelonue->getErrors());
					   Yii::app()->end();
					}
		ECHO CHtml::image(Yii::app()->params['imagenes'].'eliminado.png','',array('width'=>40,'height'=>50));
		unlink(trim(Yii::getPathOfAlias('webroot.fotosinv').DIRECTORY_SEPARATOR.$modelonue->codpropietario.DIRECTORY_SEPARATOR.$id));
		
	
		/*$nombrearchivo='IMG_0059.JPG';
		//$ruta='d:\web\motoristas\assets\FOTOS\G00001.JPG';
		//$ruta='d:/web/motoristas/assets/FOTOS/G00001.JPG';
		$rutadir=Yii::app()->params['rutafotosinventario'];
		$ruta=Yii::app()->params['rutafotosinventario'].$nombrearchivo;
		//$miarchivo=Yii::app()->CFile->getInstance(Yii::app()->params['rutafotosinventario'].trim($nombrearchivo));
		//$miarchivo=Yii::app()->CFile->getInstance("");\\192.168.26.100\web\motoristas\assets\FOTOS
	  
	//	$miarchivo->set(Yii::app()->params['rutafotosinventario'].trim($nombrearchivo));
		//$miarchivo->set($miarchivo->getRealPath(Yii::app()->params['rutafotosinventario'].trim($nombrearchivo)));
		//echo $miarchivo->getRealPath(Yii::app()->params['rutafotosinventario'].trim($nombrearchivo));
		
		//echo "El tamno es ".$miarchivo->size;
		if ( file_exists($ruta))
//\\192.168.26.100\web\motoristas\assets\FOTOS		
						{  echo "si existe  ". PHP_OS."  <br>";
						    echo " ". (!strncasecmp(PHP_OS, 'win', 3))." ";
						 $miarchivo=Yii::app()->CFile->getInstance($ruta);
						// $miarchivo->set($miarchivo->getRealPath($rutadir.$nombrearchivo));
						 //echo  $miarchivo->getRealPath($rutadir);
						  echo "El tamno es ".$miarchivo->size;
						}	else
								{
								echo "no existe";
								}
								
								//if($miarchivo->delete()) {echo Yii::app()->params['rutafotosinventario'].trim($nombrearchivo).$miarchivo->realPath."se borrro";}else{ echo Yii::app()->params['rutafotosinventario'].trim($nombrearchivo).$miarchivo->realPath."nos peudo borra";}
		
		
		*/
	}

	public function actiongestionafotos()
	{
		$this->layout = '//layouts/iframe';
		$fotos=$_GET['fotos'];
		/*print_r($fotos);
		Yii::app()->end();*/
		//verificando que ningun travieso meta la mato en el URL colocando referfncias a fotos que 
		//que no coresponde, (que nos epasen de vivos) ;
		 
			 $nuevo=array();
		foreach($fotos as $foto){
			  if(strpos($foto,"_")===false) {
				 $codigosap=$foto;
			 } else {
				  $codigosap=substr($foto,0,strpos($foto,"_"));
			 }
			 $arraymodelo=Inventario::model()->findAll("codigosap='".$codigosap."'");
			 if(count($arraymodelo)>0)
				 array_push($nuevo,$foto);
			
		}		
		 $modelo=Inventario::model()->find("codigosap='".$codigosap."'");
		$this->render("vw_galeria",array("fotos"=>$nuevo,"modelo"=>$modelo));
		//$myfile = Yii::app()->file->set(Yii::app()->params['rutafotosinventario'].$nombreimagen, true);
		//return $myfile->delete();
	}
	
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
