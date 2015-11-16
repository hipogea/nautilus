<?php

/**
 * This is the model class for table "vw_loginventari".
 *
 * The followings are the available columns in table 'vw_loginventari':
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
 * @property string $descripcion
 * @property string $marca
 * @property string $modelo
 * @property string $serie
 * @property integer $n_direc
 * @property string $c_direc
 * @property string $despro
 */
class VwLoginventari extends CActiveRecord
{
	
	public $estaseleccionado ; ///variable prar guardar le checliskt del formaulario 
	public $cE;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwLoginventari the static model class
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
		return 'vw_loginventari';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('n_direc', 'numerical', 'integerOnly'=>true),
			array('c_estado', 'length', 'max'=>1),
			array('codep, coddocu, codepanterior', 'length', 'max'=>3),
			array('creadopor, modificadopor, modelo', 'length', 'max'=>25),
			array('creadoel, modificadoel, numerodocumento, serie', 'length', 'max'=>20),
			array('codlugar, codlugarant', 'length', 'max'=>6),
			array('codigopadre', 'length', 'max'=>5),
			array('adicional, marca', 'length', 'max'=>15),
			array('codestado', 'length', 'max'=>2),
			array('descripcion', 'length', 'max'=>40),
			array('c_direc', 'length', 'max'=>60),
			array('despro', 'length', 'max'=>50),
			array('estaseleccionado,idlog,codpro, hidinventario, comentario, fecha, iddocu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('estaseleccionado,idlog,codpro, hidinventario, c_estado, codep, comentario, fecha, coddocu, creadopor, creadoel, modificadopor, modificadoel, codlugar, codigopadre, numerodocumento, adicional, codestado, codepanterior, codlugarant, iddocu, descripcion, marca, modelo, serie, n_direc, c_direc, despro', 'safe', 'on'=>'search'),
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
			'numerodocumento' => 'Num',
			'adicional' => 'Adicional',
			'codestado' => 'Codestado',
			'codepanterior' => 'Codepanterior',
			'codlugarant' => 'Codlugarant',
			'iddocu' => 'Iddocu',
			'descripcion' => 'Descripcion',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'serie' => 'Serie',
			'n_direc' => 'N Direc',
			'c_direc' => 'C Direc',
			'despro' => 'Despro',
			'codpro'=>'Codpro',
			'desdocu'=>'Doc.',
			'codigosap'=>'C.sap',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('c_direc',$this->c_direc,true);
		$criteria->compare('despro',$this->despro,true);
		$criteria->compare('estaseleccionado',$this->estaseleccionado,true);
$criteria->compare('codpro',$this->codpro,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}