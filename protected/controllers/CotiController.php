<?php

class CotiController extends Controller
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
				'actions'=>array('borraitems','create','creadetalle','update','configuraop','nada','Modificadetalle'),
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

	
public function actionImprimir($id)
	{
	
	      $matri=VwGuia::Model()->findall("id='".$id."'");
	      //$listacampos=VwGuia::Model()->attributeNames();
	      if ($matri) {
	      $listacampos=array( 	
			'numcot'  =>array('left'=>35,'bottom'=>1000),
			'despro' =>array('left'=>35,'bottom'=>1000),
			'validez' =>array('left'=>35,'bottom'=>1000),
			'fechanominal' => array('left'=>35,'bottom'=>1000),
			'tipofacturacion' => array('left'=>35,'bottom'=>1000),
			'textocabeza'=> array('left'=>35,'bottom'=>1000),
			'textopie' => array('left'=>35,'bottom'=>1000),
			'c_nombre'=> array('left'=>35,'bottom'=>1000),
			'desmon' =>  array('left'=>35,'bottom'=>1000),
						);

	      					
	      							$cadena="<style>";
	    									 foreach ($listacampos  as $clave=>$valor){
	     												$cadena=$cadena.'  .'.$clave.' {position: absolute; overflow: visible; 													left: 100; 
															left: '.$listacampos[$clave]["left"].';
														 	bottom: '.$listacampos[$clave]["bottom"].'; 
																padding: 0em; font-family:sans; font-size:0.6em; margin: 0;
																		
															}';
											 	 				}

						
						//matriz para guardar las absisas de los items
								$absisas=array(
												'c_itguia'=>array('ancho'=>30,'absi'=>77),
												'n_cangui'=>array('ancho'=>30,'absi'=>115),
												'c_um'=>array('ancho'=>30,'absi'=>180),
												'c_codgui'=>array('ancho'=>50,'absi'=>200),
												'c_descri'=>array('ancho'=>270,'absi'=>250),
												'c_codactivo'=>array('ancho'=>120,'absi'=>550),
									);

								//el valor de las coordemadas donde empieza a pintar la tabla
								//$x_inicio=69;
								$y_inicio=600;
								//el valor del alto de la fila
								$altofila=15;

						//generando los estilos  de el detalle
								//$cadena2="";
								$subrayado=" ";
								
						for ($i=0; $i < count($matri); $i++) { //recorriendo la cantidad de filas que hay
									       foreach($absisas as $clave=>$valor)  {
									       		if($i==count($matri)-1)
									       			$subrayado=" border-bottom: 1px solid #000; ";

									       		$cadena=$cadena.'     .'.$clave.$i.'{position: absolute;  '.$subrayado.' overflow: visible; width:'.$absisas[$clave]["ancho"].'; left: '.$absisas[$clave]["absi"].';bottom: '.($y_inicio-($i+1)*$altofila).'; padding: 0em; font-family:sans; font-size:0.7em; margin: 0;} ';

									      /* $cadena2=$cadena2.'     .'.$clave.$i.'{position: absolute; overflow: visible; 
									       		left: '.$absisas[$clave].';
									       		bottom: '.$y_inicio+($i+1)*$altofila.'; }';*/


									        	}
								}



						$cadena = $cadena.'</style><body>';
 					

							//generando los divs  del encabezado
 							foreach ($listacampos  as $clave=>$valor){
	     											$cadena=$cadena.'<div class="'.$clave.'" >'.$matri[0][$clave].'</div>';
								}


								//generando los divs  de el detalle
								for ($i=0; $i < count($matri); $i++) { //recorriendo la cantidad de filas que hay
									     
									      foreach($absisas as $clave=>$valor) {
									       $cadena=$cadena.'<div class="'.$clave.$i.'">'.$matri[$i][$clave].'</div>';

									                                            }
									        	
								}



								$cadena=$cadena.'<div class="nino">'.count($matri).'</div>';

								


								//echo $cadena;




				$mpdf=Yii::app()->ePdf->mpdf();
				$mpdf->SetDisplayMode('fullpage');				
				$mpdf->WriteHTML($cadena);
				$mpdf->Output();
				exit;
			} else {

				throw new CHttpException(404,'El enlace o direccion solicitado no existe');
			}

	}




public function actionBorraitems()
	{

		$errores=array();

	
		$autoIdAll = $_POST['cajita'];
		$estado=$_POST['Coti']['codestado'];
		 if(count($autoIdAll)>0 and ($this->eseditable($estado)==''))
			 {
				 foreach($autoIdAll as $autoId)
					{
               		

							$modelin=Dcotmateriales::model()->findBYpK($autoId);

							
							if ($modelin===NULL){
								 $mensaje="No se encontro algunos items para borralos";
								throw new CHttpException(404,'No se encontro el item para borrarlo ');

								}else {


								//en caso de no estar anulado proceder

											//si ya se anulo
										  if ($modelin->estadodetalle=='07') {
										  	$mensaje="El item ".$modelin->item."  :  ".$modelin->descri." Ya esta anulado";

										  }else {
											//verificando si tienen hijos
										   $arraycito=null;
											$arraycito=Dcotmateriales::model()->findall("idpadre=:papa",array(":papa"=>$autoId));
												if ($arraycito===NULL or empty($arraycito)) {	

														$command = Yii::app()->db->createCommand("update dcotmateriales set estadodetalle='07'  where id =".$autoId." "); 
														 $command->execute();
														 $mensaje="Se anulo el item ".$modelin->item."  :  ".$modelin->descri." ";
															

														} else {
															 $mensaje="El item ".$modelin->item."  :  ".$modelin->descri." Tiene Items hijos y no se puede borrar";
															//throw new CHttpException(404,'El item {$modelin->descri} tiene hijos y no se puede borrar ');
														}


				 						}//fin de si ya estaba anulado
				 					}
				 				array_push($errores,$mensaje);

					 }
		     
			
	    
			}
			echo  $mensaje;
			Yii::app()->end();
	}





	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Coti;
        $model->valorespordefecto();
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Coti']))
		{
			$model->attributes=$_POST['Coti'];
			if($model->save())
				$this->redirect(array('update','id'=>$model->idguia));
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

		if(isset($_POST['Coti']))
		{
			$model->attributes=$_POST['Coti'];
			if($model->save()){
					//$this->redirect(array('view','id'=>$model->idguia));
					if ( $_POST['Coti']['codestado'] == '01') { //si es el primer update
			   					//asegurar de que ya paso y actualizar el status de los items
			   					$command = Yii::app()->db->createCommand(" update dcotmateriales set estadodetalle='01' where hidguia='".$model->idguia."' "); 											
								$command->execute();		


			   					//$this->redirect(array('update','id'=>$model->id));
			   				}
			   				$this->redirect(array('view','id'=>$model->idguia));

			}



				
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}



	public function actionModificadetalle($id)
	{
		$model=Dcotmateriales::Model()->findByPk($id);
		 if ($model===null)
		 	  throw new CHttpException(404,'No se encontro ningun documento para estos datos');
	  	

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation1($model);

		if(isset($_POST['Dcotmateriales']))
		{
			$model->attributes=$_POST['Dcotmateriales'];	
			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		window.parent.$.fn.yiiGridView.update('resumen-grid');
																		");
														Yii::app()->end();
												}
				
				//$this->redirect(array('view','id'=>$model->n_guia));
		}
		
		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		
		$this->render('_form_detalle',array(
			'model'=>$model, 
		));
		
		
		
	}


     public function actionNada() {
     	echo "nada";
     	return 1;
     }






/****************************************************
	 *  muestra la vista de configuracion de los eventos
	 *+++++++++++++++++++++++++++++++++++++++++++++++++*/	
	
	public function actionConfiguraop()
	{
			$docu='011';  //guia de remision
			$docuhijo='024'; //detalle guia de remisio
				
				$command = Yii::app()->db->createCommand("select fn_opciones_documento(".Yii::app()->user->id." ,'".$docu."') "); 
				 $command->execute();
				$command = Yii::app()->db->createCommand("select fn_opciones_documento(".Yii::app()->user->id." ,'".$docuhijo."') "); 
				 $command->execute();
				 
				 $proveedor=VwOpcionesdocumentos::model()->search_us($docu,Yii::app()->user->id);
				  $proveedor1=VwOpcionesdocumentos::model()->search_us($docuhijo,Yii::app()->user->id);
				 $this->render('vw_admin_opciones',array(
							'proveedor'=>$proveedor,
							'proveedor1'=>$proveedor1, 
							));
	    
			
	}








	/****************************************************
	 *	Retorna una cadena '' o 'disabled' para deshabilitar los controles del form de la vista
	 ****************************************************/
	public function eseditable($estadodelmodelo)
	{
		if ($estadodelmodelo=='01' or $estadodelmodelo=='99' or empty($estadodelmodelo) or is_null($estadodelmodelo)) {return '';} else{return 'disabled';}
	}
	



	/****************************************************
	 *	crea un item de la grilla
	 ****************************************************/
	public function actionCreadetalle($idcabeza,$cest)
	{
		//VERIFICADO PRIMERO SI ES POSIBLE AGREGAR MAS ITEMS
		
		if($cest=='01' OR $cest=='99') {
		
		$model=new Dcotmateriales;
		$model->valorespordefecto();
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation1($model);

		if(isset($_POST['Dcotmateriales']))
		{
			$model->attributes=$_POST['Dcotmateriales'];
			//$model->codocu='024'; ///detalle COTIZACION
			
			//crietria para filtrar la cantidad de items del detalle
			$criterio=new CDbCriteria;			
			 $criterio->condition="hidguia=:nguia  ";
			$criterio->params=array(':nguia'=>$idcabeza);
			$model->item=str_pad(Dcotmateriales::model()->count($criterio)+1,3,"0",STR_PAD_LEFT);
			//str_pad($somevariable,$anchocampo,"0",STR_PAD_LEFT);
			////con esto calculamos el numero de items
			
			
			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		window.parent.$.fn.yiiGridView.update('resumen-grid');
																		");
														Yii::app()->end();
												}
				
				//$this->redirect(array('view','id'=>$model->n_guia));
		}
		
		 if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle',array(
			'model'=>$model, 'idcabeza'=>$idcabeza
		));
		
		} else{ //si ya cambio el estado impisble agregar mas items
			
		   if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('vw_imposible',array(
			
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
		$dataProvider=new CActiveDataProvider('Coti');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VwCotizacion('search_');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwCotizacion'])) {
			//throw new CHttpException(404,'The requested page does not exist.');
			$model->attributes=$_GET['VwCotizacion'];
			//echo "hola amigos".gettype($_GET['VwCotizacion']);
			//print_r($model);
			//Yii::app()->end();
		 // echo "hdsjdhsdshd". ->codpro;
			//echo "hola";

		} else {


		}
		$proveedor=$model->search_();
		$this->render('admin',array(
			'model'=>$model,'proveedor'=>$proveedor
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Coti the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Coti::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Coti $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='coti-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}



	 /** Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation1($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='detgui-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
