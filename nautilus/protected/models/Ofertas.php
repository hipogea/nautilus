<?php

/**
 * This is the model class for table "{{ofertas}}".
 *
 * The followings are the available columns in table '{{ofertas}}':
 * @property string $id
 * @property string $hidmaestroclipro
 * @property double $punit
 * @property string $fechadoc
 * @property integer $iduser
 * @property string $comentario
 * @property integer $validez
 * @property double $cant
 * @property string $dispo
 */
class Ofertas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ofertas}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('hidmaestroclipro, punit, fechadoc, iduser, comentario, validez, cant, dispo', 'required'),
			array('iduser, validez', 'numerical', 'integerOnly'=>true),
			array('punit, cant', 'numerical'),
			array('hidmaestroclipro', 'length', 'max'=>20),
			array('dispo', 'length', 'max'=>4),
			array('fechadoc, iduser, comentario, validez, cant, dispo,iddesolpe,fechaprog', 'safe'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidmaestroclipro, punit, fechadoc, iduser, comentario, validez, cant, dispo,iddesolpe,fechaprog', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'maestroclipro' => array(self::BELONGS_TO, 'Maestroclipro', 'hidmaestroclipro'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidmaestroclipro' => 'Hidmaestroclipro',
			'punit' => 'Punit',
			'fechadoc' => 'Fechadoc',
			'iduser' => 'Iduser',
			'comentario' => 'Comentario',
			'validez' => 'Validez',
			'cant' => 'Cant',
			'dispo' => 'Dispo',
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
		$criteria->compare('hidmaestroclipro',$this->hidmaestroclipro,true);
		$criteria->compare('punit',$this->punit);
		$criteria->compare('fechadoc',$this->fechadoc,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('validez',$this->validez);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('dispo',$this->dispo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ofertas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
