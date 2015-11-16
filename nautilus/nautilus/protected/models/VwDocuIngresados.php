<?php

class VwDocuIngresados extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwDocuIngresados the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public $d_fectra1;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_docu_ingresados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical'),
			array('codprov', 'length', 'max'=>6),
			array('correlativo, docref', 'length', 'max'=>8),
			array('tipodoc, codepv, codgrupo', 'length', 'max'=>3),
			array('moneda', 'length', 'max'=>1),
			array('descorta, nomep', 'length', 'max'=>25),
			array('codresponsable, codteniente, codlocal', 'length', 'max'=>4),
			array('creadopor', 'length', 'max'=>23),
			array('creadoel', 'length', 'max'=>15),
			array('numero', 'length', 'max'=>20),
			array('despro', 'length', 'max'=>50),
			array('rucpro', 'length', 'max'=>11),
			array('desdocu', 'length', 'max'=>45),
			array('responsable, apoderado', 'length', 'max'=>30),
			array('nomcen', 'length', 'max'=>35),
			array('fecha, fechain, d_fectra1,texv', 'safe','on'=>'search'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codprov, fecha, d_fectra1,fechain, correlativo, tipodoc, moneda, descorta, codepv, monto, codgrupo, codresponsable, creadopor, creadoel, texv, docref, codteniente, codlocal, numero, despro, rucpro, desdocu, nomep, responsable, apoderado, nomcen', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'codprov' => 'Codprov',
			'fecha' => 'Fecha Doc.',
			'fechain' => 'Fecha Ing.',
			'correlativo' => 'Correlativo',
			'tipodoc' => 'Tipodoc',
			'moneda' => 'Mon.',
			'descorta' => 'Descripcion',
			'codepv' => 'Codepv',
			'monto' => 'Monto',
			'codgrupo' => 'Grupo',
			'codresponsable' => 'Codresponsable',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'texv' => 'Detalle',
			'docref' => 'Referencia',
			'codteniente' => 'Apoderado',
			'codlocal' => '	Local',
			'numero' => 'Numero',
			'despro' => 'Remitente',
			'rucpro' => 'R.U.C.',
			'desdocu' => 'Tipo documento',
			'nomep' => 'Embarcacion',
			'responsable' => 'Responsable',
			'apoderado' => 'Apoderado',
			'nomcen' => 'Centro',
			'd_fectra1' => 'Fecha',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('codprov',$this->codprov,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('fechain',$this->fechain,true);
		$criteria->compare('correlativo',$this->correlativo,true);
		$criteria->compare('tipodoc',$this->tipodoc,true);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('descorta',$this->descorta,true);
		$criteria->compare('codepv',$this->codepv,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('codgrupo',$this->codgrupo,true);
		$criteria->compare('codresponsable',$this->codresponsable,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('texv',$this->texv,true);
		$criteria->compare('docref',$this->docref,true);
		$criteria->compare('codteniente',$this->codteniente,true);
		$criteria->compare('codlocal',$this->codlocal,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('rucpro',$this->rucpro,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('responsable',$this->responsable,true);
		$criteria->compare('apoderado',$this->apoderado,true);
		$criteria->compare('nomcen',$this->nomcen,true);
		 if((isset($this->fechain) && trim($this->fechain) != "") && (isset($this->d_fectra1) && trim($this->d_fectra1) != ""))  {
		           
                        $criteria->addBetweenCondition('fechain', ''.$this->fechain.'', ''.$this->d_fectra1.''); 
						
						}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}