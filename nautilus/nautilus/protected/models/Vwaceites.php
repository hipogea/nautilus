<?php

/**
 * This is the model class for table "vw_aceites".
 *
 * The followings are the available columns in table 'vw_aceites':
 * @property integer $id
 * @property string $nomep
 * @property string $descripcion
 * @property string $marca
 * @property string $modelo
 * @property string $serie
 * @property string $codep
 * @property string $material
 * @property integer $horascambio
 * @property string $fucambio
 * @property integer $hucambio
 * @property integer $horometro
 * @property integer $horasaceite
 * @property integer $porcentaje
 * @property string $tienecarter
 * @property string $fulectura
 * @property integer $idequipo
 */
class VwAceites extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwAceites the static model class
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
		return 'vw_aceites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, horascambio, hucambio, horometro, horasaceite, porcentaje, idequipo', 'numerical', 'integerOnly'=>true),
			array('nomep, modelo', 'length', 'max'=>25),
			array('descripcion', 'length', 'max'=>40),
			array('marca', 'length', 'max'=>15),
			array('serie', 'length', 'max'=>20),
			array('codep', 'length', 'max'=>3),
			array('material', 'length', 'max'=>60),
			array('tienecarter', 'length', 'max'=>1),
			array('fucambio, fulectura', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nomep, diasfaltantes,horasfaltantes,descripcion, marca, modelo, serie, codep, material, horascambio, fucambio, hucambio, horometro, horasaceite, porcentaje, tienecarter, fulectura, idequipo', 'safe', 'on'=>'search'),
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
			'nomep' => 'Nomep',
			'descripcion' => 'Descripcion',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'serie' => 'Serie',
			'codep' => 'Codep',
			'material' => 'Material',
			'horascambio' => 'Horascambio',
			'fucambio' => 'Fucambio',
			'hucambio' => 'Hucambio',
			'horometro' => 'Horometro',
			'horasaceite' => 'Horasaceite',
			'porcentaje' => 'Porcentaje',
			'tienecarter' => 'Tienecarter',
			'fulectura' => 'Fulectura',
			'idequipo' => 'Idequipo',
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
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('material',$this->material,true);
		$criteria->compare('horascambio',$this->horascambio);
		$criteria->compare('fucambio',$this->fucambio,true);
		$criteria->compare('hucambio',$this->hucambio);
		$criteria->compare('horometro',$this->horometro);
		$criteria->compare('horasaceite',$this->horasaceite);
		$criteria->compare('porcentaje',$this->porcentaje);
		$criteria->compare('tienecarter',$this->tienecarter,true);
		$criteria->compare('fulectura',$this->fulectura,true);
		$criteria->compare('idequipo',$this->idequipo);
		$criteria->compare('horasfaltantes',$this->horasfaltantes,true);
		$criteria->compare('diasfaltantes',$this->diasfaltantes,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination' => array(
									'pageSize' => 200,
									),
		));
	}
	
	
	
	public function search2($codep)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('material',$this->material,true);
		$criteria->compare('horascambio',$this->horascambio);
		$criteria->compare('fucambio',$this->fucambio,true);
		$criteria->compare('hucambio',$this->hucambio);
		$criteria->compare('horometro',$this->horometro);
		$criteria->compare('horasaceite',$this->horasaceite);
		$criteria->compare('porcentaje',$this->porcentaje);
		$criteria->compare('tienecarter',$this->tienecarter,true);
		$criteria->addCondition("codep = '".trim($codep)."'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function colocaicono($porcentaje)
	{
		
		if ( $porcentaje >=0 and $porcentaje < 70)
				   $imagen="verde.jpg";
				  if ( $porcentaje >=70 and $porcentaje < 90) 
				   $imagen="ambar.jpg"; 
				    if ( $porcentaje >=90 ) 
				   $imagen="rojo.jpg"; 
				    if ( $porcentaje < 0 ) 
				   $imagen="rojo.jpg"; 
				   
				 return $imagen;
		
	}
	
	
}