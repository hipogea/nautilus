<?php

class DocumentosController extends Controller
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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin','view','prefdoc','configuraop','creadetalle','update'),
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
		$model=new Documentos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Documentos']))
		{
			$model->attributes=$_POST['Documentos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->coddocu));
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

		if(isset($_POST['Documentos']))
		{
			$model->attributes=$_POST['Documentos'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->coddocu));
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
		$dataProvider=new CActiveDataProvider('Documentos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Documentos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documentos']))
			$model->attributes=$_GET['Documentos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionprefdoc()
	{
		$model=new Documentos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documentos']))
			$model->attributes=$_GET['Documentos'];

		$this->render('admin_conf',array(
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
		$model=Documentos::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='documentos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	  public function actionCreadetalle($id)
    {
           $id=(int)MiFactoria::cleanInput($id);
 $modelopadre=$this->loadModel($id);
       // $descuento=(is_null($modelopadre->descuento))?1:(1-$modelopadre->descuento/100);
            $model=new Opcionescamposdocu();
        //$model->estadodetalle=ESTADO_PREVIO;
       // $model->idusertemp=Yii::app()->user->id;
           // $model->valorespordefecto($this->documentohijo);

            if(isset($_POST['Opcionescamposdocu']))		{

                $model->attributes=$_POST['Opcionescamposdocu'];
                $model->codocu=$modelopadre->coddocu; ///detalle guia
                
                if($model->save()){
                    if (!empty($_GET['asDialog']))
                    {
                        //Close the dialog, reset the iframe and update the grid
                        echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');
													                    window.parent.$('#cru-frame3').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');

																		");

                    }
                } else {
                    print_r($model->geterrors());
                }
                Yii::app()->end();
            }
            // if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
            $this->render('//opcionescamposdocu/_form',array(
                'model'=>$model
            ));

    }
	
	
	
	
	
	public function actionConfiguraop($codocupadre){
		$docu=MiFactoria::CleanInput($codocupadre);
		 $registrox=$this->loadModel($docu);
		 $documentopadre=$registrox->desdocu;
		$matrizpadre=Opcionescamposdocu::Model()->findAll(" codocu=:cod",array(":cod"=>$docu));
		foreach($matrizpadre as $fila){
			$cantidadregistros=Yii::app()->db->createCommand()->select("id")
				->from( "{{opcionesdocumentos}}" )
				->where("idopdoc=:vidop",array(":vidop"=>$fila->id))
				->queryScalar();
			If (!$cantidadregistros) {
				$modex=new Opcionesdocumentos();
				$modex->setAttributes(array("idusuario"=>Yii::app()->user->id,"idopdoc"=>$fila->id),false);
		        $modex->save();
			}
		}
		
		
		
		$proveedor=VwOpcionesdocumentos::model()->search_us($docu,Yii::app()->user->id);
   //buacnado el codochijo
   $registro=Documentos::model()->findAll("coddocupadre=:vpadre",array(":vpadre"=>$docu));
  
     if (!is_null($registro)){
		$codocuhijo=$registro[0]->coddocu;
		$documentohijo=$registro[0]->desdocu;
	 } else {
		$codocuhijo=null; 
	 }

    if (!is_null($codocuhijo))
	{
		$codocuhijo=MiFactoria::CleanInput($codocuhijo);
		$matrizpadre1=Opcionescamposdocu::Model()->findAll(" codocu=:cod",array(":cod"=>$codocuhijo));	
		foreach($matrizpadre1 as $fila){
			$cantidadregistros=Yii::app()->db->createCommand()->select("id")
				->from( "{{opcionesdocumentos}}" )
				->where("idopdoc=:vidop",array(":vidop"=>$fila->id))
				->queryScalar();
			If (!$cantidadregistros) {
				$modex=new Opcionesdocumentos();
				$modex->setAttributes(array("idusuario"=>Yii::app()->user->id,"idopdoc"=>$fila->id),false);
		        $modex->save();
			}
		}
		
		$proveedor1=VwOpcionesdocumentos::model()->search_us($codocuhijo,Yii::app()->user->id);
		$this->render('vw_admin_opciones',array(
			'proveedor'=>$proveedor,
			'proveedor1'=>$proveedor1,
			'documentopadre'=>$documentopadre,
			'documentohijo'=>$documentohijo,
		));
	} else {
		$this->render('vw_admin_opciones',array(
			'proveedor'=>$proveedor,
			'documentopadre'=>$documentopadre,
			'proveedor1'=>null,
		));
		
	}



	}
	
	
	
	
	
	
}