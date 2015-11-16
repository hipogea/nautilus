<?php

class VwControlactivos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwControlactivos the static model class
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
		return 'vw_controlactivos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo', 'length', 'max'=>1),
			array('codobraencurso', 'length', 'max'=>12),
			array('ccanterior, ccactual', 'length', 'max'=>8),
			array('numformato', 'length', 'max'=>17),
			array('codestado', 'length', 'max'=>2),
			array('coddocu, codepanterior, codep', 'length', 'max'=>3),
			array('codcentro', 'length', 'max'=>4),
			array('estado, barcoanterior, barcoactual, modelo', 'length', 'max'=>25),
			array('codigosap', 'length', 'max'=>6),
			array('codigoaf', 'length', 'max'=>14),
			array('descripcion', 'length', 'max'=>40),
			array('marca', 'length', 'max'=>15),
			array('serie', 'length', 'max'=>20),
			array('idactivo, fecha, comentario', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idactivo, tipo, destipo,fecha,idformato, codobraencurso, ccanterior, ccactual, comentario, numformato, codestado, coddocu, codepanterior, codep, codcentro, estado, barcoanterior, barcoactual, codigosap, codigoaf, descripcion, marca, modelo, serie', 'safe', 'on'=>'search'),
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
			'idactivo' => 'Idactivo',
			'tipo' => 'Tipo',
			'fecha' => 'Fecha',
			'codobraencurso' => 'Codobraencurso',
			'ccanterior' => 'Ccanterior',
			'ccactual' => 'Ccactual',
			'comentario' => 'Comentario',
			'numformato' => 'Numero',
			'codestado' => 'Codestado',
			'coddocu' => 'Coddocu',
			'codepanterior' => 'Codepanterior',
			'codep' => 'Codep',
			'codcentro' => 'Centro',
			'estado' => 'Estado',
			'barcoanterior' => 'Ref Anterior',
			'barcoactual' => 'Ref Actual',
			'codigosap' => 'Cod. SAP',
			'codigoaf' => 'Plaquita',
			'descripcion' => 'Descripcion',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'serie' => 'Serie',
			'nomcen'=>'Centro',
			'nombrecompleto'=>'Solicitante',
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

		$criteria->compare('idactivo',$this->idactivo,true);

		$criteria->compare('idformato',$this->idformato,true);
		
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('codobraencurso',$this->codobraencurso,true);
		$criteria->compare('ccanterior',$this->ccanterior,true);
		$criteria->compare('ccactual',$this->ccactual,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('numformato',$this->numformato,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('barcoanterior',$this->barcoanterior,true);
		$criteria->compare('barcoactual',$this->barcoactual,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		//$criteria->compare('destipo',$this->destipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function search_poractivo($idactivo)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idactivo',$this->idactivo,true);
		$criteria->compare('idformato',$this->idformato,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('codobraencurso',$this->codobraencurso,true);
		$criteria->compare('ccanterior',$this->ccanterior,true);
		$criteria->compare('ccactual',$this->ccactual,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('numformato',$this->numformato,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('codepanterior',$this->codepanterior,true);
		$criteria->compare('codep',$this->codep,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('barcoanterior',$this->barcoanterior,true);
		$criteria->compare('barcoactual',$this->barcoactual,true);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('serie',$this->serie,true);
		$criteria->addCondition(" idactivo =".$idactivo."");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}