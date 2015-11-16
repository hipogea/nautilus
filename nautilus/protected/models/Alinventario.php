<?php

class Alinventario extends ModeloGeneral
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventario the static model class
	 */
	const FLAG_PRECIO_PROMEDIO_VARIABLE ='V';
	const FLAG_PRECIO_ESTANDAR ='S';
	const NOMBRE_CAMPO_PRECIO_UNITARIO='punit';
	const CAMPO_STOCK_LIBRE='cantlibre';
	const CAMPO_STOCK_RESERVADO='cantres';
	const CAMPO_STOCK_TRANSITO='canttran';
	const NOMBRE_CAMPO_CONTROL_PRECIO='controlprecio'; //NOmbre del campo de la tabla relaciondad maerto detalle
	const  NOMBRE_CAMPO_PRECIO_ESTANDAR='punit';//NOmbre del campo de la tabla relaciondad maerto detalle
	const     NOMBRE_CAMPO_PRECIO_DIFERENCIA_UNITARIA='punitdif';
	const CAMPO_STOCK__RESERVADO='cantres';
     const ESCENARIO_ACTUALIZARSTOCK='modificacantidad';
	//const NOMBRE_CAMPO_PRECIO_UNITARIO='punit';

	public $camposstock=array(
		self::CAMPO_STOCK_LIBRE=>self::CAMPO_STOCK_LIBRE,
		self::CAMPO_STOCK_RESERVADO=>self::CAMPO_STOCK__RESERVADO,
		self::CAMPO_STOCK_TRANSITO=>self::CAMPO_STOCK_TRANSITO
	);

	public $camposstockafectadosporprecio=array(
		self::CAMPO_STOCK_LIBRE=>self::CAMPO_STOCK_LIBRE,
		self::CAMPO_STOCK_RESERVADO=>self::CAMPO_STOCK__RESERVADO,
		self::CAMPO_STOCK_TRANSITO=>self::CAMPO_STOCK_TRANSITO
	);


	//public $mensajes=array(); //guarada los mensajes de las operaciones relaizadas en epscial las advertencias y lso errores
	public $pttotal;
	public $cantidadmovida; //almacena en el Active record la cantidad movida (Convertida a unidad de medida base del material)  de cualquier transaccion,
	public $montomovido; //ALMACENA EL MONTO INVOLUCRADO EN LA TX , ///sin eimportar la Unidad de medida o el control del precio d S O V DE L AMATEIRAL
	protected $controldeprecio=NULL;

	protected function getNombreClase(){
		return _CLASS_;
	}

	public static function getcamposstock(){
        return self::camposstock;
    }

    public function getstockregistro(){
		$canttotal=0;
	        foreach ($this->camposstock as $clave=>$valor){
				$canttotal+=is_null($this->{$valor})?0:$this->{$valor};
			}
		return $canttotal;
          }


	/* DEVULEV EEL STOCK VALORIZADO TOTAL DE TODOS LOS CENTROS Y ALMACENES*/
	public  function getStockValTotal(){
		$data= Yii::app()->db->createCommand()
			->select($this->getsumas())
			->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
			->where("a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault  ",
				array(":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))->queryAll();
		$stocks=array();
		foreach($data[0] as $clave=>$valor){
			$stocks[$clave]=$valor;
		}





		return $stocks;
	}

	/* DEVULEV EEL STOCK VALORIZADO SUBOTALIZADO POR CENTRO*/
	public  function getStockValCentro(){
	  $data= Yii::app()->db->createCommand()
		  ->select($this->getsumas().', a.codcen ')
		  ->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
		  ->where("a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault  ",
			  array(":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))
		  ->group('a.codcen')->order('a.codcen ASC')
		  ->queryAll();
       $centros=array();
        foreach($data as $fila){
           $centros[]=$fila['codcen'] ;
        }
        asort($centros);
        return array_combine($centros,$data);
	}


	/* DEVULEV EEL STOCK VALORIZADO SUBOTALIZADO POR ALMACEN*/
	public  function getStockValAlmacen(){
		$data= Yii::app()->db->createCommand()
			->select($this->getsumas().',
			    a.codalm,
			    a.codcen,c.nomal
			       ')
			->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
			->where("a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault  ",
				array(":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))
			->group('a.codalm, a.codcen,c.nomal')->order('a.codalm asc')
			->queryAll();
		$almacenes=array();
		foreach($data as $fila){
			$almacenes[]=$fila['codalm'] ;
		}
		asort($almacenes);
		return array_combine($almacenes,$data);
	}



	/* DEVULEV EEL STOCK VALORIZADO TOTAL DE TODOS LOS CENTROS Y ALMACENES del MATERIAL*/
	public  function getStockMatTotal($codigo){
		$data= Yii::app()->db->createCommand()
			->select($this->getsumas())
			->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
			->where("a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault and a.codart=:vcodigo ",
				array(":vcodigo"=>$codigo,":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))->queryAll();
		return $data;
	}

	/* DEVULEV EEL STOCK VALORIZADO SUBOTALIZADO POR CENTRO DEL MATERIAL */
	public  function getStockMatCentro($codigo){
		$data= Yii::app()->db->createCommand()
			->select($this->getsumas().', a.codcen,a.codart ')
			->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
			->where("a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault and a.codart=:vcodigo ",
				array(":vcodigo"=>$codigo,":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))
			->group('a.codcen,a.codart')->order('a.codcen ASC')
			->queryAll();
		$centros=array();
		foreach($data as $fila){
			$centros[]=$fila['codcen'] ;
		}
		asort($centros);
		return array_combine($centros,$data);
	}


	/* DEVULEV EEL STOCK VALORIZADO del MATERIAL SUBOTALIZADO POR ALMACEN*/
	public  function getStockMatAlmacen($codigo){
		$data= Yii::app()->db->createCommand()
			->select($this->getsumas().',
			    a.codalm,a.codart,
			    a.codcen,c.nomal
			       ')
			->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
			->where("a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault and a.codart=:vcodigo  ",
				array(":vcodigo"=>$codigo,":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))
			->group('a.codalm, a.codcen,a.codart,c.nomal')->order('a.codalm asc')
			->queryAll();
		$almacenes=array();
		foreach($data as $fila){
			$almacenes[]=$fila['codalm'] ;
		}
		asort($almacenes);
		return array_combine($almacenes,$data);
	}


	public  function getStockTotalAlmacen($codal,$infostock)
    {
        $adatosstock = array();
        $stockalmacen = null;
        if (is_array($infostock)) { ///si se definio loa consulta
            $adatosstock = $this->getStockAlmacenes();
        } else {
            $adatosstock = $infostock;
        }
        foreach ($adatosstock as $fila) {
            if ($fila['codalm'] == $codal) {
                foreach ($this->camposstock as $clave => $valor) {
                    $stockalmacen += $fila['stock_' . $valor];
                }
                break;
            }
        }
        return $stockalmacen;
    }

        public  function getStockTotalCentro($codcen,$infostock){
            $adatosstock=array();
            $stockcentro=null;
            if(is_array($infostock)){ ///si se definio loa consulta
                $adatosstock=$this->getStockAlmacenes();
            }else{
                $adatosstock=$infostock;
            }
            foreach($adatosstock as $fila)
            {
                if($fila['codcen']==$codcen)
                {
                    foreach($this->camposstock as $clave=>$valor){
                        $stockcentro+=$fila['stock_'.$valor];
                    }
                }
            }
            return $stockcentro;

	}


    public function getstockMaterial($codmaterial){
        return Yii::app()->db->createCommand()
            ->select(self::getsumas().', a.codalm,  a.codcen')
            ->from('{{alinventario}} a ,{{tipocambio}} b , {{almacenes}} c')
            ->where(" a.codalm=c.codalm and a.codcen=c.codcen and
		  c.codmon=b.codmon1 and b.codmon2=:Vmonedadefault and a.codart=:vcodart ",
                array(':vcodart'=>$codmaterial,":Vmonedadefault"=>yii::app()->settings->get('general','general_monedadef')))
            ->group('a.codalm,  a.codcen')
            ->queryAll();

    }

public function getstockTotalmaterial($codmaterial,$adatos=null){
   $cantidad=0;
    if(is_array($adatos)){

            }else{
        $adatos=$this->getstockMaterial($codmaterial);
        }

        foreach($adatos as $fila){
            foreach($this->camposstock as $clave=>$valor){
                $cantidad+=$fila['stock_'.$valor];
            }

        }
    return $cantidad;
}


    public function getstockTotalmaterialCentro($codmaterial,$codcentro,$adatos=null){
        $cantidad=0;
        if(is_array($adatos)){

        }else{
            $adatos=$this->getstockMaterial($codmaterial);
        }

        foreach($adatos as $fila){
            if($fila['codcen']==$codcentro) {
                foreach ($this->camposstock as $clave => $valor) {
                    $cantidad += $fila['stock_' . $valor];
                }
                break;
            }
        }
        return $cantidad;
    }






    public static function getStockAlmacentipo($almacen,$centro,$tipo){
		$valor=Yii::app()->db->createCommand()
			->select(' sum((cantlibre+cantres+canttran)*(punit+punitdif)) as stocktotal ')
			->from('{{alinventario}} a ,{{maestrocomponentes}} b , {{maestrotipos}} c')
			->where('a.codart=b.codigo and b.codtipo=c.codtipo and
			a.codalm=:vcodal and codcen=:vcodcen and
			 codcen=:vcodcen and c.codtipo=:vcodtipo',array(":vcodcen"=>$centro,":vcodal"=>$almacen,":vcodtipo"=>$tipo))
			//->group('a.codalm,  a.codcen')
			->querScalar();
		return ($valor!=false)?$valor:0;

	}


	public function pronostico(){
      //buscando las absisas
			$fechainicio=$this->almacen->fecharefpronostico;
		$xarray=array(); //las fechas
		$yarray=array();//Las cantidades de inventario
		$stockinicial=$this->getstockregistro();
		$valores=Yii::app()->db->createCommand()
			->select('a.fecha,sum(a.cant) as consumido')
			->from('{{alkardex}} a')
			->where('a.codart=:vcodart  and fecha >=:vfecha
			and codmov in (select codmov from {{almacenmovimientos}} where esconsumo="1" )
			',array(":vfecha"=>$fechainicio,":vcodart"=>$this->codart)
			       )
			->group('a.fecha')
			->order('a.fecha ASC')
			->queryAll();
		/*var_dump($valores);
		yii::app()->end();*/
		///sacando el comsumido total
		$consumido=0;
		foreach($valores as $fila){
			$consumido+=abs($fila['consumido']);
		}
		//cOLOCAR EL TOPE para luego restar
		$valorux=$stockinicial+$consumido;
		/*print_r($valores);*/
		/*echo "sotckinical ".$stockinicial."<br>";
		echo "sotckinical ".$consumido."<br>";
		echo "sotckinical +cosumido".$valorux."<br>";*/
		//yii::app()->end();
		$fechax=strtotime($fechainicio);
		$diaspasados=0;

		foreach($valores as $fila){
			$diaspasados+=ceil((strtotime($fila['fecha'])-$fechax)/(60*60*24));
			$xarray[$fila['fecha']]=$diaspasados+1;
			$yarray[]=$valorux-abs($fila['consumido']);
			$valorux-=abs($fila['consumido']);
			$fechax=strtotime($fila['fecha']);
		}
	/*	echo "ejes x <br>";
	print_r($xarray);
		echo "ejes y";
		echo "<br>";
		print_r($yarray);
		echo "<br>";*/
		//yii::app()->end();*/

		if(count($xarray) < 2 or count($xarray) < 2 ){
			return array(array(),array(),array(),array());
		} else {
			$recta=yii::app()->estadisticas->linear_regression(array_values($xarray), $yarray);
			//recta devuelve un array ( valorpendiente m, intercepto y)
			/*$x1=array_values($xarray)[0];
            $y1=$recta['m']*$x1+$recta['b'];
            $x2=array_values($xarray)[count($xarray)-1];
            $y2=$recta['m']*$x2+$recta['b'];*/
			$numerodepuntos=ceil((array_values($xarray)[count($xarray)-1]-array_values($xarray)[0])/count($xarray));
		/*	echo "final ".array_values($xarray)[count($xarray)-1]."<br>";
			echo "inicio ".array_values($xarray)[0]."<br>";
			echo "cuantos ".count($xarray)."<br>";
			echo "numeropuntos ".$numerodepuntos."<br>";*/
			$x0=-round($recta['b']/$recta['m'],1);
			//$escala=floor($x0/10);
			// $xreg=array_values($xarray);
			/*echo "numero puntos  ".$numerodepuntos."<br>";
            echo "x0  ".$x0."<br>";*/
			//calculndo el punto atual en el tiempo
			$ultfecha=strtotime(array_keys($xarray)[count($xarray)-1]);
			$difdias=ceil((time()-$ultfecha)/(24*60*60));
			/* echo "difdias ".$difdias."<br>";
            echo "ulrimo dia  ".array_values($xarray)[count($xarray)-1]."<br>";*/
			$diaactual=array_values($xarray)[count($xarray)-1]+$difdias;
			/*ECHO "DAI ACTUAL  ".$diaactual."<br>";
            ECHO "pendiente  ".$recta['m']."<br>";
            ECHO "residuo  ".$recta['b']."<br>";*/
			$frecuencia=floor(($x0-$diaactual)/$numerodepuntos)-1;
			/*echo "frecuencia   ".$frecuencia."<br>";*/
			$xreg=array();
			$yreg=array();
			//$xreg[]=0;
			//$yreg[] = round ($recta['m']* $xreg[$diaactual] + $recta['b'] , 0 );
			//$yreg[] = round ($recta['m']*$diaactual + $recta['b'] , 0 );
			$yreg[] = (float)($this->cantlibre+0);
			//echo "stock libre ".$yreg[0]."<br>";
			$xreg[]=(int)(round(($yreg[0]-$recta['b'])/$recta['m'],0));
			//echo "dia actual ".$xreg[0]."<br>";
			$diaactual=(int)$xreg[0];
			$i=1;
			//print_r($valores);
			/*echo "<br>";
			echo "fefucncia ".$frecuencia."<br>";
			echo "diaactual ".$diaactual."<br>";
			echo "numeropuntos ".$numerodepuntos."<br>";
			print_r($xreg);
			ECHO " X0  ".$x0;yii::app()->end();*/
			if($frecuencia > 0) //aseguranos de que no haya un bucle infinito
			while($xreg[ $i - 1 ] < $x0) {
				$xreg[] = (int)($xreg[$i-1] +$frecuencia+0);
				$yreg[] = round ( $recta['m'] * $xreg[$i] + $recta['b'] , 0 )+0;
				$i++;
			}

			foreach($xreg as $clave=>$valor){
				$xreg[$clave]=$valor-$diaactual;
			}




//$dospuntos=array(array($x1,round($y1,1)),array($x2,round($y2,1)));
			///devolvemos las ordenadas, absisas y la ecuacion de la recta de regresion
			///todo listo para el grafico



			return array(array_values($xarray),$yarray,$xreg,$yreg);

		}

	}

	/*public static function loadModel($id);
public static function stocklibre_a_reserva($cant);
public static function stocklibre_a_transito($id);
public static function stockreserva_a_libre($id);
public static function stocktransito_a_libre($id);
public static function create();
public static function grabar();
public function getPrimaryKey();*/

	protected  function getControlPrecio() {
		if(!$this->isnewRecord){
			return $this->alinventario_maestrodetalle->{self::NOMBRE_CAMPO_CONTROL_PRECIO};

		}	else 	{
			return self::FLAG_PRECIO_PROMEDIO_VARIABLE;
		}
	}

	public static function create()
	{
		$model = new Alinventario();
		return $model;
	}


	public function getPrimaryKey()
	{
		return $this->id;
	}

	public function grabar()
	{
		$retorno=false;
		if($this->save()){
			//$this->insertamensaje(InventarioUtil::FLAG_SUCCESS,"Se grabo el registro".$this->getPrimaryKey());
			//MiFactoria::Mensaje('success',__CLASS__.'=>'.__FUNCTION__.' Material : '.$this->codart.'   Se Grabó el registro de inventario ');

			$retorno=true;
		} else {
			//$this->insertamensaje(InventarioUtil::FLAG_ERROR,"Hubo un problema al grabar el registro de Inventario :".$this->getPrimaryKey());
			MiFactoria::Mensaje('error',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' Hubo un problema al grabar el registro de inventario ');

			$retorno=false;
		}
		return $retorno;
	}

	public function haystocklibre(){
		return ($this->cantlibre > 0)?true:false;
	}




	public function stocklibre_a_reserva($cant){
		if(InventarioUtil::verificarsignocant($cant)){
			if($this->verificaconsistencia_stock(self::CAMPO_STOCK_LIBRE,$cant)){
				$this->cantlibre-=$cant;
				$this->cantres+=$cant;
				// $this->insertamensaje(InventarioUtil::FLAG_SUCCESS,$this->id." :  Ok,se paso ".$cant."  del stock libre a RESERVA");
				return true;
			} else {
				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,$this->id." :La cantidad que intenta mover es mayo q elk stock libre");
				//MiFactoria::Mensaje('error',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' :La cantidad que intenta Reservar('.$cant.')  es mayor que el  stock libre ('.$this->cantlibre.')  ');

				return false;
			}

			return true;
		} else {
			MiFactoria::Mensaje('error',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' :La cantidad que intenta Reservar('.$cant.')  no es positiva ');

			return false;
		}
	}


	public function  stocklibre_a_transito($cant){
		if(InventarioUtil::verificarsignocant($cant)){
			if($this->verificaconsistencia_stock(self::CAMPO_STOCK_LIBRE,$cant)){
				$this->{self::CAMPO_STOCK_LIBRE}-=$cant;
				$this->{self::CAMPO_STOCK_TRANSITO}+=$cant;
				// $this->insertamensaje(InventarioUtil::FLAG_SUCCESS,$this->id." :  Ok,se paso ".$cant."  del stock libre a RESERVA");
				return true;
			} else {
				MiFactoria::Mensaje('error',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' :La cantidad que intenta trasladar('.$cant.')  es mayor que el  stock libre ('.$this->cantlibre.')  ');
				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,$this->id." :La cantidad que intenta mover es mayo q elk stock libre");
				return false;
			}

			return true;
		} else {
			MiFactoria::Mensaje('error',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' :La cantidad que intenta trasladar('.$cant.')  es negativa');

			return false;
		}
	}

	public function  stocktransito_a_libre($cant){
		if(InventarioUtil::verificarsignocant($cant)){
			if($this->verificaconsistencia_stock(self::CAMPO_STOCK_TRANSITO,$cant)){
				$this->{self::CAMPO_STOCK_TRANSITO}-=$cant;
				$this->{self::CAMPO_STOCK_LIBRE}+=$cant;
				// $this->insertamensaje(InventarioUtil::FLAG_SUCCESS,$this->id." :  Ok,se paso ".$cant."  del stock libre a RESERVA");
				return true;
			} else {
				$this->insertamensaje(InventarioUtil::FLAG_ERROR,$this->id." :La cantidad que intenta mover es mayo q lo del transito");
				MiFactoria::Mensaje('error',__CLASS__.' => '.__FUNCTION__.' No existe suficiente stock ('.$cant.')  de '.$this->getAttributeLabel(self::CAMPO_STOCK_TRANSITO).' :   para mover  al   '.$this->getAttributeLabel(self::CAMPO_STOCK_LIBRE).'       material '.$this->codart );
				return false;
			}

			return true;
		} else {
			MiFactoria::Mensaje('error',__CLASS__.' => '.__FUNCTION__.' lA CANTIDAD ES NEGATIVA' );

			return false;
		}
	}

	public function  stockreserva_a_libre($cant){
		$cant=abs($cant);
			if($this->verificaconsistencia_stock(self::CAMPO_STOCK_RESERVADO,$cant)){
				$this->{self::CAMPO_STOCK_RESERVADO}-=$cant;
				$this->{self::CAMPO_STOCK_LIBRE}+=$cant;
				//Yii::app()->user->setFlash('success', "OK, paso la cantidad ".$cant." de material ".$this->codart." Al  stock libre ");
				//MiFactoria::Mensaje('notice',__CLASS__.' => '.__FUNCTION__."  OK, paso la cantidad ".$cant." de material ".$this->codart." Al  stock libre ");

				// $this->insertamensaje(InventarioUtil::FLAG_SUCCESS,$this->id." :  Ok,se paso ".$cant."  del stock libre a RESERVA");
				return true;
			} else {
				//Yii::app()->user->setFlash('error ', " La cantidad que intenta pasar al stock libre  ".$cant." de material ".$this->codart." no se encuentra reservada ");
				MiFactoria::Mensaje('error',__CLASS__.' => '.__FUNCTION__."  La cantidad  ".$cant." de material ".$this->codart." Que piensa devolver al stock libre no se encuentra en reserva " );

				//$this->insertamensaje(InventarioUtil::FLAG_ERROR,$this->id." :La cantidad que intenta mover es mayo q lo de LA RESERVA");
				return false;
			}

			return true;

	}

	public function getStockCamposAfectadosPrecio() {
		///Mucho cuidado aqui , para evitar confusiones , es mejor leer
		// ESTAS CANTIDAES DESDE UN REGISTRO DIFERENTE AL OBJETO,
		//PARA SEGURARNOS QUE SE LENA CANTIDADES ORIGINALES
		$modeloprueba=Alinventario::model()->findByPk($this->id);
		$cantidadafectada=0;
		foreach($modeloprueba->camposstockafectadosporprecio as $clave=> $valor)
		{
			$cantidadafectada+=(is_null($modeloprueba->{$valor}))?0:$modeloprueba->{$valor};
			//echo "  el campo  :  ".$clave."    el valore  : ".
		}
		unset($modeloprueba);
		return $cantidadafectada;
	}

	public function getStockPrecioEstandar() {
		if(!$this->isnewRecord){
			return $this->alinventario_maestrodetalle->{self::NOMBRE_CAMPO_PRECIO_ESTANDAR};

		}	else 	{
			return 0;
		}
	}

///Solo vale para incrmeento de stocks, cuando sale algo no se actualiza los precios
	public function actualizaprecio($cant,$punitnuevo) {
		if($cant >= 0){
			$cantidadafectada=$this->getStockCamposAfectadosPrecio();

			///Que pasa si la cantidad afectada es  cero
			if( $cantidadafectada==0 ){
				///Aqui no hay mucho porblema
				//MiFactoria::Mensaje('notice',__CLASS__.' => '.__FUNCTION__."  NO HAY STOCK QUE SE AFECTE POR EL PRECIO " );

				//$this->{$campodestino}=$cant;

				if($this->getControlPrecio()==self::FLAG_PRECIO_PROMEDIO_VARIABLE ) {
					$this->{self::NOMBRE_CAMPO_PRECIO_UNITARIO}=$punitnuevo;


				}
				if($this->getControlPrecio()==self::FLAG_PRECIO_ESTANDAR ) {
					///sI ES ESTANDAR SOLO BASTA CON COLOCAR EL NUEVO REP
					//
					//MiFactoria::Mensaje('notice',__CLASS__.' => '.__FUNCTION__."  Es precio ESTANDAR" );
					$this->{self::NOMBRE_CAMPO_PRECIO_ESTANDAR}=$this->getStockPrecioEstandar();
					// Se calcula la difrencia unitaria de precio


					$this->{self::NOMBRE_CAMPO_PRECIO_DIFERENCIA_UNITARIA}=round(($punitnuevo-$this->{self::NOMBRE_CAMPO_PRECIO_ESTANDAR})/$cant,3);
					//MiFactoria::Mensaje('notice',__CLASS__.' => '.__FUNCTION__." ok, SE ACUMULO UNA DIFERENCIA DE PRECIO " );
				}
				return true;
			} else { //aqui si hay chicha
				//$this->{$campodestino}+=$cant;
				///Depende del control de precio
				//MiFactoria::Mensaje('notice',__CLASS__.' => '.__FUNCTION__."  oJO HAY STOCK AFACETADO POR EL PRECIO :  PUNIT NUEVO-> ".$punitnuevo."   CANT-> ".$cant."   CANTIDADAAFECTADA-> ".$cantidadafectada."    PUNITINVENTARIO * CANTIDAD AFECTADA->  ".$this->{self::NOMBRE_CAMPO_PRECIO_UNITARIO}*$cantidadafectada);
				if($this->getControlPrecio()==self::FLAG_PRECIO_PROMEDIO_VARIABLE ) {
					//valor ponderado
					$this->{self::NOMBRE_CAMPO_PRECIO_UNITARIO}=round(($punitnuevo*$cant+$this->{self::NOMBRE_CAMPO_PRECIO_UNITARIO}*$cantidadafectada)/($cant+$cantidadafectada),3);

				}
				if($this->getControlPrecio()==self::FLAG_PRECIO_ESTANDAR ) {
					///sI ES ESTANDAR SOLO BASTA CON COLOCAR EL NUEVO REP
					$this->{self::NOMBRE_CAMPO_PRECIO_ESTANDAR}=$this->getStockPrecioEstandar();
					// Se calcula la difrencia unitaria de precio  OJO NO ES PONDERADO
					$this->{self::NOMBRE_CAMPO_PRECIO_DIFERENCIA_UNITARIA}=round(($punitnuevo-$this->{self::NOMBRE_CAMPO_PRECIO_ESTANDAR})/$cantidadafectada,3);
				}
				return true;
			}

		} else {
			//
			//MiFactoria::Mensaje('notice',__CLASS__.' => '.__FUNCTION__." lA CANTIDAD NO ES PISITIVA " );
			return false;
		}

	}


	public function getMensajes(){
		/*echo " ya hoa que caraqjo vas a decir ";
		print_r($this->mensajes);*/

		return $this->mensajes;
	}




	protected function verificaconsistencia_stock($nombrecampostockorigen, $cant){
		$retorno=false;
		foreach ($this->camposstock as $clave=>$valor ) {
			if($clave==$nombrecampostockorigen){
				if( $this->{$valor} >= $cant ) {
					$retorno=true;
				//	echo " jajajaja lo encontramos :    ".$this->{$valor}."  > ".$cant." <br>";
					break;
				}else  {
					//$this->insertamensaje('error',' No existe suficiente stock de  '.$this->getAttributeLabel($nombrecampostockorigen).' para mover  '.$this->cant.' '.$this->maestro->maestro_ums->desum.'(s) del material '.$this->codart);
					//$this->insertamensaje('error',' No existe suficiente stock de  '.$this->getAttributeLabel($nombrecampostockorigen).' :  '.$this->{$nombrecampostockorigen}.'   para mover  '.$cant.'  '.$this->maestro->maestro_ums->desum.'(s) del material '.$this->codart);
					MiFactoria::Mensaje('error',__CLASS__.'=>'.__FUNCTION__.' No existe suficiente stock de  '.$this->getAttributeLabel($nombrecampostockorigen).' :  '.$this->{$nombrecampostockorigen}.'   para mover  '.$cant.'  '.$this->maestro->maestro_ums->desum.'(s) del material '.$this->codart);
					//echo " ups el stock e smenor <br>";

					$retorno=false;
					break;
				}
			}
			if($retorno)break;
		}

		return $retorno;
	}

	public static function loadModel($id)
	{
		return self::model()->findByPk($id);
	}





 public function actualiza_stock($codmov,$cant,$punitnuevo=null)
 {
	 $retorno=false;
	// echo "salio ";
	 if($cant > 0){
		 $modelomov=Almacenmovimientos::model()->findByPk($codmov);
	   $signo=$modelomov->signo;
		 $campo=$modelomov->campoafectadoinv;
		 $campodestino=$modelomov->campodestino;

           /*echo " signo ....: ". $signo."<br>";
		         echo " campo....: ". $campo."<br>";
		 echo " cant..: ". $cant."<br>";
		 echo " campodestino..: ". $campodestino."<br>";
         yii::app()->end();*/
		 if($modelomov->actualizaprecio=='1')

		 {

			// MiFactoria::Mensaje('notice',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' Este movimiento actualiza precio de inventario    '.$cant.'  - '.$punitnuevo);
			 $this->actualizaprecio($cant,$punitnuevo);
		 }

		 if($signo < 0){
		 	if($this->verificaconsistencia_stock($campo,$cant))
		     {
				// MiFactoria::Mensaje('notice',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' Se ha actualizado el  '.$this->getAttributelabel($campo).'  AGREGADO :'.$signo*$cant);
				//echo "antes  habia :  ".$campo."  --   ". $this->{$campo}."<br>";
				 $this->{$campo}+= $signo*$cant;
				// echo"antes  habia :  ".$campo."  --   ". $this->{$campo}."<br>";

				 $retorno=true;
		     } else {
				$retorno=false;

				echo " verifica osdnsitencioa de sotclk dio  falso <br>  ";
			}
		    } elseif($signo==0){  //// Si es un movimiento entre stocks , no entra ni sale nada
			 		if($this->verificaconsistencia_stock($campo,$cant))
			 		{
						 $this->{$campo}-=$cant;
						 $this->{$campodestino}+=$cant;
						//MiFactoria::Mensaje('notice',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' Se ha MOVIDO  '.$cant.'  de  '.$this->getAttributelabel($campo).'  Al :'.$this->getAttributelabel($campodestino));

						$retorno=true;
			 			}  else {
						$retorno=false;
						echo " verifica osdnsitencioa de sotclk dio  falso <br>  ";
					}
		   }  else { /// Si es un ingreso
			 $this->{$campo}+=$cant;
			 //MiFactoria::Mensaje('notice',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' Se ha INGRESADO  '.$cant.'  A  '.$this->getAttributelabel($campo).'  ');
			 $retorno=true;
		 }

	 } else {
		 //$this->insertamensaje(InventarioUtil::FLAG_ERROR,$this->id." :La cantidad no es positiva, debe de procesarse");
		 MiFactoria::Mensaje('error',__CLASS__.'=>'.__FUNCTION__.' Material '.$this->codart.' La cantidad no es postiva ');
		 $retorno=false;
		// echo " el signo es negativo no jodas ";
	 }
  /*print_r($this->attributes);
	 yii::app()->end();*/

	      if($retorno) {
			 	 $this->setScenario ( self::ESCENARIO_ACTUALIZARSTOCK );
						  if ( ! $this->save () ) {
				  					MiFactoria::Mensaje ( 'error' , __CLASS__ . '=>' . __FUNCTION__ . ' Material ' . $this->codart . ' Hubo un problema al grabar el registro de inventario ' );
				 				    $retorno = false;
							          echo " fallo al grabar <br>";
			  		                } else {
							     $retorno=true;
						  }
		  		} else {
			//  echo "no hay consistencia para actualkziar invnetario";
		  }

   return $retorno;
 }















	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'public_alinventario';
	}
 	/**
	 * @return array validation rules for model attributes.
	 */

	public function afterFind() {


		return parent::afterfind();
	}




	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codalm', 'required','message'=>'Debes de ingresar el almacen', 'on'=>'insert,update'),
				array('codcen', 'required','message'=>'Debes de ingresar el centro', 'on'=>'insert,update'),
				array('codmon', 'required','message'=>'Ingresa la moneda','on'=>'insert,update'),
				array('codart','required','message'=>'Debes de ingresar el material','on'=>'insert,update'),
				//array('codart','unique','message'=>'Este material ya esta registrado','on'=>'insert'),
			array('cantlibre, canttran, cantres', 'numerical','on'=>'insert,update'),
			array('codalm', 'length', 'max'=>3,'on'=>'insert,update'),
			array('periodocontable, codresponsable, codcen', 'length', 'max'=>4,'on'=>'insert,update'),
			array('codart, ubicacion, lote', 'length', 'max'=>10,'on'=>'insert,update'),
			array('ssiduser', 'length', 'max'=>30,'on'=>'insert,update'),
			array('creadopor, creadoel,punit, modificadopor, cantlibre, cantres, modificadoel,codmon, fechainicio, fechafin ', 'safe','on'=>'insert,update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codalm, creadopor, creadoel, modificadopor, modificadoel, fechainicio, fechafin, periodocontable, codresponsable, id, codart, codcen, um, cantlibre, canttran, cantres, ubicacion, lote', 'safe', 'on'=>'search'),
		

				array('cantres,cantlibre,canttran,punit,punitdif','safe','on'=>self::ESCENARIO_ACTUALIZARSTOCK),

					///para carga masiva
			array('id,cantlibre', 'safe','on'=>'cargamasiva'),
			array('id,cantlibre', 'required','message'=>'Validacion de carga masiva ha fallado', 'on'=>'cargamasiva'),
						//array('codcen', 'required','message'=>'Debes de ingresar el centro', 'on'=>'insert,update'),


		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'almacen' => array(self::BELONGS_TO, 'Almacenes', array('codalm'=>'codalm','codcen'=>'codcen')),
			'lotes' => array(self::BELONGS_TO, 'Lotes', 'hidinventario'),
			'cantidadenlotes'=>array(self::STAT,'Lotes','hidinventario','select'=>'SUM(cantsaldo)'),
			'alinventario_maestrodetalle'=> array(self::HAS_ONE, 'Maestrodetalle', array('codal'=>'codalm','codcentro'=>'codcen','codart'=>'codart')),
			'alinventario_centros' => array(self::BELONGS_TO, 'Centros', 'codcen'),
			'alinventario_docompra'=>array(self::BELONGS_TO,'Docompra', array('codalm'=>'codigoalma','codcen'=>'codentro','codart'=>'codart')),
			'alinventario_alkardex_preciomedio'=>array(self::STAT,'Alkardex',array('codart'=>'codart','codalm'=>'alemi','codcen'=>'codcentro'),'select'=>'AVG(preciounit)'),
			'alinventario_alkardex_preciominimo'=>array(self::STAT,'Alkardex',array('codart'=>'codart','codalm'=>'alemi','codcen'=>'codcentro'),'select'=>'MIN(preciounit)'),
			'alinventario_alkardex_preciomaximo'=>array(self::STAT,'Alkardex',array('codart'=>'codart','codalm'=>'alemi','codcen'=>'codcentro'),'select'=>'MAX(preciounit)'),

			'subtotal'=>array(self::STAT, 'Docompra', 'hidguia','select'=>'sum(t.punit*t.cant)'),//el subtotal

		);
	}

	
	
	
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codalm' => 'Almacen',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'fechainicio' => 'Fechainicio',
			'fechafin' => 'Fechafin',
			'periodocontable' => 'Periodo',
			'codresponsable' => 'Codresponsable',
			'id' => 'ID',
			'codart' => 'Material',
			'codcen' => 'Centro',
		//	'um' => 'Um',
			'punit'=>'Prec Unit',
			'pttotal'=>'Prec Total',
			'cantlibre' => 'Stock Libre',
			'canttran' => 'Stock trans',
			'cantres' => 'Stock Reser',
			'ubicacion' => 'Ubicacion',
			'lote' => 'Lote',
			'siid' => 'Siid',
			'ssiduser' => 'Ssiduser',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codalm',$this->codalm,true);

		$criteria->compare('fechainicio',$this->fechainicio,true);
		$criteria->compare('fechafin',$this->fechafin,true);
		$criteria->compare('periodocontable',$this->periodocontable,true);
		$criteria->compare('codresponsable',$this->codresponsable,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codcen',$this->codcen,true);
		//$criteria->compare('um',$this->um,true);
		$criteria->compare('cantlibre',$this->cantlibre);
		$criteria->compare('canttran',$this->canttran);
		$criteria->compare('cantres',$this->cantres);
		$criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('lote',$this->lote,true);
		$criteria->compare('siid',$this->siid,true);
		$criteria->compare('codmon',$this->codmon,true);
		$criteria->compare('punit',$this->punit,true);
		$criteria->compare('ssiduser',$this->ssiduser,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getTotal($provider)
	{
		$total=0;
		foreach($provider->data as $data)
		{
			$t = $data->punit*$data->cantlibre;
			$total += $t;
		}
		return $total;
	}

	public  static function encontrarregistro($centro,$almacen,$codigo)
	{
		$criteria=new CDbCriteria;
		$criteria->addcondition("codcen=:vcodcen",'AND');
		$criteria->addcondition("codalm=:vcodalm",'AND');
		$criteria->addcondition("codart=:vcodart");
		$criteria->params=Array(":vcodcen"=>trim($centro),":vcodalm"=>trim($almacen),":vcodart"=>trim($codigo));
		$registro=self::model()->find($criteria);
		if (is_null($registro))
		throw new CHttpException(500,__CLASS__.'--'. __FUNCTION__.'--'.__LINE__.'   No existe inventario para  '.$centro.'--'.$almacen.'--'.$codigo);

		return $registro;

	}







	public function gettipostock($codigomovimiento){
		//$tipostock=array();
		switch ($codigomovimiento) {
			case '98': ///(+) Stock libre: Carga inicial , se incrementara el stock libre
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
													"stock_libre"=>"cantlibre",
													"stock_reservado"=>"cantres",
													"stock_en_transito"=>"canttran",
				                               )
				                   );

				break;
			case '99':
				array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);



				break;
			case '10': //(-) Stock reservado : salida reserva  , disminuira el stock reservado

				return array("campoafectadocantidad"=>"cantres",
					           "camposafectadosprecio"=>array() //Elsacar materiales NO afecta precios
				              );
				break;
			case '20': //(+) Stock reservado : Anular vale de salida reserva, se incrementara el stock reservado
				//return "cantres";
				return array("campoafectadocantidad"=>"cantres",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			case '30':///(+) Stock libre: Ingreso por compra, compra normal se incrementara el stock libre
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			case '40': ///(-) Stock Libre: Anular ingreso por compra; compra normal se saca del stock libre
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array()
				);
				break;


			case '50': ///(-) Stock libre : Salida para ceco, se saca del stock libre
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array()
				);
				break;

			case '60': //(+) Stock libre: anular salida para ceco, se incrementa el stock libre
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			case '70': //(+)Stock libre : Reingreso de material, se incrementa el stock libre ,
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			case '77': //(-)Stock libre : disminuye el stock libre y aumenta el stock en Transito ,
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					),
					   "campodestino"=>"canttran",
				);
				break;

			case '78': //  INGRESA TRASLADO
			         // (+)Stock libre : Aumenta el stock libre y disminuye  el stock en Transito del inventario del otro almacen,
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					),


				);
				break;

			case '80': //(+)Stock reservado:  Anukar salida reserva, se incrementa el stock reservado
				return array("campoafectadocantidad"=>"cantres",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;
			case '90': //(-)Stock en transito:  Envio por traslado : se saca el stock en transito
				//return "canttra";
				return array("campoafectadocantidad"=>"canttran",
					        "camposafectadosprecio"=>array()
				          );
				break;
			case '10': //(-)Stock libre : Reserva para Traslado a otro almacen  : Se  saca del stock libre y se coloca en el stock en rtansito
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array()
				);
				break;
			case '11': //(+) Stock libre :  Ingreso por traslado  de otro almacen, se incrementa el stock libre
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			default:
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;
		}

	}


	public function distribuyecantidades($codigomovimiento){
		//$tipostock=array();
		switch ($codigomovimiento) {
			case '98': ///(+) Stock libre: Carga inicial , se incrementara el stock libre
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);

				break;
			case '99':
				array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);



				break;
			case '10': //(-) Stock reservado : salida reserva  , disminuira el stock reservado

				return array("campoafectadocantidad"=>"cantres",
					"camposafectadosprecio"=>array() //Elsacar materiales NO afecta precios
				);
				break;
			case '20': //(+) Stock reservado : Anular vale de salida reserva, se incrementara el stock reservado
				//return "cantres";
				return array("campoafectadocantidad"=>"cantres",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttra",
					)
				);
				break;

			case '30':///(+) Stock libre: Ingreso por compra, compra normal se incrementara el stock libre
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			case '40': ///(-) Stock Libre: Anular ingreso por compra; compra normal se saca del stock libre
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array()
				);
				break;


			case '50': ///(-) Stock libre : Salida para ceco, se saca del stock libre
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array()
				);
				break;

			case '60': //(+) Stock libre: anular salida para ceco, se incrementa el stock libre
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			case '70': //(+)Stock libre : Reingreso de material, se incrementa el stock libre ,
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			case '77': //(-)Stock libre : Traslado de materiales desde el almacen emisor, disminuye el stock libre ,
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;


			case '80': //(+)Stock reservado:  Anukar salida reserva, se incrementa el stock reservado
				return array("campoafectadocantidad"=>"cantres",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;
			case '90': //(-)Stock en transito:  Envio por traslado : se saca el stock en transito
				//return "canttra";
				return array("campoafectadocantidad"=>"canttran",
					"camposafectadosprecio"=>array()
				);
				break;
			case '10': //(-)Stock libre : Reserva para Traslado a otro almacen  : Se  saca del stock libre y se coloca en el stock en rtansito
				//return "cantlibre";
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array()
				);
				break;
			case '11': //(+) Stock libre :  Ingreso por traslado  de otro almacen, se incrementa el stock libre
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;

			default:
				return array("campoafectadocantidad"=>"cantlibre",
					"camposafectadosprecio"=>array(
						"stock_libre"=>"cantlibre",
						"stock_reservado"=>"cantres",
						"stock_en_transito"=>"canttran",
					)
				);
				break;
		}

	}


	/* Esta funcion es de uso general sirve como capa
	para obtener el precio de stock unitario de un material*/
	public static function preciostock($centro,$almacen,$codigo,$um) {
		return self::model()->findByAttributes(array('codalm'=>$almacen,'codcen'=>$centro,'codart'=>$codigo))->punit*Alconversiones::convierte($codigo,$um);
	}




	public function Actualizar($movimiento,$cantidad,$unidad,$punitario=null)
			{
				//obtenemos el signo del movimiento
				$signo=Almacenmovimientos::model()->findByPk($movimiento)->signo;
				$conversion=Alconversiones::convierte($this->codart,$unidad);
				$this->cantidadmovida=$signo*abs($conversion)*abs($cantidad);
				$mensajitoinv="";
				//$nombrecampostock_a=gettipostock($movimiento)
					$nombrecampo_stock_a_incrementar_o_disminuir=$this->gettipostock($movimiento)['campoafectadocantidad'];
				      $nombrecampo_stock_destino=$this->gettipostock($movimiento)['campodestino'];
				    $array_campos_afectados_precio=
				    $array_campos_stock_afectados_por_precio=$this->gettipostock($movimiento)['camposafectadosprecio'];


				///Pero de que stock moveremos ?, eso se lo dejamos a la funcion gettipostock() del modelo
				$stock_a_incrementar_o_disminuir=$this->{$nombrecampo_stock_a_incrementar_o_disminuir};  //es el stock que se va a ver (+) o (-)
				// con el movimeintos  puede ser EL VALOR DE CUALQUIER  DE ESTOS CAMPOS, SEGUN EL MOVEIMIENTO

				      /*  STOCK RESERVADO    "CANTRES";
				       STOCK EN TRANSITO   "CANTTRAN",
				       STOCK LIBRE  "CANTLIBRE",
				  */

				///LA SUMA DE STOCKS AFECTADOS POR EL PRECIO VIENE ASER  LA SUAM DE LOS STOCKS CON LOS QUE SE DIVIDIRA LA SUMA DE LOS PONDERADOS DE CANTIDADES Y PRECIOS
				$suma_de_stocks_afectados_por_el_precio=0;
				   foreach( $array_campos_stock_afectados_por_precio as $key=>$valor ) {
					   $suma_de_stocks_afectados_por_el_precio+=$this->{$valor};
				   }



				// con el movimeintos  puede ser EL VALOR DE CUALQUIER  DE ESTOS CAMPOS, SEGUN EL MOVEIMIENTO

				      /*  STOCK RESERVADO    "CANTRES";
				       STOCK EN TRANSITO   "CANTTRAN",
				       STOCK LIBRE  "CANTLIBRE",
				  */
				//verificando la consistencia del movimiento
				//para estop verificamos que los que se quiere mover (En este caso solo "quitar")
				// no es mayor que el stock  arrojado por GETTIPOSTOCK(),
				//if($signo==-1){  ///Si es un movimieto que va a sacar cosas del almacen
					if( ($signo==-1) and  (abs($this->cantidadmovida) > $stock_a_incrementar_o_disminuir)   ) { //si lo que quiere es sacar hay que analizar bien  de que movimeitno se trata
						 	$mensajitoinv=$mensajitoinv."<br> Esta intentado sacar ".$this->cantidadmovida."  (".$this->maestro->um." s) del material ".$this->codart." Pero en ". $this->getAttributeLabel($nombrecampo_stock_a_incrementar_o_disminuir) ." solo hay ".$stock_a_incrementar_o_disminuir."   Verifique bien ";
					} else {  //En otro caso proceder
						//actualizamos la cantidad y el precio unitario
						//$this->cantlibre=$this->cantlibre+$this->cantidadmovida;
						//ECHO "CANTIDAD MOVIDA ".$cantidadmovida."  \N";
						//Yii::app()->end();
						//Buscamos el precio unitario
						  ///Verificando el comportamiento del precio del material en este centro y este almacen
							$controlprecio=$this->alinventario_maestrodetalle->controlprecio;
							  if(is_null($controlprecio) or empty($controlprecio) or trim($controlprecio)=='') {
								  $mensajitoinv=$mensajitoinv."<br> El material  ".$this->codart."  No tiene registrado el control de precio en el centro  ".$this->codcen." , y almacen  ".$this->codalm."  Verifique los datos maestros ";

							  } else {
								  if(is_null($punitario)){  ///Si  es nulo quiere decir que no es  dato   y debemos jalra el precio del mismo  inventario
										     if($suma_de_stocks_afectados_por_el_precio>0 ) {   //Si hay stock se toma el valor del inventario del mismo
									                                      $punitario=$this->punit;
								                                     } else { /// ups... pero q pasa si no hay stock
									                                       if($controlprecio=='V') {
									                                              $mensajitoinv=$mensajitoinv."<br> Para el material  ".$this->codart."  No tiene stocks sensibles  en el centro  ".$this->codcen." , y almacen  ".$this->codalm." y no se ha suminsitrado el precio unitario en el movimiento, no es posible asignar un precio ";
												                                 } else { /// Si es ESTANDAR  'S' , CABALLEOR NOMAS SE RESPETA EL QUE SE EUCNEUTRAEN  INVENITARIO ASI NO HAYA STOCK
														                         $punitario=$this->punit;
													                             }
								                                  }
								               }
										  if($controlprecio=='V') {
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " <br>";
										  echo " CALCULO DEL PRECIO UNITARIO  :  Ppreciounitario x Pcantidad   x conversion :    (". $punitario.")  x (".$cantidad.") x ( ".$conversion.")  :    ".$punitario*$cantidad*$conversion."<br>";
										  echo "   this->punit x suma de stocks afectados  : (". $this->punit.")  x (".$suma_de_stocks_afectados_por_el_precio.")  : ".$this->punit*$suma_de_stocks_afectados_por_el_precio." <br>";
										  echo "  vsuma_de_stocks_afectados_por_el_precio  +  this--cantidadmovida (denominador) : ".$suma_de_stocks_afectados_por_el_precio." +  ".$this->cantidadmovida."     :". ($suma_de_stocks_afectados_por_el_precio + $this->cantidadmovida)."   <br>";
										  $this->punit=abs(( abs($punitario*$cantidad*$conversion)+$this->punit*$suma_de_stocks_afectados_por_el_precio)/($suma_de_stocks_afectados_por_el_precio + abs($this->cantidadmovida))); //da
										  echo " Al final se calcula el precio unitario asi: ( abs(vpunitario*vcantidad*vconversion)+ vthis->punit*vsuma_de_stocks_afectados_por_el_precio   )/(vsuma_de_stocks_afectados_por_el_precio + abs(vthis->cantidadmovida))) :   ". $this->punit."  <br>";

									  }

								    ///Si es "S" estandar actualiuzar solo el campo de  la diferencia unitaria
								      if($controlprecio=='S')
									    $this->punitdif= $this->cantidadmovida*($punitario-$this->punit)  /($suma_de_stocks_afectados_por_el_precio+$this->cantidadmovida);//ntidadmovida


								 $this->montomovido= $punitario*$cantidad*$conversion;

								               $this->{$nombrecampo_stock_a_incrementar_o_disminuir}=$stock_a_incrementar_o_disminuir + $this->cantidadmovida;
								          //OBSERVE QUE EN EL CASO QUE SEA UN MOVIMIETO QUE REQUIERA TRASLADAR UN TIPO DE STOCK A OTRO EN EL MISMO ALMACEN
								          //POR EJEMPLO SEPARAR MATERIALES PARA UN TRASLADO  (CANTLIBRE -> CANTTRAN)
								             if(!is_null($nombrecampo_stock_destino))
											 $this->{$nombrecampo_stock_destino}=$this->{$nombrecampo_stock_destino} - $this->cantidadmovida;


								  echo "convenrsion  :". $conversion." <br>";
								   echo "cantidad movida  $ this->cantidadmovida  :  ". $this->cantidadmovida." <br>";

								  echo "monto movido $ this->montomovido :   ".$this->montomovido." <br>";
								  echo "nombrecampo a incrementar o disminuir $ nombrecampo_stock_a_incrementar_o_disminuir  : ". $nombrecampo_stock_a_incrementar_o_disminuir." <br>";
								  echo "Stockq ue cambia    (". $nombrecampo_stock_a_incrementar_o_disminuir.") : ".$this->{$nombrecampo_stock_a_incrementar_o_disminuir}." <br>";
								  echo "suma de stocks  afectados por precio  : ".$suma_de_stocks_afectados_por_el_precio."    <br>";
								   echo "precio unitario   $ this->punit   ". $this->punit." <br>";
								  echo "precio unitario dif  $ this->punitdif : ". $this->punitdif." <br>";
								   echo " movimiento (Dato del kardex) : ". $movimiento." <br>";
								  echo "cantidad  (Dato del kardex) :".$cantidad." <br>";
								  echo "unidad  (Dato del kardex): ". $unidad." <br>";
								  echo "preciounit (Dato del kardex)  : ".$punitario." <br>";
								  echo "Finalmente queda ASI <br>";
								  echo "$ this->cantlibre :".$this->cantlibre." <br>";
								  echo "$ this->cantres :".$this->cantres." <br>";
								  echo "$ this->canttran :".$this->canttran." <br>";
								  echo "$ this->cantlibre :".$this->cantlibre." <br>";
								  echo "$ this->punit :".$this->punit." <br>";
								  echo "$ this->punitdif :".$this->punitdif." <br>";
								  echo "$ idkardex :".$idkardex." <br>";
								//  Yii::app()->end();
								 //  $row->codmov,$row->cant,$row->um,$row->preciounit


							 ///Fin del CASE SITCW Del movimiento
							  }  //Fin del else : Es un material que tiene control de precio




					  }
				//}

             return $mensajitoinv;
			}

	public static function getTotalcant($provider)
	{
		$total=0;
		foreach($provider->data as $data)
		{
			$t = $data->cantlibre;
			$total += $t;
		}
		return $total;
	}

	public function search_por_codigo($codigo)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codalm',$this->codalm,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('fechainicio',$this->fechainicio,true);
		$criteria->compare('fechafin',$this->fechafin,true);
		$criteria->compare('periodocontable',$this->periodocontable,true);
		$criteria->compare('codresponsable',$this->codresponsable,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codcen',$this->codcen,true);
		//$criteria->compare('um',$this->um,true);
		$criteria->compare('cantlibre',$this->cantlibre);
		$criteria->compare('canttran',$this->canttran);
		$criteria->compare('cantres',$this->cantres);
		$criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('lote',$this->lote,true);
		$criteria->compare('siid',$this->siid,true);
		$criteria->compare('codmon',$this->codmon,true);
		$criteria->compare('punit',$this->punit,true);
		$criteria->compare('ssiduser',$this->ssiduser,true);
		$criteria->addcondition("codart='".$codigo."'");


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getcadenacampos(){
		$cadenacampos="";
		foreach($this->camposstock as $clave=>$valor){
			$cadenacampos.="+a.".$valor;

		}
		return substr($cadenacampos,1);
	}

	public function getsumas(){
		$cadenasumas="";
		foreach($this->camposstock as $clave=>$valor){
			$cadenasumas.=", sum(a.".$valor.") as ".$valor." , sum((a.".self::NOMBRE_CAMPO_PRECIO_UNITARIO."+".self::NOMBRE_CAMPO_PRECIO_DIFERENCIA_UNITARIA.")*(a.".$valor.")*b.cambio ) as stock_".$valor;
		           }
		$cadenasumas.=", sum(".$this->getcadenacampos().") as cant_total,sum((a.".self::NOMBRE_CAMPO_PRECIO_UNITARIO."+".self::NOMBRE_CAMPO_PRECIO_DIFERENCIA_UNITARIA.")*(".$this->getcadenacampos().")*b.cambio) as stock_total";
		return substr($cadenasumas,1);
	}

}