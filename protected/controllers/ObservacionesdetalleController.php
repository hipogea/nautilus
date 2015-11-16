<?php

class ObservacionesdetalleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $direcciones='//layouts/column2';

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
		 Yii::app()->user->loginUrl = array("/cruge/ui/login");
	
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('*'),
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
	public function actionCreate($idobservacion)
	{
		$model=new Observacionesdetalle;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Observacionesdetalle']))
		{
			$model->attributes=$_POST['Observacionesdetalle'];
			$model->hidobservaciones=$idobservacion;
			$model->usuario=Yii::app()->user->name;
			$model->fecha=date("d-m-Y H:i:s");
			if($model->save())
			 $modeloinventario=Observaciones::model()->findByPk($idobservacion);
				if(!$this->enviamail($modeloinventario,$model->comentario)) {
					echo "fallo";
					yii::app()->end();
				}

				//$this->Enviarespuesta();
			   {
			   $model->refresh();
				
								if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog1').dialog('close');
													                    window.parent.$('#cru-frame1').attr('src','');
																		window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');
																		");
														Yii::app()->end();
												}
				
				
				$this->render('Confirma',array('id'=>$model->id));
				Yii::app()->end();
				}
				
				
				//$this->redirect(array('view','id'=>$model->id));
		}
		$this->layout = '//layouts/iframe';
		$this->render('create',array(
			'model'=>$model,'idobservacion'=>$idobservacion,
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
				if (trim($model->usuario)==trim(Yii::app()->getModule('user')->user()->username))		
					{
						if(isset($_POST['Observacionesdetalle']))
								{
									$model->attributes=$_POST['Observacionesdetalle'];
									if($model->save())
											$this->redirect(array('view','id'=>$model->id));
								}
									$this->render('update',array(
												'model'=>$model,
												));
		
					} else {
							echo "No puede modificar el comentario de otro usuario";
							Yii::app()->end();		   
					}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
			$model=$this->loadModel($id);
				if (trim($model->usuario)==trim(Yii::app()->getModule('user')->user()->username))		
					{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
			} else {
							echo "No puede borrar el comentario de otro usuario";
							Yii::app()->end();		   
					}
			
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Observacionesdetalle');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($idobservacion)
	{
		//$model=new Observacionesdetalle('search');
		
		$modeloobs= new Observacionesdetalle;
		$criteri=new CDbCriteria;		
		$criteri->addCondition('hidobservaciones = :phidinventario');								
		$criteri->params = array(':phidinventario' => $idobservacion);		
		$proveedorobs = new CActiveDataProvider($modeloobs, array('criteria'=>$criteri,));	
		
		
		
		
		$modeloobs->unsetAttributes();  // clear any default values
		if(isset($_GET['Observacionesdetalle']))
			$model->attributes=$_GET['Observacionesdetalle'];
		$this->layout = '//layouts/iframe';
		$this->render('admin',array(
			'model'=>$modeloobs,'proveedorobs'=>$proveedorobs,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Observacionesdetalle::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}

	
	public function Enviarespuesta()
	
			{
			  $usuarioSeleccionado=Yii::app()->user->um->loadUser('jramirez@exalmar.com.pe',true);
			  Yii::app()->crugemailer->notificarStockMercancia($usuarioSeleccionado,"Mi asunto");
			
			}

	
	public function enviamail($model,$comentario=null)
	
			{
			$subject="RESPUESTA A LA OBSERVACION-".$model->inventario->codigoaf."-".$model->inventario->descripcion;
			//$modeloparte=Inventarioartes::model()->find('id=:hidparte',array(':hidparte'=>$id));
			//echo "el tipo es ".gettype($id). "--".$id;
			//$subject="Novedad   ".$modeloparte->embarcaciones->nomep."   ".
			
			$usuariox = Yii::app()->user->um->loadUser(trim($model->usuario),true);
			//(!is_null($usuariox)?$this->direcciones=$usuariox->email:'jramirez@exalmar.com.pe';
			$this->direcciones=$usuariox->email;
				//echo $usuariox->username;
		  // $this->direcciones='jramirez@exalmar.com.pe';
		  // Contactos::model()->find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro))
    	//$this->direcciones='jramirez@exalmar.com.pe';
		 
		$adminEmail =Yii::app()->user->getField('nombres')." ".Yii::app()->user->getField('apaterno')." ".Yii::app()->user->getField('amaterno')." <".Yii::app()->user->email.">" ;
	     $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    
			$message="<head>";
			$message=$message."<style type='text/css'> ";
			$message=$message."table.gridtable {font-family: verdana,arial,sans-serif;font-size:11px;color:#333333;padding: 18px;border-width: 1px;width :600border-color: #ccddee;border-collapse: collapse;background-color: #dedede;}";
			$message=$message."table.gridtable th {border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #dedede;}";
			$message=$message."table.gridtable td {border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #ddeeff;}";
			$message=$message."</style></head>";
		$message = $message."Correo automatico : ";
        $message = $message."Haz recibido respuesta a tu observacion  respecto al Activo <b> ".$model->inventario->codigoaf." <br><br>";
		$url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl('inventario/detalle',array('id'=>$model->inventario->idinventario));
							
		  $message =$message."<table  class='gridtable'  >
					<tr><td>  COMENTARIO : </td>
					<td><a  href='$url' > Ver respuesta </a></td>
					<td><span style='fon-style: italic; font-size:14px; font-weight:bold;'>\"$comentario\"</span></td>
					</tr><br>";		  
		   $message =$message."</table>";
		 
		   // echo "sietieotoe".$modi->nomep;
		$message = wordwrap($message, 70);
	    //$message = str_replace("\n.", "\n..", $message);
	    return mail($this->direcciones,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	         
	
			}
	
	
	
	
	
	
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='observacionesdetalle-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
