<?php

/**
 * This is the model class for table "observaciones".
 *
 * The followings are the available columns in table 'observaciones':
 * @property string $id
 * @property string $hidinventario
 * @property string $fecha
 * @property string $descri
 * @property string $mobs
 * @property string $usuario
 *
 * The followings are the available model relations:
 * @property Inventario $hidinventario0
 */
class Observaciones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Observaciones the static model class
	 */
	 
	public $estado_estado; 
	 public $inventario_descripcion;
	 public $inventario_codigosap;
	  public $inventario_codigoaf;
	  public $inventario_codep;
	public $fecha1;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{observaciones}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descri,fecha,mobs', 'required'),
			array('descri', 'length', 'max'=>30),
			array('usuario', 'length', 'max'=>40),
			array('hidinventario, fecha, mobs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,codestado, hidinventario,inventario_codep,inventario_descripcion,estado_estado,inventario_codigosap,inventario_codigoaf, fecha, descri, mobs, usuario', 'safe', 'on'=>'search'),
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
			'inventario' => array(self::BELONGS_TO, 'Inventario', 'hidinventario'),
			'estado'=>array(self::BELONGS_TO, 'Estado', array('codestado'=>'codestado','codocu'=>'codocu')),
			
			//'vwobs' => array(self::HAS_ONE, 'VwObservaciones', 'id'),
				);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidinventario' => 'Hidinventario',
			'fecha' => 'Fecha',
			'descri' => 'Descripcion',
			'mobs' => 'Observacion ',
			'usuario' => 'Usuario',
		);
	}

	
	
		public function beforeSave() {
							if ($this->isNewRecord) {
									
									$this->usuario=Yii::app()->user->name;
									$this->codocu='330';
									//$this->descridetalle=" ".date("H:i")." -->".$this->descridetalle;
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidinventario',$this->hidinventario,true);
		$criteria->compare('fecha',$this->fecha,true);
			$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('descri',$this->descri,true);
		$criteria->compare('mobs',$this->mobs,true);
		$criteria->compare('usuario',$this->usuario,true);
		//$criteria->compare('codep',$this->codep,true);
		/*$criteria->together  =  true;
		$criteria->with = array('estado','inventario');*/
	
		
			
		
		
		/*	$criteria->with = array('inventario');
		if($this->inventario_descripcion){
				$criteria->compare('inventario.descripcion',$this->inventario_descripcion,true);
				
			}
			
			if($this->inventario_codigosap){
			$criteria->compare('inventario.codigosap',$this->inventario_codigosap,true);
			}
		if($this->inventario_codigoaf){
			$criteria->compare('inventario.codigoaf',$this->inventario_codigoaf,true);
			}

			if($this->inventario_codep){
			$criteria->compare('inventario.codep',$this->inventario_codep,true);
			}
			*/
			
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
                'pageSize' => 20,
            ),
		));
	}
}