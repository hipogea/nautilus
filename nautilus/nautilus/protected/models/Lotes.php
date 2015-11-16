<?php

class Lotes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lotes}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('numlote, fechafabri, fechaingreso, fechavenc, usuario, cant, hidinventario, comentario, codestado, cantsaldo, descripcion', 'required'),
			array('cant, cantsaldo', 'numerical'),
			array('numlote', 'length', 'max'=>18),
			array('usuario', 'length', 'max'=>35),
			array('hidinventario, loteprov', 'length', 'max'=>20),
			array('codestado', 'length', 'max'=>2),
			array('descripcion', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, numlote, fechafabri, fechaingreso, fechavenc, usuario, cant, hidinventario, loteprov, comentario, codestado, cantsaldo, descripcion', 'safe', 'on'=>'search'),
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
			'inventario'=>array(self::BELONGS_TO, 'Alinventario', 'hidinventario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'numlote' => 'Numlote',
			'fechafabri' => 'Fechafabri',
			'fechaingreso' => 'Fechaingreso',
			'fechavenc' => 'Fechavenc',
			'usuario' => 'Usuario',
			'cant' => 'Cant',
			'hidinventario' => 'Hidinventario',
			'loteprov' => 'lote del proveedor',
			'comentario' => 'Comentario',
			'codestado' => '\'10\' creado, \'20\' agotado, ',
			'cantsaldo' => 'Cantsaldo',
			'descripcion' => 'Descripcion',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('numlote',$this->numlote,true);
		$criteria->compare('fechafabri',$this->fechafabri,true);
		$criteria->compare('fechaingreso',$this->fechaingreso,true);
		$criteria->compare('fechavenc',$this->fechavenc,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('hidinventario',$this->hidinventario,true);
		$criteria->compare('loteprov',$this->loteprov,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('cantsaldo',$this->cantsaldo);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lotes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
