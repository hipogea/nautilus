<?php

class AlmacendocsController extends ControladorBase
{

	public function accessRules()
	{

		Yii::app()->user->loginUrl = array("/cruge/ui/login");


		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','pio'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}





	public function actionPio() {


		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
		print_r($images);
		yii::app()->end();


		echo "  falta copmpraer ".Desolpe::model()->findByPk(730)->cuantofaltacomprar();
		yii::app()->end();


		ECHO  "  del material azufre <br>";
		echo "   una caja   vale :  ".Alconversiones::convierte('18004728','190')."     unidades <br>";
		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123')."     unidades <br>";
		echo "   unA caja  vale :  ".Alconversiones::convierte('18004728','190','120')."     unidades <br>";
		echo "   unA UNIDAD  vale :  ".Alconversiones::convierte('18004728','120','190')."    CAJAS <br>";
		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123','120')."     unidades <br>";
		echo "   unA UNIDAD  vale :  ".Alconversiones::convierte('18004728','120','123')."    KILOGRAMOS <br>";


		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123','190')."    CAJAS <br>";
		echo "   unA CAJA  vale :  ".Alconversiones::convierte('18004728','190','123')."    KILOGRAMOS <br>";
		yii::app()->end();
             $model=new Noticias();

		var_dump(get_class($model));
		yii::app()->end();


		var_dump(count(Peticion::model()->search()->getdata()));
		yii::app()->end();


		ini_set ( 'soap.wsdl_cache_enable' , 0 ); ini_set ( 'soap.wsdl_cache_ttl' , 0 );
		$wsdlURL='https://www.sunat.gob.pe/ol-ti-itcpgem-beta/billService?wsdl';
		$client=new SoapClient($wsdlURL);
		var_dump($client->__getFunctions());
		ECHO "<BR>";
		ECHO "<BR>";
		var_dump($client->__getTypes());
		//var_dump($client);
		yii::app()->end();
		//$result=$client->giveTimestamp();
		//echo $result;




		var_dump(yii::app()->user);
		echo "<br>";
		echo "<br>";
		echo "<br>";
			$elusuario=Yii::app()->user->um->LoadUserById(yii::app()->user->id);
		var_dump($elusuario);
		$sesion_activa=Yii::app()->user->um->findSession($elusuario);
		echo "<br>";
		ECHO " LA DURACION MAXIMA DE LA SESION ".Yii::app()->user->um->getDefaultSystem()->getn('sessionmaxdurationmins')."   Minutos";
		echo "<br>";
		ECHO " la sesion expira  ".date("Y-m-d H:i:s",$sesion_activa->expire);
		echo "<br>";
		ECHO " la sesion inicio en ".date(" H:i:s",$sesion_activa->created);
		echo "<br>";
		ECHO " Ultimo uso  ".date("H:i:s",$sesion_activa->lastusage);
		echo "<br>";
		ECHO " la hora actual  ".date("H:i:s");
		echo "<br>";
		ECHO " Han pasado :   " .((time()-$sesion_activa->created)/(60))."   minutos       con  ";
		echo "<br>";
		echo "  Sesion expirada? :
		        ->             ".var_dump($sesion_activa->isSessionExpired());
		echo "<br>";
		echo "  Sesion name  : ".$sesion_activa->getSessionName();
		echo "<br>";
		echo"  Sesion valida : ".$sesion_activa->validateSession();

		//	$sesion_activa->getSessionFilter();
		echo "<br>";
		//print_r($sesion_activa);
		yii::app()->end();








		echo yii::getPathOfAlias('webroot.materiales');
		//echo yii::app()->baseUrl;
		YII::APP()->END();
		/*var_dump(yii::app()->request);
		echo "<br>";
		print_r(yii::app()->request->baseUrl);*/
		echo yii::app()->getBaseUrl(true);
		echo "<br>";
		var_dump( is_dir(yii::app()->getBaseUrl(true)));

		YII::APP()->END();


		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
		print_r($images);
		yii::app()->end();



	var_dump( is_dir("/public_html/recurso/materiales/"));

        YII::APP()->END();


		var_dump(yii::app()->estadisticas->linear_regression(array(2,3,3.5,5), array(2,3,4,6)));



		$this->render('//alinventario/vw_loginventario',array());

		yii::app()->end();


  $modelinv=Alinventario::model()->findByPk(343569);
		$modelinv->actualiza_stock('77',1,null);
		yii::app()->end();



		echo Yii::app()->baseUrl;
		yii::app()->end();



		$criterio=new CDbcriteria;
		$criterio->addcondition("hidsolpe=:vid");
		$criterio->params=array(":vid"=>387);
		$objeto= new Miproveedor('Desolpe',array('criteria'=>$criterio));
		//var_dump($objeto->getdata());
		$objeto->camposasumar=array("TOTAL CANTIDAD"=>'cant','SUBTOTAL PLANEADO'=>"punitplan",'SUBTOTAL REAL'=>"punitreal");
		$subtotales=$objeto->Total();
		var_dump($subtotales);
		yii::app()->end();



		$nuevoarray=array();
		$nuevoarray['uno']=1;
		$nuevoarray['dos']=2;
		var_dump($nuevoarray);
		yii::app()->end();


		$criterio=new CDbcriteria;
		$objeto= new CActiveDataProvider('Impuestos');
// $dataProvider->getData() will return a list of Post objects
         var_dump($objeto->getdata());
		yii::app()->end();







		//echo Almacendocs::model()->findByPk(709)->almacendocs_almacenmovimientos->eventos->estadofinal;
		var_dump(Almacendocs::model()->findByPk(709)->almacendocs_almacenmovimientos);
		yii::app()->end();


		$criterio=New CDbCriteria();
		$criterio->addCondition("hidguia=:xdet");
		$criterio->params=array(':xdet'=>59);
		//var_dump($criterio->condition);
		print_r(MiFactoria::arrayColumnaSQL(Docompra::model()->tableName(),'id',$criterio));
      yii::app()->end();



		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
          print_r($images);
       yii::app()->end();

		$modelito=new Ocompra();
		$modelito->codocu=$this->documento;
		echo $modelito->correlativo('numcot');
		yii::app()->end();

		echo dirname(__FILE__).'/css/estilogrid.css';
		var_dump(is_file($_SERVER['SCRIPT_NAME'].'/css/estilogrid.css'));
		//ECHO "..//".(strlen(dirname($_SERVER['SCRIPT_NAME']))>1 ? dirname($_SERVER['SCRIPT_NAME']) : '' ) . '/css/estilogrid.css';
		yii::app()->end();

		// una ffraccion de la forma   1/2 , 3/4 , 45/3, 1 /2 , 7./3 , 1/ 3, 234/567,  4/.5 ,
		$cadena1="PERNO  11/45 INOXIDABLE  7/8 HF   1/2 x 3/4  1/12 * 5/16 ";
		$cadena2="PERNO   12./. 56  3 1/2 INOXIDABLE  17/8 HF ";
		$cadena3="PERNO  45/ 34 INOXIDABLE  7./ 8 HF ";
		$cadena4="PERNO  1/2 4 5/34 INOXIDABLE  7 /8  HF ";
		$cadena5=" PERNO   4/.63 INOXIDABLE  756/458 HF ";
		$cadena6="3/4 PERNO  1 / 3 INOXIDABLE  17/8*1 HF ";
		$cadena7="PERNO INOXIDABLE  3*41 25/16 1781 HF ";

		$patron="/^(\s)[0-9]{1,}[\.|\s]?[\/]{1}[\.|\s]?[0-9]{1,}(\s)$/";
		$patron2='/[1-9]{0,}+[\s|*|x|X]{1}[0-9]{1,}[\.|\s]{0,1}[\/]{1}[\.|\s]{0,1}[0-9]{1,}[\s|*|x|X]{1}/';
		echo $cadena1. "    ". preg_match_all($patron2,$cadena1,$resultado1) ."<br>";
		print_r($resultado1);
		echo "<br>";
		echo "<br>";
		echo $cadena2. "    ". preg_match_all($patron2,$cadena2,$resultado2) ."<br>";
		print_r($resultado2);
		echo "<br>";
		echo "<br>";
		echo $cadena3. "    ". preg_match_all($patron2,$cadena3,$resultado3) ."<br>";
		print_r($resultado3);
		echo "<br>";echo "<br>";
		echo $cadena4. "    ". preg_match_all($patron2,$cadena4,$resultado4) ."<br>";
		print_r($resultado4);
		echo "<br>";echo "<br>";
		echo $cadena5. "    ". preg_match_all($patron2,$cadena5,$resultado5) ."<br>";
		print_r($resultado5);
		echo "<br>";echo "<br>";
		echo $cadena6. "    ". preg_match_all($patron2,$cadena6,$resultado6) ."<br>";
		print_r($resultado6);
		echo "<br>";echo "<br>";
		echo $cadena7. "    ". preg_match_all($patron2,$cadena7,$resultado7) ."<br>";
		print_r($resultado7);
		echo "<br>";echo "<br>";
		//echo $cadena8. "    ". preg_match('/^(\s)[0-9]{1,}[\.|\s]?[\/]{1}[\.|\s]?[0-9]{1,}(\s)$/',$cadena1) ."<br>";


		yii::app()->end();

		print_r(Yii::app()->user->rbac->getMenu());
		yii::app()->end();
		//$model=new Impuestos;
		yii::app()->crugemailer->mail_con_archivo ('neotegnia@gmail.com','hipogea@hotmail.com','hi','130165');
	//	var_dump(mail('neotegnia@gmail.com','holas','holas'));
		yii::app()->end();
		echo Valorimpuestos::getimpuesto ( '200');

		$model->codocumento='1';
		ECHO Valorimpuestos::model()->getimpuesto('100');
		yii::app()->end();
		$model->codocumento='130';
		echo $model->Correlativo('numero');
		yii::app()->end();
		$modelin=CactiveRecord::model('Alkardex');
		print_r($modelin->getTableSchema());
		yii::app()->end();


		echo get_include_path();
		yii::app()->end();


		ECHO " la sesion expira  ".date("Y-m-d,H-i:s");
		yii::app()->end();


		echo MiFactoria::decimal(47/3);
		yii::app()->end();


		print_r(MiFactoria::opcionestoolbar(345,'130','20'));
		yii::app()->end();
		$model=new Inventario();
		$objeto=$model->getMetaData();
		foreach($objeto->columns as $columna)
		{
			echo "campo  ".$columna->name."    ancho ".$columna->size."  el tipo  : ".$columna->dbType."<br>";

		}
		print_r($objeto->columns);

		//$model->rucpro='121212121212121';
		//$model->save();
		//print_r($model->getMetaData());
		yii::app()->end();




		$movimientoauxiliar='45';
		$filakardexoriginal=Alkardex::model()->findByPk(1691);
		$filakardexoriginal->alkardex_alinventario->actualiza_stock($movimientoauxiliar,abs(3),null);
		yii::app()->end();




		$modeloreserva=Alreserva::model()->findByPk(255);
		var_dump($modeloreserva->alreserva_cantidadatendida);
		yii::app()->end();
		var_dump($kardex=Alkardex::model()->findByPk(1514)->alkardex_despacho);
		yii::app()->end();
		//tag(string $tag, array $htmlOptions=array ( ), mixed $content=false, boolean $closeTag=true)
		$arrayes=Almacendocs::model()->findAll("numvale=:nimi",array("nimi"=>trim('130200000129')));
		echo count($arrayes);
		yii::app()->end();


		if(is_dir('assets'))
			echo " si es un directrio";
		yii::app()->end();

		Yii::app()->crugemailer->prueba();

		//echo CHtml::tag("div",array("style"=>"font:23px;fotn-size:445;"),"AQUI",true);
		$calse=new Cc();
		ECHO $calse::BELONGS_TO;
	//	var_dump($calse);

		//phpinfo(INFO_MODULES);
		yii::app()->end();
		//tag(string $tag, array $htmlOptions=array ( ), mixed $content=false, boolean $closeTag=true)
		$arrayes=Almacendocs::model()->findAll("numvale=:nimi",array("nimi"=>trim('130200000129')));
       echo count($arrayes);
		yii::app()->end();

		echo strpos("manicomo","c");

		Yii::app()->user->setFlash('error', "MENSAJE ERRO1");
		Yii::app()->user->setFlash('error2', "MENSAJE ERR2");
		Yii::app()->user->setFlash('error3', "MENSAJE ERR3");
		Yii::app()->user->setFlash('notice', "MENSAJE NORICE1");
		Yii::app()->user->setFlash('notice2', "MENSAJE NOTICE2");
		Yii::app()->user->setFlash('notice3', "MENSAJE NOTICE3");
		Yii::app()->user->setFlash('success', "SUCCESS ERRO1");
		Yii::app()->user->setFlash('success2', "SUCCESS ERR2");
		Yii::app()->user->setFlash('success3', "SUCCESS ERR3");

     // PRINT_R(Yii::app()->user->getFlashes());



		yii::app()->end();
		//$this->ConfirmaBuffer($id);

		$kardexhijos=MiFactoria::DevuelveKardexHijos($id);

		echo count($kardexhijos);
		/*foreach ( $kardexhijos as $filakardex ) {
			//$filakardex->preciounit=$filakardex->getMonto();
			//$filakardex->VerificaCantAtenReservas();
			//$filakardex->InsertaAtencionReserva($filakardex->id);
			echo "   id del kardex ".$filakardex->id."<br>";
			//$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmov,abs($filakardex->cantidadbase()),null);

			//$filakardex->InsertaCcGastos();
		}
	*/
		yii::app()->end();




		$id=160;
		$modeloreserva=Alreserva::model()->findByPk($id);
		$modeloreserva->anular();
		PRINT_R(Yii::app()->user->getFlashes());
		yii::app()->end();




		$id=490;
			$kardexhijos=MiFactoria::DevuelveKardexHijos($id);
		//var_dump($kardexhijos);

			foreach ( $kardexhijos as $filakardex ) {

				//calculando el precio unitario
				$filakardex->preciounit=$filakardex->getMonto();
				IF($filakardex->VerificaCantAtenReservas())
					PRINT_R($filakardex->mensajes);

				//ECHO " GRABA  ".$filakardex->InsertaAtencionReserva($filakardex->id);

				$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmov,abs($filakardex->cantidadbase()),null);
                print_r($filakardex->alkardex_alinventario->mensajes);
				//verificandso si hay errrores recoger los mensajes
				/*if(!$filakardex->VerificaCantAtenReservas() or
                    !$filakardex->InsertaAtencionReserva() or
                    !$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmovimiento,$filakardex->cant,null)
                   )
                 $this->mensajes=array_merge($this->mensajes,$filakardex->mensajes,$filakardex->alkardex_alinventario->mensajes);
          */

				$filakardex->InsertaCcGastos();

			}

		yii::app()->end();




		//$nuevo=new MiFactoria();
		//Mifactoria::InsertaAtencionReserva(1357);


		$row=Alkardex::model()->findByPk(NULL);
		$matrix= Alreserva::model()->findAll("hidesolpe=:vhidsolpe AND codocu='450' ",array(":vhidsolpe"=>$row->idref));
		$model=new Atencionreserva();
		$model->cant=$row->cant;
		$model->hidkardex=$row->id;
		$model->hidreserva=$matrix[0]['id'];
		$model->estadoatencion=Atencionreserva::ESTADO_CREADO;
		if(!$model->save())
			throw new CHttpException(500,"NO se Pudo insertar el registro de atenciones reservas ");
		unset($model);unset($matrix);unset($row);
		yii::app()->end();



           $mimo=new ModeloGeneral();
		   $mimo->insertamensaje('success','primermamesaje');
		$mimo->insertamensaje('success1','segundo mensaje');
		$mimo->insertamensaje('error','tercer mensaje');
		$mimox=new ModeloGeneral();
		$mimox->insertamensaje('successx','primermamesaje');
		$mimox->insertamensaje('success1x','segundo mensaje');
		$mimox->insertamensaje('errorx','tercer mensaje');
		/*$gg= new Alinventario();*/
		print_r($mimo->mensajes);
		echo "<br><br>";
		print_r($mimox->mensajes);
		$mensaj=array();
		$mensaj=array_merge($mensaj,$mimo->mensajes);
		$mensaj=array_merge($mensaj,$mimox->mensajes);
		//array_merge($mensaj,$mimox->mensajes);
		//$mensaj[]=$mimo->mensajes;
		//$mensaj[]=$mimox->mensajes+$mimo->mensajes;
		//array_push($mensaj,$mimox->mensajes);
		echo "<br><br>";
		print_r($mensaj);

		yii::app()->end();


		var_dump(Almacenmovimientos::model()->findByPk('10')->signo);
		//echo "total   ".Alinventario::getStockTotal('11000004');
		yii::app()->end();
		/*if(Yii::app()->periodo->getModel()->HoyDentroPeriodo()){
			echo "ESTAMOS DENTRO DEL PERIODO";
		} else {
			echo "no  ESTAMOS DENTRO DEL PERIODO";
		}

		yii::app()->end();*/

		if(Yii::app()->periodo->verificaFechas('2015-03-5','2015-03-4')){
			echo "ESTAMOS DENTRO DEL PERIODO";
		} else {
			echo "no ESTAMOS DENTRO DEL PERIODO";
		}

		yii::app()->end();


$gg=new Alkardex();
		//$gg=Alkardex::model()->findByPk(1236);
		//var_dump($gg->oldAttributes);
		ECHO "<BR><BR> ESCENARIO :".$gg->getScenario()."<BR>";
		$gg->save();
		var_dump($gg->errors);


		$ggt=new Tempalkardex();
		//$gg=Alkardex::model()->findByPk(1236);
		//var_dump($gg->oldAttributes);
		ECHO "<BR><BR> ESCENARIO :".$ggt->getScenario()."<BR>";
		$ggt->save();
		var_dump($ggt->errors);
		yii::app()->end();
		$matriz=$gg->relations();
		$nuevoarr=array();
		//print_r($matriz);
		foreach($matriz as $clave=>$matricita)
		{
				     if($matricita[0]=='CHasManyRelation')
					   $nuevoarr[$matricita[2]]=$matricita[1];
			        }
		print_r($nuevoarr);
		//$hallo=array_search('CHasManyRelation',$matriz);
    // echo var_dump($hallo);
		yii::app()->end();
		$arreglo=array();
		/*$arreglo1=array('uno'=>1);
		$arreglo2=array('dos'=>2);
		$arreglo3=array('tres'=>3);*/
		$arreglo['uno']=1;
		$arreglo['dos']=2;


		print_r($arreglo);
		yii::app()->end();

		/***********************************************
		 * Prueba de la propieda mensajes ARRAY() de
		 * la clase MODELOGENERAL
		 *
		 * *******************       */
		$modelo=new ModeloGeneral();
		$modelo->insertamensaje('error','MENSAJE 1');
		$modelo->insertamensaje('error','MENSAJE 2');
		$modelo->insertamensaje('error','MENSAJE 3');
		$modelo->insertamensaje('notice','notice 1');
		$modelo->insertamensaje('notice','notice 2');
		$modelo->insertamensaje('success','succes 3');
         echo $modelo->parsemensajes('error');
		echo $modelo->parsemensajes('notice');
		echo $modelo->parsemensajes('success');
		//PRINT_R($modelo->mensajes);
		yii::app()->end();
		foreach($arreglo as $registro) {
			echo $registro->cant;
			echo " <br><br>";
		}
		//var_dump($modelo->desolpe_alreserva);
		yii::app()->end();
		/***********************************************************
		 *
		 */



		/***********************************************
		 * Prueba de que los registros hijos pueden ser
		 * llmados desde la relacion
		*  HAS:MANY                                   */
		$modelo=Desolpe::model()->findByPk(168);
		$arreglo=$modelo->desolpe_alreserva; ///LLAMA A LA RELACION Y RETORNA OBJETOS HIJOS
		   PRINT_R($arreglo);
		foreach($arreglo as $registro) {
			  echo $registro->cant;
			  echo " <br><br>";
		  }
		//var_dump($modelo->desolpe_alreserva);
		yii::app()->end();
		/***********************************************************
		 *
		 */



		echo Alconversiones::convierte('18005239','120');
           yii::app()->end();
		$petri=new Peticion();
		print_r($petri->behaviors());
		if(array_key_exists('ActiveRecordLogableBehavior',$petri->behaviors()))echo "salio";
		yii::app()->end();


		/*print_r(MiFactoria::ExisteRegistroTemporal('Tempdpeticion',127));
		yii::app()->end();*/
		/*print_r(Peticion::relations());
		$campoenlace=Peticion::getFieldLink(Peticion::relations(),'Peticion','Tempdpeticion');
		echo "<br>";
		echo "campo enl ace   :   ".$campoenlace;
		yii::app()->end();*/
		$id=127;
		$con=$this->IniciaBuffer($id);
		foreach($con as $grupo)
		{
			echo "<br>";
			foreach($grupo as $objeto){
				echo "<br>";
				   foreach( $objeto as $row){
							echo "======================================================<br>";
								print_r($row);
								echo "======================================================<br>";
					  		 echo "<br>";
				   }
			}
			echo "<br>";
		}

		$nombremodelocabecera='Peticion';
		foreach($con as $registroshijos)
		{

			// foreach ($grupo as $registroshijos)
			//{
			// $campoenlace=$nombremodelocabecera::getFieldLink($nombremodelocabecera::relations(), $nombremodelocabecera,$nombremodelohijo);
			// $registroshijos=MiFactoria::getRegistrosHijos($nombremodelohijo,$campoenlace,$id);
			foreach  ($registroshijos as $row)
			{

				if(is_null(MiFactoria::ExisteRegistro('Tempdpeticion',$id))){

					if($row->save()){
					echo " <br>";
					 echo " *********************************";
				echo " <br>";
				   echo "grabo     ".$row->getTableAlias();
				echo " <br>";
				echo " *********************************";
				  echo " <br>";
						}
				}

			  }
		}

		yii::app()->end();
		 print_r($con);
		yii::app()->end();

	//	$lalo=null;
		$modeloant=Solpe::model()->findByPk(239);
		$matriz=$modeloant->relations();
		$palo=$this->recorro($matriz);
		//echo Solpe::HAS_MANY;
		print_r($palo);
		yii::app()->end();

		$modeloant=Solpe::model()->findByPk(239);
		print_r($modeloant->relations());
		//echo $modeloant->codart;
		yii::app()->end();

		$modelo="Dpeticion";
		$s=new $modelo;
		print_r($s);
		yii::app()->end();

		$clasetemporal="Alinventario";
		$valor=$clasetemporal::model()->hasAttribute('codart');
		echo "   gfgfgf ".$valor;
		yii::app()->end();



		$registroshijos=$modelo::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=54 ");

		print_r($registroshijos);
		yii::app()->end();


		$inv='Alinventario';

		$arraymodelos=array();
		$modelo=$inv::model()->findByPk(343563);
		$modelo2=$inv::model()->findByPk(343564);
		array_push($arraymodelos,$modelo);
		array_push($arraymodelos,$modelo2);
		//$nuevomod=Bloqueos::prueba();
		echo $arraymodelos[0]->codart;
		//print_r($modelo);
		yii::app()->end();
         // $modelo=new ModInventario();
		$modelo=ModInventario::loadModel(343563);
		$modeloant=ModInventario::loadModel(343563);
		//echo " hola  ".gettype($modelo->codart);
		//$modelo->actualizaprecio($cantmov,1.23,$this->CAMPO_STOCK_LIBRE);
		$nuevoprecio=500;
		$cantmov=100;
		if($modelo->actualizaprecio($cantmov,$nuevoprecio,ModInventario::CAMPO_STOCK_LIBRE)) {
			echo "ok se relaizo el proceso :<br>";
			echo "cant libre :  ".$modelo->cantlibre."                 anterior : ".$modeloant->cantlibre."<br>";
			echo "cant reserva :  ".$modelo->cantres."                  anterior : ".$modeloant->cantres."<br>";
			echo "cant reserva :  ".$modelo->canttran."                    anterior : ".$modeloant->canttran."<br>";
			echo "Precio unitario :".$modelo->punit."                      anterior : ".round($modeloant->punit,3)."<br>";
			echo "dif de precio unitario :  ".$modelo->punitdif."                 anterior : ".$modeloant->punitdif."<br>";
			echo "cant stock afectado por el ambio de precio  :  ".$modelo->getStockCamposAfectadosPrecio()."<br>";
			echo "cant movida  :   ".$cantmov."<br>";
			echo "precio unitario nuevo  :   ".$nuevoprecio."<br>";
			echo "-------<br><br>";
		} else {
			$matriz=$modelo->getMensajes();
             echo " HAY  ".COUNT($matriz)."     Elementos";
			print_r($matriz);
         foreach( $matriz as $arreglo){
			// echo   "  ".$arregloclave."  :   ".$valor."<br>";
		 }
			echo "hu,,-------<br><r>";
		}

		yii::app()->end();

		$am = new MyCrugeAuthManager;
		$am->init();
		foreach($am->autoDetect() as $itemName)
			printf("%s\n",$itemName);
		echo "  la direccion IP:  ".CrugeUtil::hash("julian");


		echo " es una instancia de ". gettype(Yii::app()->crugemailer);
		/*if (Yii::app()->CrugeMailer instanceof CrugeMailer) {
			echo 'Crugemailer';
		} else  {
			echo "que carajo sera";
		}*/
		yii::app()->end();
        $id=54;
		$difiere=false; ///Asumismos que no ha variado
		$registrosactuales =Tempdpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."tempdpeticion
  																 where
  																 hidpeticion=".$id." and idusertemp = ".Yii::app()->user->id." ");
		$registrosviejos =Dpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=".$id." ");
		foreach ($registrosactuales as $row)
		{   $newattributes = $row->getAttributes(); ///Los valores de este instante
			foreach ($registrosviejos as $rowviejo){
				$oldattributes=$rowviejo->getAttributes();
				echo " Emparewjando : ".$oldattributes['id']."  con  ".$newattributes['id']." <br>";
				if($oldattributes['id']==$newattributes['id'] )  //compaRlo s
				{
					echo " En la fila ".$oldattributes['id']."  : <br>";
					foreach($oldattributes as $clave=>$valor) {
						echo "Comparando  :<br>";
						echo " original  :  ".$clave."                               original=".$valor."   actual=".$newattributes[$clave]."<br>";
						if($valor<>$newattributes[$clave] and $clave<>'idtemp' and $clave<>'idusertemp' ) {
							echo " DIFERENTE <br><br> ";
							$difiere=true;
							break;
						}

					}
					echo "  <br><br><br><br>";
				}

				/* print_r($newattributes );
                    echo "<br>";
                     print_r($atributos);
                   echo "<br><br><br>";*/
				if($difiere)
					break;
			}

			/*print_r($this->bufferdetalle);
			echo "<br>";
			        if($difiere)
				   break;*/
			if($difiere)
				break;
		}

		echo "<br><br>   total    ".$difiere;
		yii::app()->end();




























		$registrostemporalesdpeticion=array();
		$datosdebuffer=array(); ///Estos datos
		$datosbufferdefila=array();
		$registroshijos =Dpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=".$hidpeticion."  ");
		foreach  ($registroshijos as $row) {
			///Evitamos levantar items duplicados
			$existeregistro= Tempdpeticion::model()->find("id= ".$row->id." AND idusertemp=".Yii::app()->user->id." ");
			if(is_null($existeregistro)) {  ///Solo si no existe
				$modelotempdpeticion=new Tempdpeticion;
				$modelotempdpeticion->attributes=$row->attributes;
				$modelotempdpeticion->idusertemp=Yii::app()->user->id;
				array_push($registrostemporalesdpeticion,$modelotempdpeticion);

				$datosbufferdefila=$row->attributes;
				//array_push($datosbufferdefila,array('micalve'=>$row->id));
				array_push($datosdebuffer,$datosbufferdefila);
			}
		}
		//print_r($datosdebuffer);

		foreach ($datosdebuffer as $clave=>$atributos){
			 print_r($atributos);
			echo "<br><br>";

		}
		//$this->bufferdetalle=$registrostemporalesdpeticion; ///Guarda el bu¡ffer de datos
		//return $registrostemporalesdpeticion;
		yii::app()->end();










		$arreglo=array();
		$arreglo1=array('uno'=>1);
		$arreglo2=array('dos'=>2);
		$arreglo3=array('tres'=>3);

		array_push($arreglo,array('uno'=>1));
		array_push($arreglo,array('dos'=>2));

		print_r($arreglo);
		yii::app()->end();

    $id=34;
		if($id)
			echo "dsdsdsds eco ";
		yii::app()->end();

		$me=Yii::app()->user->id;
		$cadena= " select distinct idusertemp from ".Yii::app()->params['prefijo']."temppeticion WHERE id=".$id." and idusertemp <> ".$me." ";
		$quien=Yii::app()->db->createCommand($cadena)->queryScalar();
		echo $cadena;
		echo " El tipo de quien ".gettype($quien)."    -----    ".$quien;
		//yii::app()->end();
		if($quien) { /// Quiere decir que hay otros que estan ediotnado el documento
			///PARA VER SIS ES CIERTO DEEBMOS VERIFICAR Q ESTE USUARIO NO HA DEJADO LA VENTANA ABANDONADA CON E DOMCUENTO EN EDICION
			$elusuario=Yii::app()->user->um->LoadUserById($quien);
			///hallando la sesion activa de este usuario
			$sesion_activa=Yii::app()->user->um->findSession($elusuario);
			if(is_null($sesion_activa)) {
				echo "  NO esta cupado man ";  //No esta ocupado por que estaba editando pero ya temrino sus sesion, alo mejor dejo la ventana abierta
			}  else {
				echo "  Estaa cupado por el usuario ".$elusuario->username;  ///Si esta ocupado por que el usuario tiene sesion activa, y eszta editando
			}

		} else {
			echo "  NO esta cupado , estas solo mano  ";
		}

		yii::app()->end();







		$usuariojesus=Yii::app()->user->um->loadUser('admin',false);
		print_r($usuariojesus);

		echo "<br><br><br><br>";
		$modelo=Yii::app()->user->um->findSession($usuariojesus);
       echo  " el tipo retoranado es ".gettype($modelo);
		print_r($modelo);


		echo "<br><br><br><br>El  modelo de sesion de Jesus";
		$modelo=Yii::app()->user->um->findSession(Yii::app()->user->um->loadUser('jesus',false));
		echo  " el tipo retoranado es ".gettype($modelo);
		print_r($modelo);




		yii::app()->end();

		$modelo->isSessionExpired();
		if($expiro){
			echo "   Ya expiro ";
		}  else {
			echo "   Todavia esta vignte la sesion  ";
		}


		yii::app()->end();




		$this->layout = '//layouts/iframe';
		$this->render('carachita');
		yii::app()->end();
        // $modelosolpe=Desolpe::model()->findByPk(79);
		$modelokardex=Alkardex::model()->findByPk(1236);
		$clonado=$modelokardex->clonaregistro();
		//echo $clonado->cant;
		print_r($clonado);
		yii::app()->end();
		echo " numeor reservar compras ". $modelosolpe->numero_reservascompras;
		echo " modelo cant ".$modelosolpe->cant;
		yii::app()->end();
		if(($cantidadatendidaacumulada+$modelokardex->cant)== $modeloreserva->cant)
		{$modeloreserva->estadoreserva='20';///Completo...!
			///Veriifcar primero si DESOLPE tiene partido RESERVA +RESERVA PARA COMPRA
			IF($modelodesolpe->numero_reservascompras == 0 ) ///Si no tiene solicitudes de compra
				$modelodesolpe->est=='40';///Completo...!
		}



		$kardex=Alkardex::model()->findByPk(1125);
		echo "  la sumatoria de las cantidades :  ".$kardex->alkardex_alkardextraslado_emisor_cant;
		echo "  la cantidad  :  ".$kardex->cant;
		yii::app()->end();

		$modelo=New Alkardex;
		$centro=$modelo->alkardex_alinventario->cantlibre;
		echo "  el cento es  ".$centro;
		yii::app()->end();
		$modelo=Desolpe::model()->findByPk(74)->desolpe_alinventario;
		$modelo->cantlibre=1234;
		$modelo->setScenario('modificacantidad');
		$modelo->save();
		echo "  ES ".$modelo->codart;
		yii::app()->end();
		//$modelo->Actualizar($movimiento,$cantidad,$unidad,$punitario=null);
		$mensaje=$modelo->Actualizar('80',0.03,'140',null);

		//echo " El almacen : ".$modelo->desolpe_alinventario->codalm."  \n";
		 if(strlen($mensaje)== 0){
			 echo " cantidad  libre : ".$modelo->cantlibre."  \n";
			 echo " cantidad  libre : ".$modelo->cantlibre."  \n";
			 echo " cantidad reservada : ".$modelo->cantres."  \n";
			 echo " cantidad  transito : ".$modelo->canttran."  \n";
			 echo " precio unitario : ".$modelo->punit."  \n";
			 echo " cantidad  movida : ".$modelo->cantidadmovida."  \n";
			 echo " monto movido : ".$modelo->montomovido."  \n";
			// echo " La conversion  : ".Alconversiones::model()->convierte($modelo->codart,$modelo->um)."  \n";
			 //echo " catidad reservada  : ".$modelo->desolpe_alinventario->cantres."  \n";

		 } else {
			 echo "  ".$mensaje;
		 }
		yii::app()->end();
	   }


}