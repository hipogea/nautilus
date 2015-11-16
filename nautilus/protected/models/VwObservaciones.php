<?php

/**
 * This is the model class for table "vw_observaciones".
 *
 * The followings are the available columns in table 'vw_observaciones':
 * @property string $hidinventario
 * @property string $fecha
 * @property string $descri
 * @property string $mobs
 * @property string $usuario
 * @property integer $id
 * @property string $codestado
 * @property string $estado
 * @property string $codigoaf
 * @property string $codigosap
 * @property string $codlugar
 * @property string $descripcion
 * @property string $marca
 * @property string $modelo
 * @property string $serie
 */
class VwObservaciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwObservaciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public $fecha1 ;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vw_observaciones';
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
			array('descri', 'length', 'max'=>30),
			array('usuario, descripcion', 'length', 'max'=>40),
			array('codestado', 'length', 'max'=>2),
			array('estado, modelo', 'length', 'max'=>25),
			array('codigoaf', 'length', 'max'=>14),
			array('codigosap, codlugar', 'length', 'max'=>6),
			array('marca', 'length', 'max'=>15),
			array('serie', 'length', 'max'=>20),
			array('hidinventario, fecha, mobs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hidinventario, codcentro,fecha,fecha1, descri, mobs, usuario, id, codestado, estado, codigoaf, codigosap, codlugar, descripcion, marca, modelo, serie', 'safe', 'on'=>'search'),
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
			'hidinventario' => 'Hidinventario',
			'fecha' => 'Fecha',
			'descri' => 'Descri',
			'mobs' => 'Mobs',
			'usuario' => 'Usuario',
			'id' => 'ID',
			'codestado' => 'Codestado',
			'estado' => 'Estado',
			'codigoaf' => 'Codigoaf',
			'codigosap' => 'Codigosap',
			'codlugar' => 'Codlugar',
			'descripcion' => 'Descripcion',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'serie' => 'Serie',
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

		$criteria->compare('hidinventario',$this->hidinventario,true);
		//$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('mobs',$this->mobs,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		 if((isset($this->fecha) && trim($this->fecha) != "") && (isset($this->fecha1) && trim($this->fecha1) != ""))  {
                        $criteria->addBetweenCondition('fecha', ''.$this->fecha.'', ''.$this->fecha1.''); 
						
						}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}