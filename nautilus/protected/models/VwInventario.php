<?php


class VwInventario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwInventario the static model class
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
		return 'vw_inventario';
	}

	public function findByPk($id,$condition='',$params=array()){
		if($id===null) 
			$id=0; 
			
		
			  /********************************************************
			  *      CAMBIAR PARA OTRAS PALCAIONES 
			  *******************************************************/
			if  (preg_match(Yii::app()->params['mascaraactivo'], $id)) {
					return VwInventario::model()->find("codactivo=".$id);
				}else {
					return VwInventario::model()->find("idinventario=".$id);
				}
			

		

         

	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rocoto, c_estado, baja, tipo', 'length', 'max'=>1),
			array('coddocu, codep, codeporiginal, codepanterior', 'length', 'max'=>3),
			array('posicion, codlugar, codigo, codigosap', 'length', 'max'=>6),
			array('modificadopor, modelo, nomep, nombreepanterior, nombreeporiginal', 'length', 'max'=>25),
			array('modificadoel, serie, numerodocumento', 'length', 'max'=>20),
			array('codigoaf', 'length', 'max'=>14),
			array('descripcion', 'length', 'max'=>40),
			array('marca, adicional', 'length', 'max'=>15),
			array('clasefoto', 'length', 'max'=>30),
			array('codigopadre', 'length', 'max'=>5),
			array('desdocu', 'length', 'max'=>45),
			array('deslugar, despro', 'length', 'max'=>50),
			array('nomcen', 'length', 'max'=>35),
			array('idinventario, comentario, fecha, codorden', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rocoto, coddocu, posicion, codlugar, codep, idinventario, codigo, c_estado, modificadopor, modificadoel, codigosap, codigoaf, descripcion, marca, modelo, comentario, fecha, serie, clasefoto, codigopadre, adicional, numerodocumento, codorden, codeporiginal, codepanterior, baja, tipo, desdocu, nomep, nombreepanterior, nombreeporiginal, deslugar, nomcen, despro', 'safe', 'on'=>'search'),
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
			'rocoto' => 'Rocoto',
			'coddocu' => 'Coddocu',
			'posicion' => 'Posicion',
			'codlugar' => 'Codlugar',
			'codep' => 'Codep',
			'idinventario' => 'Idinventario',
			'codigo' => 'Codigo',
			'c_estado' => 'C Estado',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'codigosap' => 'Codigosap',
			'codigoaf' => 'Codigoaf',
			'descripcion' => 'Descripcion',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'comentario' => 'Comentario',
			'fecha' => 'Fecha',
			'serie' => 'Serie',
			'clasefoto' => 'Clasefoto',
			'codigopadre' => 'Codigopadre',
			'adicional' => 'Adicional',
			'numerodocumento' => 'Numerodocumento',
			'codorden' => 'Codorden',
			'codeporiginal' => 'Codeporiginal',
			'codepanterior' => 'Codepanterior',
			'baja' => 'Baja',
			'tipo' => 'Tipo',
			'desdocu' => 'Desdocu',
			'nomep' => 'Nomep',
			'nombreepanterior' => 'Nombreepanterior',
			'nombreeporiginal' => 'Nombreeporiginal',
			'deslugar' => 'Deslugar',
			'nomcen' => 'Nomcen',
			'despro' => 'Despro',
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

		$criteria->compare('rocoto',$this->rocoto,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('posicion',$this->posicion,true);
		$criteria->compare('codlugar',$this->codlugar,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('idinventario',$this->idinventario,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('clasefoto',$this->clasefoto,true);
		$criteria->compare('codigopadre',$this->codigopadre,true);
		$criteria->compare('adicional',$this->adicional,true);
		$criteria->compare('numerodocumento',$this->numerodocumento,true);
		//$criteria->compare('codorden',$this->codorden,true);
		$criteria->compare('codeporiginal',$this->codeporiginal,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('baja',$this->baja,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('nomep',$this->nomep,true);
		$criteria->compare('nombreepanterior',$this->nombreepanterior,true);
		$criteria->compare('nombreeporiginal',$this->nombreeporiginal,true);
		$criteria->compare('deslugar',$this->deslugar,true);
		$criteria->compare('nomcen',$this->nomcen,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}