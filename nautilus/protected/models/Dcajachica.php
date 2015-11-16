<?php

class Dcajachica extends ModeloGeneral
{
const ESTADO_DETALLE_CAJA_ANULADO='30';
const ESTADO_DETALLE_CAJA_CREADO='10';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dcajachica}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidcaja, fecha, glosa, monto,monedahaber,referencia, debe,tipoflujo,  codtra, ceco,  codocu', 'safe'),
			array('fecha', 'checkfecha','on'=>'insert,update'),
			array('fecha', 'checkfecha_detalle','on'=>'upd_rencidiontrabajador,ins_rendiciontrabajador'),
			//array('tipoflujo', 'checkflujo','on'=>'upd_rencidiontrabajador,ins_rendiciontrabajador'),
			array('hidcaja, fecha, glosa, referencia, debe, tipoflujo,  codtra, ceco,  codocu', 'required'),
			array('hidcaja, iduser', 'numerical', 'integerOnly'=>true),
			array('glosa, referencia', 'length', 'max'=>60),
			array('debe, haber, saldo', 'length', 'max'=>10),
			array('monedahaber, codocu', 'length', 'max'=>3),
			array('codtra', 'length', 'max'=>4),
			array('ceco', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidcaja, fecha, glosa, referencia, tipoflujo, debe, haber, monedahaber, saldo, codtra, ceco, fechacre, iduser, codocu', 'safe', 'on'=>'search'),
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
			'documentos' => array(self::BELONGS_TO, 'Documentos', 'codocu'),
			'cabecera' => array(self::BELONGS_TO, 'Cajachica', 'hidcaja'),
			'trabajadores' => array(self::BELONGS_TO, 'Trabajadores', 'codtra'),
			'estado'=> array(self::BELONGS_TO, 'Estado', array('codestado'=>'codestado', 'coddocu'=>'codocu')),			
			'cco' => array(self::BELONGS_TO, 'VwImputaciones', 'ceco'),
			'moneda' => array(self::BELONGS_TO, 'Monedas', 'codmon'),
			'flujos' => array(self::BELONGS_TO, 'Tipoflujocaja', 'tipoflujo'),
		);
	}

	public function checkfecha($attribute,$params) {
     $fechainicio=Cajachica::model()->findByPk($this->hidcaja)->fechaini;
		$fechafin=Cajachica::model()->findByPk($this->hidcaja)->fechafin;
		if(!yii::app()->periodo->estadentrodefechas($fechainicio,$this->fecha,$fechafin))
			$this->adderror('Fecha','Esta fecha no esta dentro del perido de la cabecera ');

	}

	public function checkfecha_detalle($attribute,$params) {

		$fecharegistro=Dcajachica::model()->findByPk($this->hidcargo)->fecha;
		if(!yii::app()->periodo->verificaFechas($fecharegistro,$this->fecha))
			$this->adderror('c_numgui','Esta fecha es anterior a la entrega de dinero ');

	}

	public static function getMonto($proveedor){
		$totalplan=0;
		foreach($proveedor->data as $data)
		{
			if($data->codestado <> self::ESTADO_DETALLE_CAJA_ANULADO){

				$totalplan += $data->monto;
			}
		}
		return $totalplan;
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidcaja' => 'Hidcaja',
			'fecha' => 'Fecha',
			'glosa' => 'Glosa',
			'referencia' => 'Referencia',
			'debe' => 'Debe',
			'haber' => 'Haber',
			'monedahaber' => 'Monedahaber',
			'saldo' => 'Saldo',
			'codtra' => 'Codtra',
			'ceco' => 'Ceco',
			'fechacre' => 'Fechacre',
			'iduser' => 'Iduser',
			'codocu' => 'Codocu',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidcaja',$this->hidcaja);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('glosa',$this->glosa,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('debe',$this->debe,true);
		$criteria->compare('haber',$this->haber,true);
		$criteria->compare('monedahaber',$this->monedahaber,true);
		$criteria->compare('saldo',$this->saldo,true);
		$criteria->compare('codtra',$this->codtra,true);
		$criteria->compare('ceco',$this->ceco,true);
		$criteria->compare('fechacre',$this->fechacre,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('codocu',$this->codocu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_por_caja($idcabecera)
	{

		$criteria=new CDbCriteria;

		$criteria->addcondition("hidcaja=".$idcabecera."  and hidcargo IS NULL ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_por_cargo_a_rendir($idcabecera,$idparent)
	{

		$criteria=new CDbCriteria;

		$criteria->addcondition("hidcaja=".$idcabecera."  and hidcargo= ".$idparent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_por_trabajador($codigo)
	{

		$criteria=new CDbCriteria;

		$criteria->addcondition("codtra='".$codigo."'  ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	///verifica que ningun otro usuario modifiaue o trate tu caja cabecera
	private function isPropietariocaja(){
		return ($this->cabecera->codtra==yii::app()->user->um->getFieldValue(yii::app()->user->id,'codtra'))?true:false;
	}


	public function isTratable(){
		return (in_array($this->codestado,array(ESTADO_CREADO)) and $this->isPropietariocaja())?true:false;
	}


	private function tieneHijos(){
		if($this->tipoflujo==TIPO_DE_FLUJO_A_RENDIR)
		{
			$criteriax=New CDbcriteria;
			$criteriax->addCondition(" hidcargo=:vcargo AND hidcaja=:vhidcaja  ");
			$criteriax->params=array(":vcargo"=>$this->id ,":vhidcaja"=>$this->hidcaja);
			return (count(Dcajachica::model()->findAll($criteriax))>0)?true:false;
		}else{
			return false;
		}
	}

	public function tieneHijospendientes(){
		$sepuede=true;
		if($this->tieneHijos())
		{
			$criteriaxy=New CDbcriteria;
			$criteriaxy->addCondition(" hidcargo=:vcargo AND hidcaja=:vhidcaja  ");
			$criteriaxy->params=array(" :vcargo"=>$this->id ,":vhidcaja"=>$this->hidcaja);
			foreach (Dcajachica::model()->findAll($criteriaxy) as $fila){
				if(in_array($fila->codestado,array(ESTADO_CREADO)))
				{
					$sepuede=false;
					break;
				}
			}
		}else{
			$sepuede= false;
		}
		return $sepuede;
	}


	public function esEditable(){
		if($this->isTratable()){
			 if($this->tieneHijos())
			 {
				 return false;
			 }else  {
				return true;
			 }
		}ELSE {
			RETURN false;
		}

	}


	public function borra(){
		//Primero veriifcansdo si es usuario propietario
		$mensaje="";
		   if($this->isPropietariocaja()){

			   if($this->isTratable())
			    {
					if(!$this->tieneHijos())
					{

						$this->delete();

					}else {
						$mensaje.="  Este registro tiene rendiciones hijas <br>";
					}


			     }else {
				   $mensaje.="  Este registro no se puede borrar porque tiene estado '.$this->estado->estado  <br>";
			   }

		   } else {
			   $mensaje.="  Para borrar el registro debe estar registrado como Empleado  <br>";
		   }
          return $mensaje;
	}






	public function beforeSave() {
		if ($this->isNewRecord) {

			if($this->tipoflujo <> '102')
			$this->haber=$this->debe;
			
			  
		} else
		{

			/* echo "saliop carajo";	//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
            */
		}
		
		if($this->monedahaber==yii::app()->params['monedabase']){
			   $this->monto=$this->haber;
			}else{
			   $this->monto=$this->debe*MiFactoria::TipoCambio($this->monedahaber,yii::app()->params['monedabase']);
			}
		
		
		
		return parent::beforesave();
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dcajachica the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}