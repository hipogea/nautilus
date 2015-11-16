<?php

/**
 * This is the model class for table "vw_opcionesdocumentos".
 *
 * The followings are the available columns in table 'vw_opcionesdocumentos':
 * @property string $desdocu
 * @property string $idopdoc
 * @property string $campo
 * @property string $nombrecampo
 * @property string $tipodato
 * @property integer $longitud
 * @property integer $id
 * @property string $idusuario
 * @property string $username
 * @property string $coddocu
 */
class VwOpcionesdocumentos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwOpcionesdocumentos the static model class
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
		return 'vw_opcionesdocumentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('longitud, id', 'numerical', 'integerOnly'=>true),
			array('desdocu', 'length', 'max'=>45),
			array('campo, nombrecampo', 'length', 'max'=>30),
			array('tipodato', 'length', 'max'=>1),
			array('username', 'length', 'max'=>64),
			array('coddocu', 'length', 'max'=>3),
			array('idopdoc, idusuario', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('desdocu,valor, idopdoc, campo, nombrecampo, tipodato, longitud, id, idusuario, username, coddocu', 'safe', 'on'=>'search'),
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
			'desdocu' => 'Desdocu',
			'idopdoc' => 'Idopdoc',
			'campo' => 'Campo',
			'nombrecampo' => 'Nombrecampo',
			'tipodato' => 'Tipodato',
			'longitud' => 'Longitud',
			'id' => 'ID',
			'idusuario' => 'Idusuario',
			'username' => 'Username',
			'coddocu' => 'Coddocu',
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

		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('idopdoc',$this->idopdoc,true);
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('tipodato',$this->tipodato,true);
		$criteria->compare('longitud',$this->longitud);
		$criteria->compare('id',$this->id);
		$criteria->compare('idusuario',$this->idusuario,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('coddocu',$this->coddocu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function search_us($docu,$usu)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('idopdoc',$this->idopdoc,true);
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('nombrecampo',$this->nombrecampo,true);
		$criteria->compare('tipodato',$this->tipodato,true);
		$criteria->compare('longitud',$this->longitud);
		$criteria->compare('id',$this->id);
		$criteria->compare('idusuario',$this->idusuario,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->addCondition(" coddocu='".$docu."' and idusuario=".$usu." ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function search_d($docu)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('desdocu',$this->desdocu,true);
		//$criteria->compare('idopdoc',$this->idopdoc,true);
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('valor',$this->campo,true);
		$criteria->compare('tipodato',$this->campo,true);
		//$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->addCondition(" coddocu='".$docu."'  ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}