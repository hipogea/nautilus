<?php

/**
 * This is the model class for table "maestrosolicitudescabecera".
 *
 * The followings are the available columns in table 'maestrosolicitudescabecera':
 * @property integer $id
 * @property string $codcentro
 * @property string $correlativo
 * @property string $fecha
 * @property string $creadopor
 * @property string $modificadopor
 * @property string $solicitante
 * @property string $codigoestado
 * @property string $coddocu
 * @property string $descripcion
 */
class Maestrosolicitudescabecera extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Maestrosolicitudescabecera the static model class
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
		return 'maestrosolicitudescabecera';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcentro, correlativo', 'length', 'max'=>5),
			array('creadopor', 'length', 'max'=>26),
			array('modificadopor, descripcion', 'length', 'max'=>25),
			array('solicitante', 'length', 'max'=>30),
			array('codigoestado', 'length', 'max'=>2),
			array('coddocu', 'length', 'max'=>3),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codcentro, correlativo, fecha, creadopor, modificadopor, solicitante, codigoestado, coddocu, descripcion', 'safe', 'on'=>'search'),
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
			'codcentro' => 'Codcentro',
			'correlativo' => 'Correlativo',
			'fecha' => 'Fecha',
			'creadopor' => 'Creadopor',
			'modificadopor' => 'Modificadopor',
			'solicitante' => 'Solicitante',
			'codigoestado' => 'Codigoestado',
			'coddocu' => 'Coddocu',
			'descripcion' => 'Descripcion',
		);
	}

	
	
	
	public $maximovalor;
//	public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									  
									    $this->creadopor=(Yii::app()->user->isGuest)?'Invitado':Yii::app()->user->name;
										// $this->creadoel=Yii::app()->user->name;
									    $this->correlativo=Numeromaximo::numero($this->model(),'correlativo','maximovalor',5);
										$this->codigoestado='01';
											//$this->c_salida='1';
									} else
									{
										
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('correlativo',$this->correlativo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('solicitante',$this->solicitante,true);
		$criteria->compare('codigoestado',$this->codigoestado,true);
		$criteria->compare('coddocu',$this->coddocu,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}