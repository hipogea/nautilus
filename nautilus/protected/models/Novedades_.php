<?php

/**
 * This is the model class for table "novedades".
 *
 * The followings are the available columns in table 'novedades':
 * @property integer $idnovedad
 * @property integer $hidparte
 * @property string $codsistema
 * @property string $codigosap
 * @property string $codigoaf
 * @property string $descri
 * @property string $descridetalle
 * @property string $criticidad
 *
 * The followings are the available model relations:
 * @property Sistemas $codsistema0
 * @property Partes $hidparte0
 */
class Novedades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Novedades the static model class
	 */
	 
	public $advertencia ; //--para guaradar una adeveretnvia 
	public $sistemas_sistema;
	
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'novedades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codsistema,criticidad,descridetalle', 'required'),
			array('hidparte', 'numerical', 'integerOnly'=>true),
			array('codsistema, codigosap', 'length', 'max'=>5),
			array('codigoaf', 'length', 'max'=>13),
			array('descri', 'length', 'max'=>30),
			array('criticidad', 'length', 'max'=>1),
			array('descridetalle','idpartepesca', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idnovedad,sistemas_sistema, hidparte, codsistema, codigosap, codigoaf, descri, descridetalle, criticidad', 'safe', 'on'=>'search'),
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
			'sistemas' => array(self::BELONGS_TO, 'Sistemas', 'codsistema'),
			'hidparte0' => array(self::BELONGS_TO, 'Partes', 'hidparte'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(				
			'codsistema' => 'Sistema',
			'sistemas_sistema'=> 'Sistema',
			//'codigosap' => 'Codigosap',
			//'codigoaf' => 'Codigoaf',
			//'descri' => 'Descripcion ',
			'descridetalle' => 'Indica la novedad',
			'criticidad' => 'Criticidad',
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

		$criteria->compare('idnovedad',$this->idnovedad);
		$criteria->compare('hidparte',$this->hidparte);
		$criteria->compare('idpartepesca',$this->hidparte);
		$criteria->compare('codigosap',$this->codigosap,true);
		$criteria->compare('codigoaf',$this->codigoaf,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('descridetalle',$this->descridetalle,true);
		$criteria->compare('criticidad',$this->criticidad,true);
		
		$criteria->compare('codsistema',$this->codsistema,true);
		
		//$criteria->compare('codep',$this->codep,true);
		$criteria->together  =  true;
		$criteria->with = array('sistemas');
		 if($this->sistemas_sistema){
				$criteria->compare('sistemas.sistema',$this->sistemas_sistema,true);
			}
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}