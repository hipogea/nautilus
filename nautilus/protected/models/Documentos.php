<?php

/**
 * This is the model class for table "documentos".
 *
 * The followings are the available columns in table 'documentos':
 * @property string $coddocu
 * @property string $desdocu
 * @property string $clase
 * @property string $tipo
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $coddocupadre
 * @property string $tabla
 * @property integer $anuladesde
 * @property string $cactivo
 * @property string $abreviatura
 */
class Documentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Documentos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public static function documentopadre($codocuhijo){

		$documentohijo=self::model()->find("coddocu=:vcodocuhijo",array(":vcodocuhijo"=>$codocuhijo));
		if(!is_null($documentohijo))
		{
			$documentopadre=self::model()->findBypK($documentohijo->coddocupadre);
		}else{
			$documentopadre=null;
		}
		return $documentopadre;
	}

	public static function documentohijo($codocupadre){

		return self::model()->find("coddocupadre=:vpadre",array(":vpadre"=>$codocupadre));

	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{documentos}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('coddocu', 'required'),
			array('desdocu,prefijo', 'required'),
			//array('anuladesde', 'numerical', 'integerOnly'=>true),
			array('coddocu, coddocupadre', 'length', 'max'=>3),
			array('coddocu', 'length', 'max'=>3),
			array('coddocu', 'required'),
			array('coddocu', 'length', 'min'=>3),
			array('coddocu', 'unique'),
			array('coddocu', 'match', 'pattern'=>Yii::app()->params['mascaradocs'],'message'=>'El codigo  no es el correcto, El c debe comenzar por 2 DIGITOS  > 0 y los caracteres deben ser numericos','on'=>'insert'),

			array('x_report,y_report,idreportedefault,comprobante', 'safe'),
			array('desdocu', 'length', 'max'=>45),
			array('clase, cactivo', 'length', 'max'=>1),
			array('prefijo', 'length', 'max'=>3),
			array('prefijo', 'length', 'min'=>3),
			array('tipo', 'length', 'max'=>2),
			//array('creadopor, modificadopor', 'length', 'max'=>25),
			//array('creadoel, modificadoel', 'length', 'max'=>20),
			//array('tabla', 'length', 'max'=>50),
			array('abreviatura', 'length', 'max'=>5),
			array('prefijo', 'unique', 'message'=>'Este prefijo ya esta en Uso, coloca otro'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('coddocu, desdocu, clase, tipo, creadopor, creadoel, modificadopor, modificadoel, coddocupadre, tabla, anuladesde, cactivo, abreviatura', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'coddocu' => 'Codigo',
			'desdocu' => 'Documento',
			'clase' => 'Clase',
			'tipo' => 'Tipo',
			'creadopor' => 'Creado por',
			'creadoel' => 'Creado el',
			'modificadopor' => 'Modificado por',
			'modificadoel' => 'Modificado el',
			'coddocupadre' => 'Doc Padre',
			'tabla' => 'Tabla',
			'anuladesde' => 'Anuladesde',
			'cactivo' => 'Cactivo',
			'abreviatura' => 'Abreviatura',
		);
	}

	public function suggestcod($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'desdocu LIKE :keyword',
			'order'=>'desdocu',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		//$suggest=array(JSON_ENCODE($models[0]),'KFSHFKSIY');
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->codigo.' - '.$model->desdocu,  // label for dropdown list
				'value'=>$model->codigo,  // value for input field
				//'id'=>$model->id,       // return values from autocomplete
				//'code'=>$model->code,
				//'call_code'=>$model->call_code,
			);
		}
		
		return $suggest;
	}

	public static function Prefijo($documento){
		$modelin=self::model()->find('coddocu=:vcd',array(':vcd'=>$documento));
		if(!is_null($modelin)){
			return $modelin->prefijo;
		}else {
			throw new CHttpException(404,__CLASS__.'   '.__FUNCTION__.' El prefijo no existe para este documento');
		}

	}


	public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									    $this->creadopor=Yii::app()->user->name;
										// $this->creadoel=Yii::app()->user->name;
									  //  $this->coddocu=Numeromaximo::numero($this->model(),'coddocu','maximovalor',3);
										//$this->cod_estado='01';
											//$this->c_salida='1';
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

		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('coddocupadre',$this->coddocupadre,true);
		$criteria->compare('tabla',$this->tabla,true);
		$criteria->compare('anuladesde',$this->anuladesde);
		$criteria->compare('cactivo',$this->cactivo,true);
		$criteria->compare('abreviatura',$this->abreviatura,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_tipo()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->addcondition("clase='D'");
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('coddocupadre',$this->coddocupadre,true);
		$criteria->compare('tabla',$this->tabla,true);
		$criteria->compare('anuladesde',$this->anuladesde);
		$criteria->compare('cactivo',$this->cactivo,true);
		$criteria->compare('abreviatura',$this->abreviatura,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}