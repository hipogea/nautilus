<?php

/**
 * This is the model class for table "alconversiones".
 *
 * The followings are the available columns in table 'alconversiones':
 * @property integer $id
 * @property string $um1
 * @property string $um2
 * @property double $numerador
 * @property double $denominador
 * @property string $codart
 *
 * The followings are the available model relations:
 * @property Maestrocomponentes $codart0
 * @property Ums $um10
 * @property Ums $um20
 */
class Alconversiones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Alconversiones the static model class
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
		return 'public_alconversiones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numerador, denominador', 'numerical'),
			array('numerador, um2, denominador', 'required','message'=>'Dato obligatorio'),
			array('um1', 'compare', 'compareAttribute'=>'um2','operator'=>'!=', 'message'=>'Las unidades de medida son iguales'),
			array('numerador', 'compare', 'compareAttribute'=>'denominador','operator'=>'!=', 'message'=>'La conversion debe de tener valores distintos '),
			array('codart+um2', 'application.extensions.uniqueMultiColumnValidator','on'=>'insert,update'),
			//array('codpro+codart+um+centro', 'application.extensions.uniqueMultiColumnValidator','on'=>'insert'),

			array('um1, um2', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, um1, um2, numerador, denominador, codart', 'safe', 'on'=>'search'),
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
			'alconversiones_maestrocompo' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'alconversiones_um1' => array(self::BELONGS_TO, 'Ums', 'um1'),
			'alconversiones_um2' => array(self::BELONGS_TO, 'Ums', 'um2'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'um1' => 'Unidad base',
			'um2' => 'Unidad alternativa',
			'numerador' => 'Numerador',
			'denominador' => 'Denominador',
			'codart' => 'Codigo',
		);
	}


//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									   // $this->creadopor=Yii::app()->user->name;
										//$this->codigo=Numeromaximo::numero($this->model(),'correl','maximovalor',6,'codtipo');
										//$this->codigo='34343434';
								//$this->um1=$this->alconversiones_maestrocompo->um;
								//$this->codart=$this->alconversiones_maestrocompo->codigo;
									
									} else
									{
										
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
									}
									return parent::beforeSave();
				}
	
	

  public static function convierte($codmaterial, $unidad,$unidad2=NULL) {
  			$modelomateriales=Maestrocompo::model()->findByPk(trim($codmaterial));
  			if (!is_null($modelomateriales)) {
				   IF(is_null($unidad2)){
					   if($unidad==$modelomateriales->um) { //se trata de la unidad de medida base
						   return 1;

					   } else { //hay conversiones
						   $registro=self::model()->find("codart=:codigo and um2=:unitas",array(":codigo"=>$codmaterial,":unitas"=>$unidad));
						   if(!is_null($registro) ){
							   //efectuar la conversion

							   return round($registro->numerador/$registro->denominador,3); //Se tiene que multiplicar al revers
						   } else {
							   return 1;
							   // throw new CHttpException(404,' No se encontraron conversiones para la unidad de medida especificada '.$unidad.' para este material : ' .$codmaterial);

						   }
					   }
				   } else {

					   if($unidad==$unidad2){
						   return 1;
					   }else {
						   if($unidad==$modelomateriales->um)
							   return 1/self::convierte($codmaterial,$unidad2);
						   if($unidad2==$modelomateriales->um)
							   return self::convierte($codmaterial,$unidad);

						   ///convirtiendo  a la unidad  $unidad primero
						  return self::convierte($codmaterial,$unidad)/self::convierte($codmaterial,$unidad2);




					   }
				   }

  			} else {

  					throw new CHttpException(404,'Error en conversiones de unidades, Este codigo de material no existe : ' .$codmaterial);
  			}

  }





	/* ESTA FUNCION DEVUELVE  el array de LAS CONVERSIONE SPARA HACER EL LISBOX DE LAS um
	Si no tine solo devuel el array de launida de medida base */
	public static function devuelveconversiones($codmaterial) {
		$datos = CHtml::listData(Ums::model()->findAll(),'um','desum');
		$modelomateriales=Maestrocompo::model()->findByPk(trim($codmaterial));
		if (!is_null($modelomateriales)) {
			if($unidad==$modelomateriales->um) { //se trata de la unidad de medida base
				return 1;

			} else { //hay conversiones
				$registro=self::model()->findAll("codart=:codigo and um2=:unitas",array(":codigo"=>$codmaterial,":unitas"=>$unidad));
				if(!is_null($registro) ){
					//efectuar la conversion

					return $registro->numerador/$registro->denominador; //Se tiene que multiplicar al revers
				} else {
					throw new CHttpException(404,' No se encontraron conversiones para la unidad de medida especificada '.$unidad.' para este material : ' .$codmaterial);

				}
			}
		} else {

			throw new CHttpException(404,'Error en conversiones de unidades, Este codigo de material no existe : ' .$codmaterial);
		}

	}



	public static function Listadoums ($codigo){
		$valores=array();
		$codigo=MiFactoria::cleanInput($codigo);
		$filamaterial=Maestrocompo::model()->findByPk($codigo);
		if(!is_null($filamaterial)) {

			$filas=self::model()->findAll("codart=:vcodigo",ARRAY(":vcodigo"=>$codigo));
			foreach($filas as $fila){
				$valores[$fila->um2]=$fila->alconversiones_um2->desum;
							}
			$valores[$filamaterial->um]=$filamaterial->maestro_ums->desum;


		}else {

		}
		return $valores;
	}







	public static function validaum($codart,$um){

		if(in_array($um,array_keys(self::Listadoums($codart)))){
			$retorno=true;
		} else {
			$retorno=false;
		}
           //var_dump(self::Listadoums($codart));
		return $retorno;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('um1',$this->um1,true);
		$criteria->compare('um2',$this->um2,true);
		$criteria->compare('numerador',$this->numerador);
		$criteria->compare('denominador',$this->denominador);
		$criteria->compare('codart',$this->codart,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_material($codigo)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('um1',$this->um1,true);
		$criteria->compare('um2',$this->um2,true);
		$criteria->compare('numerador',$this->numerador);
		$criteria->compare('denominador',$this->denominador);
		//$criteria->compare('codart',$this->codart,true);
		$criteria->addcondition("codart='".$codigo."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}