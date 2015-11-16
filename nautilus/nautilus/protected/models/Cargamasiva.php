<?php

/**
 * This is the model class for table "cargamasiva".
 *
 * The followings are the available columns in table 'cargamasiva':
 * @property integer $id
 * @property string $modelo
 * @property integer $iduser
 * @property string $fechacreac
 * @property string $fechaejec
 * @property string $insercion
 * @property string $descripcion
 */
class Cargamasiva extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	 
	 public $ruta;
	public function tableName()
	{
		return '{{cargamasiva}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('modelo', 'length', 'max'=>100),
			array('insercion', 'length', 'max'=>1),
			array('insercion', 'safe'),

			array('fechacreac,escenario,iduser,insercion, fechaejec, descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, modelo, iduser, fechacreac, fechaejec, insercion, descripcion', 'safe', 'on'=>'search'),
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
	
		'detalle'=>array(self::HAS_MANY, 'Cargamasivadet', 'hidcarga', 'order'=>'orden ASC'),
		'numeroerrores'=>array(self::STAT, 'Logcargamasiva', 'hidcarga', 'select'=> 'COUNT(id)', 'condition'=>"level='0'",),
		'numeroitems'=>array(self::STAT, 'Cargamasivadet', 'hidcarga'),//el campo foraneo
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'modelo' => 'Modelo',
			'iduser' => 'Iduser',
			'fechacreac' => 'Fechacreac',
			'fechaejec' => 'Fechaejec',
			'insercion' => 'Insercion',
			'descripcion' => 'Descripcion',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechacreac',$this->fechacreac,true);
		$criteria->compare('fechaejec',$this->fechaejec,true);
		$criteria->compare('insercion',$this->insercion,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cargamasiva the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
		public function afterSave() {
				
		if ($this->isNewRecord) {
			        
             /*  $model=new Inventario();
		$objeto=$model->getMetaData();
		foreach($objeto->columns as $columna)
		{
			echo "campo  ".$columna->name."    ancho ".$columna->size."  el tipo  : ".$columna->dbType."<br>";

		}
		print_r($objeto->columns);*/
		       $this->iduser=yii::app()->user->id;

					}else{
						 	
						  if($this->numeroitems==0) 
						  {
							  $cadena="\$modeloatratar=new ".$this->modelo."('".$this->escenario."');";
							
							
							  eval($cadena);
							  
							 $campos= $modeloatratar->getMetaData();
							 
							  //$modeloatratar->setScenario($this->escenario);
							    //echo "el escanrio de   es :  ".$modeloatratar->getScenario();
								// Yii::app()->end();
							  //$campos=$this->getMetaData();
									foreach( $campos->columns as $columna)
									{
										if($modeloatratar->isAttributeSafe(trim($columna->name))) {
										      //verificando si no se agregado antes 
													     $registro=Cargamasivadet::model()->find("hidcarga=:vcarga and 
																								nombrecampo=:vnombrecampo",
																								array(
																								   ':vcarga'=>$this->id,
																								   ':vnombrecampo'=>trim($columna->name)
																								   )
																								);
															if(is_null($registro)){
																$registro=new Cargamasivadet;
																	$registro->nombrecampo=trim($columna->name);
																	$registro->hidcarga=$this->id;
																	$registro->aliascampo=trim($this->getAttributelabel($columna->name));
																	if( $modeloatratar->isAttributeRequired($columna->name)) 																	
																		$registro->requerida = '1';
																		$registro->activa = '1';																		
																		$registro->longitud =(is_null( $columna->size) or trim($columna->size.'')=='')?20:$columna->size;																		
																		$registro->tipo = $columna->dbType;
																	
																		$registro->tipo = $columna->dbType;
																	$registro->save();
															    }	
										   }
										  
										   /*
											
											$validadores=$modeloatratar->getValidators();
											var_dump($validadores);
											yii::app()->end();
											$modcargadet->activa=$modeloatratar->rules();
											//$modcargadet->requerida=;*/
							  
								   }
						    }
						   
						  
						  

				}
		
		return parent::aftersave();
	}
	
		public function beforeSave() {
				
		if ($this->isNewRecord) {
		       $this->iduser=yii::app()->user->id;

					}else{
						 

				}
		
		return parent::beforeSave();
	}
	
	
}
