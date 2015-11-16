<?php


 
class VwKardex extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VwKardex the static model class
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
		return 'vw_kardex';
	}


    public $fecha1;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('cant', 'numerical'),
			array('codart', 'length', 'max'=>10),
			array('codmov, codestado, prefijo', 'length', 'max'=>2),
			array('alemi, aldes, coddoc, um, codocuref', 'length', 'max'=>3),
			array('numdoc, numdocref', 'length', 'max'=>15),
			array('usuario, creadopor, modificadopor', 'length', 'max'=>25),
			array('creadoel, modificadoel, comentario', 'length', 'max'=>20),
			array('codcentro', 'length', 'max'=>4),
			array('correlativo', 'length', 'max'=>12),
			array('numkardex', 'length', 'max'=>14),
			array('solicitante', 'length', 'max'=>18),
			array('descripcion', 'length', 'max'=>60),
			array('desdocu', 'length', 'max'=>45),
			array('movimiento', 'length', 'max'=>35),
			array('fecha, fechadoc, hidvale', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codart, codmov, cant, alemi, aldes, fecha,fecha1, coddoc, numdoc,
			   um, comentario, codocuref, numdocref, codcentro, id,
			  codestado, prefijo, fechadoc, correlativo, numkardex,
			   solicitante, hidvale, descripcion, desdocu, movimiento', 'safe', 'on'=>'search'),
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

            'maestro' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),

        );
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
			'correlativo' => 'Correlativo',
			'numkardex' => 'Numkardex',
			'solicitante' => 'Solicitante',
			'hidvale' => 'Hidvale',
			'descripcion' => 'Descripcion',
			'desdocu' => 'Desdocu',
			'movimiento' => 'Movimiento',
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

		//$criteria->compare('codart',$this->codart,true);
		$criteria->compare('codmov',$this->codmov,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('alemi',$this->alemi,true);
		$criteria->compare('aldes',$this->aldes,true);
		//$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('coddoc',$this->coddoc,true);
		$criteria->compare('numdoc',$this->numdoc,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('codocuref',$this->codocuref,true);
		$criteria->compare('numdocref',$this->numdocref,true);
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('id',$this->id);
		//$criteria->compare('codestado',$this->codestado,true);
		$criteria->compare('prefijo',$this->prefijo,true);
		$criteria->compare('fechadoc',$this->fechadoc,true);
		$criteria->compare('correlativo',$this->correlativo,true);
		$criteria->compare('numkardex',$this->numkardex,true);
		$criteria->compare('solicitante',$this->solicitante,true);
		$criteria->compare('hidvale',$this->hidvale,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('desdocu',$this->desdocu,true);
		$criteria->compare('movimiento',$this->movimiento,true);
		//$criteria->addcondition('codart!=:codigoservicio');
		//$criteria->params=array(':codigoservicio'=>Yii::app()->settings->get('materiales', 'materiales_codigoservicio'));
  /*var_dump(Yii::app()->settings->get('materiales'));
		yii::app()->end();*/
		//$criteria->addcondition(" valido='1' ");
		//$criteria->addcondition(" codestado <> '99' ");
        $criteria->addBetweenCondition('fecha', ''.$this->fecha.'', ''.$this->fecha1.'');
        if(isset($_SESSION['sesion_Maestrocompo'])) {
            $criteria->addInCondition('codart', $_SESSION['sesion_Maestrocompo'], 'AND');
        } ELSE {
            $criteria->compare('codart',$this->codart,true);
        }

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	public function search_porvale($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

	
		$criteria->addcondition('hidvale='.$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function search_porvale_firme($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addcondition('hidvale='.$id);
		//$criteria->addcondition(" valido='1' ");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_pormaterial($modelito)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addcondition('alemi=:vcodalm','AND');
		$criteria->addcondition('codcentro=:vcodcen','AND');
		$criteria->addcondition('codart=:vcodart');
		//$criteria->addcondition(" valido='1' ");
		$criteria->addcondition(" codestado <> '99' ");
		$criteria->params=array(':vcodalm'=>trim($modelito->codalm),
			':vcodcen'=>trim($modelito->codcen),
			':vcodart'=>trim($modelito->codart),
		);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}