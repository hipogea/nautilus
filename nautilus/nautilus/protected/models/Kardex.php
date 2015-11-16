<?php

/**
 * This is the model class for table "kardex".
 *
 * The followings are the available columns in table 'kardex':
 * @property string $codart
 * @property string $codmov
 * @property double $cant
 * @property string $alemi
 * @property string $aldes
 * @property string $fecha
 * @property string $coddoc
 * @property string $numdoc
 * @property string $idmov
 * @property string $usuario
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $um
 * @property string $comentario
 * @property string $codocuref
 * @property string $numdocref
 * @property string $codcentro
 * @property integer $id
 * @property string $codestado
 * @property string $prefijo
 * @property string $fechadoc
 *
 * The followings are the available model relations:
 * @property Maestrocomponentes $codart0
 * @property Almacenmovimientos $codmov0
 * @property Centros $codcentro0
 * @property Documentos $coddoc0
 * @property Documentos $codocuref0
 */
class Kardex extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Kardex the static model class
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
		return 'kardex';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('idmov', 'required'),
			array('cant', 'numerical'),
			array('codart', 'length', 'max'=>10),
			array('codmov, codestado, prefijo', 'length', 'max'=>2),
			array('alemi, aldes, coddoc, um, codocuref', 'length', 'max'=>3),
			array('numdoc, numdocref', 'length', 'max'=>15),
			array('usuario, creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel, comentario', 'length', 'max'=>20),
			array('codcentro', 'length', 'max'=>4),
			array('fecha, fechadoc', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codart, codmov, cant, alemi, aldes, fecha, coddoc, numdoc, idmov, usuario, creadopor, creadoel, modificadopor, modificadoel, um, comentario, codocuref, numdocref, codcentro, id, codestado, prefijo, fechadoc', 'safe', 'on'=>'search'),
		);


			//escenario para  insertar un ajuste de inventario

				







		  //escenario para un vale de salida para orden 







	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'codart0' => array(self::BELONGS_TO, 'Maestrocomponentes', 'codart'),
			'codmov0' => array(self::BELONGS_TO, 'Almacenmovimientos', 'codmov'),
			'codcentro0' => array(self::BELONGS_TO, 'Centros', 'codcentro'),
			'coddoc0' => array(self::BELONGS_TO, 'Documentos', 'coddoc'),
			'codocuref0' => array(self::BELONGS_TO, 'Documentos', 'codocuref'),
		);
	}





		public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									    $this->creadopor=Yii::app()->user->name;

										$this->numdoc=Numeromaximo::numero($this->model(),'correlativo','maximovalor',12,'prefijo');
										//$this->codigo='34343434';
									
									} else
									{
										
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
									}
									return parent::beforeSave();
				}
	















	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codart' => 'Codart',
			'codmov' => 'Codmov',
			'cant' => 'Cant',
			'alemi' => 'Alemi',
			'aldes' => 'Aldes',
			'fecha' => 'Fecha',
			'coddoc' => 'Coddoc',
			'numdoc' => 'Numdoc',
			'idmov' => 'Idmov',
			'usuario' => 'Usuario',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'um' => 'Um',
			'comentario' => 'Comentario',
			'codocuref' => 'Codocuref',
			'numdocref' => 'Numdocref',
			'codcentro' => 'Codcentro',
			'id' => 'ID',
			'codestado' => 'Codestado',
			'prefijo' => 'Prefijo',
			'fechadoc' => 'Fechadoc',
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

		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('alemi',$this->alemi,true);
		$criteria->compare('aldes',$this->aldes,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddoc',$this->coddoc,true);
		$criteria->compare('numdoc',$this->numdoc,true);
		$criteria->compare('idmov',$this->idmov,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('creadopor',$this->creadopor,true);
		$criteria->compare('creadoel',$this->creadoel,true);
		$criteria->compare('modificadopor',$this->modificadopor,true);
		$criteria->compare('modificadoel',$this->modificadoel,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codocuref',$this->codocuref,true);
		$criteria->compare('numdocref',$this->numdocref,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('id',$this->id);
		$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('prefijo',$this->prefijo,true);
		$criteria->compare('fechadoc',$this->fechadoc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}