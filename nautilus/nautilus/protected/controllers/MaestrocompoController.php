<?php

class MaestrocompoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function actualizar(){
		$model=new Maestrocompo;
		$model_centro=new Maestrodetallecentros();
		$model_centro_almacen=new Maestrodetalle();

// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation(array($model,$model_centro,$model_centro_almacen));

		if(isset($_POST['Maestrocompo'], $_POST['Maestrodetalle'], $_POST['Maestrodetallecentros']))
{
			$model->attributes=$_POST['Maestrocompo'];
			$model_centro_almacen->attributes=$_POST['Maestrodetalle'];
			$model_centro->attributes=$_POST['Maestrodetallecentros'];

	}
	}





    public function filters()
    {
        return array('accessControl',array('CrugeAccessControlFilter'));
    }

	public function behaviors() {
		return array(
			'exportableGrid' => array(
				'class' => 'application.components.ExportableGridBehavior',
				'filename' => 'materiales.csv',
				'csvDelimiter' => ',', //i.e. Excel friendly csv delimiter
			));
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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','import','borraimagen','configuraop','update','prueba','pinta', 'cargaalmacen','modificaconversion','creaconversion'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actions() {

           }

	public function actionConfiguraop()
	{
		$docu='901';  //guia de remision

		$matrizpadre=Opcionescamposdocu::Model()->findAll(" codocu=:cod",array(":cod"=>$docu));
		for ($i=0; $i < count($matrizpadre); $i++){
			$cantidadregistros=Yii::app()->db->createCommand("SELECT id FROM  ".Yii::app()->params['prefijo']."opcionesdocumentos WHERE IDOPDOC=".$matrizpadre[$i]['id']."")->QueryScalar();
			If (!$cantidadregistros) {
				$command = Yii::app()->db->createCommand("INSERT INTO ".Yii::app()->params['prefijo']."opcionesdocumentos (IDUSUARIO,IDOPDOC,valor) VALUES (".Yii::app()->user->id.",".$matrizpadre[$i]['id'].",'') ");
				$command->execute();
			}
		}
		$proveedor=VwOpcionesdocumentos::model()->search_us($docu,Yii::app()->user->id);
		$proveedor1=VwOpcionesdocumentos::model()->search_us('XXXX',Yii::app()->user->id);
		$this->render('vw_admin_opciones',array(
			'proveedor'=>$proveedor,
			'proveedor1'=>$proveedor1,
		));
	}



	public function actionImport(){
		$model=new Maestrocompo();
		$model->setScenario("cargamasiva");
		if(isset($_POST['Maestrocompo']))
		{
			echo " Si salio el POST                             OK ->   ";
			$model->attributes=$_POST['Maestrocompo'];
			$filelist=CUploadedFile::getInstancesByName('csvfile');
			// if($filelist)
			// $model->csvfile=1;
			//if($model->validate())
			// {
			// echo " Se valido  ....";
			foreach($filelist as $file)
			{
				try{
					$transaction = Yii::app()->db->beginTransaction();
					$handle = fopen("$file->tempName", "r");
					echo "el handle  es ....".gettype($handle);
					$row = 2;
					ini_set('max_execution_time', '120');
					while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
						if($row>1){
							$newmodel=new Maestrocompo;
							$newmodel->codigo=$data[0];
							$newmodel->um=$data[1];
							$newmodel->codtipo=$data[2];
							$newmodel->descripcion=$data[3];
							$newmodel->marca=$data[4];
							$newmodel->marca=$data[5];
							$newmodel->marca=$data[6];


							//$newmodel->setScenario("cargamasiva");
							/*$newmodel->cantlibre=$data[1];
							echo " el id  a cargar es :  ".$data[0]."   \n";*/
							if($newmodel->save()) {
								//echo " grabo  carajo --------------------> :  ".$data[1]."   \n";
								echo "ok  ".$newmodel->codigo."\n";
							} else {
								//echo " NO grabo  xxxxxxxxxxx-> :  ".$data[1]."   \n";
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
		} else  {
			echo "NO se ha enviado ningun form";
		}
		$this->render('cargamaestro',array(
			'model'=>$model,
		));
	}



	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model=$this->loadModel($id);
       $this->performAjaxValidation($model);
        if(isset($_POST['Maestrocompo']))
        {
            // if (isset($_POST['Maestrodetalle']['catreorden']))
              //  echo "reorden".$_POST['Maestrodetalle']['catreorden'];
            if($_POST['Maestrocompo']['escompletar']=='si') { ///si se esta completadno los campos cenro y almacen
                $modelodetalle=Maestrodetalle::model()->findByPk(array('codart'=>$model->codigo,'codcentro'=>$_POST['Maestrocompo']['codcent'],'codal'=>$_POST['Maestrocompo']['alam']));
                     if (gettype($modelodetalle)=='object') {
                             $this->render('update_varios',array(
                                        'model'=>$model,
                                         'habilitado'=>'disabled',
                                         'modelodetalle'=>$modelodetalle,
                                                    ));
                                                 Yii::app()->end();
                                            }else {
                                throw new CHttpException(404,'No se pudo encontrar el detalle del centro almacen');

                                                     }

                         }else { //ene l caos de ser ya una catualizacion

                $model->attributes=$_POST['Maestrocompo'];
                $modelodetalle=Maestrodetalle::model()->findByPk(array('codart'=>$model->codigo,'codcentro'=>$_POST['Maestrocompo']['codcent'],'codal'=>$_POST['Maestrocompo']['alam']));

                $modelodetalle->attributes=$_POST['Maestrodetalle'];



                    $this->render('update',array(
                        'model'=>$model,
                        'habilitado'=>'disabled',
                    ));
                    Yii::app()->end();


            }

        }

        $this->render('update',array(
            'model'=>$model,
            'habilitado'=>'disabled',
        ));

	}

public function actionPinta() {

	$ruta='materiales'.DIRECTORY_SEPARATOR;
				// Archivo y nuevo tamaño
$nombre_archivo = $ruta.'14000008.jpg';
$rutaImagenOriginal=$nombre_archivo;

					//Creamos una variable imagen a partir de la imagen original
									$img_original = imagecreatefromjpeg($rutaImagenOriginal);

									//Se define el maximo ancho y alto que tendra la imagen final
										$max_ancho = 200;
										$max_alto = 200;

											//Ancho y alto de la imagen original
											list($ancho,$alto)=getimagesize($rutaImagenOriginal);

												//Se calcula ancho y alto de la imagen final
													$x_ratio = $max_ancho / $ancho;
													$y_ratio = $max_alto / $alto;
													//Si el ancho y el alto de la imagen no superan los maximos,
															//ancho final y alto final son los que tiene actualmente
															if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho
																	$ancho_final = $ancho;
																	$alto_final = $alto;
																		}
																			/*
																			* si proporcion horizontal*alto mayor que el alto maximo,
																			* alto final es alto por la proporcion horizontal
																			* es decir, le quitamos al ancho, la misma proporcion que
																			* le quitamos al alto
																			*
																			*/
																		elseif (($x_ratio * $alto) < $max_alto){
																				$alto_final = ceil($x_ratio * $alto);
																				$ancho_final = $max_ancho;
																						}
																								/*
																								* Igual que antes pero a la inversa
																								*/
																					else{
																							$ancho_final = ceil($y_ratio * $ancho);
																							$alto_final = $max_alto;
																						}  
																						//Creamos una imagen en blanco de tamaño $ancho_final  por $alto_final .
																		$tmp=imagecreatetruecolor($ancho_final,$alto_final);

																		//Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($tmp)
																		imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);

																			//Se destruye variable $img_original para liberar memoria
																		imagedestroy($img_original);
																		//Definimos la calidad de la imagen final
																		$calidad=95;
																		echo gettype($tmp);
																		//Se crea la imagen final en el directorio indicado
																		imagejpeg($tmp,$ruta.'etetet.jpg',$calidad);
$im = imagecreatetruecolor(120, 20);
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);

// Save the image as 'simpletext.jpg'
imagejpeg($im, $ruta.'/etetet.jpg');

// Free up memory
imagedestroy($im);

}


public function actionCargaalmacen() {
//echo "holitas".$_GET['identi'];
		
		//$valor=trim($_GET['identi']);
		$data=CHtml::listData(Almacenes::model()->findAll(),'codcen','codalm'); 
			//$data=Almacenes::model()->findAll();
		  //	echo "pap";
			echo count($data);

		echo CHtml::dropDownList('clientId', '', $data, array(
    'empty' => 'Select a client',
   // 'class' => 'form-control'
								)); 
		  	
			/*//echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja una direccion'),true);
			foreach($data as $value=>$name) { 
			    echo CHtml::tag('option', array('value'=>$value),CHtml::encode(trim($name)),true);
			   } */
		


}






public function actionprueba() {
  $modelo= new Maestrocompo;
  $modelo->codtipo='12';
  echo Numeromaximo::numero($modelo,'correl','maximovalor',6,'codtipo');


}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Maestrocompo;
		$model->valorespordefecto();
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Maestrocompo']))
		{
			$model->attributes=$_POST['Maestrocompo'];
			$transaccion=$model->dbConnection->beginTransaction();
			if($model->save()) {
					//actualizamos tambien las tablas inventario y maestrodetalle
				//inventario

				$centros=Centros::model()->findAll();
					foreach ($centros  as $fila){
						            $modeloporcentros=new Maestrodetallecentros();
									$modeloporcentros->setAttributes(array('hcodart'=>$model->codigo,
														'codcen'=>$fila->codcen,
														'catvalor'=>'',
														'iqf'=>'0'
																	),true);
						   // var_dump($fila);
						            $modeloalmacenes=Almacenes::model()->findall("codcen=:vcdocen",array(":vcdocen"=>$fila->codcen));


				         	                      foreach ($modeloalmacenes  as $filaalmacen){
				         	                    	//$contact->setIsNewRecord(true);
				         	                    	$modeloinventario=new Alinventario;
													$modelodetalle=new Maestrodetalle;
				         								$modelodetalle->setAttributes(array('codart'=>$model->codigo,
				         																	'codcentro'=>$fila->codcen,
				         																	'codal'=>$filaalmacen->codalm,
				         																	'codgrupoventas'=>'001',
				         																	'canaldist'=>'01',
																							'sujetolote'=>'0',
				         																	'canteconomica'=>0,
				         																	'cantreposic'=>0,
				         																	'cantreorden'=>0,
				         																	'leadtime'=>0,
															                                'controlprecio'=>'V',
				         																	),true);
				         								$modeloinventario->setAttributes(array('codart'=>$model->codigo,
				         																	'codcen'=>$fila->codcen,
																							'codalm'=>$filaalmacen->codalm,
				         																	//'um'=>$model->um,
				         																	'cantlibre'=>0,
				         																	'canttran'=>0,
				         																	'cantres'=>0,
				         																	'ubicacion'=>'',
				         																	'lote'=>'',
				         																	'codmon'=>Yii::app()->params['monedadef'],
				         																	),true);

				         										//   var_dump($modeloinventario);
													/*  echo "<br><br><br>";
													  var_dump($modelodetalle->attributes);
													  echo "<br><br><br>";*/
													//  var_dump($modeloinventario->attributes);
				         												if ( !$modeloinventario->save() or !$modelodetalle->save() ) {
				         												 $transaccion->rollback();
				         												throw new CHttpException(404,'No se pudieron grabar los datos detalles ');
				         												   } else {

				         												   }	


											 	 				} //bucle de almacenes
						if ( !$modeloporcentros->save()  ) {
							$transaccion->rollback();
							throw new CHttpException(404,'No se pudieron grabar los datos del modelo poR CENTROS ');
						}

					} ///FIN DEL BUCLE CENTROS
											 	 $transaccion->commit();
				Yii::app()->user->setFlash('success', "Se ha creado el material  ".$model->codigo);

			}
							else {  /// SSI HUBO UN ERRRO AL GRANAR EL MATERIAL 

				 				 $transaccion->rollback();
				 				throw new CHttpException(404,'No se pudieron grabar los datos del material ');	

				 			}

						

				$this->redirect(array('update','id'=>$model->codigo));
				} /// si no se puede grabar 
				 

		   

		$this->render('create',array(
			'model'=>$model,
            'habilitado'=>'',
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
		$mensa="";
		$model->valorespordefecto();
		//$this->performAjaxValidation($model);
		if(isset($_POST['Maestrocompo']))
		{
			if($_POST['Maestrocompo']['escompletar']=='si') { ///si se esta ENTRANDO PARA VER LAS PESTAÑAS
			/*ECHO "SALIO A PRIMERA OPCIN";
				Yii::app()->end();*/
						  $modelodetalle=Maestrodetalle::model()->findByPk(array('codart'=>$model->codigo,'codcentro'=>$_POST['Maestrocompo']['codcent'],'codal'=>$_POST['Maestrocompo']['alam']));
				          $modelodetallecentro=Maestrodetallecentros::model()->find("hcodart=:vhcodart AND  codcen=:codcen " , array(':vhcodart'=>$model->codigo,':codcen'=>$_POST['Maestrocompo']['codcent']));

									  if (is_null($modelodetalle))
										  $mensa.="No se encontro el registro del detalle del Centro-Almacen de este material, Es posible que tenga que correr un proceso masivo de actualización <br>";
									if (is_null($modelodetallecentro))
										$mensa.="No se encontro el registro del detalle del Centro de este material, Es posible que tenga que correr un proceso masivo de actualización .".$_POST['Maestrocompo']['codcent']."   ".$model->codigo."<br>";
 									/*var_dump($modelodetalle);
									var_dump($modelodetallecentro);*/

						if (strlen($mensa)==0) {

							$this->render('update_varios',array('model'=>$model,'modelodetalle'=>$modelodetalle,'modelodetallecentro'=>	$modelodetallecentro,
                                             'habilitado'=>'',
													));
							yii::app()->end();
												} else {

													//$transaccion=rollback();
													Yii::app()->user->setFlash('error', $mensa);
													$this->render('update',array(
														'model'=>$model,
												'habilitado'=>'',
												));
							                   yii::app()->end();
						               }
							
						}else { //SIU YA MANDO LOS DATOS DE LOS FOMRUALRIOS
			//	ECHO "SALIO LA SEGUNDA PCIN";
				//Yii::app()->end();
							$modelodetalle=Maestrodetalle::model()->findByPk(array('codart'=>$model->codigo,'codcentro'=>$_POST['Maestrocompo']['codcent'],'codal'=>$_POST['Maestrocompo']['alam']));
							$modelodetallecentro=Maestrodetallecentros::model()->find("hcodart=:vhcodart AND  codcen=:codcen " , array(':vhcodart'=>$model->codigo,':codcen'=>$_POST['Maestrocompo']['codcent']));
											if (is_null($modelodetalle))
														$mensa.="No se encontro el registro del detalle del Centro-Almacen de este material, Es posible que tenga que correr un proceso masivo de actualización <br>";
											if (is_null($modelodetallecentro))
												$mensa.="No se encontro el registro del detalle del Centro de este material, Es posible que tenga que correr un proceso masivo de actualización <br>";


											if (strlen($mensa)==0) {
														$model->attributes=$_POST['Maestrocompo'];
														//$modelodetalle=Maestrodetalle::model()->findByPk(array('codart'=>$model->codigo,'codcentro'=>$_POST['Maestrocompo']['codcent'],'codal'=>$_POST['Maestrocompo']['alam']));
															$modelodetalle->attributes=$_POST['Maestrodetalle'];
																	//$this->performAjaxValidation($model);
				                								 $modelodetallecentro->attributes=$_POST['Maestrodetallecentros'];
												               $modelodetallecentro->codcen=$_POST['Maestrocompo']['codcent'];
												$transaccion=$model->dbConnection->beginTransaction();
												$this->performAjaxValidation(array($model,$modelodetalle,$modelodetallecentro));
													if(!$model->save())
													$mensa.="No se pudo grabar el registro maestro del material <br>";

												if(!$modelodetalle->save())
													$mensa.="No se pudo grabar el registro Centro - Almacen - Material <br>";
												if(!$modelodetallecentro->save())
													$mensa.="No se pudo grabar el registro Centro  - Material <br>";

												if(strlen($mensa)==0) {
													$transaccion->commit();
													Yii::app()->user->setFlash('success', "Se Realizaron los cambios!   ".$mensa);
														$this->render('update',array(
															'model'=>$model,
															'habilitado'=>'',
														));

														Yii::app()->end();
													   } else {
													Yii::app()->user->setFlash('error', "Hubo error   ".$mensa);


													Yii::app()->end();

												}

											}


						}
			if(strlen($mensa) > 0) {
			   //	$transaccion=rollback();
				Yii::app()->user->setFlash('error', $mensa);
				$this->render('update',array(
					'model'=>$model,
					'habilitado'=>'',
				));
			}
						
		} ELSE {

		$this->render('update',array(
			'model'=>$model,
            'habilitado'=>'',
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


  public function actionborraimagen() {
	  if (isset($_POST['codiguito'])) {
	  $yourfile = Yii::getPathOfAlias('webroot').Yii::app()->params['rutaimagenesmateriales'].$_POST['codiguito'].'.jpg';
	  $cfile = Yii::app()->file;
	  IF($cfile->set($yourfile)->exists)
	  {
		  if(@unlink($yourfile)){//$cfile->delete(true)
			 // echo "El archivo ".$yourfile." se borro exitosamente ";
			  Numeromaximo::Pintaimagen( $yourfile,Yii::app()->params['rutaimagenesmateriales']."NODISPONIBLE.JPG",240,240);

		  } else {
			 // echo "El archivo ".$yourfile." No pudo ser borrado ";
		  }

	  } ELSE {
       // echo "El archivo ".$yourfile." No existe ";
	  }

		  $yourfile1 = Yii::getPathOfAlias('webroot').Yii::app()->params['rutaimagenesmateriales'].$_POST['codiguito'].'.JPG';
		  $cfile1 = Yii::app()->file;
		  IF($cfile1->set($yourfile1)->exists)
		  {
			  if(@unlink($yourfile1)){
				 // echo "El archivo ".$yourfile1." se borro exitosamente ";
			  } else {
				  //echo "El archivo ".$yourfile1." No pudo ser borrado ";
			  }

		  } ELSE {
			 // echo "El archivo ".$yourfile1." No existe ";
		  }



   }
  }




public function actionCreaconversion($codigox)
	{
		$model=new Alconversiones;
		
		$modelomaestro=$this->loadModel($codigox);
		if(isset($_POST['Alconversiones']))
		{
			$model->attributes=$_POST['Alconversiones'];
			
			
			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('conversiones-grid');
																		");
														Yii::app()->end();
											}
			
				
		} 
		 
		// if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle_conversiones',array('modelomaestro'=>$modelomaestro,
			'model'=>$model, 'codigox'=>$codigox
		));
		
	}



public function actionModificaconversion($id)
	{
		$model=Alconversiones::model()->find("id=:cvb",array(":cvb"=>$id));
		
		$modelomaestro=$this->loadModel($model->codart);
		if(isset($_POST['Alconversiones']))
		{
			$model->attributes=$_POST['Alconversiones'];
			
			
			if($model->save())
					  if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialogdetalle').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																			");
														Yii::app()->end();
											}
			
				
		} 
		 
		// if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_form_detalle_conversiones',array('modelomaestro'=>$modelomaestro,
			'model'=>$model, 'codigox'=>$modelomaestro->codigo
		));
		
	}










	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Maestrocompo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Maestrocompo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Maestrocompo'])){
			$model->attributes=$_GET['Maestrocompo'];
		if ($this->isExportRequest()) { //<==== [[ADD THIS BLOCK BEFORE RENDER]]
			//set_time_limit(0); //Uncomment to export lage datasets
			//Add to the csv a single line of text
			//  $this->exportCSV(array('POSTS WITH FILTER:'), null, false);

			//Add to the csv a single model data with 3 empty rows after the data
			// $this->exportCSV($model, array_keys($model->attributeLabels()), false, 3);
			//Add to the csv a lot of models from a CDataProvider

			$this->exportCSV($model->search(), array('codigo','um','codtipo','descripcion','marca','modelo','nparte'),false);
			$newmodel->codigo=$data[0];
			$newmodel->um=$data[1];
			$newmodel->codtipo=$data[2];
			$newmodel->descripcion=$data[3];
			$newmodel->marca=$data[4];
			$newmodel->modelo=$data[5];
			$newmodel->nparte=$data[6];

		}
		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Maestrocompo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Maestrocompo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Maestrocompo $model the model to be validated
	 */
	protected function performAjaxValidation($arreglo)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='maestrodetalle-form')
		{
			echo CActiveForm::validate($arreglo);
			Yii::app()->end();
		}
	}





}
