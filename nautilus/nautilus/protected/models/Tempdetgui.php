<?php

class Tempdetgui extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tempdetgui}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		////escenarios
		///INS_LIBRE
		///INS_AF
		///INS_NUEVO


		///UPD_LIBRE
		///UPD_AF
		///UPD_NUEVO





		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			///PARA TODOS LOS ESCENARIOS
			array('c_codep', 'required','message'=>'Sin referencia'),
			array('c_edgui', 'required','message'=>'Llene el destino'),

			array('c_descri', 'length', 'max'=>40),
			array('c_descri', 'length', 'min'=>10),
			array('c_descri', 'required','message'=>'Sin descripcion'),


			//ESCENARIO DE ACTIVO FIJO //
			array('c_codactivo,n_cangui,c_itguia,c_descri,c_um,c_edgui,c_codep','safe','on'=>'INS_ACTIVO,UPD_ACTIVO'),
			array('c_codactivo', 'exist','allowEmpty' => false,'attributeName' => 'codigoaf', 'className' => 'Inventario','message'=>'Este códIgo de activo no existe', 'on'=>'INS_ACTIVO,UPD_ACTIVO'),
			array('c_codactivo', 'match', 'pattern'=>'/90-3[1-5]{1}00-[0-9]{5}/','message'=>'El codigo de placa no es el correcto', 'on'=>'INS_ACTIVO,UPD_ACTIVO'),
			array('n_cangui', 'required', 'message'=>'La cantidad', 'on'=>'INS_ACTIVO,UPD_ACTIVO'),
			array('c_codactivo','checkmovimiento','on'=>'INS_ACTIVO,UPD_ACTIVO'),
			array('modo', 'required','message'=>'Llene el modo','on'=>'INS_ACTIVO,UPD_ACTIVO'),
			//array('c_codactivo','cargodevolver','on'=>'INS_ACTIVO','UPD_ACTIVO'),
			array('c_codactivo','checkcantidaddescripcion','on'=>'INS_ACTIVO,UPD_ACTIVO'),
			array('c_codactivo+n_hguia', 'application.extensions.uniqueMultiColumnValidator','message'=>'Este Activo ya se encuentra Registrado en el documento ','on'=>'INS_ACTIVO,UPD_ACTIVO'),





			array('c_codgui', 'exist','allowEmpty' => true,'attributeName' => 'codigo', 'className' => 'Maestrocompo','message'=>'Este códIgo de material no existe', 'on'=>'INS_NUEVO,UPD_NUEVO'),
			array('c_um', 'required','message'=>'Sin unidad de medida','on'=>'INS_NUEVO,UPD_NUEVO'),
			//array('c_codactivo', 'checkplaca','on'=>'INS_ACTIVO,UPD_ACTIVO'),
			array('c_codgui','safe','on'=>'INS_NUEVO,UPD_NUEVO'),

			array('n_hguia,m_obs,modo,codocu,c_codgui,c_itguia,n_direcformaldes,n_directran,n_dire,n_dirsoc,c_codactivo,c_um,c_codgui,c_um,c_itguia,n_cangui,c_descri,c_edgui,c_codep,cargodevolucion,codlugar', 'safe'),


            array('idstatus,cargodevolucion','safe', 'on'=>'escenario_idstatus'),
			array('n_libre', 'numerical', 'integerOnly'=>true),
			array('n_cangui', 'numerical'),
			array('n_cangui', 'required','message'=>'Cantidad vacia'),

			array('docrefext', 'length', 'max'=>15),
			array('n_hguia,m_obs, codlugar,id,idusertemp,idstatus,iduser,hidespacho', 'safe'),

			//array('c_codsap', 'checkplaca','on'=>'insert,update'),
			//array('c_codgui', 'checkcodigo','on'=>'insert,update'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('n_hguia, c_itguia, n_cangui, c_codgui, c_edgui, c_descri, m_obs, c_um, c_codep, ndeenvio, n_detgui, l_libre, creadopor, creadoel, modificadopor, modificadoel, n_hconformidad, c_estado, n_libre, n_idconformidad, c_af, c_codactivo, c_img, c_codsap, docref, docrefext, hidref, codocu', 'safe', 'on'=>'search'),


		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'guia' => array(self::BELONGS_TO, 'Guia', 'n_hguia'),
		'materiales' => array(self::BELONGS_TO, 'Maestrocompo', 'c_codgui'),
			'inventario'=>array(self::BELONGS_TO, 'VwInventario1', 'c_codactivo'),
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.

		);
	}


	public function checkmovimiento($attribute,$params) {
		//si se puede mover o el innteot de trsnportarlo es licito
		if(!$this->guia->canMove($this->c_codactivo)){
			$this->adderror('c_codactivo','Este activo no se puede mover desde este punto de partida, es posible que en inventario Físico no aparezca aquí ');
		}
	}


	public function cargodevolver($attribute,$params) {
		//si se puede mover o el innteot de trsnportarlo es licito

		if(!$this->guia->canMove($this->c_codactivo)){
			$this->adderror('c_codactivo','Este activo no se puede mover desde este punto de partida, es posible que en inventario Físico no aparezca aquí ');
		}
	}

	///verifica que el activo A MOVER, NMO SE ENCUENTRA EN TRANSPORTE
	public function checksiestaenotraguia($attribute,$params) {

		$inve=Inventario::recordByPlate($this->c_codactivo);
		if($inve->rocoto=='1'){
			$this->adderror('c_codactivo','Este activo yA esta en transporte ');

		}


	}


	public function checkcantidaddescripcion($attribute,$params) {
			//si se puede mover o el innteot de trsnportarlo es licito

			 $inve=Inventario::recordByPlate($this->c_codactivo);
			$descripcion=(is_null($inve))?'':$inve->descripcion;
			if (!strtolower(trim($this->c_descri))==strtolower(trim($this->c_descri)))
				$this->adderror('c_descri','La descripcion del activo y del documenrto no coinciden');


		}





	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->c_estado='99';
			$this->idusertemp=yii::app()->user->id;

		}



		return parent::beforeSave();
	}





	public function checkcodigo($attribute,$params) {
		//Primero debemos verificar que el codigo SAP y el codigo de AF son los correctos
		$codigo=$this->c_codgui;
		if ( !is_null($codigo) or !empty($codigo))
		{
			$vari=Maestrocompo::model()->find('codigo=:codito',array(':codito'=>$codigo));
			$comp=is_null($vari)?'':$vari->codigo;
			if(!(trim($codigo)==trim($comp )))
				$this->adderror('c_codgui','El codigo de material no Existe');
		} else {

		}

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'n_hguia' => 'N Hguia',
			'c_itguia' => 'Item',
			'n_cangui' => 'Cantidad',
			'c_codgui' => 'Codigo',
			'c_edgui' => 'Destino',
			'c_descri' => 'Descripcion',
			'm_obs' => 'Detalle',
			'c_um' => 'Um',
			'c_codep' => 'Referencia',
			'ndeenvio' => 'Ndeenvio',
			//	'n_detgui' => 'N Detgui',
			'l_libre' => 'L Libre',
			'n_hconformidad' => 'N Hconformidad',
			'c_estado' => 'Estado',
			'n_libre' => 'N Libre',
			'n_idconformidad' => 'N Idconformidad',
			'c_af' => 'Es activo?',
			'c_codactivo' => 'Codigo de placa',
			'c_img' => 'C Img',
			'c_codsap' => 'Codigo SAP',
			'docref' => 'Doc. Referencia',
			'docrefext' => 'Docrefext',
			'hidref' => 'Hidref',
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

		$criteria->compare('n_hguia',$this->n_hguia,true);
		$criteria->compare('c_itguia',$this->c_itguia,true);
		$criteria->compare('n_cangui',$this->n_cangui);
		$criteria->compare('c_codgui',$this->c_codgui,true);
		$criteria->compare('c_edgui',$this->c_edgui,true);
		$criteria->compare('c_descri',$this->c_descri,true);
		$criteria->compare('m_obs',$this->m_obs,true);
		$criteria->compare('c_um',$this->c_um,true);
		$criteria->compare('c_codep',$this->c_codep,true);
		$criteria->compare('ndeenvio',$this->ndeenvio,true);
		$criteria->compare('l_libre',$this->l_libre,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('n_hconformidad',$this->n_hconformidad,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('n_libre',$this->n_libre);
		$criteria->compare('n_idconformidad',$this->n_idconformidad,true);
		$criteria->compare('c_af',$this->c_af,true);
		$criteria->compare('c_codactivo',$this->c_codactivo,true);
		$criteria->compare('c_img',$this->c_img,true);
		$criteria->compare('c_codsap',$this->c_codsap,true);
		$criteria->compare('docref',$this->docref,true);
		$criteria->compare('docrefext',$this->docrefext,true);
		$criteria->compare('hidref',$this->hidref,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('idtemp',$this->idtemp,true);
		$criteria->compare('idstatus',$this->idstatus);
		$criteria->compare('id',$this->id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tempdetgui the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}