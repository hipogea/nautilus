<?php

class Direcciones extends ModeloGeneral
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Direcciones the static model class
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
		return '{{direcciones}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		     array('c_hcod,c_direc,codplanta,coddepa,codprov, coddist,esembarque','safe','on'=>'BATCH_INS,BATCH_UPD'),


			array('codplanta', 'required', 'on'=>'insert,update,BATCH_INS,BATCH_UPD'),
			//array('n_valor, n_direc', 'numerical', 'integerOnly'=>true),
			//array('c_hcod', 'length', 'max'=>6,'min'=>6),
			//array('c_hcod', 'safe'),
			array('c_hcod', 'verifica','on'=>'insert,update,BATCH_INS,BATCH_UPD'),
			array('c_direc,c_hcod', 'required', 'message'=>'Coloca la direccion','on'=>'insert,update,BATCH_INS,BATCH_UPD'),
			array('c_direc', 'length','min'=>10, 'max'=>60,'on'=>'insert,update,BATCH_INS,BATCH_UPD'),
			array('c_nomlug', 'required', 'message'=>'Coloca el nombre de la zona','on'=>'insert,update'),
			array('coddist', 'required', 'message'=>'Coloca el  distrito','on'=>'insert,update,BATCH_INS,BATCH_UPD'),
			array('codprov', 'required', 'message'=>'Coloca la  provincia','on'=>'insert,update,BATCH_INS,BATCH_UPD'),
			array('coddepa', 'required', 'message'=>'Coloca el departamento','on'=>'insert,update,BATCH_INS,BATCH_UPD'),
				array('c_hcod', 'required','message'=>'Debes de indicar la empresa','on'=>'creasolo'),
			array('c_distrito, c_prov, c_departam', 'length', 'max'=>20,'on'=>'insert,update'),
			array('socio', 'length', 'max'=>1,'on'=>'insert,update'),

			array('l_vale,esembarque', 'safe','on'=>'insert,update,BATCH_INS,BATCH_UPD'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('c_hcod, c_direc, l_vale, c_nomlug, n_valor, c_distrito, c_prov, c_departam, n_direc, socio', 'safe', 'on'=>'search'),
		);
	}

	
	
	public function verifica($attribute,$params) {
	  
						$modeloprueba=Clipro::model()->find("codpro=:micodpro",array(":micodpro"=>is_null($this->c_hcod)?'':$this->c_hcod)) ;
			 if (is_null($modeloprueba )) 
			    $this->adderror('c_hcod','Esta empresa no existe');
					//else {
			    //$this->adderror('c_hcod','hol apapa');
					//} 
	} 
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'prove' => array(self::BELONGS_TO, 'Clipro', 'c_hcod'),
			'centrito'=>array(self::BELONGS_TO,'Centros','codplanta'),
			'ubigeos'=>array(self::BELONGS_TO,'Ubigeos',array('coddepa'=>'coddep','codprov'=>'codprov','coddist'=>'coddist')),
			#1005 - Can't create table
			'guias' => array(self::HAS_MANY, 'Guia', 'n_direc'),
			'guias1' => array(self::HAS_MANY, 'Guia', 'n_directran'),
			'guias2' => array(self::HAS_MANY, 'Guia', 'n_direcformaldes'),
			'guias3' => array(self::HAS_MANY, 'Guia', 'n_dirsoc'),
			'lugares'=>array(self::HAS_MANY, 'Lugares', 'n_direc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'c_hcod' => 'Organizacion',
			'c_direc' => 'Direccion',
			'l_vale' => 'Activa',
			'c_nomlug' => 'NOmbre del lugar',
			'n_valor' => 'N Valor',
			'c_distrito' => 'Dsitrito',
			'c_prov' => 'Provincia',
			'c_departam' => 'Departamento',
			'n_direc' => 'N Direc',
			'codplanta'=>'Referencia',
			'socio' => 'Socio',

		);
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

		$criteria->compare('c_hcod',$this->c_hcod,true);
		$criteria->compare('c_direc',$this->c_direc,true);
		$criteria->compare('l_vale',$this->l_vale);
		$criteria->compare('c_nomlug',$this->c_nomlug,true);
		$criteria->compare('n_valor',$this->n_valor);
		$criteria->compare('c_distrito',$this->c_distrito,true);
		$criteria->compare('c_prov',$this->c_prov,true);
		$criteria->compare('c_departam',$this->c_departam,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('socio',$this->socio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}