<?php

/**
 * This is the model class for table "{{valorimpuestos}}".
 *
 * The followings are the available columns in table '{{valorimpuestos}}':
 * @property integer $id
 * @property string $hcodimpuesto
 * @property string $valor
 * @property string $finicio
 * @property string $ffinal
 *
 * The followings are the available model relations:
 * @property Impuestos $hcodimpuesto0
 */
class Valorimpuestos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{valorimpuestos}}';
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hcodimpuesto, valor, finicio, ffinal', 'required'),
			array('hcodimpuesto', 'length', 'max'=>3),
			array('activo', 'checkactivo'),
			array('finicio,ffinal','checkfechas'),
			array('valor', 'length', 'max'=>6),
			array('valor','numerical','min'=>0,'max'=>99,'message'=>' Este valor esta fuera del rango'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hcodimpuesto, valor, finicio,activo, ffinal', 'safe', 'on'=>'search'),
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
			'impuesto' => array(self::BELONGS_TO, 'Impuestos', 'hcodimpuesto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hcodimpuesto' => 'Hcodimpuesto',
			'valor' => 'Valor',
			'finicio' => 'Finicio',
			'ffinal' => 'Ffinal',
		);
	}

	public function getfechafinmax($codimpuesto){
		$valormax=yii::app()->db->createCommand()
			->select('max(ffinal)')->
			from($this->tableName())->
			where("hcodimpuesto='".trim($codimpuesto)."'")
			->queryScalar();
		return ($valormax!=false)?$valormax:'1000-01-01';

	}

	public function getfechainimax($codimpuesto){
		$valormax=yii::app()->db->createCommand()
			->select('max(finicio)')->
			from($this->tableName())->
			where("hcodimpuesto='".trim($codimpuesto)."'")
			->queryScalar();
		return ($valormax!=false)?$valormax:'1000-01-01';

	}

	//para ver si es el valordel impuesto  vigente a la fecha por medio de las fechas
	public function isActive(){
		return (!$this->isnewRecord and  Yii::app()->periodo->HoyDentroDe($this->finicio,$this->ffinal));

	  }


	public function AfterSave() {
		$this->refresh();
		if($this->activo=='1')
			$this->activacion($this->hcodimpuesto);

		return parent::afterSave();
	}


	public function beforeSave() {

		if(!$this->activo=='1')
			$this->activo=='0';
		return parent::beforeSave();
	}

	//para ver si es el valordel impuesto  vigente a la fecha por medio de las fechas
public function activacion($codimpuesto){

		yii::app()->db->createCommand()
			->update($this->tableName(),
				array("activo"=>'0'),
				"id <> :vid AND hcodimpuesto=:vcodigo",
				array(":vid"=>$this->id,":vcodigo"=>trim($codimpuesto)));
      return 1;
	}

	///evuelve el valrodel impuesto activo
	public static function getimpuesto($codimpuesto){
		$criteria=New CDBCriteria;
		$criteria->addcondition(" finicio <= '".date('Y-m-d')."' AND ffinal >= '".date('Y-m-d')."' AND activo='1' and hcodimpuesto= '".$codimpuesto."'");
		//$criteria->addcondition(" activo='1' ");
		//$criteria->params=array(" :vfactual "=>date('Y-m-d')," :vfactual2 "=>date('Y-m-d'));

		$registro=self::model()->find($criteria);
		if(is_null($registro ))
			throw new CHttpException(500,__CLASS__.'--'. __FUNCTION__.'--'.__LINE__.'   El impuesto '.Impuestos::model()->findByPk($codimpuesto)->descripcion.'  No se ha actualizado a la fecha , pro favor actualizarlo  ');


		///vwrificando que este enporcentaje




		      return $registro->valor/100;
	}






	public function checkfechas($attribute,$params) {
	if(!Yii::app()->periodo->verificaFechas($this->finicio,$this->ffinal))
		$this->adderror('ffinal',' La fecha final es menor que la fecha de Inicio');

	}


	public function checkactivo($attribute,$params) {
		 if($this->activo=='1' and !Yii::app()->periodo->HoyDentroDe($this->finicio,$this->ffinal))
			 $this->adderror('activo','No puede activar este impuesto la fecha actual esta fuera de rango de fechas');

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
		$criteria->compare('hcodimpuesto',$this->hcodimpuesto,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('valor',$this->valor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Valorimpuestos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
