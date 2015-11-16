<?php

class Factur extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{factur}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codproadqui,codpro','exist','allowEmpty' => false, 'attributeName' => 'codpro', 'className' => 'Clipro','message'=>'Esta empresa no existe'),
			array('codproadqui, fechaemision, versionubl, versionestruc, fechaconsumo, codestado, texto, tipodocumento, moneda, coddocu, codtipofac, codsociedad, codgrupoventas, ordenventa, codcentro, codobjeto, firmadigital, tipodocadqui, codleyenda, codal', 'required'),
			array('descuento', 'numerical', 'integerOnly'=>true),
			array('numero, ordenventa', 'length', 'max'=>13),
			array('codpro, codproadqui', 'length', 'max'=>6),
			array('versionubl, versionestruc', 'length', 'max'=>10),
			array('codestado, tipodocumento, codtipofac, tipodocadqui', 'length', 'max'=>2),
			array('texto', 'length', 'max'=>40),
			array('moneda, coddocu, codgrupoventas, codobjeto, codal', 'length', 'max'=>3),
			array('orcli', 'length', 'max'=>12),
			array('codsociedad, tenorsup, tenorinf', 'length', 'max'=>1),
			array('codcentro, codleyenda', 'length', 'max'=>4),
			array('numerocheque', 'length', 'max'=>24),
			array('textolargo, fechapresentacion, fechanominal, fechacancelacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('numero, codpro, codproadqui, fechaemision, versionubl, versionestruc, fechaconsumo, codestado, texto, textolargo, tipodocumento, moneda, orcli, descuento, coddocu, codtipofac, codsociedad, codgrupoventas, ordenventa, codcentro, codobjeto, fechapresentacion, fechanominal, fechacancelacion, id, tenorsup, tenorinf, numerocheque, firmadigital, tipodocadqui, codleyenda, codal', 'safe', 'on'=>'search'),
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
			'dfacturs' => array(self::HAS_MANY, 'Dfactur', 'hidfactu'),
			'moneda0' => array(self::BELONGS_TO, 'Monedas', 'moneda'),
			'codpro0' => array(self::BELONGS_TO, 'Clipro', 'codpro'),
			'codal0' => array(self::BELONGS_TO, 'Almacenes', 'codal'),
			'codproadqui0' => array(self::BELONGS_TO, 'Clipro', 'codproadqui'),
			'codcentro0' => array(self::BELONGS_TO, 'Centros', 'codcentro'),
			'coddocu0' => array(self::BELONGS_TO, 'Documentos', 'coddocu'),
			'codtipofac0' => array(self::BELONGS_TO, 'Tipofacturacion', 'codtipofac'),
			'codgrupoventas0' => array(self::BELONGS_TO, 'Grupoventas', 'codgrupoventas'),
			'tempdfacturs' => array(self::HAS_MANY, 'Tempdfactur', 'hidfactu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'numero' => 'Numero',
			'codpro' => 'Codpro',
			'codproadqui' => 'Codproadqui',
			'fechaemision' => 'Fechaemision',
			'versionubl' => 'Versionubl',
			'versionestruc' => 'Versionestruc',
			'fechaconsumo' => 'Fechaconsumo',
			'codestado' => 'Codestado',
			'texto' => 'Texto',
			'textolargo' => 'Textolargo',
			'tipodocumento' => 'Tipodocumento',
			'moneda' => 'Moneda',
			'orcli' => 'Orcli',
			'descuento' => 'Descuento',
			'coddocu' => 'Coddocu',
			'codtipofac' => 'Codtipofac',
			'codsociedad' => 'Codsociedad',
			'codgrupoventas' => 'Codgrupoventas',
			'ordenventa' => 'Ordenventa',
			'codcentro' => 'Codcentro',
			'codobjeto' => 'Codobjeto',
			'fechapresentacion' => 'Fechapresentacion',
			'fechanominal' => 'Fechanominal',
			'fechacancelacion' => 'Fechacancelacion',
			'id' => 'ID',
			'tenorsup' => 'Tenorsup',
			'tenorinf' => 'Tenorinf',
			'numerocheque' => 'Numerocheque',
			'firmadigital' => 'Firmadigital',
			'tipodocadqui' => 'Tipodocadqui',
			'codleyenda' => 'Codleyenda',
			'codal' => 'Codal',
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

		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('codproadqui',$this->codproadqui,true);
		$criteria->compare('fechaemision',$this->fechaemision,true);
		$criteria->compare('versionubl',$this->versionubl,true);
		$criteria->compare('versionestruc',$this->versionestruc,true);
		$criteria->compare('fechaconsumo',$this->fechaconsumo,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('tipodocumento',$this->tipodocumento,true);
		$criteria->compare('moneda',$this->moneda,true);
		$criteria->compare('orcli',$this->orcli,true);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('codtipofac',$this->codtipofac,true);
		$criteria->compare('codsociedad',$this->codsociedad,true);
		$criteria->compare('codgrupoventas',$this->codgrupoventas,true);
		$criteria->compare('ordenventa',$this->ordenventa,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codobjeto',$this->codobjeto,true);
		$criteria->compare('fechapresentacion',$this->fechapresentacion,true);
		$criteria->compare('fechanominal',$this->fechanominal,true);
		$criteria->compare('fechacancelacion',$this->fechacancelacion,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('tenorsup',$this->tenorsup,true);
		$criteria->compare('tenorinf',$this->tenorinf,true);
		$criteria->compare('numerocheque',$this->numerocheque,true);
		$criteria->compare('firmadigital',$this->firmadigital,true);
		$criteria->compare('tipodocadqui',$this->tipodocadqui,true);
		$criteria->compare('codleyenda',$this->codleyenda,true);
		$criteria->compare('codal',$this->codal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Factur the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
