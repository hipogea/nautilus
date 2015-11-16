<?php

class Temppeticion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{temppeticion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		
		   array('pventa,um,cant,codcen,disponibilidad,descripcion,tipo,imputacion',
			   'required','message'=>'Este dato es obligatorio', 'on'=>'servicio'),
			array('pventa,um,cant,codcen,codart,disponibilidad,descripcion,tipo,imputacion',
				'required','message'=>'Este dato es obligatorio', 'on'=>'servicio'),


			//	array('idusertemp, id, codpro, numero, fecha, usuario, fechacreac, comentario, textocorto, idcontacto, iduser, codocu, codestado, correlativo, prefijo, codmon, descuento', 'required'),
			array('idusertemp, idcontacto, iduser, correlativo, prefijo', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>20),
			array('codpro', 'length', 'max'=>6),
			array('numero', 'length', 'max'=>12),
			array('usuario', 'length', 'max'=>25),
			array('textocorto', 'length', 'max'=>40),
			array('codocu, codmon', 'length', 'max'=>3),
			array('codestado', 'length', 'max'=>2),
			array('idtemp,id','safe', 'on'=>'insert, update'),
			//array('descuento', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
		//	array('idusertemp, id, codpro, numero, fecha, usuario, fechacreac, comentario, textocorto, idcontacto, iduser, codocu, codestado, correlativo, prefijo, codmon, descuento', 'safe', 'on'=>'search'),
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
			'idcontacto0' => array(self::BELONGS_TO, 'Contactos', 'idcontacto'),
			'codpro0' => array(self::BELONGS_TO, 'Clipro', 'codpro'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idusertemp' => 'Idusertemp',
			'id' => 'ID',
			'codpro' => 'Codpro',
			'numero' => 'Numero',
			'fecha' => 'Fecha',
			'usuario' => 'Usuario',
			'fechacreac' => 'Fechacreac',
			'comentario' => 'Comentario',
			'textocorto' => 'Textocorto',
			'idcontacto' => 'Idcontacto',
			'iduser' => 'Iduser',
			'codocu' => 'Codocu',
			'codestado' => 'Codestado',
			'correlativo' => 'Correlativo',
			'prefijo' => 'Prefijo',
			'codmon' => 'Codmon',
			'descuento' => 'Descuento',
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

		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('codpro',$this->codpro,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('fechacreac',$this->fechacreac,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('textocorto',$this->textocorto,true);
		$criteria->compare('idcontacto',$this->idcontacto);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('correlativo',$this->correlativo);
		$criteria->compare('prefijo',$this->prefijo);
		$criteria->compare('codmon',$this->codmon,true);
		$criteria->compare('descuento',$this->descuento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Temppeticion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
