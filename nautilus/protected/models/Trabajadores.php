<?php

class Trabajadores extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Trabajadores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
	public $oficios_oficio;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'public_trabajadores';
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
			//array('codigotra', 'required'),
			//array('codigotra', 'length', 'max'=>4),
			array('ap', 'length', 'max'=>30),
			array('am', 'length', 'max'=>35),
			array('dni', 'numerical'),
			array('nombres', 'length', 'max'=>25),
			array('iduser', 'unique','message'=>'Este usuario ya ha sido tomado por otro trabajador'),
			array('nombres', 'required', 'message'=>'Indica los nombres'),
			array('cumple', 'required', 'message'=>'Indica el onomastico'),
			array('ap', 'required', 'message'=>'Indica el apellido paterno'),
			array('dni', 'length', 'max'=>8),
			//array('codigoaf', 'unique', 'attributeName'=> 'codigoaf', 'caseSensitive' => 'true','message'=>'Hermano, esta placa ya esta registrada'),
			
			array('dni', 'unique', 'attributeName'=> 'dni','message'=>'Hermano, este DNI ya esta registrado'),
			array('codpuesto', 'required','message'=>'Debes de llenar el puesto'),
            array('oficios_oficio,codigotra,cumple,iduser, ap,fecingreso, domicilio, activo, tiposangre, telfijo,prefijo, telmoviles','safe', 'on'=>'update,insert'),
			//array('creadoel, modificadoel', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('oficios_oficio,codigotra,cumple, fecingreso, direccion, tiposangre, ap,telfijo, telmoviles, am, nombres, dni, codpuesto, creadopor, creadoel, modificadopor, modificadoel', 'safe', 'on'=>'search'),
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
			'oficio' => array(self::BELONGS_TO, 'Oficios', 'codpuesto'),
			'usuarios'=>array(self::BELONGS_TO, 'CrugeUser', 'codpuesto'),
			'usuarios'=>array(self::BELONGS_TO, 'CrugeUser', 'codpuesto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codigotra' => 'Codigo',
			'ap' => 'A Paterno',
			'am' => 'A Materno',
			'nombres' => 'Nombres',
			'dni' => 'D.N.I.',
			'codpuesto' => 'Codpuesto',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
		);
	}

	public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									   // $this->creadopor=Yii::app()->user->name;
										// $this->creadoel=Yii::app()->user->name;
								         $this->prefijo='7';
									    $this->codigotra=Numeromaximo::numero($this,'correlativo','maximovalor',3,'prefijo');
										//$this->cod_estado='01';
											//$this->c_salida='1';
									} else
									{

										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
									}
		if($this->oldattributes['iduser'] <> $this->iduser) ///Si han actualizado el campo iduser
		                                {
											if(!is_null($this->iduser))  {
												$registros = Yii::app()->db->createCommand(" select idfield  from	cruge_field t where t.fieldname='codtra' ")->queryAll();
												if(count($registros)> 0 )  {
													foreach  ($registros as $row) {
														$cuantoshay= Yii::app()->db->createCommand(" SELECT count(idfieldvalue) from cruge_fieldvalue where iduser=".$this->iduser." and idfield=".$row['idfield']." ")->queryScalar();

														if($cuantoshay == 0){
														$comando = Yii::app()->db->createCommand(" INSERT INTO cruge_fieldvalue(iduser,idfield,value) values (".$this->iduser.",".$row['idfield'].",'".$this->codigotra."') " );
														$comando->execute();
															}
														if($cuantoshay == 1){
															$comando = Yii::app()->db->createCommand(" UPDATE cruge_fieldvalue  SET value= '".$this->codigotra."' where  iduser=".$this->iduser." and idfield=".$row['idfield']." "   );
														$comando->execute();
															}
													}

													}
											}
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

		$criteria->compare('codigotra',$this->codigotra,true);
		$criteria->compare('ap',$this->ap,true);
		$criteria->compare('am',$this->am,true);
		$criteria->compare('nombres',$this->nombres,true);
		$criteria->compare('dni',$this->dni,true);
		$criteria->compare('codpuesto',$this->codpuesto,true);		
		$criteria->together  =  true;
        $criteria->with = array('oficio');
		 //if($this->oficios_oficio){
		$criteria->compare('oficio.oficio',$this->oficios_oficio,true);
			//}
				$sort=new CSort;
				$sort->attributes=array(
										//'codpuesto',
									// For each relational attribute, create a 'virtual attribute' using the public variable name
										'oficios_oficio' => array(
																	'asc' => 'oficio.oficio  ASC',
																	'desc' => 'oficio.oficio DESC ',
																	'label' => 'Oficio',
																	),
										'*',
										);
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}