<?php
class Maestrodetalle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Maestrodetalle the static model class
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
		return 'public_maestrodetalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codart,controlprecio', 'required'),
			array('codart, codcentro, codal,controlprecio', 'safe'),
			//array('controlprecio', 'checkcontrolprecio'),
			array('leadtime', 'numerical', 'integerOnly'=>true),
			array('canteconomica, cantreposic, cantreorden', 'numerical'),
			array('canteconomica, cantreposic, cantreorden', 'checkvalores','on'=>'update'),
			array('codart', 'length', 'max'=>8),
			array('codcentro', 'length', 'max'=>4),
			array('codal, codgrupoventas', 'length', 'max'=>3),
			array('canaldist', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codart, codcentro, codal, codgrupoventas,punitstd,punitv,catval,controlprecio,supervisionautomatica, canaldist, canteconomica, cantreposic, cantreorden, leadtime', 'safe'),
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
			'codart0' => array(self::BELONGS_TO, 'Maestrocomponentes', 'codart'),
			'codal0' => array(self::BELONGS_TO, 'Almacenes', 'codal'),
			'codcentro0' => array(self::BELONGS_TO, 'Centros', 'codcentro'),
		);
	}

	public function checkcontrolprecio($attribute,$params) {
		$control=''.trim($this->controlprecio);
		if(($control <>'V')  AND  ($control <>'S') )
			$this->adderror('controlprecio','No es un dato correcto  valores posibles ( V , S ) Solamente ');


	}
	public function checkvalores($attribute,$params) {

	      IF($this->supervisionautomatica=='1')
			if(!(($this->canteconomica > $this->cantreorden) and
			 ( $this->cantreorden > $this->cantreposic )))
			$this->adderror('cantreorden','Revise las cantidades, Cantidad ecónomica es mayor que reorden y a su vez mayor que reposicion');


	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codart' => 'Codigo material',
			'codcentro' => 'Centro',
			'codal' => 'Almacen',
			'codgrupoventas' => 'Grupo ventas',
			'canaldist' => 'Canal dist.',
			'canteconomica' => 'Cant Econom',
			'cantreposic' => 'P. Reposicion',
			'cantreorden' => 'P. Reorden',
			'leadtime' => 'Lead time(Dias)',
            'supervisionautomatica'=>'Sup. Autom.?'

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
		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codal',$this->codal,true);
		$criteria->compare('codgrupoventas',$this->codgrupoventas,true);
		$criteria->compare('canaldist',$this->canaldist,true);
		$criteria->compare('canteconomica',$this->canteconomica);
		$criteria->compare('cantreposic',$this->cantreposic);
		$criteria->compare('cantreorden',$this->cantreorden);
		$criteria->compare('leadtime',$this->leadtime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}