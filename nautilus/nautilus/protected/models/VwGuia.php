<?php
CONST ESTADO_GUIA_APROBADA='30';
class VwGuia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwGuia the static model class
	 */
	public $d_fectra1;
	public $acepta; ///si acepta le materila o no  '0' o '1'
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_guia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('n_direc, n_direcformaldes, n_directran, n_dirsoc', 'numerical', 'integerOnly'=>true),
			array('n_cangui', 'numerical'),
			//array('ptopartida, ptollegada, direccionformaldes, direcciontransportista', 'length', 'max'=>60),
			array('distpartida, provpartida, dptopartida, distllegada, provllegada, dptollegada, c_trans, creadoel, modificadoel', 'length', 'max'=>20),
			array('c_numgui, c_codgui, docref', 'length', 'max'=>8),
			array('c_coclig, c_codtra', 'length', 'max'=>6),
			array('c_estgui, c_edgui', 'length', 'max'=>2),
			array('c_rsguia, c_dirsoc, c_salida, c_estado, l_libre, c_af', 'length', 'max'=>1),
			array('c_motivo, c_serie, c_itguia, c_um, c_codep, codocu', 'length', 'max'=>3),
			array('c_placa', 'length', 'max'=>15),
			array('c_licon', 'length', 'max'=>10),
			array('razondestinatario, razontransportista', 'length', 'max'=>50),
			array('rucdestinatario, ructrans, rucsoc', 'length', 'max'=>11),
			array('creadopor, modificadopor, estado, nomep, estadodetalle', 'length', 'max'=>25),
			array('c_descri', 'length', 'max'=>40),
			array('c_codactivo', 'length', 'max'=>13),
			//array('motivo', 'length', 'max'=>30),
			array('acepta','safe','on'=>'update'),
		//	array('acepta', 'required', 'message'=>'Debes de confirma la llegada del material o no, en caso de no estar seguro presiona "No acepto" ','on'=>'update'),
			array('cod_cen', 'length', 'max'=>4),
			array('c_codsap', 'length', 'max'=>5),	
			array('c_descri', 'required', 'message'=>'llena la descripcion','on'=>'search'),	
			array('d_fectra', 'required', 'message'=>'Llena la fecha de traslado','on'=>'search'),	
			array('d_fectra1', 'required', 'message'=>'Llena la fecha de traslado','on'=>'search'),	
			
			array('d_fecgui,n_detgui,c_descri, d_fectra, d_fectra1,c_desgui, n_guia, c_texto, n_hguia, m_obs, n_detgui, hidref', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ptopartida,n_detgui,c_descri,d_fectra, d_fectra1,distpartida, provpartida, dptopartida, ptollegada, distllegada, provllegada, dptollegada, direccionformaldes, direcciontransportista, c_numgui, c_coclig, d_fecgui, c_estgui, c_rsguia, c_codtra, c_trans, c_motivo, c_placa, c_licon, d_fectra, c_desgui, n_guia, c_texto, c_dirsoc, c_serie, c_salida, razondestinatario, rucdestinatario, ructrans, razontransportista, c_estado, n_direc, n_direcformaldes, n_directran, n_dirsoc, creadopor, modificadopor, creadoel, modificadoel, rucsoc,  estado, n_hguia, c_itguia, n_cangui, c_codgui, c_edgui, c_descri, m_obs, c_codactivo, c_um, c_codep, n_detgui, l_libre, nomep, motivo, estadodetalle, c_af, cod_cen, c_codsap, hidref, docref, codocu', 'safe', 'on'=>'search'),
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

	public static function hayactivoentransporte($codigoaf,$id=null){
		//$registro=self::model()->find("c_codactivo=:vcodactivo and c_estgui=:vestado AND ",array(":vcodactivo"=>$codigoaf,":vestado"=>ESTADO_GUIA_APROBADA));
	$criteria=New CDBCriteria();
		$criteria->addCondition("c_codactivo=:vcodactivo and c_estgui=:vestado ");
		if(!is_null($id))
		{
			$criteria->addCondition(" n_hguia <> :id ");
			$criteria->params=array(":vcodactivo"=>$codigoaf, ":vestado"=>ESTADO_GUIA_APROBADA,":id"=>$id);

		} else{
			$criteria->params=array(":vcodactivo"=>$codigoaf, ":vestado"=>ESTADO_GUIA_APROBADA);
		}
		$registro=VwGuia::model()->find($criteria);

				if (!IS_NULL($registro)){
			return $registro->c_numgui."   -   ".$registro->c_itguia;
		} else {
			return null;
		}

	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ptopartida' => 'Pto de partida',
			'distpartida' => 'Distrito de partida',
			'provpartida' => 'Prov. de partida',
			'dptopartida' => 'Dpto. de partida',
			'ptollegada' => 'Pto. de llegada',
			'distllegada' => 'Dist. de llegada',
			'provllegada' => 'Prov. de llegada',
			'dptollegada' => 'Dpto. de llegada',
			'direccionformaldes' => 'Direccion fiscal destinatario',
			'direcciontransportista' => 'Direccion',
			'c_numgui' => 'N guia',
			'c_coclig' => 'Codigo destinatario',
			'd_fecgui' => 'Fecha',
			'c_estgui' => 'C Estgui',
			'c_rsguia' => 'C Rsguia',
			'c_codtra' => 'C Codtra',
			'c_trans' => 'C Trans',
			'c_motivo' => 'C Motivo',
			'c_placa' => 'C Placa',
			'c_licon' => 'C Licon',
			'd_fectra' => 'Fecha de traslado',
			'd_fectra1' => 'Fecha de traslado',
			'c_desgui' => 'C Desgui',
			'n_guia' => 'N Guia',
			'c_texto' => 'C Texto',
			'c_dirsoc' => 'C Dirsoc',
			'c_serie' => 'Serie',
			'c_salida' => 'Es una salida ?',
			'razondestinatario' => 'Destinatario/Recep',
			'rucdestinatario' => 'R.U.C.',
			'ructrans' => 'Ructrans',
			'razontransportista' => 'Razontransportista',
			'c_estado' => 'C Estado',
			'n_direc' => 'N Direc',
			'n_direcformaldes' => 'N Direcformaldes',
			'n_directran' => 'N Directran',
			'n_dirsoc' => 'N Dirsoc',
			'creadopor' => 'Creadopor',
			'modificadopor' => 'Modificadopor',
			'creadoel' => 'Creadoel',
			'modificadoel' => 'Modificadoel',
			'rucsoc' => 'Rucsoc',
			'estado' => 'Estado',
			'n_hguia' => 'N Hguia',
			'c_itguia' => 'Item',
			'n_cangui' => 'Cant.',
			'c_codgui' => 'Codigo',
			'c_edgui' => 'Estado',
			'c_descri' => 'Descripcion',
			'm_obs' => 'M',
			'c_codactivo' => 'Placa',
			'c_um' => 'Um',
			'c_codep' => 'Referencia',
			'n_detgui' => 'N Detgui',
			'l_libre' => 'L Libre',
			'nomep' => 'EP',
			'motivo' => 'Motivo',
			'estadodetalle' => 'Estado',
			'c_af' => 'C Af',
			'cod_cen' => 'Planta',
			'c_codsap' => 'C Codsap',
			'hidref' => 'Hidref',
			'docref' => 'Docref',
			'codocu' => 'Codocu',
		);
	}

	/**
	 * ENCUENTRA LOS REGISTROS ENTRE DOS FECHAS 
	 * 
	 */
	public function search_()
	{
		
		$criteria=new CDbCriteria;

		$criteria->compare('ptopartida',$this->ptopartida,true);
		$criteria->compare('distpartida',$this->distpartida,true);
		$criteria->compare('provpartida',$this->provpartida,true);
		$criteria->compare('dptopartida',$this->dptopartida,true);
		$criteria->compare('ptollegada',$this->ptollegada,true);
		$criteria->compare('distllegada',$this->distllegada,true);
		$criteria->compare('provllegada',$this->provllegada,true);
		$criteria->compare('dptollegada',$this->dptollegada,true);
		$criteria->compare('direccionformaldes',$this->direccionformaldes,true);
		$criteria->compare('direcciontransportista',$this->direcciontransportista,true);
		$criteria->compare('c_numgui',$this->c_numgui,true);
		$criteria->compare('c_coclig',$this->c_coclig,true);
		$criteria->compare('d_fecgui',$this->d_fecgui,true);
		$criteria->compare('c_estgui',$this->c_estgui,true);
		$criteria->compare('c_rsguia',$this->c_rsguia,true);
		$criteria->compare('c_codtra',$this->c_codtra,true);
		$criteria->compare('c_trans',$this->c_trans,true);
		$criteria->compare('c_motivo',$this->c_motivo,true);
		$criteria->compare('c_placa',$this->c_placa,true);
		$criteria->compare('c_licon',$this->c_licon,true);
	//	$criteria->compare('d_fectra',$this->d_fectra,true);
		//$criteria->compare('c_descri',$this->c_descri,true);

		$criteria->compare('n_guia',$this->n_guia,true);
		$criteria->compare('c_texto',$this->c_texto,true);
		$criteria->compare('c_dirsoc',$this->c_dirsoc,true);
		$criteria->compare('c_serie',$this->c_serie,true);
		//$criteria->compare('c_salida',$this->c_salida,true);
		$criteria->compare('razondestinatario',$this->razondestinatario,true);
		$criteria->compare('rucdestinatario',$this->rucdestinatario,true);
		$criteria->compare('ructrans',$this->ructrans,true);
		$criteria->compare('razontransportista',$this->razontransportista,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('n_direcformaldes',$this->n_direcformaldes);
		$criteria->compare('n_directran',$this->n_directran);
		$criteria->compare('n_dirsoc',$this->n_dirsoc);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('rucsoc',$this->rucsoc,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('n_hguia',$this->n_hguia,true);
		$criteria->compare('c_itguia',$this->c_itguia,true);
		$criteria->compare('n_cangui',$this->n_cangui);
		$criteria->compare('c_codgui',$this->c_codgui,true);
		$criteria->compare('c_edgui',$this->c_edgui,true);
		$criteria->compare('c_descri',$this->c_descri,true);
		$criteria->compare('m_obs',$this->m_obs,true);
		$criteria->compare('c_codactivo',$this->c_codactivo,true);
		$criteria->compare('c_um',$this->c_um,true);
		$criteria->compare('c_codep',$this->c_codep,true);
		$criteria->compare('n_detgui',$this->n_detgui,true);
		$criteria->compare('l_libre',$this->l_libre,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('c_af',$this->c_af,true);
		$criteria->compare('cod_cen',$this->cod_cen,true);
		$criteria->compare('c_codsap',$this->c_codsap,true);
		$criteria->compare('hidref',$this->hidref,true);
		$criteria->compare('docref',$this->docref,true);
		$criteria->compare('codocu',$this->codocu,true);
		$case=$this->d_fectra;
		//$criteria->compare('d_fectra',trim(" ".$case." "),false);
		$case2=$this->d_fectra1;
		
		//$criteria->compare('d_fectra1',trim(" ".$case2." "),false);
		$criteria->compare('codocu',$this->codocu,true);
		 if((isset($this->d_fectra) && trim($this->d_fectra) != "") && (isset($this->d_fectra1) && trim($this->d_fectra1) != ""))  {
		             //  $limite1=date("Y-m-d",strotime($this->d_fectra)-24*60*60); //UN DIA MENOS 
					 //  $limite2=date("Y-m-d",strotime($this->d_fectra)+24*60*60); //UN DIA mas 
		 
                        $criteria->addBetweenCondition('d_fectra', ''.$this->d_fectra.'', ''.$this->d_fectra1.''); 
						
						}
		
		//$fechaactual = date("Y-m-d");
		//$criteria->addCondition("d_fectra = '".$fechaactual."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('ptopartida',$this->ptopartida,true);
		$criteria->compare('distpartida',$this->distpartida,true);
		$criteria->compare('provpartida',$this->provpartida,true);
		$criteria->compare('dptopartida',$this->dptopartida,true);
		$criteria->compare('ptollegada',$this->ptollegada,true);
		$criteria->compare('distllegada',$this->distllegada,true);
		$criteria->compare('provllegada',$this->provllegada,true);
		$criteria->compare('dptollegada',$this->dptollegada,true);
		$criteria->compare('direccionformaldes',$this->direccionformaldes,true);
		$criteria->compare('direcciontransportista',$this->direcciontransportista,true);
		$criteria->compare('c_numgui',$this->c_numgui,true);
		$criteria->compare('c_coclig',$this->c_coclig,true);
		$criteria->compare('d_fecgui',$this->d_fecgui,true);
		$criteria->compare('c_estgui',$this->c_estgui,true);
		$criteria->compare('c_rsguia',$this->c_rsguia,true);
		$criteria->compare('c_codtra',$this->c_codtra,true);
		$criteria->compare('c_trans',$this->c_trans,true);
		$criteria->compare('c_motivo',$this->c_motivo,true);
		$criteria->compare('c_placa',$this->c_placa,true);
		$criteria->compare('c_licon',$this->c_licon,true);
	$criteria->addcondition(" c_descri like '%".$this->c_descri."%' ");
	$criteria->compare('c_texto',$this->c_texto,true);
		$criteria->compare('c_dirsoc',$this->c_dirsoc,true);
		$criteria->compare('c_serie',$this->c_serie,true);
		$criteria->compare('razondestinatario',$this->razondestinatario,true);
		$criteria->compare('rucdestinatario',$this->rucdestinatario,true);
		$criteria->compare('ructrans',$this->ructrans,true);
		$criteria->compare('razontransportista',$this->razontransportista,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('n_direcformaldes',$this->n_direcformaldes);
		$criteria->compare('n_directran',$this->n_directran);
		$criteria->compare('n_dirsoc',$this->n_dirsoc);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('rucsoc',$this->rucsoc,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('n_hguia',$this->n_hguia,true);
		$criteria->compare('c_itguia',$this->c_itguia,true);
		$criteria->compare('n_cangui',$this->n_cangui);
		$criteria->compare('c_codgui',$this->c_codgui,true);
		$criteria->compare('c_edgui',$this->c_edgui,true);
		$criteria->compare('m_obs',$this->m_obs,true);
		$criteria->compare('c_codactivo',$this->c_codactivo,true);
		$criteria->compare('c_um',$this->c_um,true);
		$criteria->compare('c_codep',$this->c_codep,true);
		$criteria->compare('l_libre',$this->l_libre,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('c_af',$this->c_af,true);
		$criteria->compare('cod_cen',$this->cod_cen,true);
		$criteria->compare('c_codsap',$this->c_codsap,true);
		$criteria->compare('hidref',$this->hidref,true);
		$criteria->compare('docref',$this->docref,true);
		$criteria->compare('codocu',$this->codocu,true);
				$criteria->compare('codocu',$this->codocu,true);
		 if((isset($this->d_fectra) && trim($this->d_fectra) != "") && (isset($this->d_fectra1) && trim($this->d_fectra1) != ""))  {
		              $criteria->addBetweenCondition('d_fectra', ''.$this->d_fectra.'', ''.$this->d_fectra1.'');
												}

	return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	
		
		public function search_detalle($id)
	{

		$criteria=new CDbCriteria;

		$criteria->addCondition("id =".$id);
				//$criteria->addCondition("c_estgui ='01'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
		public function search2()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ptopartida',$this->ptopartida,true);
		$criteria->compare('distpartida',$this->distpartida,true);
		$criteria->compare('provpartida',$this->provpartida,true);
		$criteria->compare('dptopartida',$this->dptopartida,true);
		$criteria->compare('ptollegada',$this->ptollegada,true);
		$criteria->compare('distllegada',$this->distllegada,true);
		$criteria->compare('provllegada',$this->provllegada,true);
		$criteria->compare('dptollegada',$this->dptollegada,true);
		$criteria->compare('direccionformaldes',$this->direccionformaldes,true);
		$criteria->compare('direcciontransportista',$this->direcciontransportista,true);
		$criteria->compare('c_numgui',$this->c_numgui,true);
		$criteria->compare('c_coclig',$this->c_coclig,true);
		$criteria->compare('d_fecgui',$this->d_fecgui,true);
		$criteria->compare('c_estgui',$this->c_estgui,true);
		$criteria->compare('c_rsguia',$this->c_rsguia,true);
		$criteria->compare('c_codtra',$this->c_codtra,true);
		$criteria->compare('c_trans',$this->c_trans,true);
		$criteria->compare('c_motivo',$this->c_motivo,true);
		$criteria->compare('c_placa',$this->c_placa,true);
		$criteria->compare('c_licon',$this->c_licon,true);
	//	$criteria->compare('d_fectra',$this->d_fectra,true);
		$criteria->compare('c_desgui',$this->c_desgui,true);
		$criteria->compare('c_descri',$this->c_descri,true);
		$criteria->compare('n_guia',$this->n_guia,true);
		$criteria->compare('c_texto',$this->c_texto,true);
		$criteria->compare('c_dirsoc',$this->c_dirsoc,true);
		$criteria->compare('c_serie',$this->c_serie,true);
		//$criteria->compare('c_salida',$this->c_salida,true);
		$criteria->compare('razondestinatario',$this->razondestinatario,true);
		$criteria->compare('rucdestinatario',$this->rucdestinatario,true);
		$criteria->compare('ructrans',$this->ructrans,true);
		$criteria->compare('razontransportista',$this->razontransportista,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('n_direcformaldes',$this->n_direcformaldes);
		$criteria->compare('n_directran',$this->n_directran);
		$criteria->compare('n_dirsoc',$this->n_dirsoc);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('rucsoc',$this->rucsoc,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('n_hguia',$this->n_hguia,true);
		$criteria->compare('c_itguia',$this->c_itguia,true);
		$criteria->compare('n_cangui',$this->n_cangui);
		$criteria->compare('c_codgui',$this->c_codgui,true);
		$criteria->compare('c_edgui',$this->c_edgui,true);
		$criteria->compare('c_descri',$this->c_descri,true);
		$criteria->compare('m_obs',$this->m_obs,true);
		$criteria->compare('c_codactivo',$this->c_codactivo,true);
		$criteria->compare('c_um',$this->c_um,true);
		$criteria->compare('c_codep',$this->c_codep,true);
		$criteria->compare('n_detgui',$this->n_detgui,true);
		$criteria->compare('l_libre',$this->l_libre,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('c_af',$this->c_af,true);
		$criteria->compare('cod_cen',$this->cod_cen,true);
		$criteria->compare('c_codsap',$this->c_codsap,true);
		$criteria->compare('hidref',$this->hidref,true);
		$criteria->compare('docref',$this->docref,true);
		$criteria->compare('codocu',$this->codocu,true);
		$case=$this->d_fectra;
		$criteria->compare('d_fectra',trim(" ".$case." "),false);
		$case2=$this->d_fectra1;
		//$criteria->compare('d_fectra1',trim(" ".$case2." "),false);
		$criteria->compare('codocu',$this->codocu,true);
		$fechaactual = date("Y-m-d");
		$criteria->addCondition("d_fectra = '".$fechaactual."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	


	public function findByPk($id,$condition='',$params=array()){
           return  $this->model()->find("id=".$id);

	}
	
	public function checkfecha($attribute,$params) 	{  
				$fechainicio=$this->d_fectra;
				$fechafinal=$this->d_fectra1;
						if (!isset($fechainicio)  OR $fechainicio=="" ) {
									if (!isset($fechafinal)  OR $fechafinal=="" ) 
								    {
									   //INICIO BLANCO   FINAL BLANCO
									   
									} else {
									  // INICIO BLANCO   FINAL LLEMO 
									  
									}
						
						} else {
								if (!isset($fechafinal)  OR $fechafinal=="" ) 
								    {
									    //INICIO LLENO FINAL BLANCO
									} else {
									   //INICIO LLENO  FINAL LLENO
									   
									   if ( $fechainicio > $fechafinal ) {
									      $this->adderror('d_fectra','Las fecha de inicio es mayor que la fecha final ');
										   $this->adderror('d_fectra1','Las fecha de inicio es mayor que la fecha final ');
									   }
									   
									} 
													
						}
						
	}	
	
	
	
	
	
	public function rrsearch() 
        { 
                // Warning: Please modify the following code to remove attributes that 
                // should not be searched. 
 
                $criteria=new CDbCriteria; 
 
 
                if((isset($this->d_fectra) && trim($this->d_fectra) != "") && (isset($this->d_fectra1) && trim($this->d_fectra1) != "")) 
                        $criteria->addBetweenCondition('date', ''.$this->date_first.'', ''.$this->date_last.''); 
                return new CActiveDataProvider(get_class($this), array( 
                        'criteria'=>$criteria, 
                )); 
        }

	
}