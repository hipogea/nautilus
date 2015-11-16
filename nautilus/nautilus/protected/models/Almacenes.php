<?php

/**
 * This is the model class for table "almacenes".
 *
 * The followings are the available columns in table 'almacenes':
 * @property string $codalm
 * @property string $nomal
 * @property string $desalm
 * @property string $tipo
 * @property string $codcen
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $codsoc
 * @property string $tipovaloracion
 * @property string $estructura
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Sociedades $codsoc0
 * @property Centros $codcen0
 */
class Almacenes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Almacenes the static model class
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
		return 'public_almacenes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

	public function behaviors()
	{
		return array(
			// Classname => path to Class
			'ActiveRecordLogableBehavior'=>
				'application.behaviors.ActiveRecordLogableBehavior',
		);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codsoc', 'required'),
			array('codalm', 'length', 'max'=>3),
			array('codalm', 'required'),
			array('codalm', 'length', 'min'=>3),
			array('codalm', 'unique'),
			array('codalm', 'match', 'pattern'=>Yii::app()->params['mascaradocs'],'message'=>'El codigo  no es el correcto, El c debe comenzar por 2 DIGITOS  > 0 y los caracteres deben ser numericos'),
			array('codmon', 'required', 'message'=>' Indique la moneda para valorizar el inventario'),

			array('nomal', 'length', 'max'=>35),
			array('nomal', 'required'),
			array('tipo, tipovaloracion', 'length', 'max'=>2),
			//array('codcen', 'length', 'max'=>4),
			array('codcen', 'required'),
			array('creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel', 'length', 'max'=>20),
			array('codsoc', 'length', 'max'=>1),
			array('estructura', 'length', 'max'=>15),
			array('desalm,verprecios,novalorado', 'safe'),
			array('codalm, nomal, desalm, tipo, codcen,codmon,  codsoc, tipovaloracion, estructura,tolstockres,fecharefpronostico', 'safe', 'on'=>'insert,update'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codalm, nomal, desalm, tipo, codcen, creadopor, creadoel, modificadopor, modificadoel, codsoc, tipovaloracion, estructura, id', 'safe', 'on'=>'search'),
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
			'codsoc0' => array(self::BELONGS_TO, 'Sociedades', 'codsoc'),
			'centros' => array(self::BELONGS_TO, 'Centros', 'codcen'),
			//'items_inventario' => array(self::STAT, 'Alinventario', 'codalmacen','select'=>'count(id)','condition'=>" cantlibre > 0 "),),
		);
	}




	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codalm' => 'Codalm',
			'nomal' => 'Nomal',
			'desalm' => 'Desalm',
			'tipo' => 'Tipo',
			'codcen' => 'Codcen',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'codsoc' => 'Codsoc',
			'tipovaloracion' => 'Tipovaloracion',
			'estructura' => 'Estructura',
			'id' => 'ID',
		);
	}


     public $maximovalor;

	public function beforeSave() {
							if ($this->isNewRecord) {
										//$this->codsoc='A';
										//$this->codalm=Numeromaximo::numero($this->model(),'codalm','maximovalor',3);

									} else
									{
										 
										 	}
									return parent::beforeSave();
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

		$criteria->compare('codalm',$this->codalm,true);
		$criteria->compare('nomal',$this->nomal,true);
		$criteria->compare('desalm',$this->desalm,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('codsoc',$this->codsoc,true);
		$criteria->compare('tipovaloracion',$this->tipovaloracion,true);
		$criteria->compare('estructura',$this->estructura,true);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}