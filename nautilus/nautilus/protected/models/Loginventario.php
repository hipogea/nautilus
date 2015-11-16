<?php

/**
 * This is the model class for table "loginventario".
 *
 * The followings are the available columns in table 'loginventario':
 * @property string $idlog
 * @property string $hidinventario
 * @property string $c_estado
 * @property string $codep
 * @property string $comentario
 * @property string $fecha
 * @property string $coddocu
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $codlugar
 * @property string $codigopadre
 * @property string $numerodocumento
 * @property string $adicional
 * @property string $codestado
 * @property string $codepanterior
 * @property string $codlugarant
 * @property string $iddocu
 *
 * The followings are the available model relations:
 * @property Documentos $coddocu0
 * @property Embarcaciones $codepanterior0
 * @property Embarcaciones $codep0
 * @property Inventario $hidinventario0
 */
class Loginventario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Loginventario the static model class
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
		return 'public_loginventario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hidinventario', 'required'),
			array('c_estado', 'length', 'max'=>1),
			array('codep, coddocu, codepanterior', 'length', 'max'=>3),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel, numerodocumento', 'length', 'max'=>20),
			array('codlugar, codlugarant', 'length', 'max'=>6),
			array('codigopadre', 'length', 'max'=>5),
			array('adicional', 'length', 'max'=>15),
			array('codestado', 'length', 'max'=>2),
			array('comentario, fecha, iddocu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idlog, hidinventario, c_estado, codep, comentario, fecha, coddocu, creadopor, creadoel, modificadopor, modificadoel, codlugar, codigopadre, numerodocumento, adicional, codestado, codepanterior, codlugarant, iddocu', 'safe', 'on'=>'search'),
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
			'documentos' => array(self::BELONGS_TO, 'Documentos', 'codocumov'),
			'guias' => array(self::BELONGS_TO, 'Guia', 'iddocu'),
			'barcoanterior' => array(self::BELONGS_TO, 'Embarcaciones', 'codepanterior'),
			'lugares' => array(self::BELONGS_TO, 'Lugares', 'codlugar'),
			'barcoactual' => array(self::BELONGS_TO, 'Embarcaciones', 'codep'),
			'hidinventario0' => array(self::BELONGS_TO, 'Inventario', 'hidinventario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idlog' => 'Idlog',
			'hidinventario' => 'Hidinventario',
			'c_estado' => 'C Estado',
			'codep' => 'Codep',
			'comentario' => 'Comentario',
			'fecha' => 'Fecha',
			'coddocu' => 'Coddocu',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'codlugar' => 'Codlugar',
			'codigopadre' => 'Codigopadre',
			'numerodocumento' => 'Numerodocumento',
			'adicional' => 'Adicional',
			'codestado' => 'Codestado',
			'codepanterior' => 'Codepanterior',
			'codlugarant' => 'Codlugarant',
			'iddocu' => 'Iddocu',
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

		$criteria->compare('idlog',$this->idlog,true);
		$criteria->compare('hidinventario',$this->hidinventario,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('codigopadre',$this->codigopadre,true);
		$criteria->compare('numerodocumento',$this->numerodocumento,true);
		$criteria->compare('adicional',$this->adicional,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codlugarant',$this->codlugarant,true);
		$criteria->compare('iddocu',$this->iddocu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}