<?php

class Cajachica extends ModeloGeneral
{
	const ESTADO_DETALLE_CAJA_CREADO='10';

	const ESTADO_DETALLE_CAJA_ANULADO='20';
	const ESTADO_DETALLE_CAJA_CERRADO='30';
	const ESTADO_CAJA_CREADO='10';
	const ESTADO_CAJA_CERRADO='20';
	const ESTADO_CAJA_ANULADO='30';
	const ESTADO_CAJA_CONFIRMADO='40';
	const CODIGO_DOC='40';
	//const TIPO_DE_FLUJO_A_RENDIR='102';



	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cajachica}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidperiodo,descripcion, fechaini,serie, fechafin, hidfondo, valornominal,codtra,codarea', 'required','message'=>'Este dato es obligatorio', 'on'=>'insert, update'),
			array('descripcion,liquidada,hidfondo,serie, hidperiodo, fechaini,valornominal, fechafin, codtra, codarea,codcen, iduser', 'safe', 'on'=>'insert,udpate'),
			array('serie','checksepuedeabrir','on'=>'insert'),
			array('fechaini, fechafin','checkfechas','on'=> 'insert,update'),
			array('hidperiodo, iduser', 'numerical', 'integerOnly'=>true),
			array('codtra, codcen', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descripcion,liquidada,hidfondo, hidperiodo, fechaini, fechafin, codtra, codarea,codcen, iduser', 'safe', 'on'=>'search'),
		);
	}

	public function checkfechas($attribute,$params) {
		if( !Yii::app()->periodo->verificaFechas($this->fechaini,$this->fechafin))
			$this->adderror('fechaini','La fecha de inicio es mayor que la fecha de finalizacion');

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'dcajachicas' => array(self::HAS_MANY, 'Dcajachica', 'hidcaja'),
			'fondo' => array(self::BELONGS_TO, 'Fondofijo', 'hidfondo'),
			'periodo' => array(self::BELONGS_TO, 'Periodos', 'hidperiodo'),
			'trabajadores' => array(self::BELONGS_TO, 'Trabajadores', 'codtra'),
			'estado'=> array(self::BELONGS_TO, 'Estado', array('codestado'=>'codestado', 'codocu'=>'codocu')),
			'monto_rendido' => array(self::STAT, 'Dcajachica', 'hidcaja','select'=>'sum(t.debe)','condition'=>" codestado in ('".ESTADO_DETALLE_CAJA_CERRADO."') "),
			 'hijospendientes'=>array(self::STAT, 'Dcajachica', 'hidcaja','condition'=>" codestado in ('".ESTADO_DETALLE_CAJA_PREVIO."','".ESTADO_DETALLE_CAJA_CREADO."') "),//el campo
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(

			'hidperiodo' => 'Periodo',
			'fechaini' => 'F inicio',
			'fechafin' => 'F Finaliz',
			'codtra' => 'Responsable',
			'codcen' => 'Centro',
			'codarea' => 'Area',


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
		$criteria->compare('hidperiodo',$this->hidperiodo);
		$criteria->compare('fechaini',$this->fechaini,true);
		$criteria->compare('fechafin',$this->fechafin,true);
		$criteria->compare('codtra',$this->codtra,true);

		$criteria->compare('iduser',$this->iduser);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	public function checksepuedeabrir($attribute,$params) {
$devolver=false;
		$valorultimo=Yii::app()->db->createCommand()
			->select('max(a.id)')
			->from('{{cajachica}} a')
			->where(' a.serie=:vserie and codestado <>:vanulado and codestado  ',array(":vserie"=>$this->serie,":vanulado"=>ESTADO_CAJA_ANULADO))
			->queryScalar();
		if($valorultimo!=false){
				///anualizamo esta caja
			$cajaanterior=Cajachica::model()->findBypK((int)$valorultimo);
			if ($cajaanterior->hijospendientes ==0 )
				$devolver=false;

		}else{
			$devolver=true; //se puede abrir no hay registro anteriores
		}
if(!$devolver)
	$this->adderror('serie'," Aun existe una caja en esta serie pendiente de liquidar  ");
	}










	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cajachica the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public $maximovalor;
//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones
	public function beforeSave() {
		if ($this->isNewRecord) {
            $this->codestado=self::ESTADO_CAJA_CREADO;
			$this->codocu=self::CODIGO_DOC;
		} else
		{

			/* echo "saliop carajo";	//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
            */
		}
		return parent::beforesave();
	}


}