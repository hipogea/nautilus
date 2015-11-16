<?php

class Maestrocompo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Maestrocompo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	public function behaviors()
	{
		return array(
			// Classname => path to Class
			'ActiveRecordLogableBehavior'=>
				'application.behaviors.ActiveRecordLogableBehavior',
		);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'public_maestrocomponentes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('codigo', 'required'), 
			array('codigo, codpadre', 'length', 'max'=>8),
			array('um', 'required', 'message'=>'Llena la unidad de medida'),
			array('codtipo', 'required', 'message'=>'Tienes que indicar el tipo'),
			array('marca, modelo, nparte', 'length', 'max'=>35),
			array('um', 'length', 'max'=>3),
			array('descripcion', 'length', 'max'=>40),
			array('descripcion', 'required', 'message'=>'Debes de llenar la descripcion'),
			array('descripcion', 'length', 'min'=>5),
			array('clase', 'length', 'max'=>50),
			array('codmaterial', 'length', 'max'=>16),
			array('codean', 'length', 'max'=>14),
			array('flag', 'length', 'max'=>1),
			array('codtipo', 'length', 'max'=>2),
			array('um','checkvalores','on'=>'update'),
			//array('esrotativo','checkrotativo','on'=>'update'),
			//array('detalle', 'safe'),
			array('codcent,alam,escompletar,codigox,um,esrotativo','safe','on'=>'insert,update'),
			array('codcent,alam', 'required','message'=>'Llene estos valores ','on'=>'update'), ///veriicar que no ingresen cuaklqueir cochinada
			array('codcent,alam', 'checkalmacen', 'on'=>'update'), ///veriicar que no ingresen cuaklqueir cochinada
			array('codcent,alam', 'checkalmacen', 'required','message'=>'Dato obligatorio','on'=>'update'), ///veriicar que no ingresen cuaklqueir cochinada

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codigo, marca, modelo, nparte, um, descripcion,esrotativo,  codtipo', 'safe', 'on'=>'update'),
			array('codigo, marca, modelo, nparte, codpadre, um, descripcion, detalle, clase, codmaterial, flag, codtipo', 'safe', 'on'=>'search'),
		);
             //Escenario para cargar


	}


public function FileReceptor($fullFileName,$userdata) {
        // userdata is the same passed via widget config.
 		$path_parts = pathinfo($fullFileName);
	   /*VAR_DUMP($fullFileName);
	  yii::app()->end();*/
 		if (rename($fullFileName,$path_parts['dirname'].DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] )) {
 				$ruta_imagen = $fullFileName;
								$miniatura_ancho_maximo = 200;
								$miniatura_alto_maximo = 200;
								$info_imagen = getimagesize($path_parts['dirname'].DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension']);
								$imagen_ancho = $info_imagen[0];
									$imagen_alto = $info_imagen[1];
										$imagen_tipo = $info_imagen['mime'];
$proporcion_imagen = $imagen_ancho / $imagen_alto;
$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

if ( $proporcion_imagen > $proporcion_miniatura ){
	$miniatura_ancho = $miniatura_ancho_maximo;
	$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
} else if ( $proporcion_imagen < $proporcion_miniatura ){
	$miniatura_ancho = $miniatura_ancho_maximo * $proporcion_imagen;
	$miniatura_alto = $miniatura_alto_maximo;
} else {
	$miniatura_ancho = $miniatura_ancho_maximo;
	$miniatura_alto = $miniatura_alto_maximo;
}


										switch ( $imagen_tipo ){
												case "image/jpg":
												case "image/jpeg":
														$imagen = imagecreatefromjpeg($path_parts['dirname'].DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] );
														break;
												case "image/png":
														$imagen = imagecreatefrompng( $path_parts['dirname'].DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] );
															break;
												case "image/gif":
													$imagen = imagecreatefromgif( $path_parts['dirname'].DIRECTORY_SEPARATOR.$userdata.'.'.$path_parts['extension'] );
													break;
															}
													
$lienzo = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );

imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);

	
													imagejpeg($lienzo,$path_parts['dirname'].DIRECTORY_SEPARATOR.$userdata.'.JPG', 50);
unlink($fullFileName);
 																	} else {
 			
 														}

    }

	public static function subeimagen($archivo,$dato){
		self::FileReceptor($archivo,$dato);
		RETURN 1;
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'maestro_desolpe' => array(self::HAS_MANY, 'Desolpe', 'codart'),
			'maestro_maestrotipos'=>array(self::BELONGS_TO, 'Maestrotipos', 'codtipo'),
			'maestro_alkardex' => array(self::HAS_MANY, 'Alkardex', 'codart'),
			'maestro_docompra' => array(self::HAS_MANY, 'Docompra', 'codart'),
			'maestro_alconversiones' => array(self::HAS_MANY, 'Alconversiones', 'codart'),
			'maestro_centros'=>array(self::BELONGS_TO, 'Centros', 'codcent'),
			'maestro_ums'=>array(self::BELONGS_TO, 'Ums', 'um'),
			'maestro_almacenes'=>array(self::BELONGS_TO, 'Almacenes', 'alam'),
			'numeroitems_desolpe'=>array(self::STAT, 'Desolpe', 'codart'),//el campo foraneo
			'numeroitems_alkardex'=>array(self::STAT, 'Alkardex', 'codart'),//el campo foraneo
			'numeroitems_docompra'=>array(self::STAT, 'Docompra', 'codart'),//el campo foraneo

			'tieneconversiones'=>array(self::STAT, 'Alconversiones', 'codart'),//el campo foraneo
			'stocktotal'=>array(self::STAT, 'Alinventario', 'codart','select'=>'sum(cantlibre+cantres+canttran)'),//el campo foraneo
			//'stocka'=>array(self::STAT, 'Alinventario', 'codart','select'=>'sum(cantlibre+cantres+canttran)'),//el campo foraneo

			'tienecompras'=>array(self::STAT, 'Docompra', 'codart'),//el campo foraneo
			'tienecomprasd'=>array(self::STAT, 'Docomprat', 'codart'),//el campo foraneo
			'tienesolpe'=>array(self::STAT, 'Desolpe', 'codart'),//el campo foraneo
			'tienekardex'=>array(self::STAT, 'Alkardex', 'codart'),//el campo foraneo

			'numeroitems_docompra'=>array(self::STAT, 'Docompra', 'codart'),//el campo foraneo



		);
	}

public function checkvalores($attribute,$params) {
 if($this->sepuedecambiarum()){
		} else {
		 $this->adderror('um','No es posible cambiar la unidad de medida, este material ya fue usado con la unidad de medida base original ');

	 }
			}


	public function checkrotativo($attribute,$params) {
	if($this->sepuedecambiarrotativo()){
		} else {
			$this->adderror('esrotativo','No es posible cambiar el comportamiento rotativo de este material, Hay documentos abiertos que lo usan, epsere a que se completen y el stock debe ser cero ');
		}
	}




	public function valorespordefecto(){
		//Vamos a cargar los valores por defecto
		$matriz=VwOpcionesdocumentos::Model()->search_d('901')->getData();
		//recorreindo la matriz

		$i=0;

		for ($i=0; $i <= count($matriz)-1;$i++) {
			if ($matriz[$i]['tipodato']=="N" ) {
				$this->{$matriz[$i]['campo']}=!empty($matriz[$i]['valor'])?$matriz[$i]['valor']+0:'';
			}ELSE {
				$this->{$matriz[$i]['campo']}=!empty($matriz[$i]['valor'])?$matriz[$i]['valor']:'';

			}

		}
		return 1;
	}








public function checkalmacen($attribute,$params) {

	  if (Almacenes::model()->find("codalm =:xcodalm and  codcen=:xcodcen",array(":xcodalm"=>$this->alam,":xcodcen"=>$this->codcent))==null)
	  	$this->adderror('alam','Este almacen no corresponde a este centro');
	   

			}

public $codcent;
public $alam;
public $escompletar;
public $codigox;


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigo' => 'Codigo',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'nparte' => 'Nparte',
			'codpadre' => 'Codpadre',
			'um' => 'Um',
			'codean'=>'Cd. EAN',
			'detalle' => 'Detalle',



			'clase' => 'Clase',
			'codmaterial' => 'Codmaterial',
			'descripcion' => 'Descripcion',
			'flag' => 'Flag',
			'codtipo' => 'Codtipo',
			'id' => 'ID',
		);
	}


public function Sepuedecambiarum() {
	if(!$this->isNewRecord){
		//Si ha habido cambios en la unidad de medida
		if($this->oldattributes['um'] <> $this->um)  {

		//Debemos de verificar si existe alguyn documento comprpmetido
						if($this->esmateriallibre()) {
									return true;


							         }else {
			 					           return false;
									}
			  return true;

		} else {
			return true;
		}

	} else {
		return true;
	}

}


	public function esmateriallibre(){
        $inventario=new Alinventario();
		if(!$this->isNewRecord){
		if($inventario->getStockMatTotal($this->codigo)['cant_total']==0 and   ///si hay stock en algun lado, de cualquier tipo
		$this->tienecompras==0 and ///si se ha incluido en las compras
		$this->tienecomprasd==0 and  ///si alguien en este momento esta haciendonuna OC, copne ste material
		$this->tienesolpe==0 //and ///si se ha incluido en las compras			 //se ha incluido en las compras
		) 	{
			return TRUE;
		 }else 	{
			return FALSE;
		}

		}else 	{
						return true;
		}

	}

	public function esmateriallibrecentro($centro){
		$inventario=new Alinventario();
        if(!$this->isNewRecord){
			if($inventario->getstockTotalmaterialCentro($this->codigo,$centro)==0 and   ///si hay stock en algun lado, de cualquier tipo
				$this->tienecompras==0 and ///si se ha incluido en las compras
				$this->tienecomprasd==0 and  ///si alguien en este momento esta haciendonuna OC, copne ste material
				$this->tienesolpe==0 //and ///si se ha incluido en las compras			 //se ha incluido en las compras
			) 	{
				return TRUE;
			}else 	{
				return FALSE;
			}

		}else 	{
			return true;
		}

	}





	public function Sepuedecambiarrotativo() {
		if(!$this->isNewRecord){
			//Si ha habido cambios en la unidad de medida
			if($this->oldattributes['esrotativo'] <> $this->esrotativo)  {
                  //echo "veroifico cambio de esrotativo";
				//Debemos de verificar si existe alguyn documento comprpmetido
				if($this->esmateriallibre()) {
					return true;


				}else {
					return false;
				}
				return true;

			} else {
				return true;
			}

		} else {
			return true;
		}

	}



		
/**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
	public function suggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'descripcion LIKE :keyword',
			'order'=>'descripcion',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		//$suggest=array(JSON_ENCODE($models[0]),'KFSHFKSIY');
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->codigo.' - '.$model->um.' - '.$model->descripcion,  // label for dropdown list
				'value'=>$model->descripcion,  // value for input field
				//'id'=>$model->id,       // return values from autocomplete
				//'code'=>$model->code,
				//'call_code'=>$model->call_code,
			);
		}
		
		return $suggest;
	}

	
	public function suggestcod($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'descripcion LIKE :keyword',
			'order'=>'descripcion',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		//$suggest=array(JSON_ENCODE($models[0]),'KFSHFKSIY');
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->codigo.' - '.$model->um.' - '.$model->descripcion,  // label for dropdown list
				'value'=>$model->codigo,  // value for input field
				//'id'=>$model->id,       // return values from autocomplete
				//'code'=>$model->code,
				//'call_code'=>$model->call_code,
			);
		}
		
		return $suggest;
	}
	
	public function Muestrainventario(){


		
	}
	
	/**
	 * Suggests a list of existing fullnames matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching fullnames
	 */
	public function legacySuggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		foreach($models as $model)
			$suggest[]=$model->name.' - '.$model->code.' - '.$model->call_code.'|'.$model->name.'|'.$model->code.'|'.$model->call_code;
		return $suggest;
	}
	
	
	
	public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									    //$this->creadopor=Yii::app()->user->name;
								        $this->codocu='901';

								        //Si es un tipo de material que hereda el atributo ROTATIVO
								    ///eNOTOICES COLOCARLO AUTOMATRICAMENTE
								       if(Maestrotipos::model()->findBypK($this->codtipo)->esrotativo=='1')
								        $this->esrotativo='1';

										//$g=new Numeromaximo;
										$this->codigo=Numeromaximo::numero($this,'correl','maximovalor',6,'codtipo');
										//$this->codigo='34343434';
									
									} else
									{
										
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
									}
									return parent::beforeSave();
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

		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('nparte',$this->nparte,true);
		$criteria->compare('codpadre',$this->codpadre,true);
		$criteria->compare('um',$this->um,true);
		//$criteria->compare('descripcion',$this->descripcion,TRUE);
		$criteria->compare('detalle',$this->detalle,true);
		//$criteria->compare('modificadopor',$this->modificadopor,true);
		//$criteria->compare('modificadoel',$this->modificadoel,true);
		//$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('esrotativo',$this->esrotativo,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('codmaterial',$this->codmaterial,true);
		$criteria->compare('flag',$this->flag,true);
		$criteria->compare('codtipo',$this->codtipo,true);
		$criteria->compare('id',$this->id);
		$criteria->addcondition(" descripcion like '%".$this->descripcion."%' ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_window()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('nparte',$this->nparte,true);
		$criteria->addcondition(" descripcion like '%".$this->descripcion."%' ");


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
				'pageSize' => 100,
			),
		));
	}



}