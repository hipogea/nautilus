<?php

/**
 * This is the model class for table "dcotmateriales".
 *
 * The followings are the available columns in table 'dcotmateriales':
 * @property string $id
 * @property string $numcot
 * @property string $codart
 * @property string $disp
 * @property double $cant
 * @property double $punit
 * @property string $item
 * @property string $descri
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property double $stock
 * @property string $detalle
 * @property string $tipoitem
 * @property string $estadodetalle
 * @property string $coddocu
 * @property string $um
 * @property string $hidguia
 * @property string $codservicio
 *
 * The followings are the available model relations:
 * @property Disponiblidad $disp0
 * @property TServicios $codservicio0
 * @property DcotmaterialesD[] $dcotmaterialesDs
 */
class Dcotmateriales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dcotmateriales the static model class
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
		return 'dcotmateriales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cant, punit,  descri,   um', 'required'),
			array('cant, punit, stock', 'numerical'),
			//array('numcot', 'length', 'max'=>7),
			array('codart', 'length', 'max'=>8),
			array('codart','checkservicio'),

			array('disp, estadodetalle', 'length', 'max'=>2),
			array('item, coddocu, um', 'length', 'max'=>3),
			array('descri', 'length', 'max'=>40),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('tipoitem', 'length', 'max'=>1),
			array('codservicio', 'length', 'max'=>6),
			array('detalle, hidguia,idpadre', 'safe'),
			array('tipo','required','message'=>'LLena el tipo de posicion'),
		
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,tipo, idpadre,  codart, disp, cant, punit, item, descri, creadopor, creadoel, modificadopor, modificadoel, stock, detalle, tipoitem, estadodetalle, coddocu, um, hidguia, codservicio', 'safe', 'on'=>'search'),
		








		);
	}


		/************************************************
		*  ATENCION : ESTA VALIDACION DEBE DE CAMBIARSE A ESCENARIOS 
		*             EN FUTURAS APLICAIONES CUANDO QUIERAN IMPUTAR
		               A CENTROS DE BENEFICIOS PARA CONTABILIZAR LAS VENTAS 
		               O A ORDENES DE PRODUCCION
		***************************************************/

		public function checkservicio($attribute,$params) {

			 if ( $this->tipo=='00') {//si es un tipo  servicio
			 									$modelito=Maestrocompo::model()->findByPk(TRIM($this->codart));
										if (!$modelito===null) {
															$tipomaterial=$modelito->codtipo;
																//ADEMAS DEBE DE TENER EL TIPO DE DETALLE COMO TIPO SERVICIO '00'
																		if( !(($this->tipo=='00') and ($tipomaterial=='00')))
																					{
	   																						$this->adderror('tipo','Es un servicio pero el codigo no correpsonde');
																
																						}
																							

			 													}else {
													$this->adderror('codart','Lleno el tipo como servicio pero el codigo no corresponde');
																}
										}
									}
			


			


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'disp0' => array(self::BELONGS_TO, 'Disponiblidad', 'disp'),
			'codservicio0' => array(self::BELONGS_TO, 'TServicios', 'codservicio'),
			'materiales'=>array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
			'dcotmaterialesDs' => array(self::HAS_MANY, 'DcotmaterialesD', 'hid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			//'numcot' => 'Numcot',
			'codart' => 'Codart',
			'disp' => 'Disp',
			'cant' => 'Cant',
			'punit' => 'Punit',
			'item' => 'Item',
			'descri' => 'Descri',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'stock' => 'Stock',
			'detalle' => 'Detalle',
			'tipoitem' => 'Tipoitem',
			'estadodetalle' => 'Estadodetalle',
			'coddocu' => 'Coddocu',
			'um' => 'Um',
			'hidguia' => 'Hidguia',
			'codservicio' => 'Codservicio',
		);
	}

			public function beforeSave() {
							if ($this->isNewRecord) {									
									$this->estadodetalle='99';
									$this->coddocu='024';
									
									
													}
						
							
											$this->idpadre=$this->idpadre+0;		
										return parent::beforeSave();	
											}  
					



	public function valorespordefecto(){ 
						//Vamos a cargar los valores por defecto
						$matriz=VwOpcionesdocumentos::Model()->search_d('240')->getData();
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		//$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('disp',$this->disp,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('tipoitem',$this->tipoitem,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('hidguia',$this->hidguia,true);
		$criteria->compare('codservicio',$this->codservicio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
	public function search_($idcoti)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		//$criteria->compare('numcot',$this->numcot,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('disp',$this->disp,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('stock',$this->stock);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('tipoitem',$this->tipoitem,true);
		$criteria->compare('estadodetalle',$this->estadodetalle,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('hidguia',$this->hidguia,true);
		$criteria->compare('codservicio',$this->codservicio,true);
		$criteria->addcondition("hidguia=".$idcoti);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}