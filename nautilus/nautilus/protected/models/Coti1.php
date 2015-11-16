<?php

/**
 * This is the model class for table "coti".
 *
 * The followings are the available columns in table 'coti':
 * @property string $numcot
 * @property string $codpro
 * @property string $fecdoc
 * @property string $codcon
 * @property string $codestado
 * @property string $texto
 * @property string $textolargo
 * @property string $tipologia
 * @property string $moneda
 * @property string $orcli
 * @property integer $descuento
 * @property string $usuario
 * @property string $coddocu
 * @property string $creado
 * @property string $modificado
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $codtipofac
 * @property string $codsociedad
 * @property string $codgrupoventas
 * @property string $codtipocotizacion
 * @property integer $validez
 * @property string $codcentro
 * @property double $nigv
 * @property string $codobjeto
 * @property string $fechapresentacion
 * @property string $fechanominal
 * @property string $idguia
 * @property string $tenorsup
 * @property string $tenorinf
 * @property double $montototal
 *
 * The followings are the available model relations:
 * @property Contactos $codpro0
 * @property Grupocompras $codgrupoventas0
 * @property Sociedades $codsociedad0
 * @property Tipofacturacion $codtipofac0
 * @property Contactos $codcon0
 * @property Tenores $coddocu0
 * @property TMoneda $moneda0
 * @property Tenores $tenorsup0
 */
class Coti extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Coti the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'coti';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codpro, fecdoc, codcon, tipologia, moneda, codtipofac, codsociedad, codgrupoventas,
			 codtipocotizacion, validez, codcentro, idguia', 'required'),
			array('descuento, validez', 'numerical', 'integerOnly'=>true),
			array('nigv, montototal', 'numerical'),
			array('numcot', 'length', 'max'=>8),
			array('codpro', 'length', 'max'=>6),
			array('codcon', 'length', 'max'=>5),
			array('codestado, codtipofac', 'length', 'max'=>2),
			array('texto', 'length', 'max'=>40),
			array('tipologia, codsociedad, codtipocotizacion, tenorsup, tenorinf', 'length', 'max'=>1),
			array('moneda, coddocu, codgrupoventas, codcentro, codobjeto', 'length', 'max'=>3),
			array('orcli', 'length', 'max'=>12),
			array('usuario', 'length', 'max'=>35),
			array('creado, modificado, creadoel, modificadoel', 'length', 'max'=>20),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('textolargo, fechapresentacion, fechanominal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('numcot, codpro, fecdoc, codcon, codestado, texto, textolargo, tipologia, moneda, orcli, descuento, usuario, coddocu, creado, modificado, creadopor, creadoel, modificadopor, modificadoel, codtipofac, codsociedad, codgrupoventas, codtipocotizacion, validez, codcentro, nigv, codobjeto, fechapresentacion, fechanominal, idguia, tenorsup, tenorinf, montototal', 'safe', 'on'=>'search'),
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
			'codpro0' => array(self::BELONGS_TO, 'Contactos', 'codpro'),
			'codgrupoventas0' => array(self::BELONGS_TO, 'Grupocompras', 'codgrupoventas'),
			'codsociedad0' => array(self::BELONGS_TO, 'Sociedades', 'codsociedad'),
			'codtipofac0' => array(self::BELONGS_TO, 'Tipofacturacion', 'codtipofac'),
			'codcon0' => array(self::BELONGS_TO, 'Contactos', 'codcon'),
			'coddocu0' => array(self::BELONGS_TO, 'Tenores', 'coddocu'),
			'moneda0' => array(self::BELONGS_TO, 'TMoneda', 'moneda'),
			'tenorsup0' => array(self::BELONGS_TO, 'Tenores', 'tenorsup'),
			'clientes' => array(self::BELONGS_TO, 'Clipro', 'copro'),
		);
	}

		public function checkvalores($attribute,$params) {
	   //verificando que se a el unico 
	    	//Comporbando si existen valores en los matchcodes
			
			//En el modelo cliente
			$modeloprueba=Clipro::model()->find("codpro=:micodpro",array(":micodpro"=>is_null($this->codpro)?'':$this->codpro)) ;
			 if (is_null($modeloprueba )) {
			    			$this->adderror('codpro','Este cliente no existe');										
												} else {
										$modeloprueba2=ObjetosClientes::model()->find("codpro=:micodpro and codobjeto=:miobjeto",array(":micodpro"=>is_null($this->codpro)?'':$this->codpro), ":miobjeto"=>is_null($this->codobjeto)?'':$this->codobjeto)) ;
			 								if (is_null($modeloprueba2 )) //si no encuentra ninigun objeto en el cliente seleccionao
			 										$this->adderror('codobjeto','Esta referencia no existe');				
												}




		public function valorespordefecto(){ 
						//Vamos a cargar los valores por defecto
						$matriz=VwOpcionesdocumentos::Model()->search_d('011')->getData();
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
						
						




	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'numcot' => 'Numcot',
			'codpro' => 'Codpro',
			'fecdoc' => 'Fecdoc',
			'codcon' => 'Codcon',
			'codestado' => 'Codestado',
			'texto' => 'Texto',
			'textolargo' => 'Textolargo',
			'tipologia' => 'Tipologia',
			'moneda' => 'Moneda',
			'orcli' => 'Orcli',
			'descuento' => 'Descuento',
			'usuario' => 'Usuario',
			'coddocu' => 'Coddocu',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'codtipofac' => 'Codtipofac',
			'codsociedad' => 'Codsociedad',
			'codgrupoventas' => 'Codgrupoventas',
			'codtipocotizacion' => 'Codtipocotizacion',
			'validez' => 'Validez',
			'codcentro' => 'Codcentro',
			'nigv' => 'Nigv',
			'codobjeto' => 'Codobjeto',
			'fechapresentacion' => 'Fechapresentacion',
			'fechanominal' => 'Fechanominal',
			'idguia' => 'Idguia',
			'tenorsup' => 'Tenorsup',
			'tenorinf' => 'Tenorinf',
			'montototal' => 'Montototal',
		);
	}





	public function beforeSave() {
							if ($this->isNewRecord) {
									
									//buscano el igv
									$this->nigv=Igv::model()->findByPk(1)->valor;
									//
									$this->codestado='99';
									$this->coddocu='011';
									$this->fecdoc=date("Y-m-d");


									///$this->usuario=Yii::app()->user->name;
											
									  
										//	$this->c_salida='1';
											//$command = Yii::app()->db->createCommand(" select nextval('sq_guias') "); 											
											//$this->n_guia= $command->queryScalar();
											//$this->c_estgui='99'; //para que no lo agarre la vista VW-GUIA  HASTA QUE GRABE TODO EL DETALLE
									} else
									{
										//  IF ($this->c_estgui=='99') //SI SE TRATA DE UNA GUIA NUEVA COLOCARLE 'PREVIO'
												//$this->c_estgui='01';gv
												  
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

		$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('fecdoc',$this->fecdoc,true);
		$criteria->compare('codcon',$this->codcon,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('tipologia',$this->tipologia,true);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('orcli',$this->orcli,true);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codtipofac',$this->codtipofac,true);
		$criteria->compare('codsociedad',$this->codsociedad,true);
		$criteria->compare('codgrupoventas',$this->codgrupoventas,true);
		$criteria->compare('codtipocotizacion',$this->codtipocotizacion,true);
		$criteria->compare('validez',$this->validez);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('nigv',$this->nigv);
		$criteria->compare('codobjeto',$this->codobjeto,true);
		$criteria->compare('fechapresentacion',$this->fechapresentacion,true);
		$criteria->compare('fechanominal',$this->fechanominal,true);
		$criteria->compare('idguia',$this->idguia,true);
		$criteria->compare('tenorsup',$this->tenorsup,true);
		$criteria->compare('tenorinf',$this->tenorinf,true);
		$criteria->compare('montototal',$this->montototal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}